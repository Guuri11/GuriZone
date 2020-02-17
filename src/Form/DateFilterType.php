<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class DateFilterType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('fecha_inicial',DateType::class,
            [
                'required'=>false,
                'label'=>'Fecha inicial',
                'widget'=>'single_text'
            ])
            ->add('fecha_final',DateType::class,
                [
                    'required'=>false,
                    'label'=>'Fecha final',
                    'widget'=>'single_text'
                ])
            ->add('filtrar',SubmitType::class,
                [
                    'label'=>'Filtrar'
                ])
            ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
