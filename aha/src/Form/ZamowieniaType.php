<?php

namespace App\Form;

use App\Entity\Zamowienia;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ZamowieniaType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('data')
            ->add('wartosc')
            ->add('produkt')
            ->add('ileProduktow')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Zamowienia::class,
        ]);
    }
}
