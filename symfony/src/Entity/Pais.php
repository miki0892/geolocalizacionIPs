<?php

namespace App\Entity;

use App\Repository\PaisRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=PaisRepository::class)
 */
class Pais
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
    private $nombreEsnEspaniol;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $nombreEnIngles;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $codigoISO;

    /**
     * @ORM\ManyToOne(targetEntity=Moneda::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private $moneda;

    /**
     * @ORM\ManyToMany(targetEntity=Idioma::class)
     */
    private $idiomas;

    /**
     * @ORM\ManyToMany(targetEntity=Horario::class)
     */
    private $horarios;

    /**
     * @ORM\OneToOne(targetEntity=Ubicacion::class, cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $ubicacion;

    public function __construct()
    {
        $this->idiomas = new ArrayCollection();
        $this->horarios = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNombreEsnEspaniol(): ?string
    {
        return $this->nombreEsnEspaniol;
    }

    public function setNombreEsnEspaniol(string $nombreEsnEspaniol): self
    {
        $this->nombreEsnEspaniol = $nombreEsnEspaniol;

        return $this;
    }

    public function getNombreEnIngles(): ?string
    {
        return $this->nombreEnIngles;
    }

    public function setNombreEnIngles(string $nombreEnIngles): self
    {
        $this->nombreEnIngles = $nombreEnIngles;

        return $this;
    }

    public function getCodigoISO(): ?string
    {
        return $this->codigoISO;
    }

    public function setCodigoISO(string $codigoISO): self
    {
        $this->codigoISO = $codigoISO;

        return $this;
    }

    public function getMoneda(): ?Moneda
    {
        return $this->moneda;
    }

    public function setMoneda(?Moneda $moneda): self
    {
        $this->moneda = $moneda;

        return $this;
    }

    /**
     * @return Collection|Idioma[]
     */
    public function getIdiomas(): Collection
    {
        return $this->idiomas;
    }

    public function addIdioma(Idioma $idioma): self
    {
        if (!$this->idiomas->contains($idioma)) {
            $this->idiomas[] = $idioma;
        }

        return $this;
    }

    public function removeIdioma(Idioma $idioma): self
    {
        if ($this->idiomas->contains($idioma)) {
            $this->idiomas->removeElement($idioma);
        }

        return $this;
    }

    /**
     * @return Collection|Horario[]
     */
    public function getHorarios(): Collection
    {
        return $this->horarios;
    }

    public function addHorario(Horario $horario): self
    {
        if (!$this->horarios->contains($horario)) {
            $this->horarios[] = $horario;
        }

        return $this;
    }

    public function removeHorario(Horario $horario): self
    {
        if ($this->horarios->contains($horario)) {
            $this->horarios->removeElement($horario);
        }

        return $this;
    }

    public function getUbicacion(): ?Ubicacion
    {
        return $this->ubicacion;
    }

    public function setUbicacion(Ubicacion $ubicacion): self
    {
        $this->ubicacion = $ubicacion;

        return $this;
    }
}
