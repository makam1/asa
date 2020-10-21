<?php

namespace App\Form;

use App\Entity\Evenement;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TimeType;
use App\Entity\Enfant;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class EvenType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        ->add('libelle')
        ->add('descriptif')
        ->add('datedebut',DateType::class, [
            'widget' => 'single_text',
            'format' => 'dd-MM-yyyy',
        ])
        ->add('heuredebut',TimeType::class, [
            'widget' => 'single_text',
        ])
        ->add('heurefin',TimeType::class, [
            'widget' => 'single_text',
        ])
        ->add('statut')
        ->add('frequence')
        ->add('enfant', EntityType::class, [
            'class' => Enfant::class,
            'choice_label' => 'enfant_id',
            
        ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Evenement::class,
        ]);
    }
}
