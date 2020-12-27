<?php

declare(strict_types=1);

namespace Pollen\ComingSoon;

use Exception;
use Pollen\ComingSoon\Contracts\ComingSoonContract;

trait ComingSoonAwareTrait
{
    /**
     * Instance du gestionnaire.
     * @var ComingSoonContract|null
     */
    private $comingSoon;

    /**
     * Récupération de l'instance du gestionnaire.
     *
     * @return ComingSoonContract|null
     */
    public function comingSoon(): ?ComingSoonContract
    {
        if (is_null($this->comingSoon)) {
            try {
                $this->comingSoon = ComingSoon::instance();
            } catch (Exception $e) {
                $this->comingSoon;
            }
        }
        return $this->comingSoon;
    }

    /**
     * Définition de l'instance du gestionnaire.
     *
     * @param ComingSoonContract $comingSoon
     *
     * @return static
     */
    public function setComingSoon(ComingSoonContract $comingSoon): self
    {
        $this->comingSoon = $comingSoon;

        return $this;
    }
}