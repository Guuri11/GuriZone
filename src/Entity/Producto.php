<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Producto
 *
 * @ORM\Table(name="Producto", indexes={@ORM\Index(name="subcategoria_prod", columns={"subcategoria_prod"}), @ORM\Index(name="Producto_ibfk_3", columns={"id_empleado"}), @ORM\Index(name="categoria_prod", columns={"categoria_prod"})})
 * @ORM\Entity
 */
class Producto
{
    /**
     * @var int
     *
     * @ORM\Column(name="id_prod", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idProd;

    /**
     * @var string
     *
     * @ORM\Column(name="modelo_prod", type="string", length=255, nullable=false)
     */
    private $modeloProd;

    /**
     * @var string
     *
     * @ORM\Column(name="marca_prod", type="string", length=255, nullable=false)
     */
    private $marcaProd;

    /**
     * @var string
     *
     * @ORM\Column(name="color", type="string", length=255, nullable=false)
     */
    private $color;

    /**
     * @var int
     *
     * @ORM\Column(name="color_disp", type="integer", nullable=false)
     */
    private $colorDisp;

    /**
     * @var string
     *
     * @ORM\Column(name="talla", type="string", length=255, nullable=false)
     */
    private $talla;

    /**
     * @var int
     *
     * @ORM\Column(name="talla_disp", type="integer", nullable=false)
     */
    private $tallaDisp;

    /**
     * @var int
     *
     * @ORM\Column(name="stock_prod", type="integer", nullable=false)
     */
    private $stockProd;

    /**
     * @var int
     *
     * @ORM\Column(name="num_ventas_prod", type="integer", nullable=false)
     */
    private $numVentasProd;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fecha_salida", type="datetime", nullable=false)
     */
    private $fechaSalida;

    /**
     * @var float
     *
     * @ORM\Column(name="precio_unidad", type="float", precision=10, scale=0, nullable=false)
     */
    private $precioUnidad;

    /**
     * @var string
     *
     * @ORM\Column(name="foto_prod", type="string", length=255, nullable=false)
     */
    private $fotoProd;

    /**
     * @var string
     *
     * @ORM\Column(name="descripcion", type="text", length=0, nullable=false)
     */
    private $descripcion;

    /**
     * @var bool
     *
     * @ORM\Column(name="descatalogado", type="boolean", nullable=false)
     */
    private $descatalogado;

    /**
     * @var \Categorias
     *
     * @ORM\ManyToOne(targetEntity="Categorias")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="categoria_prod", referencedColumnName="id_cat")
     * })
     */
    private $categoriaProd;

    /**
     * @var \Subcategoria
     *
     * @ORM\ManyToOne(targetEntity="Subcategoria")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="subcategoria_prod", referencedColumnName="id_sub")
     * })
     */
    private $subcategoriaProd;

    /**
     * @var \Usuario
     *
     * @ORM\ManyToOne(targetEntity="Usuario")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_empleado", referencedColumnName="id_cli")
     * })
     */
    private $idEmpleado;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="Pedidos", inversedBy="idProd")
     * @ORM\JoinTable(name="pedido",
     *   joinColumns={
     *     @ORM\JoinColumn(name="id_prod", referencedColumnName="id_prod")
     *   },
     *   inverseJoinColumns={
     *     @ORM\JoinColumn(name="id_ped", referencedColumnName="id_ped")
     *   }
     * )
     */
    private $idPed;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->idPed = new \Doctrine\Common\Collections\ArrayCollection();
    }

    public function getIdProd(): ?int
    {
        return $this->idProd;
    }

    public function getModeloProd(): ?string
    {
        return $this->modeloProd;
    }

    public function setModeloProd(string $modeloProd): self
    {
        $this->modeloProd = $modeloProd;

        return $this;
    }

    public function getMarcaProd(): ?string
    {
        return $this->marcaProd;
    }

    public function setMarcaProd(string $marcaProd): self
    {
        $this->marcaProd = $marcaProd;

        return $this;
    }

    public function getColor(): ?string
    {
        return $this->color;
    }

    public function setColor(string $color): self
    {
        $this->color = $color;

        return $this;
    }

    public function getColorDisp(): ?int
    {
        return $this->colorDisp;
    }

    public function setColorDisp(int $colorDisp): self
    {
        $this->colorDisp = $colorDisp;

        return $this;
    }

    public function getTalla(): ?string
    {
        return $this->talla;
    }

    public function setTalla(string $talla): self
    {
        $this->talla = $talla;

        return $this;
    }

    public function getTallaDisp(): ?int
    {
        return $this->tallaDisp;
    }

    public function setTallaDisp(int $tallaDisp): self
    {
        $this->tallaDisp = $tallaDisp;

        return $this;
    }

    public function getStockProd(): ?int
    {
        return $this->stockProd;
    }

    public function setStockProd(int $stockProd): self
    {
        $this->stockProd = $stockProd;

        return $this;
    }

    public function getNumVentasProd(): ?int
    {
        return $this->numVentasProd;
    }

    public function setNumVentasProd(int $numVentasProd): self
    {
        $this->numVentasProd = $numVentasProd;

        return $this;
    }

    public function getFechaSalida(): ?\DateTimeInterface
    {
        return $this->fechaSalida;
    }

    public function setFechaSalida(\DateTimeInterface $fechaSalida): self
    {
        $this->fechaSalida = $fechaSalida;

        return $this;
    }

    public function getPrecioUnidad(): ?float
    {
        return $this->precioUnidad;
    }

    public function setPrecioUnidad(float $precioUnidad): self
    {
        $this->precioUnidad = $precioUnidad;

        return $this;
    }

    public function getFotoProd(): ?string
    {
        return $this->fotoProd;
    }

    public function setFotoProd(string $fotoProd): self
    {
        $this->fotoProd = $fotoProd;

        return $this;
    }

    public function getDescripcion(): ?string
    {
        return $this->descripcion;
    }

    public function setDescripcion(string $descripcion): self
    {
        $this->descripcion = $descripcion;

        return $this;
    }

    public function getDescatalogado(): ?bool
    {
        return $this->descatalogado;
    }

    public function setDescatalogado(bool $descatalogado): self
    {
        $this->descatalogado = $descatalogado;

        return $this;
    }

    public function getCategoriaProd(): ?Categorias
    {
        return $this->categoriaProd;
    }

    public function setCategoriaProd(?Categorias $categoriaProd): self
    {
        $this->categoriaProd = $categoriaProd;

        return $this;
    }

    public function getSubcategoriaProd(): ?Subcategoria
    {
        return $this->subcategoriaProd;
    }

    public function setSubcategoriaProd(?Subcategoria $subcategoriaProd): self
    {
        $this->subcategoriaProd = $subcategoriaProd;

        return $this;
    }

    public function getIdEmpleado(): ?Usuario
    {
        return $this->idEmpleado;
    }

    public function setIdEmpleado(?Usuario $idEmpleado): self
    {
        $this->idEmpleado = $idEmpleado;

        return $this;
    }

    /**
     * @return Collection|Pedidos[]
     */
    public function getIdPed(): Collection
    {
        return $this->idPed;
    }

    public function addIdPed(Pedidos $idPed): self
    {
        if (!$this->idPed->contains($idPed)) {
            $this->idPed[] = $idPed;
        }

        return $this;
    }

    public function removeIdPed(Pedidos $idPed): self
    {
        if ($this->idPed->contains($idPed)) {
            $this->idPed->removeElement($idPed);
        }

        return $this;
    }

}
