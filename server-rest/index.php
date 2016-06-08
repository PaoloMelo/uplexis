<?php
function printa($v, $dump = false)
{
	echo '<pre>';
	if ($dump) {
		var_dump($v);
	} else {
		print_r($v);
	}
	echo '</pre>';
}

function CallAPI($method, $url, $data = false)
{
    $curl = curl_init();

    switch ($method)
    {
        case "POST":
            curl_setopt($curl, CURLOPT_POST, 1);

            if ($data)
                curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
            break;
        case "PUT":
            curl_setopt($curl, CURLOPT_PUT, 1);
            break;
        default:
            if ($data)
                $url = sprintf("%s?%s", $url, http_build_query($data));
    }

    // Optional Authentication:
    curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
    curl_setopt($curl, CURLOPT_USERPWD, "username:password");

    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);

    $result = curl_exec($curl);

    curl_close($curl);

    return $result;
}

require_once __DIR__ . '/vendor/autoload.php';

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

$app = new Silex\Application();
//$app['debug'] = true;

$app->get('/', function() {
    return 'REST - Pagina Inicial';
});

$app->post('/buscar', function (Request $request) use ($app) {
    $cnpj = $request->get('cnpj');
    // 31804115000243

    $retorno = [
        'cnpj_busca' => $cnpj,
        'sucesso' => 0,
        'mensagem' => '',
        'body' => '',
    ];

    $consulta = CallAPI('POST', 'http://www.sintegra.es.gov.br/resultado.php', [
        'num_cnpj' => $cnpj,
        'num_ie' => '',
        'botao' => 'Consultar'
    ]);

    $consulta = trim($consulta);

    if (empty($consulta)) {
        // erro
        $retorno['sucesso'] = 0;
        $retorno['mensagem'] = 'Erro ao buscar cnpj';
    } else {
        // sucesso
        $retorno['sucesso'] = 1;

        preg_match("~<body>(.*?)</body>~si", $consulta, $body);
        $body = $body[1];
        $body = utf8_decode($body);
        $body = htmlentities($body);
        $retorno['body'] = $body;
    }

    return $app->json($retorno);
});

$app->run();
