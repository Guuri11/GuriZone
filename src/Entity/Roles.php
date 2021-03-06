<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Roles
 *
 * @ORM\Table(name="Roles")
 * @ORM\Entity
 */
class Roles
{
    /**
     * @var int
     *
     * @ORM\Column(name="id_rol", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idRol;

    /**
     * @var string
     *
     * @ORM\Column(name="tipo_rol", type="string", length=255, nullable=false)
     */
    private $tipoRol;

    public function getIdRol(): ?int
    {
        return $this->idRol;
    }

    public function getTipoRol(): ?string
    {
        return $this->tipoRol;
    }

    public function setRol(int $idRol): self
    {
        $this->idRol = $idRol;

        return $this;
    }

    public function setTipoRol(string $tipoRol): self
    {
        $this->tipoRol = $tipoRol;

        return $this;
    }

    public function getRoles():?array
    {
        return [$this->getTipoRol()];
    }

    public function __toString()
    {
        return (string) $this->getTipoRol();
    }

}
