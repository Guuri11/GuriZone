<?php

namespace App\Form;

use App\Entity\Producto;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
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
            ->add('categoriaProd', ChoiceType::class,[
                'choices'=>[
                        'Accesorios'=>'1',
                        'Ropa'=>'2',
                        'Zapatillas'=>'3'
                    ]
                ])
            ->add('subcategoriaProd', ChoiceType::class,
                [
                    'choices'=>[
                        'Balones'=>'1',
                        'Tableros'=>'2',
                        'Varios'=>'3',
                        'Camisetas NBA'=>'4',
                        'Sudaderas'=>'5',
                        'Camisetas'=>'6',
                        'Chaquetas'=>'7',
                        'Pantalones'=>'8',
                        'Jordan'=>'9',
                        'Nike'=>'10',
                        'Adidas'=>'11',
                    ]
                ])
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
