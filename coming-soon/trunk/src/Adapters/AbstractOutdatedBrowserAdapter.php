<?php

declare(strict_types=1);

namespace Pollen\ComingSoon\Adapters;

use Pollen\ComingSoon\Contracts\ComingSoonContract;
use Pollen\ComingSoon\ComingSoonAwareTrait;

abstract class AbstractOutdatedBrowserAdapter implements AdapterInterface
{
    use ComingSoonAwareTrait;

    /**
     * @param ComingSoonContract $comingSoonManager
     */
    public function __construct(ComingSoonContract $comingSoonManager)
    {
        $this->setComingSoon($comingSoonManager);
    }
}