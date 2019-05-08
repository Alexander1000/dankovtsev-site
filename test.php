#!/usr/bin/env php
<?php declare(strict_types = 1);

require_once __DIR__ . '/vendor/autoload.php';

$client = new \Session\SessionServiceClient(
    '127.0.0.1:50051',
    ['credentials' => \Grpc\ChannelCredentials::createInsecure()]
);

$request = (new \Session\GetRequest())->setSessid('fa342df');

$call = $client->Get($request);

$response = $call->wait();

$result = $response[0];

/** @var \Session\GetResponse $result */
var_dump($result->getAccessToken());
var_dump($result->getRefreshToken());
var_dump($result->getUserId());
