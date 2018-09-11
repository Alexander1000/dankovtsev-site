<?php declare(strict_types = 1);

namespace Controller;

use Beauty;

class Errors extends Beauty\Controller\Web
{
    /**
     * @return Beauty\Http\ResponseInterface
     */
    public function notFound(): Beauty\Http\ResponseInterface
    {
        return $this->render('404')
            ->setCode(Beauty\Http\Response::HTTP_CODE_NOT_FOUND);
    }

    /**
     * @return Beauty\Http\ResponseInterface
     */
    public function internalError(): Beauty\Http\ResponseInterface
    {
        return $this->render('50x')
            ->setCode(Beauty\Http\Response::HTTP_CODE_INTERNAL_ERROR);
    }

    /**
     * {@inheritdoc}
     */
    protected function getTheme(): string
    {
        return 'errors';
    }
}
