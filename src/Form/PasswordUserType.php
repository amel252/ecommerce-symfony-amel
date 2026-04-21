<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormError;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Validator\Constraints\Length;

class PasswordUserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('actualpassword', PasswordType::class,[
                'label' => "Votre mot de passe actuel",
                'attr' => [
                    'placeholder' =>  "Indiquez votre mot de passe actuel"
                ],
                'mapped'=> false,
            ])
            
         
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
                //  ne pas relier une colonne qui n'existe a notre entity user 
                'mapped'=> false,
            ])
            ->add('Submit', SubmitType::class,[
                'label'=> "Mettre à jour mon mot de passe",
                'attr'=>[
                    'class'=> "btn btn-success"
                ]
            ])
            //  dés que le formulaire est soumi ecoute cet evenement en cas de modif 
                ->addEventListener(FormEvents::SUBMIT, function(formEvent $event){
                    // chercher le formulaire 
                     $form = $event->getForm();
                    //  chercher le user actuel 
                    $user = $form->getConfig()->getOptions()['data'];

                    //  Verif de l'encodage de mdp 
                    $passwordHasher = $form->getConfig()->getOptions()['passwordHasher'];

                    //  Methode permettant de comparé les Mdp dans BD et mdp du formulaire 
                    $isValid = $passwordHasher->isPasswordValid($user, $form->get('actualpassword')->getData());
                    //  Message d'erreur
                    if(!$isValid){
                        $form->get('actualpassword')->addError(new FormError("Votre mot de passe n'est pas conforme , veuillez verifier votre saisi"));
                    }
                })
        ;
    }
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
            //  le mettre a null une fois est bien passé 
            'passwordHasher'=> null
        ]);
    }
}
