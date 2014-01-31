<?php

$postdata = file_get_contents("php://input");
$request = json_decode($postdata, true);

$plan    = $_POST['plan'];
$amt     = $_POST['amt'];
$name    = $_POST['name'];
$snippet = $_POST['snippet'];
$price   = $_POST['price'];

// ChromePhp::log($plan);
// ChromePhp::log($amt);
// ChromePhp::log($name);
// ChromePhp::log($snippet);
// ChromePhp::log($price);

if ($plan == "flag") {
    //URL de retorno, caso o cliente confirme o pagamento
    $returnURL = 'http://novadelicia.com.br/cpbr/createprofile.php';
    // $returnURL = 'http://localhost:8888/modelo_paypal/#/createprofile';
} else {
    $returnURL = 'http://novadelicia.com.br/cpbr/confirm.php';
}

//URL de cancelamento, caso o cliente desista do pagamento
$cancelURL = 'http://localhost/cancel';

//Incluindo o arquivo que contém a função sendNvpRequest
require 'sendNvpRequest.php';
include 'ChromePhp.php';

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

/**
 * $items[][0] = quantidade
 * $items[][1] = Nome do produto
 * $items[][2] = Descrição do produto
 * $items[][3] = Preço
 */
$items = array(
    array($amt, $name, $snippet, $price)
);

//Calculando total do Express Checkout
$total = 0;

foreach ($items as $item) {
    $total += $item[0] * $item[3];
}

//Campos que serão enviados com a operação SetExpressCheckout
$requestNvp = array(
    'PAYMENTREQUEST_0_AMT'           => $total,
    'PAYMENTREQUEST_0_CURRENCYCODE'  => 'BRL',
    'PAYMENTREQUEST_0_PAYMENTACTION' => 'Sale',
    'RETURNURL'                      => $returnURL,
    'CANCELURL'                      => $cancelURL,
    'METHOD'                         => 'SetExpressCheckout',
    'VERSION'                        => '108.0',
    'PWD'                            => $pswd,
    'USER'                           => $user,
    'SIGNATURE'                      => $signature,
    'NOSHIPPING'                     => 1,
    'REQCONFIRMSHIPPING'             => 0,
    'USERACTION'                     => 'COMMIT'
);

for ($i = 0, $t = count($items); $i < $t; ++$i) {
    $requestNvp['L_PAYMENTREQUEST_0_QTY' . $i ] = $items[$i][0];
    $requestNvp['L_PAYMENTREQUEST_0_NAME'. $i ] = $items[$i][1];
    $requestNvp['L_PAYMENTREQUEST_0_DESC'. $i ] = $items[$i][2];
    $requestNvp['L_PAYMENTREQUEST_0_AMT' . $i ] = $items[$i][3];

    if (isset($items[$i][4])) {
        $requestNvp['L_PAYMENTREQUEST_0_ITEMCATEGORY' . $i] = $items[$i][4];
    }
}

if ($plan == "flag") {
    ChromePhp::log("aquiiiiiii");
    $requestNvp['L_BILLINGTYPE0'] = 'RecurringPayments';
    $requestNvp['L_BILLINGAGREEMENTDESCRIPTION0'] = 'Exemplo';
}

//Envia a requisição e obtém a resposta da PayPal
$responseNvp = sendNvpRequest($requestNvp, $sandbox);

ChromePhp::log($responseNvp);

//Se a operação tiver sido bem sucedida, redireciona o cliente para o ambiente de pagamento.
if (isset($responseNvp['ACK']) && $responseNvp['ACK'] == 'Success') {

    $paypalURL = 'https://www.sandbox.paypal.com/cgi-bin/webscr';
    $query = array(
        'cmd' => '_express-checkout',
        'token' => $responseNvp['TOKEN']
    );

    $redirectURL = sprintf('%s?%s', $paypalURL, http_build_query($query));

    //carrega a página de redirecionamento
    require 'redirect.php';


} else {
    //alguma coisa aconteceu
}