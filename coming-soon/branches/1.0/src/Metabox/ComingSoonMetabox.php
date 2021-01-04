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
    protected $name = 'coming_soon';

    /**
     * @inheritDoc
     */
    public function getTitle(): string
    {
        return $this->title ?? __('Page d\'attente', 'pollen-coming-soon');
    }

    /**
     * @inheritDoc
     */
    public function viewDirectory(): string
    {
        return $this->comingSoon()->resources("/views/metabox/coming-soon");
    }
}