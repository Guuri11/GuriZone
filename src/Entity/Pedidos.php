<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Pedidos
 *
 * @ORM\Table(name="Pedidos", indexes={@ORM\Index(name="cliente", columns={"cliente"})})
 * @ORM\Entity
 */
class Pedidos
{
    /**
     * @var int
     *
     * @ORM\Column(name="id_ped", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idPed;

    /**
     * @var bool
     *
     * @ORM\Column(name="entregado", type="boolean", nullable=false)
     */
    private $entregado;

    /**
     * @var bool
     *
     * @ORM\Column(name="pagado", type="boolean", nullable=false)
     */
    private $pagado;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fecha_entrega", type="datetime", nullable=false)
     */
    private $fechaEntrega;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fecha_pagado", type="datetime", nullable=false)
     */
    private $fechaPagado;

    /**
     * @var \Usuario
     *
     * @ORM\ManyToOne(targetEntity="Usuario")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="cliente", referencedColumnName="id_cli")
     * })
     */
    private $cliente;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="Producto", mappedBy="idPed")
     */
    private $idProd;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->idProd = new \Doctrine\Common\Collections\ArrayCollection();
    }

    public function getIdPed(): ?int
    {
        return $this->idPed;
    }

    public function getEntregado(): ?bool
    {
        return $this->entregado;
    }

    public function setEntregado(bool $entregado): self
    {
        $this->entregado = $entregado;

        return $this;
    }

    public function getPagado(): ?bool
    {
        return $this->pagado;
    }

    public function setPagado(bool $pagado): self
    {
        $this->pagado = $pagado;

        return $this;
    }

    public function getFechaEntrega(): ?\DateTimeInterface
    {
        return $this->fechaEntrega;
    }

    public function setFechaEntrega(\DateTimeInterface $fechaEntrega): self
    {
        $this->fechaEntrega = $fechaEntrega;

        return $this;
    }

    public function getFechaPagado(): ?\DateTimeInterface
    {
        return $this->fechaPagado;
    }

    public function setFechaPagado(\DateTimeInterface $fechaPagado): self
    {
        $this->fechaPagado = $fechaPagado;

        return $this;
    }

    public function getCliente(): ?Usuario
    {
        return $this->cliente;
    }

    public function setCliente(?Usuario $cliente): self
    {
        $this->cliente = $cliente;

        return $this;
    }

    /**
     * @return Collection|Producto[]
     */
    public function getIdProd(): Collection
    {
        return $this->idProd;
    }

    public function addIdProd(Producto $idProd): self
    {
        if (!$this->idProd->contains($idProd)) {
            $this->idProd[] = $idProd;
            $idProd->addIdPed($this);
        }

        return $this;
    }

    public function removeIdProd(Producto $idProd): self
    {
        if ($this->idProd->contains($idProd)) {
            $this->idProd->removeElement($idProd);
            $idProd->removeIdPed($this);
        }

        return $this;
    }

}
