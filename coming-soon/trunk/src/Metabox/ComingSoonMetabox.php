<?php

declare(strict_types=1);

namespace Pollen\ComingSoon\Metabox;

use Pollen\ComingSoon\ComingSoonAwareTrait;
use tiFy\Metabox\MetaboxDriver;

class ComingSoonMetabox extends MetaboxDriver
{
    use ComingSoonAwareTrait;

    /**
     * @inheritDoc
     */
    protected $alias = 'coming-soon';

    /**
     * @inheritDoc
     */
    public function defaults(): array
    {
        return array_merge(
            parent::defaults(),
            [
                'title' => __('Accès au site', 'pollen-coming-soon'),
            ]
        );
    }

    /**
     * @inheritDoc
     */
    public function viewDirectory(): string
    {
        return $this->comingSoon()->resources("/views/metabox/{$this->getAlias()}");
    }
}