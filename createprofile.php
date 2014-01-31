<?php


//Incluindo o arquivo que contém a função sendNvpRequest
require 'php/sendNvpRequest.php';
include 'php/ChromePhp.php';

//Vai usar o Sandbox, ou produção?
$sandbox = true;

if ($sandbox) {
    $paypalURL = 'https://www.sandbox.paypal.com/cgi-bin/webscr';
    //credenciais da API para o Sandbox
    $user = 'empresa_api1.empresateste.com.br';
    $pswd = '1390932561';
    $signature = 'A1iK8SWiLlvpgdDfIXRoaVGOvHOnADYgKKY3P6rp1r-IUylwnTE6Lece';
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
$payerID = $_GET['PayerID'];

ChromePhp::log($token);
ChromePhp::log($payerID);


//Campos que serão enviados com a operação SetExpressCheckout
$requestNvp = array(
    'METHOD'    => 'CreateRecurringPaymentsProfile',
    'VERSION'   => '108.0',
    'PWD'       => $pswd,
    'USER'      => $user,
    'SIGNATURE' => $signature,
    'TOKEN'     => $token,
    'PayerID' => $payerID,
    'PROFILESTARTDATE' => '2014-02-08T16:00:00Z',
    'DESC' => 'Exemplo',
    'BILLINGPERIOD' => 'Month',
    'BILLINGFREQUENCY' => '1',
    'AMT' => 100,
    'CURRENCYCODE' => 'BRL',
    'COUNTRYCODE' => 'BR',
    'MAXFAILEDPAYMENTS' => 3
);

//Envia a requisição e obtém a resposta da PayPal
$responseNvp = sendNvpRequest($requestNvp, $sandbox);

ChromePhp::log($responseNvp);

//Se a operação tiver sido bem sucedida, redireciona o cliente para o ambiente de pagamento.
if (isset($responseNvp['ACK']) && $responseNvp['ACK'] == 'Success') {

    // echo json_encode($responseNvp);
    header("location: ./#/congratulations");

} else {
    //alguma coisa aconteceu
}