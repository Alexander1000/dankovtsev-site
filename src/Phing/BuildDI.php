<?php declare (strict_types = 1);

namespace Phing;

use Symfony\Component\Config\ConfigCache;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Dumper\PhpDumper;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;
use Symfony\Component\Config\FileLocator;

class BuildDI extends \Task
{
    public const ENV_TEST = 'test';
    public const ENV_DEV = 'dev';
    public const ENV_PROD = 'prod';

    private const BUILD_DEPLOY = 'deploy';

    /**
     * @var string
     */
    protected $env;

    /**
     * @inheritdoc
     */
    public function main()
    {
        $builder = new ContainerBuilder();
        $this->loadData($builder);
        $builder->compile();

        $isDebug = $this->env != self::ENV_PROD;
        $containerConfigCache = new ConfigCache(DI_CONTAINER_PATH, $isDebug);
        $containerConfigCache->write(
            (string) (new PhpDumper($builder))->dump([
                'namespace' => 'DI',
                'class' => 'CachedContainer',
                'debug' => $isDebug
            ]),
            $builder->getResources()
        );
    }

    /**
     * @param ContainerBuilder $builder
     * @todo добавить поддержку окружений
     */
    protected function loadData(ContainerBuilder $builder)
    {
        $params = [
            'services.yml',
            'controllers.yml',
            'params.yml'
        ];

        if (file_exists(sprintf('%s/params/%s.yml', DI_CONFIG_PATH, $this->env))) {
            $params[] = sprintf('params/%s.yml', $this->env);
        }

        if (file_exists(sprintf('%s/params/%s.yml', DI_CONFIG_PATH, self::BUILD_DEPLOY))) {
            $params[] = sprintf('params/%s.yml', self::BUILD_DEPLOY);
        }

        $fileLoader = new YamlFileLoader(
            $builder,
            new FileLocator(DI_CONFIG_PATH)
        );

        array_walk($params, function ($configName) use ($fileLoader) {
            $fileLoader->load($configName, 'yml');
        });
    }

    /**
     * @param string $env
     */
    public function setEnv(string $env)
    {
        $this->env = $env;
    }
}
