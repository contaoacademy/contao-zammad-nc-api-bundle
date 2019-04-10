<?php

namespace Contaoacademy\ZammadNCApiBundle\Gateway;


class Zammad extends \NotificationCenter\Gateway\Base implements \NotificationCenter\Gateway\GatewayInterface {


    protected $strGroup = '';
    protected $strRequest = null;
    protected $strPassword = null;
    protected $strUsername = null;
    protected $arrHttpHeader = [];
    protected $arrApiFields = [ 'firstname', 'lastname', 'email', 'mobile', 'phone', 'web', 'address', 'note', 'department' ];


    public function send( \NotificationCenter\Model\Message $objMessage, array $arrTokens, $strLanguage = '') {

        $this->strPassword = \Config::get('zammadPassword');
        $this->strUsername = \Config::get('zammadUser');
        $this->strRequest = \Config::get('zammadHost');
        $this->strGroup = $objMessage->getRelated('pid')->zammad_group ?: 'Users';

        $this->arrHttpHeader[] = 'Content-Type: application/json';

        $objCurl = curl_init();

        curl_setopt( $objCurl, CURLOPT_USERPWD, $this->strUsername . ":" . $this->strPassword );
        curl_setopt( $objCurl, CURLOPT_HTTPHEADER, $this->arrHttpHeader );
        curl_setopt( $objCurl, CURLOPT_RETURNTRANSFER, true );

        $this->createUser( $arrTokens, $objCurl );
        $this->createTicket( $arrTokens, $objCurl );

        curl_close ( $objCurl );
    }


    protected function createTicket( $arrTokens, $objCurl ) {

        $strRequest = $this->strRequest . '/api/v1/tickets';

        $arrRequest = [
            'title' => $arrTokens['form_subject'],
            'group' => $this->strGroup,
            'article' => [
                'subject' => $arrTokens['form_subject'],
                'body' => $this->collectBodyData( $arrTokens ),
                'type' => 'web',
                'internal' => false,
                'to' => $arrTokens['form_email']
            ],
            'customer' => $arrTokens['form_email'],
            'note' => $arrTokens['form_subject']
        ];

        $arrCustomHeader = $this->arrHttpHeader; // get standard header
        $arrCustomHeader[] = 'X-On-Behalf-Of:' . $arrTokens['form_email'];

        curl_setopt( $objCurl, CURLOPT_HTTPHEADER, $arrCustomHeader );
        curl_setopt( $objCurl, CURLOPT_URL, $strRequest );
        curl_setopt( $objCurl, CURLOPT_POST, 1 );
        curl_setopt( $objCurl, CURLOPT_POSTFIELDS, json_encode( $arrRequest, 512 ) );

        $objResponse = curl_exec( $objCurl );

        \System::log( $objResponse, __METHOD__, TL_GENERAL );
    }


    protected function createUser( $arrTokens, $objCurl ) {

        $strRequest = $this->strRequest . '/api/v1/users/search';
        curl_setopt( $objCurl, CURLOPT_URL, $strRequest . '?query=' . $arrTokens['form_email'] . '&limit=1' );
        $strUserResult = curl_exec( $objCurl );
        $arrResults = json_decode( $strUserResult, 512 );

        if ( empty( $arrResults ) ) {

            $arrRequest = [];
            $strRequest = $this->strRequest . '/api/v1/users';

            foreach ( $this->arrApiFields as $strFieldname ) {

                $arrRequest[ $strFieldname ] = $arrTokens['form_' . $strFieldname ] ?: '';
            }

            curl_setopt( $objCurl, CURLOPT_HTTPHEADER, $this->arrHttpHeader );
            curl_setopt( $objCurl, CURLOPT_URL, $strRequest );
            curl_setopt( $objCurl, CURLOPT_POST, 1 );
            curl_setopt( $objCurl, CURLOPT_POSTFIELDS, json_encode( $arrRequest, 512 ) );
            $objResponse = curl_exec( $objCurl );

            \System::log( $objResponse, __METHOD__, TL_GENERAL );
        }
    }


    protected function collectBodyData( $arrTokens ) {

        global $objPage;

        $strBody = $arrTokens['form_body'] . PHP_EOL . PHP_EOL;

        foreach ( $arrTokens as $strName => $strValue ) {

            if ( strpos( $strName, 'form_' ) === false ) {

                continue;
            }

            $strName = substr( $strName, 5 );

            if ( in_array( $strName, $this->arrApiFields ) ) {

                continue;
            }

            if ( in_array( $strName, [ 'body', 'subject' ] ) ) {

                continue;
            }

            $strName = ucfirst( $strName );
            $strBody .= $strName . ': ' . $strValue . PHP_EOL;
        }

        $strBody .= 'Alias: ' . $objPage->alias;

        return $strBody;
    }
}