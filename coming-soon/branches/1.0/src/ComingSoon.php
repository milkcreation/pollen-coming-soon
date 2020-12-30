<?php

declare(strict_types=1);

namespace Pollen\ComingSoon;

use Pollen\ComingSoon\Adapters\AdapterInterface;
use Pollen\ComingSoon\Contracts\ComingSoonContract;
use Psr\Container\ContainerInterface as Container;
use RuntimeException;
use tiFy\Contracts\Filesystem\LocalFilesystem;
use tiFy\Support\Concerns\BootableTrait;
use tiFy\Support\Concerns\ContainerAwareTrait;
use tiFy\Support\ParamsBag;
use tiFy\Support\Proxy\Storage;

class ComingSoon implements ComingSoonContract
{
    use BootableTrait;
    use ContainerAwareTrait;

    /**
     * Instance de la classe.
     * @var static|null
     */
    private static $instance;

    /**
     * Instance de l'adapteur associé.
     * @var AdapterInterface
     */
    private $adapter;

    /**
     * Instance du gestionnaire de configuration.
     * @var ParamsBag
     */
    private $configBag;

    /**
     * Instance du gestionnaire des ressources
     * @var LocalFilesystem|null
     */
    private $resources;

    /**
     * @param array $config
     * @param Container|null $container
     *
     * @return void
     */
    public function __construct(array $config = [], Container $container = null)
    {
        $this->setConfig($config);

        if (!is_null($container)) {
            $this->setContainer($container);
        }

        if (!self::$instance instanceof static) {
            self::$instance = $this;
        }
    }

    /**
     * @inheritDoc
     */
    public static function instance(): ComingSoonContract
    {
        if (self::$instance instanceof self) {
            return self::$instance;
        }
        throw new RuntimeException(sprintf('Unavailable %s instance', __CLASS__));
    }

    /**
     * @inheritDoc
     */
    public function boot(): ComingSoonContract
    {
        if (!$this->isBooted()) {
            events()->trigger('coming-soon.booting', [$this]);

            $this->setBooted();

            events()->trigger('coming-soon.booted', [$this]);
        }
        return $this;
    }

    /**
     * @inheritDoc
     */
    public function config($key = null, $default = null)
    {
        if (!isset($this->configBag) || is_null($this->configBag)) {
            $this->configBag = new ParamsBag();
        }

        if (is_string($key)) {
            return $this->configBag->get($key, $default);
        } elseif (is_array($key)) {
            return $this->configBag->set($key);
        } else {
            return $this->configBag;
        }
    }

    /**
     * @inheritDoc
     */
    public function getAdapter(): ?AdapterInterface
    {
        return $this->adapter;
    }

    /**
     * @inheritDoc
     */
    public function resources(?string $path = null)
    {
        if (!isset($this->resources) || is_null($this->resources)) {
            $this->resources = Storage::local(dirname(__DIR__) . DIRECTORY_SEPARATOR . 'resources');
        }

        return is_null($path) ? $this->resources : $this->resources->path($path);
    }

    /**
     * @inheritDoc
     */
    public function setAdapter(AdapterInterface $adapter): ComingSoonContract
    {
        $this->adapter = $adapter;

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function setConfig(array $attrs): ComingSoonContract
    {
        $this->config($attrs);

        return $this;
    }
}