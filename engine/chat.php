<?php

include 'Bot.php';
include 'Cotacao.php';
include 'Cep.php';
include 'Imc.php';

$bot = new Bot();

$lista_ajuda = [
    "ajuda" => [
        '1) Cotação do dólar atual => <strong>cotar dolar</strong><br>' => '',
        '2) Cotação do euro atual => <strong>cotar euro</strong><br>' => '',
        '3) Cotação do bitcoin atual => <strong>cotar bitcoin</strong><br>' => '',
        '4) Pesquisar um endereço pelo cep => <strong>cep 12345678</strong><br>' => '',
        '5) Calcular IMC => <strong>imc sexo(M/F)/peso/altura/idioma(pt_br/eng)</strong><br>' => '',
        '6) Saber o nome do ChatBot => <strong>Qual é o seu nome?</strong>' => ''],
];

if (isset($_GET['msg'])) {
    $msg = strtolower($_GET['msg']);

    # aqui vai o callback
    $bot->hears($msg, function (Bot $botty) {
        global $msg;
        global $lista_ajuda;

        # array para as expressões regulares das moedas
        $moedas = [
            'dolar' => 'USD-BRL',
            'euro' => 'EUR-BRL',
            'bitcoin' => 'BTC-BRL',
        ];

        # nome do chatBot
        if ($msg == 'qual é o seu nome?') {
            $botty->reply('Olá, meu nome é <strong>' . $botty->getNome() . '</strong>');
            die();

            # cotação de moedas com o uso de expressões regulares
        } else if (preg_match('/cotar/', $msg) == 1) {
            preg_match('/[^cotar].*/', $msg, $matches);

            $c = new Cotacao($botty->procurarPergunta($matches[0], $moedas));
            print('Cotação: <strong>: ' . $c->retorno()->name . '</strong><br>');
            print('Data/Hora: <strong>' . $c->retorno()->create_date . '</strong><br>');
            print('Menor valor: <strong>' . $c->retorno()->low . '</strong><br>');
            print('Maior valor: <strong>' . $c->retorno()->high . '</strong><br>');

        } else if (preg_match('/imc/', $msg) == 1) { # imc
            preg_match('/[^imc].*/', $msg, $matches);
            $msg = explode('/', $matches[0]);
            $imc = new Imc(trim($msg[0]), $msg[1], $msg[2], $msg[3]);

            if ($msg[3] == 'pt_br') {
                print('Student: <strong>' . $imc->getData()->Student . '</strong><br>');
                print('Sexo: <strong>' . strtoupper($imc->getData()->Sexo) . '</strong><br>');
                print('Peso: <strong>' . $imc->getData()->Peso . '</strong><br>');
                print('Altura: <strong>' . $imc->getData()->Altura . '</strong><br>');
                print('IMC: <strong>' . $imc->getData()->IMC . '</strong><br>');
                print('Categoria: <strong>' . $imc->getData()->Categoria . '</strong><br>');

            } else if ($msg[3] == 'eng') {
                print('Student: <strong>' . $imc->getData()->Student . '</strong><br>');
                print('Gender: <strong>' . strtoupper($imc->getData()->Gender) . '</strong><br>');
                print('Weight: <strong>' . $imc->getData()->Weight . '</strong><br>');
                print('Height: <strong>' . $imc->getData()->Height . '</strong><br>');
                print('BIC: <strong>' . $imc->getData()->BIC . '</strong><br>');
                print('Category: <strong>' . $imc->getData()->Category . '</strong><br>');
            }

            die();

            # pesquisar endereço pelo cep
        } else if (preg_match('/cep/', $msg) == 1) { # cep

            # remove possíveis caracteres especiais do cep
            $cep = str_replace(["-", ' ', '.', '-', ',', ';'], "", $msg);

            preg_match('/\d*$/', $cep, $matches); # somente números de 0 a 9

            if (strlen($matches[0]) != 8) { # comprimento do cep sem o hífen
                $botty->reply('O CEP está incorreto ou no formato incorreto');
                die(); # mata a instrução
            }

            # consultar o CEP informado, pois passou no teste anterior
            try {
                $_cep = new Cep($matches[0]);
                print('Endereço: <strong>' . $_cep->getAddress() . '</strong><br>');
                print('Bairro: <strong>' . $_cep->getDistrict() . '</strong><br>');
                print('Cidade/UF: <strong>' . $_cep->getCity() . '/' . $_cep->getState() . '</strong><br>');

            } catch (Exception $ex) {
                print($ex->getMessage());
                die(); # similar ao break
            }

        } else { # ajuda

            if ($msg == "ajuda") {
                $botty->reply($botty->procurarPergunta($msg, $lista_ajuda));
                die();
            } else if ($botty->procurarPergunta($msg, $lista_ajuda) == "") {
                $botty->reply('Desculpe, não entendi sua pergunta. Tente [ajuda]');
                die();

            } else {
                $botty->reply($botty->procurarPergunta($msg, $lista_ajuda));
                die();
            }
        }
    });
}
