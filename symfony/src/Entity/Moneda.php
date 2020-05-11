<?php

namespace App\Entity;

use App\Repository\MonedaRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=MonedaRepository::class)
 */
class Moneda
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $codigo;

    /**
     * @ORM\Column(type="decimal", precision=10, scale=6)
     */
    private $cotizacionEnUSD;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCodigo(): ?string
    {
        return $this->codigo;
    }

    public function setCodigo(string $codigo): self
    {
        $this->codigo = $codigo;

        return $this;
    }

    public function getCotizacionEnUSD(): ?string
    {
        return $this->cotizacionEnUSD;
    }

    public function setCotizacionEnUSD(string $cotizacionEnUSD): self
    {
        $this->cotizacionEnUSD = $cotizacionEnUSD;

        return $this;
    }
}
