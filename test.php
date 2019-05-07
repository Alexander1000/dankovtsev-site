<?php declare(strict_types = 1);

require_once __DIR__ . '/src/bootstrap.php';

$client = new \Session\SessionServiceClient(
    '127.0.0.1:50051',
    ['credentials' => \Grpc\ChannelCredentials::createInsecure()]
);

var_dump(
    $client->Get(
        (new \Session\GetRequest())
            ->setSessid('35242')
    )->wait()
);
