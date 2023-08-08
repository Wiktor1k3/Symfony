<?php

namespace App\Form;

use App\Entity\PersonalDate;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PersonalDateType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('Name')
            ->add('Lastname')
            ->add('PostalCode')
            ->add('city')
            ->add('StreetAndNumberHouse')
            ->add('Country')
            ->add('MobileNumber')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => PersonalDate::class,
        ]);
    }
}
