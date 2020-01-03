<?php

$post = array(
  'hostname' => 'cert.api.firstdata.com',
  'credentials' =>
    array(
      'apiKey' => 'Enter your PAYMENTJS2 APIKEY',
      'apiSecret' => 'Enter your PAYMENTJS2 APISECRET'
    ),
  'gatewayConfig' =>
    array(
      'gateway' => 'PAYEEZY',
      'apiKey' => '{PAYEEZY_APIKEY}',
      'apiSecret' => '{PAYEEZY_APISECRET}',
      'authToken' => '{PAYEEZY_AUTHTOKEN}',
      'transarmorToken' => '{PAYEEZY_TATOKEN}',
      'zeroDollarAuth' => false

    /*"gateway" => 'BLUEPAY', 
      "accountId" => '', 
      "secretKey" => '',
      'zeroDollarAuth' => false */

    /*"gateway" => 'CARD_CONNECT', 
      "apiUserAndPass" => '', 
      "merchantId" => '',
      'zeroDollarAuth' => false */

    /*"gateway" => 'IPG', 
      "apiKey" => '', 
      "apiSecret" => ''
      'zeroDollarAuth' => false */
    )
)

?>