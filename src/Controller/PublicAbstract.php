<?php declare(strict_types = 1);

namespace Controller;

use Beauty;
use Session;
use Alexander1000\Clients\Users;
use Alexander1000\Clients\Auth;
use Beauty\Request;

abstract class PublicAbstract extends Beauty\Controller\Web
{
    protected Session $session;

    protected Users\Client $userClient;

    protected Auth\Client $authClient;

    public function __construct(
        Request $request,
        Session $session,
        Users\Client $userClient,
        Auth\Client $authClient
    ) {
        parent::__construct($request);
        $this->session = $session;
        $this->userClient = $userClient;
        $this->authClient = $authClient;
    }

    /**
     * @return string
     */
    public function getTheme(): string
    {
        return 'site';
    }

    /**
     * @inheritDoc
     */
    protected function render(string $template, array $context = []): Beauty\Http\ResponseInterface
    {
        $context['menuItems'] = $this->getMenuItems();
        return parent::render($template, $context);
    }

    /**
     * @return array
     */
    protected function getMenuItems(): array
    {
        $data = [
            [
                'title' => 'Главная',
                'link' => '/'
            ],
            [
                'title' => 'История проектов (blog)'
            ],
            [
                'title' => 'Мои работы'
            ]
        ];

        $sessData = $this->session->getData();
        if ($sessData->getUserId() > 0) {
            $user = $this->userClient->getById($sessData->getUserId());
            $data[] = [
                'title' => 'Выход (' . $user->getEmails()[0]->getEmail() . ')',
                'link' => '/logout'
            ];
        }

        return $data;
    }
}
