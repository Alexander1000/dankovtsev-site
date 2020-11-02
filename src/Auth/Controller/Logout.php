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
        return $this->render('index');
    }
}
