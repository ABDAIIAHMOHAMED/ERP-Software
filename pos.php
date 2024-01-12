<?php
require_once 'vendor/autoload.php';

use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Request;

$client = new Client();
$base_url = 'https://id.preprod.eta.gov.eg';
$headers = [
  'posserial' => 'F20MP2202002662',
  'pososversion' => 'os',
  'presharedkey' => '',
  'Content-Type' => 'application/x-www-form-urlencoded'
];
$options = [
  'form_params' => [
    'grant_type' => 'client_credentials',
    'client_id' => 'bb68355e-ef22-48f5-b9cb-be97dc62aed7',
    'client_secret' => '0bbf8b2d-8a3f-4384-a2c6-d2fa53256010'
  ]
];
$request = new Request('POST', $base_url . '/connect/token', $headers);
$res = $client->sendAsync($request, $options)->wait();
echo "<pre>";
echo $res->getBody();
echo "</pre>";
