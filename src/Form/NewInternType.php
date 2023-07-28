<?php

namespace App\Form;

use App\Entity\Intern;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class NewInternType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('familyName')
            ->add('name')
            ->add('gender')
            ->add('birthDate')
            ->add('town')
            ->add('email')
            ->add('phone')
            ->add('sessions')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Intern::class,
        ]);
    }
}
