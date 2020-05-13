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
            $idioma = new Idioma($lenguaje["name"], $lenguaje["iso639_1"]);
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

    public function mostrarHorasSegunFechaActual($fechaActualArgentina){
        $timeStampActualArgentina = $fechaActualArgentina->getTimestamp();
        //Seteo fecha en timezone UTC 0 para sumarle o restarle las horas segun cada zonaHoraria del pais
        date_default_timezone_set('UTC');
        $fechaActualUTC0 = DateTime::createFromFormat('Y-m-d H:i:s', date('Y-m-d H:i:s', $timeStampActualArgentina));
        $zonasHorariasConFecha = array();
        //Por cada zona horaria calculo la fecha en base al offset (horas y minutos) y a la fecha en UTC
        foreach ($this->zonasHorarias as $zonaHoraria){
            $fechaZonaHoraria = clone $fechaActualUTC0;
            $horaSegunZonaHoraria = $fechaZonaHoraria->format("H:i:s");
            $offset = str_replace('UTC', '', $zonaHoraria);
            if ($offset != "") {
                $signo = $offset[0];
                $horas = explode(":",$offset)[0] . "hours";
                $minutos = $signo . explode(":",$offset)[1] . "minutes";
                $horaSegunZonaHoraria = $fechaZonaHoraria->modify($horas)->modify($minutos)->format("H:i:s");
            }
            $zonaHorariaConFecha = $horaSegunZonaHoraria . ' (' . $zonaHoraria .  ')';
            array_push($zonasHorariasConFecha, $zonaHorariaConFecha);
        }
        return join(' o ', $zonasHorariasConFecha);
    }
}
