<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class RegisterUserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email',EmailType::class , [
                'label'=> "Votre adresse mail",
                'attr'=>[
                    'placeholder' => 'Indiquez votre Adresse email',
                    'class' => 'form-control w-75',
                ]
               

            ])
            ->add('password', PasswordType::class,[
                'label'=> "Votre mot de passe",
                'attr'=>[
                    'placeholder' => 'Indiquez votre Mot de passe',
                    'class' => 'form-control w-75',
                ]
            ])
            ->add('firstName', TextType::class,[
                'label'=> "Votre nom",
                'attr'=>[
                    'placeholder' => 'Indiquez votre nom',
                    'class' => 'form-control w-75',
                ]
            ])
            ->add('lastName', TextType::class,[
                'label'=> "Votre prénom",
                'attr'=>[
                    'placeholder' => 'Indiquez votre nom',
                    'class' => 'form-control w-75',
                ]
            ])
            //  j'ai ajouté le btn submi avec add puis j'ai pris le lien en haut sur la doc 
            ->add('Submit', SubmitType::class,[
                'label'=> "Valider",
                'attr'=>[
                    'class'=> "btn btn-success"
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
