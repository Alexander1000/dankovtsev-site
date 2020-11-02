<?php

declare(strict_types = 1);

namespace Auth;

use Session;
use Alexander1000\Clients\Users;
use Alexander1000\Clients\Auth;

class Repository
{
    private Session $session;

    private Users\Client $userClient;

    private Auth\Client $authClient;

    private ?Session\Data $sessData = null;

    public function __construct(
        Session $session,
        Users\Client $userClient,
        Auth\Client $authClient
    ) {
        $this->session = $session;
        $this->userClient = $userClient;
        $this->authClient = $authClient;
    }

    /**
     * @return Users\Response\V1\User|null
     * @throws Users\Exception
     * @throws \NetworkTransport\Http\Exception
     */
    public function getCurrentUser(): ?Users\Response\V1\User
    {
        $sessData = $this->getSessData();
        if ($sessData === null || $sessData->getUserId() == 0) {
            return null;
        }

        $user = $this->userClient->getById($sessData->getUserId());

        $reqAuthorize = new Auth\Request\V1\Authorize($sessData->getAccessToken());
        if ($this->authClient->authorize($reqAuthorize)) {
            return $user;
        }

        return null;
    }

    private function getSessData(): ?Session\Data
    {
        if ($this->sessData !== null) {
            return $this->sessData;
        }
        $this->sessData = $this->session->getData();
        return $this->sessData;
    }
}
