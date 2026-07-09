<?php

declare(strict_types=1);

/*
 * This file is part of the Contao Zammad Gateway extension.
 *
 * (c) Contao Academy
 *
 * @license LGPL-3.0-or-later
 */

namespace ContaoAcademy\ZammadNCApiBundle\Gateway;

use Codefog\HasteBundle\StringParser;
use Contao\CoreBundle\Framework\ContaoFramework;
use Contao\StringUtil;
use Contao\Validator;
use ContaoAcademy\ZammadNCApiBundle\Config\ZammadMessageConfig;
use ContaoAcademy\ZammadNCApiBundle\Exception\ZammadGatewayException;
use ContaoAcademy\ZammadNCApiBundle\Parcel\Stamp\ZammadMessageStamp;
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpKernel\KernelInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Terminal42\NotificationCenterBundle\BulkyItem\BulkyItemStorage;
use Terminal42\NotificationCenterBundle\BulkyItem\FileItem;
use Terminal42\NotificationCenterBundle\Config\GatewayConfig;
use Terminal42\NotificationCenterBundle\Exception\Parcel\CouldNotDeliverParcelException;
use Terminal42\NotificationCenterBundle\Gateway\GatewayInterface;
use Terminal42\NotificationCenterBundle\Parcel\Parcel;
use Terminal42\NotificationCenterBundle\Parcel\Stamp\BulkyItemsStamp;
use Terminal42\NotificationCenterBundle\Parcel\Stamp\GatewayConfigStamp;
use Terminal42\NotificationCenterBundle\Parcel\Stamp\TokenCollectionStamp;
use Terminal42\NotificationCenterBundle\Receipt\Receipt;

class ZammadGateway implements GatewayInterface
{
    public const NAME = 'zammad';

    public function __construct(
        private readonly HttpClientInterface $client,
        private readonly ContaoFramework $contaoFramework,
        private readonly LoggerInterface $contaoGeneralLogger,
        private readonly LoggerInterface $contaoErrorLogger,
        private readonly KernelInterface $kernel,
        private readonly StringParser $stringParser,
        private readonly BulkyItemStorage $bulkyItemStorage,
    ) {
    }

    public function getName(): string
    {
        return self::NAME;
    }

    public function sealParcel(Parcel $parcel): Parcel
    {
        return $parcel
            ->withStamp($this->createZammadMessageStamp($parcel))
            ->seal()
        ;
    }

    public function sendParcel(Parcel $parcel): Receipt
    {
        try {
            $client = $this->createClientForGateway($parcel->getStamp(GatewayConfigStamp::class)->gatewayConfig);
            $config = $parcel->getStamp(ZammadMessageStamp::class)->zammadMessageConfig;
            $customerId = $this->getCustomerId($client, $config);

            $article = [
                'subject' => $config->getTitle(),
                'body' => $config->getBody(),
                'content_type' => $config->isHtml() ? 'text/html' : 'text/plain',
                'type' => 'web',
                'internal' => false,
            ];

            if ($attachments = $this->buildAttachments($config)) {
                $article['attachments'] = $attachments;
            }

            // Create the ticket
            $response = $client->request(
                'POST',
                '/api/v1/tickets',
                [
                    'json' => [
                        'customer_id' => $customerId,
                        'title' => $config->getTitle(),
                        'group' => $config->getGroup(),
                        'article' => $article,
                    ],
                    'headers' => [
                        'From' => $customerId,
                    ],
                ],
            );

            $result = json_decode($response->getContent(), true, 512, JSON_THROW_ON_ERROR);

            $this->contaoGeneralLogger->info(sprintf('Zammad ticket #%s ("%s") created.', $result['id'], $result['title']));

            return Receipt::createForSuccessfulDelivery($parcel);
        } catch (\Throwable $e) {
            if ($this->kernel->isDebug()) {
                throw $e;
            }

            $this->contaoErrorLogger->error('Zammad API Request failed: '.$e->getMessage(), ['exception' => $e]);

            return Receipt::createForUnsuccessfulDelivery(
                $parcel,
                CouldNotDeliverParcelException::becauseOfGatewayException(self::NAME, exception: $e),
            );
        }
    }

