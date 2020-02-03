<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Subcategoria
 *
 * @ORM\Table(name="Subcategoria", indexes={@ORM\Index(name="cat_id", columns={"cat_id"})})
 * @ORM\Entity
 */
class Subcategoria
{
    /**
     * @var int
     *
     * @ORM\Column(name="id_sub", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idSub;

    /**
     * @var string
     *
     * @ORM\Column(name="tipo", type="string", length=255, nullable=false)
     */
    private $tipo;

    /**
     * @var \Categorias
     *
     * @ORM\ManyToOne(targetEntity="Categorias")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="cat_id", referencedColumnName="id_cat")
     * })
     */
    private $cat;

    public function getIdSub(): ?int
    {
        return $this->idSub;
    }

    public function getTipo(): ?string
    {
        return $this->tipo;
    }

    public function setTipo(string $tipo): self
    {
        $this->tipo = $tipo;

        return $this;
    }

    public function getCat(): ?Categorias
    {
        return $this->cat;
    }

    public function setCat(?Categorias $cat): self
    {
        $this->cat = $cat;

        return $this;
    }


}
