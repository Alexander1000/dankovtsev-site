<?php declare(strict_types = 1);

namespace Auth\Controller;

use Beauty;
use Alexander1000\Clients\Auth;
use Alexander1000\Clients\Users;

class Login extends ControllerAbstract
{
    /**
     * @return Beauty\Http\ResponseInterface
     */
    public function loginAction(): Beauty\Http\ResponseInterface
    {
        if ($this->request->isPost()) {
            $user = $this->userClient->getByEmail($this->request->getParam('email'));

            if ($user !== null) {
                $reqAuthenticate = new Auth\Request\V1\Authenticate(
                    new Auth\Model\Credential($user->getEmails()[0]->getId(), 'email'),
                    $this->request->getParam('password')
                );
                $token = $this->authClient->authenticate($reqAuthenticate);

                if ($user->getStatusId() == 0) {
                    $this->confirmUser($user);
                }

                $sessData = $this->session->getData();
                $sessData
                    ->setUserId($user->getUserId())
                    ->setAccessToken($token->getAccess())
                    ->setRefreshToken($token->getRefresh());

                $this->session->save($sessData);

                return $this->redirect('/', 302);
            }

            $this->addAlert('404', 'User not found', self::ALERT_COLOR_RED);
        }

        return $this->render('auth/login');
    }

    /**
     * confirm user
     * @param Users\Response\V1\User $user
     * @throws Users\Exception
     * @throws \NetworkTransport\Http\Exception\MethodNotAllowed
     */
    private function confirmUser(Users\Response\V1\User $user)
    {
        $reqEmails = [];
        if (count($user->getEmails()) > 0) {
            foreach ($user->getEmails() as $email) {
                $reqEmails[] = new Users\Request\V1\Save\Email(
                    $email->getId(),
                    $email->getStatusId(),
                    $email->getEmail()
                );
            }
        }

        $reqPhones = [];
        if (count($user->getPhones()) > 0) {
            foreach ($user->getPhones() as $phone) {
                $reqPhones[] = new Users\Request\V1\Save\Phone(
                    $phone->getId(),
                    $phone->getStatusId(),
                    $phone->getPhone()
                );
            }
        }

        $reqUserUpdate = new Users\Request\V1\Save\User(
            $user->getUserId(),
            1,
            $user->getLogin(),
            !empty($reqEmails) ? $reqEmails : null,
            !empty($reqPhones) ? $reqPhones : null
        );

        $this->userClient->save($reqUserUpdate);
    }
}
