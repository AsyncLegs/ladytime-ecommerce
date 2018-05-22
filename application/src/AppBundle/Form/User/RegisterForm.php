<?php

namespace AppBundle\Form\User;

use AppBundle\Entity\User;
use libphonenumber\PhoneNumberFormat;
use Misd\PhoneNumberBundle\Form\Type\PhoneNumberType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RegisterForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $builder
            ->add('email', EmailType::class, ['label_format' => '%name%'])
            ->add('username', TextType::class, ['label_format' => '%name%'])
            //->add('phone', TextType::class, ['label_format' => '%name%'])
            ->add('phone', PhoneNumberType::class, [
                'attr' => [
                    'class' => 'mobile-phone'
                ],
                'label_format' => '%name%', 'format' => PhoneNumberFormat::NATIONAL
            ])
            ->add('plainPassword', RepeatedType::class, [
                'type' => PasswordType::class,
                'first_options' => [
                    'label' => 'password',
                    'label_format' => '%name%',
                    'attr' => [
                        'data-minlength' => 5,
                        'data-error' => 'Пароль должен быть более 5 символов'
                    ]],
                'second_options' => [
                    'label' => 'repeat_password',
                    'label_format' => '%name%',
                    'attr' => [
                        'data-minlength' => 5,
                        'data-error' => 'Пароль должен быть более 5 символов'
                    ]

                ],
            ]);

    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => User::class,
            'validation_groups' => ['register'],
        ));
    }

}
