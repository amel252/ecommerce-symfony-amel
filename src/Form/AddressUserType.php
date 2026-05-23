<?php

namespace App\Form;

use App\Entity\Address;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\CountryType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class AddressUserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('firstname', textType::class, [
                'label' => 'Votre prénom',
                'attr' => [
                    'placeholder' => 'Indiquez votre prénom'
                ]
            ])
            ->add('lastname', textType::class, [
                'label' => 'Votre nom',
                'attr' => [
                    'placeholder' => 'Indiquez votre nom'
                ]
            ])
            ->add('address', textType::class, [
                'label' => 'Votre nom',
                'attr' => [
                    'placeholder' => 'Indiquez votre adresse'
                ]
            ])
            ->add('postalCode', textType::class, [
                'label' => 'Votre code postal',
                'attr' => [
                    'placeholder' => 'Indiquez votre code postal'
                ]
            ])
            ->add('city', textType::class, [
                'label' => 'Votre ville',
                'attr' => [
                    'placeholder' => 'Indiquez votre ville'
                ]
            ])
            ->add('country', countryType::class, [
                'label' => 'Votre pays',
                'attr' => [
                    'placeholder' => 'Indiquez votre pays'
                ]
            ])
            ->add('phoneNumber', textType::class, [
                'label' => 'Votre téléphone',
                'attr' => [
                    'placeholder' => 'Indiquez votre numéro de télephone'
                ]
            ])
             ->add('Submit', submitType::class, [
                'label' => 'Valider',
                'attr' => [
                    'placeholder' => 'btn btn btn -success'
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Address::class,
        ]);
    }
}
