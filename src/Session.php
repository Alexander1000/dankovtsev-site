<?php declare(strict_types = 1);

class Session
{
    /**
     * @var \Session\SessionServiceClient
     */
    private $sessionClient;

    public function __construct(
        \Session\SessionServiceClient $sessionClient
    ) {
        $this->sessionClient = $sessionClient;
    }
}
