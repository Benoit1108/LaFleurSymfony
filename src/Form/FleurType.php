<?php

namespace App\Form;

use App\Entity\Fleur;
use App\Entity\Categorie;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class FleurType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('designation')
            ->add('prix')
            ->add('photo')
            ->add('uneCategorie', EntityType::class,[
                'class' => Categorie::class,
                'choice_label' => 'libelle',
                'placeholder' => 'Choisir une catégorie'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Fleur::class,
        ]);
    }
}
