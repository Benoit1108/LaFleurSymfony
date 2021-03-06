<?php

namespace App\Form;

use App\Entity\Utilisateur;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;

class ProfilMdpType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
       
        ->add('password', PasswordType::class, [
            // instead of being set onto the object directly,
            // this is read and encoded in the controller
            'mapped' => false,
            'label' => 'Mot de passe', 
            'constraints' => [
                new NotBlank([
                    'message' => 'Merci de saisir votre mot de passe',
                ]),
                new Length([
                    'min' => 6,
                    'minMessage' => 'Votre mot de passe doit faire au moins {{ limit }} caractères',
                    // max length allowed by Symfony for security reasons
                    'max' => 4096,
                ]),
            ],
        ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Utilisateur::class,
        ]);
    }
}