    private function createZammadMessageStamp(Parcel $parcel): ZammadMessageStamp
    {
        $this->contaoFramework->initialize();

        $messageConfig = $parcel->getMessageConfig();
        $tokens = $parcel->getStamp(TokenCollectionStamp::class)->tokenCollection->forSimpleTokenParser();
        $email = $this->stringParser->recursiveReplaceTokensAndTags($messageConfig->getString('zammad_email'), $tokens);

        if (!$email || !Validator::isEmail($email)) {
            throw new ZammadGatewayException('Invalid email address "'.$email.'" given.');
        }

        if (!$title = $this->stringParser->recursiveReplaceTokensAndTags($messageConfig->getString('zammad_title'), $tokens)) {
            throw new ZammadGatewayException('No title given!');
        }

        if (!$group = $this->stringParser->recursiveReplaceTokensAndTags($messageConfig->getString('zammad_group'), $tokens)) {
            throw new ZammadGatewayException('No group given!');
        }

        $parameters = [];

        foreach (StringUtil::deserialize($messageConfig->getString('zammad_params'), true) as $param) {
            $key = $this->stringParser->recursiveReplaceTokensAndTags((string) $param['key'], $tokens);
            $value = $this->stringParser->recursiveReplaceTokensAndTags((string) $param['value'], $tokens);
            $parameters[$key] = $value;
        }

        return ZammadMessageStamp::fromArray([
            'email' => $email,
            'parameters' => $parameters,
            'title' => $title,
            'group' => $group,
            'body' => $this->stringParser->recursiveReplaceTokensAndTags($messageConfig->getString('zammad_body'), $tokens),
            'html' => $messageConfig->getBoolean('zammad_html'),
            'attachments' => $this->resolveAttachmentVouchers($parcel, $messageConfig->getString('zammad_attachment_tokens'), $tokens),
        ]);
    }

    /**
     * Resolves the configured file tokens to bulky item vouchers. Only vouchers that are
     * actually registered as bulky items on the parcel are kept (same guard the mailer uses).
     *
     * @param array<string, string> $tokens
     *
     * @return array<string>
     */
    private function resolveAttachmentVouchers(Parcel $parcel, string $tokenList, array $tokens): array
    {
        if ('' === $tokenList || !$parcel->hasStamp(BulkyItemsStamp::class)) {
            return [];
        }

        $bulkyItemsStamp = $parcel->getStamp(BulkyItemsStamp::class);
        $vouchers = [];

        foreach (StringUtil::trimsplit(',', $tokenList) as $token) {
            if ('' === $token) {
                continue;
            }

            $resolved = $this->stringParser->recursiveReplaceTokensAndTags($token, $tokens);

            foreach (StringUtil::trimsplit(',', $resolved) as $voucher) {
                if ('' !== $voucher && $bulkyItemsStamp->has($voucher)) {
                    $vouchers[] = $voucher;
                }
            }
        }

        return $vouchers;
    }

    /**
     * @return array<array{filename: string, data: string, 'mime-type': string}>
     */
    private function buildAttachments(ZammadMessageConfig $config): array
    {
        $attachments = [];

        foreach ($config->getAttachmentVouchers() as $voucher) {
            $item = $this->bulkyItemStorage->retrieve($voucher);

            if (!$item instanceof FileItem) {
                continue;
            }

            $contents = $item->getContents();
            $data = \is_resource($contents) ? stream_get_contents($contents) : (string) $contents;

            $attachments[] = [
                'filename' => $item->getName(),
                'data' => base64_encode((string) $data),
                'mime-type' => $item->getMimeType(),
            ];
        }

        return $attachments;
    }

    private function createClientForGateway(GatewayConfig $gatewayConfig): HttpClientInterface
    {
        $options = ['base_uri' => $gatewayConfig->getString('zammadHost')];

        match ($gatewayConfig->getString('zammadAuthType')) {
            'basic' => $options['auth_basic'] = [$gatewayConfig->getString('zammadUser'), $gatewayConfig->getString('zammadPassword')],
            'token' => $options['auth_bearer'] = $gatewayConfig->getString('zammadToken'),
            default => throw new ZammadGatewayException('Invalid authentication type given.'),
        };

        return $this->client->withOptions($options);
    }

    private function getCustomerId(HttpClientInterface $client, ZammadMessageConfig $config): string
    {
        // Search for the customer first
        $response = $client->request(
            'GET',
            '/api/v1/users/search',
            [
                'query' => [
                    'query' => \sprintf('email.keyword:"%s"', $config->getEmail()),
                    'limit' => 1,
                ],
            ],
        );

        if ($result = json_decode($response->getContent(), true, 512, JSON_THROW_ON_ERROR)) {
            // Customer already exists
            return (string) $result[0]['id'];
        }

        // Create the customer
        $parameters = $config->getParameters();
        $parameters['email'] = $config->getEmail();

        $response = $client->request('POST', '/api/v1/users', ['json' => $parameters]);

        $result = json_decode($response->getContent(), true, 512, JSON_THROW_ON_ERROR);

        $this->contaoGeneralLogger->info(sprintf('Zammad customer #%s (%s) created.', $result['id'], $result['email']));

        return (string) $result['id'];
    }
}
