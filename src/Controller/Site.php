<?php declare(strict_types = 1);

namespace Controller;

use Beauty;

class Site extends PublicAbstract
{
    /**
     * @return Beauty\Http\ResponseInterface
     */
    public function indexAction(): Beauty\Http\ResponseInterface
    {
        return $this->render('index');
    }
}
