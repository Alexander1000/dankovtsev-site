<?php declare(strict_types = 1);

namespace Auth\Controller;

use Beauty;
use Alexander1000\Clients\Users;
use Alexander1000\Clients\Auth;

class Register extends ControllerAbstract
{
    /**
     * @return Beauty\Http\ResponseInterface
     */
    public function registerAction(): Beauty\Http\ResponseInterface
    {
        if ($this->request->isPost()) {
            $user = $this->userClient->getByEmail($this->request->getParam('email'));

            if ($user !== null && $user->getStatusId() !== 0) {
                throw new \InvalidArgumentException('User with email already exists');
            }

            if ($user === null) {
                $email = new Users\Request\V1\Save\Email(null, null, $this->request->getParam('email'));
                $request = new Users\Request\V1\Save\User(null, null, null, [$email], []);
                $user = $this->userClient->save($request);
            }

            $emailData = $user->getEmails()[0];

            $reqAuthRegister = new Auth\Request\V1\Registration(
                $user->getUserId(),
                $this->request->getParam('password'),
                [new Auth\Model\Credential($emailData->getId(), 'email')]
            );

            $result = $this->authClient->registration($reqAuthRegister);
            if ($result) {
                return $this->redirect('/login', 302);
            }
        }

        return $this->render('auth/register');
    }
}
