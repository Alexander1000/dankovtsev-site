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
        if ($this->request->isPost()) {
            var_dump($this->request->getParams());
        }
        return $this->render('auth/login');
    }
}
