<?php


namespace App\Form;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\Length;

class EditPicsFormType extends AbstractType
{
    private const MAX_PIC_NAME_CAR=150;
    public function buildForm(FormBuilderInterface $formBuilder, array $options)
    {
        $formBuilder
            ->add("id",HiddenType::class,[])
            ->add("picName", TextType::class,[
                'label' => "Nom de l'œuvre",
                'required' => true,
                'constraints'=>[
                    new Length([
                        'max' => self::MAX_PIC_NAME_CAR,
                        'maxMessage' => sprintf("Le titre ne peut pas contenir plus de 150 caractères")
                        ])
                    ]
                ])
            ->add("description", TextType::class,[
                'label' => "Description",
                'required' => true])
            ->add('portfolio',CheckboxType::class,[
                'label'=> 'portfolio',
                'required' => false,
                'label_attr' => ['class'=>'ml-2']
            ])
            ->add('papier',CheckboxType::class,[
                'label'=> 'papier',
                'required' => false,
                'label_attr' => ['class'=>'ml-2']
            ])
            ->add('numerique',CheckboxType::class,[
                'label'=> 'numerique',
                'required' => false,
                'label_attr' => ['class'=>'ml-2']
            ]);

    }
}