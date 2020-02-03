<?php

namespace App\Form;

use App\Entity\Producto;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProductoType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('modeloProd')
            ->add('marcaProd')
            ->add('color')
            ->add('colorDisp')
            ->add('talla')
            ->add('tallaDisp')
            ->add('stockProd')
            ->add('numVentasProd')
            ->add('fechaSalida')
            ->add('precioUnidad')
            ->add('fotoProd')
            ->add('descripcion')
            ->add('descatalogado')
            ->add('categoriaProd')
            ->add('subcategoriaProd')
            ->add('idEmpleado')
            ->add('idPed')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Producto::class,
        ]);
    }
}
