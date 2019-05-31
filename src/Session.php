<?php declare(strict_types = 1);

class Session
{
    /**
     * @var \Beauty\Request
     */
    private $request;

    /**
     * @var \Session\SessionServiceClient
     */
    private $sessionClient;

    public function __construct(
        \Beauty\Request $request,
        \Session\SessionServiceClient $sessionClient
    ) {
        $this->request = $request;
        $this->sessionClient = $sessionClient;
    }
}
