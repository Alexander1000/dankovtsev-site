<?php declare(strict_types = 1);

namespace Auth\Controller;

use Beauty;

abstract class ControllerAbstract extends Beauty\Controller\Web
{
    /**
     * @return string
     */
    public function getTheme(): string
    {
        return 'site';
    }
}
