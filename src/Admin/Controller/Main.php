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
        $context = [
            'userId' => 0,
            'accessToken' => '',
            'refreshToken' => '',
        ];

        try {
            $response = $this->sessionService->Get(
                (new \Session\GetRequest())
                    ->setSessid('some-value')
            );
            if ($response) {
                $result = $response->wait();
                $getResponse = $result[0];
                if ($getResponse instanceof \Session\GetResponse) {
                    $context['userId'] = $getResponse->getUserId();
                    $context['accessToken'] = $getResponse->getAccessToken();
                    $context['refreshToken'] = $getResponse->getRefreshToken();
                }
            }
        } catch (\Throwable $e) {
            var_dump($e);
        }
        return $this->render('index', $context);
    }
}
