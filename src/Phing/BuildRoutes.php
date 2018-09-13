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
        $length = strlen(ROOT_PATH . '/src/');
        $phpFiles = array_map(
            function (string $path) use ($length) {
                return substr($path, $length);
            },
            $phpFiles
        );
        var_dump($phpFiles);
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
