<?php declare(strict_types = 1);

namespace Auth\Controller;

use Beauty\Request;
use Session;
use Alexander1000\Clients\Auth;
use Alexander1000\Clients\Users;

abstract class ControllerAbstract extends \Controller\PublicAbstract
{
    protected Session $session;

    protected Users\Client $userClient;

    protected Auth\Client $authClient;

    public function __construct(
        Request $request,
        \Auth\Repository $authRepository,
        Session $session,
        Users\Client $userClient,
        Auth\Client $authClient
    ) {
        parent::__construct($request, $authRepository);
        $this->session = $session;
        $this->userClient = $userClient;
        $this->authClient = $authClient;
    }
}
