<?php declare(strict_types = 1);

namespace Auth\Controller;

use Beauty;
use Alexander1000\Clients\Auth;

class Login extends ControllerAbstract
{
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

            $sessData = $this->session->getData();
            $sessData
                ->setUserId($user->getUserId())
                ->setAccessToken($token->getAccess())
                ->setRefreshToken($token->getRefresh());

            $this->session->save($sessData);

            return $this->redirect('/', 302);
        }
        return $this->render('auth/login');
    }
}
