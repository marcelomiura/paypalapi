<?php

//Incluindo o arquivo que contém a função sendNvpRequest
require 'php/sendNvpRequest.php';
include 'php/ChromePhp.php';

//Vai usar o Sandbox, ou produção?
$sandbox = true;

if ($sandbox) {
    $paypalURL = 'https://www.sandbox.paypal.com/cgi-bin/webscr';
    //credenciais da API para o Sandbox
    $user = 'empresa_teste_api1.exemplo.com.br';
    $pswd = '1390932388';
    $signature = 'Abe71FlSItlBpVShdmwmOGXUHNFtARU-8OPz2sdYQSIFP5Fv7auorA8t';
} else {
    $paypalURL = 'https://www.paypal.com/cgi-bin/webscr';
    //credenciais da API para produção
    $user = 'usuario';
    $pswd = 'senha';
    $signature = 'assinatura';
}

$postdata = file_get_contents("php://input");
$request = json_decode($postdata, true);

$token = $_GET['token'];
$payerID = $_GET['payerID'];

ChromePhp::log($token);
ChromePhp::log($payerID);

//Campos que serão enviados com a operação SetExpressCheckout
$requestNvp = array(
    'METHOD'    => 'GetExpressCheckoutDetails',
    'VERSION'   => '108.0',
    'PWD'       => $pswd,
    'USER'      => $user,
    'SIGNATURE' => $signature,
    'TOKEN'     => $token
);

// ChromePhp::log($requestNvp);

//Envia a requisição e obtém a resposta da PayPal
$responseNvp = sendNvpRequest($requestNvp, $sandbox);

//Se a operação tiver sido bem sucedida, redireciona o cliente para o ambiente de pagamento.
if (isset($responseNvp['ACK']) && $responseNvp['ACK'] == 'Success') {

    // echo json_encode($responseNvp);

    //Campos que serão enviados com a operação SetExpressCheckout
    $requestNvp = array(
        'METHOD'                             => 'DoExpressCheckoutPayment',
        'VERSION'                            => '108.0',
        'PWD'                                => $pswd,
        'USER'                               => $user,
        'SIGNATURE'                          => $signature,
        'TOKEN'                              => $responseNvp['TOKEN'],
        'PAYERID'                            => $responseNvp['PAYERID'],
        'NOTIFYURL'                          => $responseNvp['NOTIFYURL'],
        'PAYMENTREQUEST_0_PAYMENTACTION'     => $responseNvp['PAYMENTREQUEST_0_PAYMENTACTION'],
        'PAYMENTREQUEST_0_AMT'               => $responseNvp['PAYMENTREQUEST_0_AMT'],
        'PAYMENTREQUEST_0_CURRENCYCODE'      => $responseNvp['PAYMENTREQUEST_0_CURRENCYCODE'],
        'PAYMENTREQUEST_0_ITEMAMT'           => $responseNvp['PAYMENTREQUEST_0_ITEMAMT'],
        'PAYMENTREQUEST_0_INVNUM'            => $responseNvp['PAYMENTREQUEST_0_INVNUM'],
        'L_PAYMENTREQUEST_0_NAME0'           => $responseNvp['L_PAYMENTREQUEST_0_NAME0'],
        'L_PAYMENTREQUEST_0_DESC0'           => $responseNvp['L_PAYMENTREQUEST_0_DESC0'],
        'L_PAYMENTREQUEST_0_AMT0'            => $responseNvp['L_PAYMENTREQUEST_0_AMT0'],
        'L_PAYMENTREQUEST_0_QTY0'            => $responseNvp['L_PAYMENTREQUEST_0_QTY0'],
        'L_PAYMENTREQUEST_0_ITEMAMT'         => $responseNvp['L_PAYMENTREQUEST_0_ITEMAMT'],
        'L_PAYMENTREQUEST_0_NAME1'           => $responseNvp['L_PAYMENTREQUEST_0_NAME1'],
        'L_PAYMENTREQUEST_0_DESC1'           => $responseNvp['L_PAYMENTREQUEST_0_DESC1'],
        'L_PAYMENTREQUEST_0_AMT1'            => $responseNvp['L_PAYMENTREQUEST_0_AMT1'],
        'L_PAYMENTREQUEST_0_QTY1'            => $responseNvp['L_PAYMENTREQUEST_0_QTY1'],
        'PAYMENTREQUEST_0_SHIPTONAME'        => $responseNvp['PAYMENTREQUEST_0_SHIPTONAME'],
        'PAYMENTREQUEST_0_SHIPTOSTREET'      => $responseNvp['PAYMENTREQUEST_0_SHIPTOSTREET'],
        'PAYMENTREQUEST_0_SHIPTOSTREET2'     => $responseNvp['PAYMENTREQUEST_0_SHIPTOSTREET2'],
        'PAYMENTREQUEST_0_SHIPTOCITY'        => $responseNvp['PAYMENTREQUEST_0_SHIPTOCITY'],
        'PAYMENTREQUEST_0_SHIPTOSTATE'       => $responseNvp['PAYMENTREQUEST_0_SHIPTOSTATE'],
        'PAYMENTREQUEST_0_SHIPTOZIP'         => $responseNvp['PAYMENTREQUEST_0_SHIPTOZIP'],
        'PAYMENTREQUEST_0_SHIPTOCOUNTRYCODE' => $responseNvp['PAYMENTREQUEST_0_SHIPTOCOUNTRYCODE']
    );

    // ChromePhp::log($requestNvp);
    $responseNvp = null;

    //Envia a requisição e obtém a resposta da PayPal
    $responseNvp = sendNvpRequest($requestNvp, $sandbox);

    // print_r ($responseNvp);

    //Se a operação tiver sido bem sucedida, redireciona o cliente para o ambiente de pagamento.
    if (isset($responseNvp['ACK']) && $responseNvp['ACK'] == 'Success' && $responseNvp['PAYMENTINFO_0_PAYMENTSTATUS'] == 'Completed') {

        header("location: ./#/congratulations");

    } else {
        //alguma coisa aconteceu
    }

} else {
    //alguma coisa aconteceu
}