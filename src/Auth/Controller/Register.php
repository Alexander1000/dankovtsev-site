<?php declare(strict_types = 1);

namespace Auth\Controller;

use Beauty;

class Register extends ControllerAbstract
{
    /**
     * @return Beauty\Http\ResponseInterface
     */
    public function registerAction(): Beauty\Http\ResponseInterface
    {
        return $this->render('auth/register');
    }
}
