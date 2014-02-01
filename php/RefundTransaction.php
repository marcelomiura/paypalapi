<?php

	//Incluindo o arquivo que contém a função sendNvpRequest
	require 'sendNvpRequest.php';
	include 'ChromePhp.php';

	//Vai usar o Sandbox, ou produção?
	$sandbox = true;

	//Baseado no ambiente, sandbox ou produção, definimos as credenciais
	//e URLs da API.
	if ($sandbox) {
	    //credenciais da API para o Sandbox
	    $user = 'empresa_api1.empresateste.com.br';
	    $pswd = '1390932561';
	    $signature = 'A1iK8SWiLlvpgdDfIXRoaVGOvHOnADYgKKY3P6rp1r-IUylwnTE6Lece';

	    //URL da PayPal para redirecionamento, não deve ser modificada
	    $paypalURL = 'https://www.sandbox.paypal.com/cgi-bin/webscr';
	} else {
	    //credenciais da API para produção
	    $user = 'usuario';
	    $pswd = 'senha';
	    $signature = 'assinatura';

	    //URL da PayPal para redirecionamento, não deve ser modificada
	    $paypalURL = 'https://www.paypal.com/cgi-bin/webscr';
	}

	$transID = $_POST['transID'];

	ChromePhp::log($transID);

	//Campos da requisição da operação RefundTransaction.
	$requestNvp = array(
		'USER'          => $user,
		'PWD'           => $pswd,
		'SIGNATURE'     => $signature,
		'VERSION'       => '108.0',
		'METHOD'        => 'RefundTransaction',
		'TRANSACTIONID' => $transID,
		'REFUNDTYPE'    => 'Full'
	);

	//Envia a requisição e obtém a resposta da PayPal
	$responseNvp = sendNvpRequest($requestNvp, $sandbox);

	ChromePhp::log($responseNvp);


	//Verifica se a operação foi bem sucedida
	if (isset($responseNvp['ACK']) && $responseNvp['ACK'] == 'Success') {
	    //regras de negócio específicas para o reembolso
	    header("location: ./#/home");
	}