<?php

namespace App\Entity;

use App\Repository\PaisRepository;
use Cassandra\Date;
use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Intl\Timezones;

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
    private $nombreEnEspaniol;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $nombreEnIngles;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $codigoISO;

    /**
     * @ORM\ManyToMany(targetEntity=Moneda::class, cascade={"persist"})
     */
    private $monedas;

    /**
     * @ORM\ManyToMany(targetEntity=Idioma::class, cascade={"persist"})
     */
    private $idiomas;

    /**
     * @ORM\Column(type="array")
     */
    private $zonasHorarias;

    /**
     * @ORM\OneToOne(targetEntity=Ubicacion::class, cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $ubicacion;

    public function __construct()
    {
        $this->idiomas = new ArrayCollection();
        $this->monedas = new ArrayCollection();
    }

    public function cargarInformacionPais($infoPais){
        $this->nombreEnEspaniol = $infoPais["translations"]["es"];
        $this->nombreEnIngles = $infoPais["name"];
        $this->codigoISO = $infoPais["alpha2Code"];
        foreach ($infoPais["languages"] as $lenguaje){
            $idioma = new Idioma($lenguaje["nativeName"], $lenguaje["iso639_1"]);
            $this->idiomas->add($idioma);
        }
        $this->zonasHorarias = $infoPais["timezones"];
        $this->ubicacion = new Ubicacion($infoPais["latlng"][0], $infoPais["latlng"][1]);
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNombreEnEspaniol(): ?string
    {
        return $this->nombreEnEspaniol;
    }

    public function setNombreEnEspaniol(string $nombreEnEspaniol): self
    {
        $this->nombreEnEspaniol = $nombreEnEspaniol;

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


    /**
     * @return Collection|Moneda[]
     */
    public function getMonedas(): Collection
    {
        return $this->monedas;
    }

    public function addMoneda(Moneda $moneda): self
    {
        if (!$this->monedas->contains($moneda)) {
            $this->monedas[] = $moneda;
        }

        return $this;
    }

    public function removeMoneda(Moneda $moneda): self
    {
        if ($this->monedas->contains($moneda)) {
            $this->monedas->removeElement($moneda);
        }

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

    public function getZonasHorarias(): ?array
    {
        return $this->zonasHorarias;
    }

    public function setZonasHorarias(array $zonasHorarias): self
    {
        $this->zonasHorarias = $zonasHorarias;

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

    public function __toString()
    {
        return $this->nombreEnEspaniol . ' (' . $this->nombreEnIngles . ') ';
    }

    public function mostrarHorasSegunFechaActualUTC0($fechaActualArgentina){
        $timeStampActualArgentina = $fechaActualArgentina->getTimestamp();
        $zonasHorariasConFecha = array();
        foreach ($this->zonasHorarias as $zonaHoraria){
            $offset = str_replace('UTC', '', $zonaHoraria);
            if ($offset == "") $offset = "0:0";
            if (substr($offset,0,3) == "-12") $offset = str_replace("-","+",$offset);
            // Calcular segundos desde el offset
            list($horas, $minutos) = explode(':', $offset);
            $segundosOffset = $horas * 60 * 60 + $minutos * 60;
            // Obtengo nombre del timezone a traves de los segundos calculados del offset
            $timeZoneConvertido = timezone_name_from_abbr('', $segundosOffset, true); //true para horario de verano
            // si el timezone es falso entonces se debe buscar por el horario de invierno
            if ($timeZoneConvertido == "" || $timeZoneConvertido == false){
                $timeZoneConvertido = timezone_name_from_abbr('', $segundosOffset, false);
            }
            date_default_timezone_set($timeZoneConvertido);

            $horaSegunZonaHoraria = date('H:i:s', $timeStampActualArgentina);
            $zonaHorariaConFecha = $horaSegunZonaHoraria . ' (' . $zonaHoraria .  ')';
            array_push($zonasHorariasConFecha, $zonaHorariaConFecha);
        }
        return join(' o ', $zonasHorariasConFecha);
    }
}
