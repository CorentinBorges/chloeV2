<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Regex;

class UserFormType extends AbstractType
{
    const PASS_MIN = 8;

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('username',TextType::class,[
                'label'=> 'Nom d\'utilisateur'
            ])
            ->add('plainPassword', PasswordType::class,[
                'required' => false,
                'label'=>'Mot de passe',
                'mapped' => false,
                'constraints'=>[
                    new Length([
                        'min'=>self::PASS_MIN,
                        'minMessage'=> sprintf('Le mot de passe doit contenir au moins %s caractères',self::PASS_MIN)
                    ]),
                    new Regex([
                        'pattern'=> '#[0-9]+#',
                        'message'=>'Le mot de passe doit comporter au moins 1 chiffre']),
                    new Regex([
                        'pattern'=> '#[a-z]+#',
                        'message'=>'Le mot de passe doit comporter au moins 1 lettre minuscule']),
                    new Regex([
                        'pattern'=> '#[A-Z]+#',
                        'message'=>'Le mot de passe doit comporter au moins 1 lettre majuscule'])
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
