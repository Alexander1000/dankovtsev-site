<?php declare(strict_types = 1);

namespace Admin\Controller;

use Beauty;
use Beauty\Request;

class Main extends AbstractController
{
    /**
     * @var \Session
     */
    private $session;

    public function __construct(Request $request, \Session $session)
    {
        parent::__construct($request);
        $this->session = $session;
    }

    /**
     * @return Beauty\Http\ResponseInterface
     */
    public function indexAction(): Beauty\Http\ResponseInterface
    {
        $context = [
            'sessId' => '',
            'userId' => 0,
            'accessToken' => '',
            'refreshToken' => '',
        ];

        try {
            $sessionData = $this->session->getData();
            $context['sessId'] = $sessionData->getId();
            $context['userId'] = $sessionData->getUserId();
            $context['accessToken'] = $sessionData->getAccessToken();
            $context['refreshToken'] = $sessionData->getRefreshToken();
        } catch (\Throwable $e) {
            var_dump($e);
        }

        return $this->render('index', $context);
    }
}
