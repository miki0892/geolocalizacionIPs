<?php

namespace App\Entity;

use App\Repository\UbicacionRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=UbicacionRepository::class)
 */
class Ubicacion
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="decimal", precision=5, scale=2)
     */
    private $latitud;

    /**
     * @ORM\Column(type="decimal", precision=5, scale=2)
     */
    private $longitud;

    public function __construct($latitud, $longitud)
    {
        $this->latitud = $latitud;
        $this->longitud = $longitud;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLatitud(): ?string
    {
        return $this->latitud;
    }

    public function setLatitud(string $latitud): self
    {
        $this->latitud = $latitud;

        return $this;
    }

    public function getLongitud(): ?string
    {
        return $this->longitud;
    }

    public function setLongitud(string $longitud): self
    {
        $this->longitud = $longitud;

        return $this;
    }

    public function __toString()
    {
        return '(' . number_format($this->latitud, 0) . ', ' . number_format($this->longitud, 0)  . ')';
    }
}
