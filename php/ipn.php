<?php

//Email da conta do vendedor, que será utilizada para verificar o
//destinatário da notificação.
$receiver_email = 'empresa@empresateste.com.br';

//As notificações sempre serão via HTTP POST, então verificamos o método
//utilizado na requisição, antes de fazer qualquer coisa.
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    //Antes de trabalhar com a notificação, precisamos verificar se ela
    //é válida e, se não for, descartar.
    if (!isIPNValid($_POST)) {
        return;
    }

    //Se chegamos até aqui, significa que estamos lidando com uma
    //notificação IPN válida. Agora precisamos verificar se somos o
    //destinatário dessa notificação, verificando o campo receiver_email.
    if ($_POST['receiver_email'] == $receiver_email) {
        //Está tudo correto, somos o destinatário da notificação, vamos
        //gravar um log dessa notificação.

        $fp = fopen("log.txt", "a");
        $text_log = '';

        foreach ($_POST as $key => $item) {
            // $text_log = fwrite($fp, '<b>'.$key.'</b>'.': '. $item. '<br>');
            $text_log .= '<b>'.$key.'</b>'.': '. $item. '<br>';
        }

        $text_log .= '<br>-----------------------------------------------<br>';

        fwrite($fp, $text_log);

        fclose($fp);
    }
}

/**
 * Verifica se uma notificação IPN é válida, fazendo a autenticação
 * da mensagem segundo o protocolo de segurança do serviço.
 *
 * @param array $message Um array contendo a notificação recebida.
 * @return boolean TRUE se a notificação for autência, ou FALSE se
 *                 não for.
 */
function isIPNValid(array $message)
{
    $endpoint = 'https://www.paypal.com';

    if (isset($message['test_ipn']) && $message['test_ipn'] == '1') {
        $endpoint = 'https://www.sandbox.paypal.com';
    }

    $endpoint .= '/cgi-bin/webscr?cmd=_notify-validate';

    $curl = curl_init();

    curl_setopt($curl, CURLOPT_URL, $endpoint);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_POST, true);
    curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($message));

    $response = curl_exec($curl);
    $error = curl_error($curl);
    $errno = curl_errno($curl);

    curl_close($curl);

    return empty($error) && $errno == 0 && $response == 'VERIFIED';
}