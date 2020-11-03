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
        if ($this->request->isGet()) {
            return $this->render('auth/login');
        }

        $context = [
            'form' => $this->request->getParams(),
        ];

        $user = $this->userClient->getByEmail($this->request->getParam('email'));

        if ($user !== null) {
            $token = $this->authenticateUser($user, $this->request->getParam('password'));

            if ($token !== null) {
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
            } else {
                $this->addAlert(null, 'Ошибка аутентификации!', self::ALERT_COLOR_RED);
            }
        } else {
            $this->addAlert(null, 'Ошибка аутентификации!', self::ALERT_COLOR_RED);
        }

        return $this->render('auth/login', $context);
    }

    /**
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

    /**
     * @param Users\Response\V1\User $user
     * @param string $password
     * @return Auth\Model\Token|null
     * @throws \NetworkTransport\Http\Exception\MethodNotAllowed
     */
    private function authenticateUser(Users\Response\V1\User $user, string $password): ?Auth\Model\Token
    {
        $reqAuthenticate = new Auth\Request\V1\Authenticate(
            new Auth\Model\Credential($user->getEmails()[0]->getId(), 'email'),
            $password
        );

        try {
            $token = $this->authClient->authenticate($reqAuthenticate);
        } catch (Auth\Exception $e) {
            $token = null;
        }

        return $token;
    }
}
