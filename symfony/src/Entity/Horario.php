<?php

namespace App\Entity;

use App\Repository\HorarioRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=HorarioRepository::class)
 */
class Horario
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
    private $zonaHoraria;

    /**
     * @ORM\Column(type="time")
     */
    private $hora;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getZonaHoraria(): ?string
    {
        return $this->zonaHoraria;
    }

    public function setZonaHoraria(string $zonaHoraria): self
    {
        $this->zonaHoraria = $zonaHoraria;

        return $this;
    }

    public function getHora(): ?\DateTimeInterface
    {
        return $this->hora;
    }

    public function setHora(\DateTimeInterface $hora): self
    {
        $this->hora = $hora;

        return $this;
    }
}
