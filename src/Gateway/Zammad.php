<?php

namespace Contaoacademy\ZammadNCApiBundle\Gateway;


class Zammad extends \NotificationCenter\Gateway\Base implements \NotificationCenter\Gateway\GatewayInterface {


    protected $strPassword = null;
    protected $strUsername = null;
    protected $strRequest = null;
    protected $strGroup = '';


    public function send( \NotificationCenter\Model\Message $objMessage, array $arrTokens, $strLanguage = '') {

        $this->strPassword = \Config::get('zammadPassword');
        $this->strUsername = \Config::get('zammadUser');
        $this->strRequest = \Config::get('zammadHost');
        $this->strGroup = $objMessage->getRelated('pid')->zammad_group ?: 'Users';

        $objCurl = curl_init();

        curl_setopt( $objCurl, CURLOPT_USERPWD, $this->strUsername . ":" . $this->strPassword );
        curl_setopt( $objCurl, CURLOPT_HTTPHEADER, [ 'Content-Type: application/json' ] );
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
                'type' => 'note',
                'internal' => false
            ],
            'customer' => $arrTokens['form_email'],
            'note' => ''
        ];

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

            $strRequest = $this->strRequest . '/api/v1/users';

            $arrRequest = [

                'firstname' => $arrTokens['form_firstname'] ?: '',
                'lastname' => $arrTokens['form_lastname'] ?: '',
                'email' => $arrTokens['form_email'],
                'mobile' => $arrTokens['form_mobile'] ?: '',
                'phone' => $arrTokens['form_phone'] ?: '',
                'web' => $arrTokens['form_web'] ?: '',
                'address' => $arrTokens['form_address'] ?: '',
                'note' => $arrTokens['form_note'] ?: '',
                'department' => $arrTokens['form_department'] ?: ''
            ];

            curl_setopt( $objCurl, CURLOPT_URL, $strRequest );
            curl_setopt( $objCurl, CURLOPT_POST, 1 );
            curl_setopt( $objCurl, CURLOPT_POSTFIELDS, json_encode( $arrRequest, 512 ) );
            $objResponse = curl_exec( $objCurl );

            \System::log( $objResponse, __METHOD__, TL_GENERAL );
        }
    }


    protected function collectBodyData( $arrTokens ) {

        global $objPage;

        $strBody = '';

        foreach ( $arrTokens as $strName => $strValue ) {

            if ( strpos( $strName, 'form_' ) === false ) {

                continue;
            }

            $strName = substr( $strName, 5 );
            $strName = ucfirst( $strName );

            $strBody .= $strName . ': ' . $strValue . PHP_EOL;
        }

        $strBody .= 'Alias: ' . $objPage->alias;

        return $strBody;
    }
}