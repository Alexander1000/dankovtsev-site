#!/usr/bin/env php
<?php declare(strict_types = 1);

require_once __DIR__ . '/vendor/autoload.php';

$client = new \Session\SessionServiceClient(
    '127.0.0.1:50051',
    ['credentials' => \Grpc\ChannelCredentials::createInsecure()]
);

$request = (new \Session\GetRequest())->setSessid('fa342df');

$call = $client->Get($request);

var_dump($call->wait());
