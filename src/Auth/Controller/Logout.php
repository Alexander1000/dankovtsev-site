<?php

declare(strict_types = 1);

namespace Auth\Controller;

use Beauty;

class Logout extends ControllerAbstract
{
    /**
     * @return Beauty\Http\ResponseInterface
     */
    public function logoutAction(): Beauty\Http\ResponseInterface
    {
        $sessData = $this->session->getData();
        if ($sessData->getUserId() == 0) {
            return $this->redirect('/', 301);
        }

        return $this->render('index');
    }
}
