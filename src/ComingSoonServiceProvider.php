<?php

declare(strict_types=1);

namespace Pollen\ComingSoon;

use Pollen\ComingSoon\Adapters\WordpressAdapter;
use Pollen\ComingSoon\Contracts\ComingSoonContract;
use tiFy\Container\ServiceProvider;

class ComingSoonServiceProvider extends ServiceProvider
{
    /**
     * @inheritDoc
     */
    protected $provides = [
        ComingSoonContract::class,
        WordpressAdapter::class,
    ];

    /**
     * @inheritDoc
     */
    public function boot(): void
    {
        events()->listen(
            'wp.booted',
            function () {
                /** @var ComingSoonContract $comingSoon */
                $comingSoon = $this->getContainer()->get(ComingSoonContract::class);

                $comingSoon->setAdapter($this->getContainer()->get(WordpressAdapter::class))->boot();
            }
        );
    }

    /**
     * @inheritDoc
     */
    public function register(): void
    {
        $this->getContainer()->share(
            ComingSoonContract::class,
            function () {
                return new ComingSoon(config('coming-soon', []), $this->getContainer());
            }
        );

        $this->registerAdapters();
    }

    /**
     * Déclaration des adapteurs.
     *
     * @return void
     */
    public function registerAdapters(): void
    {
        $this->getContainer()->share(
            WordpressAdapter::class,
            function () {
                return new WordpressAdapter($this->getContainer()->get(ComingSoonContract::class));
            }
        );
    }
}