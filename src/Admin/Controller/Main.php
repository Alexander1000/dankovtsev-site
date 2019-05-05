<?php declare(strict_types = 1);

namespace Admin\Controller;

use Beauty;
use Beauty\Request;

class Main extends AbstractController
{
    /**
     * @var \Session\SessionServiceClient
     */
    private $sessionService;

    public function __construct(Request $request, \Session\SessionServiceClient $sessionService)
    {
        parent::__construct($request);
        $this->sessionService = $sessionService;
    }

    /**
     * @return Beauty\Http\ResponseInterface
     */
    public function indexAction(): Beauty\Http\ResponseInterface
    {
        return $this->render('index');
    }
}
