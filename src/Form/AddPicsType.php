<?php


namespace App\Form;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\FormBuilderInterface;

class AddPicsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder ->add('images', CollectionType::class, [
            'entry_type' => ImageFormType::class,
            'entry_options' => ['label' => false],
            'mapped' => false,
            'allow_add' => true,
            'allow_delete' => true,
            'prototype' => true]);
    }
}