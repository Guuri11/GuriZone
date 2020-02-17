<?php

namespace App\Form;

use App\Entity\Categorias;
use App\Entity\Producto;
use App\Entity\Subcategoria;
use App\Entity\Usuario;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\DateTime;

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
            ->add('fechaSalida',HiddenType::class,
                [
                    'data'=>\DateTime::createFromFormat('Y-m-d H:i:s',time())
                ])
            ->add('precioUnidad')
            ->add('fotoProd',TextType::class,[
                'label'=>'Foto Perfil',
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
                'choice_label'=>'tipoCat'
                ])
            ->add('subcategoriaProd', EntityType::class,
                [
                    'class'=>Subcategoria::class,
                    'choice_label'=>'tipo'
                ])
            ->add('idEmpleado',EntityType::class,
                [
                    'class'=>Usuario::class,
                    'choice_label'=>'email'
                ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Producto::class,
        ]);
    }
}
