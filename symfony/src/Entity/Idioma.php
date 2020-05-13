<?php

namespace App\Entity;

use App\Repository\IdiomaRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=IdiomaRepository::class)
 */
class Idioma
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
    private $nombre;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $abreviacion;

    public function __construct($nombre, $abreviacion)
    {
        $this->nombre = $nombre;
        $this->abreviacion = $abreviacion;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNombre(): ?string
    {
        return $this->nombre;
    }

    public function setNombre(string $nombre): self
    {
        $this->nombre = $nombre;

        return $this;
    }

    public function getAbreviacion(): ?string
    {
        return $this->abreviacion;
    }

    public function setAbreviacion(string $abreviacion): self
    {
        $this->abreviacion = $abreviacion;

        return $this;
    }

    public function __toString()
    {
        $cadena = $this->nombre . ' ';
        if ($this->abreviacion) $cadena .= $cadena . '(' . $this->abreviacion . ') ';
        return $cadena;
    }
}
