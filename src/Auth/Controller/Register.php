<?php declare(strict_types = 1);

namespace Auth\Controller;

use Beauty;
use Beauty\Request;
use Alexander1000\Clients\Users;

class Register extends ControllerAbstract
{
    private Users\Client $userClient;

    public function __construct(Request $request, Users\Client $userClient)
    {
        parent::__construct($request);
        $this->userClient = $userClient;
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
