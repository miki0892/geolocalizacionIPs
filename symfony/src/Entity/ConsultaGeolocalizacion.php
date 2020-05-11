<?php

namespace App\Entity;

use App\Repository\ConsultaGeolocalizacionRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ConsultaGeolocalizacionRepository::class)
 */
class ConsultaGeolocalizacion
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="array")
     */
    private $ips = [];

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $codigoISOPais;

    /**
     * @ORM\OneToOne(targetEntity=Pais::class, cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $pais;

    /**
     * @ORM\Column(type="decimal", precision=7, scale=2)
     */
    private $distanciaDesdeBsAs;

    /**
     * @ORM\Column(type="integer")
     */
    private $cantidadInvocaciones;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIps(): ?array
    {
        return $this->ips;
    }

    public function setIps(array $ips): self
    {
        $this->ips = $ips;

        return $this;
    }

    public function getCodigoISOPais(): ?string
    {
        return $this->codigoISOPais;
    }

    public function setCodigoISOPais(string $codigoISOPais): self
    {
        $this->codigoISOPais = $codigoISOPais;

        return $this;
    }

    public function getPais(): ?Pais
    {
        return $this->pais;
    }

    public function setPais(Pais $pais): self
    {
        $this->pais = $pais;

        return $this;
    }

    public function getDistanciaDesdeBsAs(): ?string
    {
        return $this->distanciaDesdeBsAs;
    }

    public function setDistanciaDesdeBsAs(string $distanciaDesdeBsAs): self
    {
        $this->distanciaDesdeBsAs = $distanciaDesdeBsAs;

        return $this;
    }

    public function getCantidadInvocaciones(): ?int
    {
        return $this->cantidadInvocaciones;
    }

    public function setCantidadInvocaciones(int $cantidadInvocaciones): self
    {
        $this->cantidadInvocaciones = $cantidadInvocaciones;

        return $this;
    }
}
