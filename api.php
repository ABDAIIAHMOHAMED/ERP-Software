<?php
require_once 'vendor/autoload.php';

use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Request;

$client = new Client();
$base_url = 'https://id.preprod.eta.gov.eg';
$headers = [
  'Content-Type' => 'application/x-www-form-urlencoded',
];
$options = [
  'form_params' => [
    'grant_type' => 'client_credentials',
    'client_id' => 'bb68355e-ef22-48f5-b9cb-be97dc62aed7',
    'client_secret' => 'ebf86f08-23e7-46ca-968a-1c098244febd',
  ]
];
$request = new Request('POST', $base_url . '/connect/token', $headers);
$res = $client->sendAsync($request, $options)->wait();
echo "<pre>";
echo $res->getBody();
echo "</pre>";
