<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Categorias
 *
 * @ORM\Table(name="Categorias")
 * @ORM\Entity
 */
class Categorias
{
    /**
     * @var int
     *
     * @ORM\Column(name="id_cat", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idCat;

    /**
     * @var string
     *
     * @ORM\Column(name="tipo_cat", type="string", length=255, nullable=false)
     */
    private $tipoCat;

    public function getIdCat(): ?int
    {
        return $this->idCat;
    }

    public function getTipoCat(): ?string
    {
        return $this->tipoCat;
    }

    public function setTipoCat(string $tipoCat): self
    {
        $this->tipoCat = $tipoCat;

        return $this;
    }
    public function __toString()
    {
        return (string) $this->idCat;
    }
}
