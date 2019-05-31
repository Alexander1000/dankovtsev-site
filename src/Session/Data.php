<?php

declare(strict_types = 1);

namespace Session;

class Data
{
    /**
     * @var string
     */
    private $id;

    /**
     * @var int
     */
    private $userId;

    /**
     * @var string
     */
    private $accessToken;

    /**
     * @var string
     */
    private $refreshToken;

    public function __construct(
        string $id,
        int $userId,
        string $accessToken,
        string $refreshToken
    ) {
        $this->id = $id;
        $this->userId = $userId;
        $this->accessToken = $accessToken;
        $this->refreshToken = $refreshToken;
    }
}
