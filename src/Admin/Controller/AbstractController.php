<?php declare(strict_types = 1);

namespace Admin\Controller;

use Beauty;

abstract class AbstractController extends Beauty\Controller\Web
{
    /**
     * @return string
     */
    public function getTheme(): string
    {
        return 'admin';
    }
}
