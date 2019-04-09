<?php

namespace Contaoacademy\ZammadNCApiBundle\Gateway;


class Zammad extends \NotificationCenter\Gateway\Base implements \NotificationCenter\Gateway\GatewayInterface {


    protected $strPassword = null;
    protected $strUsername = null;
    protected $strRequest = null;


    public function send( \NotificationCenter\Model\Message $objMessage, array $arrTokens, $strLanguage = '') {

        $this->strPassword = \Config::get('zammadPassword');
        $this->strUsername = \Config::get('zammadUser');
        $this->strRequest = \Config::get('zammadHost');

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
            'group' => 'Users',
            'article' => [
                'subject' => $arrTokens['form_subject'],
                'body' => $arrTokens['form_body'],
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
            ];

            curl_setopt( $objCurl, CURLOPT_URL, $strRequest );
            curl_setopt( $objCurl, CURLOPT_POST, 1 );
            curl_setopt( $objCurl, CURLOPT_POSTFIELDS, json_encode( $arrRequest, 512 ) );
            $objResponse = curl_exec( $objCurl );

            \System::log( $objResponse, __METHOD__, TL_GENERAL );
        }
    }
}