<?php declare(strict_types = 1);

namespace Auth\Controller;

use Beauty;
use Beauty\Request;
use Alexander1000\Clients\Users;
use Alexander1000\Clients\Auth;

class Login extends ControllerAbstract
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
    public function loginAction(): Beauty\Http\ResponseInterface
    {
        if ($this->request->isPost()) {
            $user = $this->userClient->getByEmail($this->request->getParam('email'));

            $reqAuthenticate = new Auth\Request\V1\Authenticate(
                new Auth\Model\Credential($user->getEmails()[0]->getId(), 'email'),
                $this->request->getParam('password')
            );
            $token = $this->authClient->authenticate($reqAuthenticate);

            // @todo: save in session
        }
        return $this->render('auth/login');
    }
}
