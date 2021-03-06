<?php

namespace App\Entity;

use App\Repository\GeolocalizacionRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=GeolocalizacionRepository::class)
 */
class Geolocalizacion
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank
     * @Assert\Ip(message = "La dirección IP ingresada no es válida.", version="all")
     */
    private $ultimaIpConsultada;

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

    public function cargarInformacionPais($infoPais){
        $this->codigoISOPais = $infoPais["alpha2Code"];
        $this->pais = new Pais();
        $this->pais->cargarInformacionPais($infoPais);
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUltimaIpConsultada(): ?string
    {
        return $this->ultimaIpConsultada;
    }

    public function setUltimaIpConsultada(string $ip): self
    {
        $this->ultimaIpConsultada = $ip;

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


    public function aumentarCantidadInvocaciones(){
        $this->cantidadInvocaciones = $this->cantidadInvocaciones + 1;
    }
}
