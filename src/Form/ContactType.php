<?php

namespace App\Form;

use App\Entity\Contact;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class ContactType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('objet', ChoiceType::class,
            [
                'choices' => [
                    'Demande de renseignements' => 'Demande de renseignements',
                    'Service après-vente' => 'Service après-vente'
                ],
                'placeholder' => 'Choisir un motif',
            ])
            ->add('nom')
            ->add('type', ChoiceType::class,
            [
                'choices' => [
                    'Entreprise' => 'Entreprise',
                    'Particulier' => 'Particulier',
                    'Association' => 'Association'
                ],
                'expanded' => true,
            ])
            ->add('profession', ChoiceType::class,
            [
                'choices' => [

                    'Fleuriste' => 'Fleuriste',
                    'Grossiste' => 'Grossiste',
                    'Autre' => 'Autre'
                ],
                'expanded' => true,
            ])
            ->add('mail')
            ->add('demande')

        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Contact::class,
        ]);
    }
}
