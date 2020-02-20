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
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\DateTime;
use Vich\UploaderBundle\Form\Type\VichImageType;

class ProductoType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('modeloProd',TextType::class)
            ->add('marcaProd',TextType::class)
            ->add('color',TextType::class)
            ->add('colorDisp')
            ->add('talla',TextType::class)
            ->add('tallaDisp')
            ->add('stockProd')
            ->add('numVentasProd')
            ->add('precioUnidad')
            ->add('imageFile', VichImageType::class, [
                'required' => false,
                'allow_delete' => true,
                'download_label' => '...',
                'download_uri' => true,
                'image_uri' => true,
                'imagine_pattern' => '...',
                'asset_helper' => true,
            ])
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
