<?php declare(strict_types = 1);

namespace Auth\Controller;

use Beauty;
use Beauty\Request;
use Alexander1000\Clients\Users;
use Alexander1000\Clients\Auth;

class Register extends ControllerAbstract
{
    private Users\Client $userClient;

    private Auth\Client $authClient;

    public function __construct(Request $request, Users\Client $userClient, Auth\Client $authClient)
    {
        parent::__construct($request);
        $this->userClient = $userClient;
        $this->authClient = $authClient;
    }

    /**
     * @return Beauty\Http\ResponseInterface
     */
    public function registerAction(): Beauty\Http\ResponseInterface
    {
        if ($this->request->isPost()) {
            $email = new Users\Request\V1\Save\Email(null, null, $this->request->getParam('email'));

            $request = new Users\Request\V1\Save\User(null, null, null, [$email], []);

            $response = $this->userClient->save($request);
        }

        return $this->render('auth/register');
    }
}
