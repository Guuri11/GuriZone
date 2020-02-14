<?php

namespace App\Form;

use App\Entity\Categorias;
use App\Entity\Producto;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
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
            ->add('fotoProd',TextType::class,[
                'label'=>'Foto Perfil',
                'data'=>'/imgs/productos/'
            ])
            ->add('descripcion',TextareaType::class)
            ->add('descatalogado',ChoiceType::class,[
                'expanded'=>true,
                'multiple'=>false,
                'choices'=>[
                    'Dar alta'=>'0',
                    'Dar baja'=>'1'
                ]
            ])
            ->add('categoriaProd', EntityType::class,[
                'class'=>Categorias::class,
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
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Producto::class,
        ]);
    }
}
