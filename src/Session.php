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

    /**
     * @return \Session\Data
     */
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
     * @param \Session\Data $sessionData
     */
    public function save(Session\Data $sessionData)
    {
        $call = $this->sessionClient->Save(
            (new \Session\SaveRequest())
                ->setSessid($sessionData->getId())
                ->setUserId($sessionData->getUserId())
                ->setAccessToken($sessionData->getAccessToken())
                ->setRefreshToken($sessionData->getRefreshToken())
        );
        $call->wait();
    }

    /**
     * @return string
     */
    private function getId(): string
    {
        if ($this->id === null) {
            $sessId = $this->request->getCookie()->get(self::SESSION_ID_COOKIE_NAME);

            if ($sessId) {
                $this->id = $sessId;
            } else {
                $call = $this->sessionClient->Create(
                    new \Session\CreateRequest()
                );
                $response = $call->wait();
                // todo: validate
                $result = $response[0];

                /** @var \Session\CreateResponse $result */
                $sessId = $result->getSessid();

                if ($sessId) {
                    $this->request->getCookie()->set(self::SESSION_ID_COOKIE_NAME, $sessId);
                    $this->id = $sessId;
                }
            }
        }

        return $this->id;
    }
}
