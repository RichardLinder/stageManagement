<?php

namespace App\Form;

use App\Entity\Intern;
use App\Entity\Session;
use App\Entity\Formation;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;

class SessionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('maxParticipant',IntegerType ::class)
            ->add('startingDate', DateType::class)
            ->add('endDate',DateType::class)
            ->add
                (
                        'formation', EntityType::class,
                        [
                            'class' => Formation::class,
                            'mapped' => false
                        ]
                )
    
               
                
                ->add('valider', SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Session::class,
        ]);
    }
}
