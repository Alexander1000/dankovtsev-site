<?php declare(strict_types = 1);

namespace Auth\Controller;

use Beauty;

class Login extends ControllerAbstract
{
    /**
     * @return Beauty\Http\ResponseInterface
     */
    public function loginAction(): Beauty\Http\ResponseInterface
    {
        return $this->render('auth/login');
    }
}
