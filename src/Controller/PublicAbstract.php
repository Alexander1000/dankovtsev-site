<?php declare(strict_types = 1);

namespace Controller;

use Beauty;
use Beauty\Request;

abstract class PublicAbstract extends Beauty\Controller\Web
{
    protected \Auth\Repository $authRepository;

    public function __construct(
        Request $request,
        \Auth\Repository $authRepository
    ) {
        parent::__construct($request);
        $this->authRepository = $authRepository;
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

        $curUser = $this->authRepository->getCurrentUser();
        if ($curUser !== null) {
            $data[] = [
                'title' => 'Выход (' . $curUser->getEmails()[0]->getEmail() . ')',
                'link' => '/logout'
            ];
        } else {
            $data[] = [
                'title' => 'Войти',
                'link' => '/login'
            ];
        }

        return $data;
    }
}
