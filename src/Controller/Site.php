<?php declare(strict_types = 1);

namespace Controller;

use Beauty;

class Site extends Beauty\Controller\Web
{
    /**
     * @return Beauty\Http\ResponseInterface
     */
    public function indexAction(): Beauty\Http\ResponseInterface
    {
        return $this->render('index');
    }

    /**
     * @return string
     */
    public function getTheme(): string
    {
        return 'site';
    }
}
