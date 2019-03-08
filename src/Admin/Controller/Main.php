<?php declare(strict_types = 1);

namespace Admin\Controller;

use Beauty;

class Main extends AbstractController
{
    /**
     * @return Beauty\Http\ResponseInterface
     */
    public function indexAction(): Beauty\Http\ResponseInterface
    {
        return $this->render('index');
    }
}
