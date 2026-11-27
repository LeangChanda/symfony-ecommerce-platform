<?php

namespace AppBundle\Form;

use AppBundle\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('username', TextType::class, [
                'label' => 'Username'
            ])
            ->add('email', EmailType::class, [
                'label' => 'Email'
            ])
            ->add('firstName', TextType::class, [
                'label' => 'First Name',
                'required' => false
            ])
            ->add('lastName', TextType::class, [
                'label' => 'Last Name',
                'required' => false
            ])
            ->add('phone', TextType::class, [
                'label' => 'Phone',
                'required' => false
            ])
            ->add('address', TextareaType::class, [
                'label' => 'Address',
                'required' => false
            ])
            ->add('password', PasswordType::class, [
                'label' => 'Password',
                'mapped' => false,
                'required' => false,
                'attr' => [
                    'placeholder' => 'Enter password'
                ]
            ])
            ->add('roles', ChoiceType::class, [
                'label' => 'Roles',
                'choices' => [
                    'User' => 'ROLE_USER',
                    'Admin' => 'ROLE_ADMIN'
                ],
                'multiple' => true,
                'expanded' => true,
                'required' => true
            ])
            ->add('isActive', CheckboxType::class, [
                'label' => 'Active Account',
                'required' => false
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class
        ]);
    }
}
