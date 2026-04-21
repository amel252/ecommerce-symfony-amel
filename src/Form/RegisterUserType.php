<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints\Length;

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
            //  si on utiliser le MDP plusieurs fois 
            ->add('plainPassword', RepeatedType::class,[
                'type'=> PasswordType::class,
                'constraints'=>[
                    new Length([
                        'min'=> 4,
                        'max'=> 30
                    ])
                ],
                'first_options'=>[
                    'label'=> "Votre mot de passe",
                    'attr'=>[
                        'placeholder' => 'Indiquez votre Mot de passe',
                        'class' => 'form-control w-75',
                    ],
                     'hash_property_path'=>'password',
                ],
               

                'second_options'=>[
                    'label'=> "Confirmez votre mot de passe",
                    'attr'=>[
                        'placeholder' => 'Confirmez votre Mot de passe',
                        'class' => 'form-control w-75',
                    ]
                ],
                // plainPassword n'esixte pas dans le modele User, on mettant mapped pour séparer le plainPassword du modele user
                'mapped'=> false, 

               
            ])
            ->add('firstName', TextType::class,[
                'label'=> "Votre nom",
                'constraints'=>[
                    new Length([
                        'min'=>4,
                        'max'=>30
                    ])
                ],
                'attr'=>[
                    'placeholder' => 'Indiquez votre nom',
                    'class' => 'form-control w-75',
                ]
            ])
            ->add('lastName', TextType::class,[
                'label'=> "Votre prénom",
                'constraints'=>[
                    new Length([
                        'min'=>4,
                        'max'=>30
                    ])
                ],
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
            //  on précise ici ce qu'on veux 
            'constraints'=>[
                    new UniqueEntity([
                        'entityClass'=>User::class,
                        'fields'=> 'email'
                    ])
                ],
            'data_class' => User::class,
        ]);
    }
}
