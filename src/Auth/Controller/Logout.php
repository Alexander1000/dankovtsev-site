<?php

declare(strict_types = 1);

namespace Auth\Controller;

use Beauty;
use Alexander1000\Clients\Auth;

class Logout extends ControllerAbstract
{
    /**
     * @return Beauty\Http\ResponseInterface
     */
    public function logoutAction(): Beauty\Http\ResponseInterface
    {
        $sessData = $this->session->getData();
        if ($sessData->getUserId() == 0) {
            return $this->redirect('/', 302);
        }

        $reqAuthLogout = new Auth\Request\V1\Logout($sessData->getAccessToken());
        $this->authClient->logout($reqAuthLogout);

        $sessData->setUserId(0);
        $sessData->setAccessToken('');
        $sessData->setRefreshToken('');
        $this->session->save($sessData);

        return $this->redirect('/', 302);
    }
}
