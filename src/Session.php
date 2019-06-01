<?php declare(strict_types = 1);

class Session
{
    private const SESSION_ID_COOKIE_NAME = 's';

    /**
     * @var \Beauty\Request
     */
    private $request;

    /**
     * @var \Session\SessionServiceClient
     */
    private $sessionClient;

    /**
     * @var string|null
     */
    private $id;

    /**
     * @var Session\Data|null
     */
    private $data;

    public function __construct(
        \Beauty\Request $request,
        \Session\SessionServiceClient $sessionClient
    ) {
        $this->request = $request;
        $this->sessionClient = $sessionClient;
    }

    public function getData(): Session\Data
    {
        if ($this->data === null) {
            $sessionId = $this->getId();
            $call = $this->sessionClient->Get(
                (new \Session\GetRequest())
                    ->setSessid($sessionId)
            );
            $response = $call->wait();
            // todo: validate
            $result = $response[0];
            /** @var \Session\GetResponse $result */
            $this->data = new Session\Data(
                $sessionId,
                $result->getUserId(),
                $result->getAccessToken(),
                $result->getRefreshToken()
            );
        }

        return $this->data;
    }

    /**
     * @return string
     */
    private function getId(): string
    {
        if ($this->id === null) {
            $this->id = $this->request->getCookie()->get(self::SESSION_ID_COOKIE_NAME);

            if (!$this->id) {
                $call = $this->sessionClient->Create(
                    new \Session\CreateRequest()
                );
                $response = $call->wait();
                // todo: validate
                $result = $response[0];

                /** @var \Session\CreateResponse $result */
                $this->id = $result->getSessid();

                if ($this->id) {
                    $this->request->getCookie()->set(self::SESSION_ID_COOKIE_NAME, $this->id);
                }
            }
        }

        return $this->id;
    }
}
