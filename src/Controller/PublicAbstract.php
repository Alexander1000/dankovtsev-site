<?php declare(strict_types = 1);

namespace Controller;

use Beauty;
use Beauty\Request;

abstract class PublicAbstract extends Beauty\Controller\Web
{
    protected \Auth\Repository $authRepository;

    private array $alerts = [];

    protected const ALERT_COLOR_RED = 0;
    protected const ALERT_COLOR_GREEN = 1;

    protected const ALLERT_CLASS = [
        self::ALERT_COLOR_RED => 'danger',
        self::ALERT_COLOR_GREEN => 'success',
    ];

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
        $context['alerts'] = $this->alerts;
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
                'title' => 'Профиль',
                'link' => '/profile',
            ];
            $data[] = [
                'title' => 'Выход (' . $curUser->getEmails()[0]->getEmail() . ')',
                'link' => '/logout',
            ];
        } else {
            $data[] = [
                'title' => 'Войти',
                'link' => '/login',
            ];
        }

        return $data;
    }

    protected function addAlert(string $title, string $text, int $color)
    {
        $this->alerts[] = [
            'title' => $title,
            'text' => $text,
            'color' => self::ALLERT_CLASS[$color],
        ];
    }
}
