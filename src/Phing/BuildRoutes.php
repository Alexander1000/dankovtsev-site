<?php declare(strict_types = 1);

namespace Phing;

class BuildRoutes extends \Task
{
    protected $cache;

    /**
     * @inheritdoc
     * @throws \ReflectionException
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
     * @throws \ReflectionException
     */
    private function processFile(string $path)
    {
        $length = strlen(ROOT_PATH . '/src/');
        $phpClass = str_replace('/', '\\', substr($path, $length, -4));

        if (class_exists($phpClass)) {
            $refClass = new \ReflectionClass($phpClass);
            $docComments = $refClass->getDocComment();
            if ($docComments !== false) {
                $ymlFile = $this->getYmlFromDocComment($docComments);
                if ($ymlFile !== null) {
                    $this->log(sprintf('yml file: %s', $ymlFile));

                    if (!file_exists(ROOT_PATH . '/' . $ymlFile)) {
                        throw new \InvalidArgumentException(
                            sprintf('yml file "%s" not found', $ymlFile)
                        );
                    }

                    $routes = yaml_parse_file(ROOT_PATH . '/' . $ymlFile);
                    if ($routes === false) {
                        throw new \InvalidArgumentException(
                            sprintf('fail on parse yml file "%s"', $ymlFile)
                        );
                    }

                    $fileName = str_replace('\\', '_', $phpClass);
                    $relativeFileName = ROOT_PATH . '/' . $this->cache . '/' . $fileName . '.php';
                    $content = var_export($routes, true);

                    $this->log(sprintf('cached to: %s', $relativeFileName));

                    file_put_contents(
                        $relativeFileName,
                        sprintf("<?php\nreturn %s;", $content)
                    );
                    $sourceTime = filemtime(ROOT_PATH . '/' . $ymlFile);
                    touch($relativeFileName, $sourceTime);
                }
            }
        } else {
            echo "Class {$phpClass} does not exists" . PHP_EOL;
        }
    }

    /**
     * Разбор phpDocComment-а
     * Поиск yml-файла
     * @param string $docComment
     * @return string|null
     */
    private function getYmlFromDocComment(string $docComment): ?string
    {
        if (!preg_match('/@router\s([\w\/_]+\.yml)/m', $docComment, $matches)) {
            return null;
        }

        return $matches[1];
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
