<?php declare(strict_types = 1);

namespace Phing;

class BuildRoutes extends \Task
{
    protected $cache;

    /**
     * @inheritdoc
     */
    public function main()
    {
        $phpFiles = $this->scanDir(ROOT_PATH . '/src');
        foreach ($phpFiles as $file) {
            $this->processFile($file);
        }
    }

    /**
     * @param string $path
     */
    private function processFile(string $path)
    {
        $length = strlen(ROOT_PATH . '/src/');
        $phpClass = str_replace('/', '\\', substr($path, $length, -4));

        if (class_exists($phpClass)) {
            $refClass = new \ReflectionClass($phpClass);
            $docComments = $refClass->getDocComment();
            if ($docComments !== false) {
                $this->processDocComment($docComments);
            }
        } else {
            echo "Class {$phpClass} does not exists" . PHP_EOL;
        }
    }

    /**
     * Разбор phpDocComment-а
     * Поиск yml-файла
     * @param string $docComment
     */
    private function processDocComment(string $docComment)
    {
        if (!preg_match('/@router\s([\w\/_]+\.yml)/m', $docComment, $matches)) {
            return;
        }

        $ymlFile = $matches[1];
    }

    /**
     * @param string $path
     * @return array
     */
    private function scanDir(string $path): array
    {
        $files = [];
        foreach (new \DirectoryIterator($path) as $info) {
            if ($info->isDir()) {
                if ($info->getFilename() == '.' || $info->getFilename() == '..') {
                    continue;
                }
                $files = array_merge($files, $this->scanDir($info->getPath() . '/' . $info->getFilename()));
            } elseif ($info->getExtension() == 'php') {
                $files[] = $info->getPath() . '/' . $info->getFilename();
            }
        }

        return $files;
    }

    /**
     * @param string $cache
     */
    public function setCache(string $cache)
    {
        $this->cache = $cache;
    }
}
