<?php


namespace App\Form;


use App\Entity\Image;
use App\Entity\Picture;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\Validator\Constraints\Length;

class ImageFormType extends AbstractType
{
    private const MAX_PIC_NAME_CAR=150;
    public function buildForm(FormBuilderInterface $formBuilder, array $options)
    {
        if ($options['is_edit'] === true) {
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
        } else {
            $formBuilder
                ->add('image', FileType::class, [
                    'data_class' => Picture::class,
                    'label' => 'Nouvelle image',
                    'required' => true,
                    'mapped' => false,
                    'attr' => [
                        'accept' => "image/png, image/jpeg",
                        'custom-file-label' => 'charger',
                    ],
                    'constraints' => [
                        new File([
                            'maxSize' => '200M',
                            'mimeTypes' => [
                                'image/jpeg',
                                'image/png'
                            ],
                            'mimeTypesMessage' => 'Le fichier doit être de type jpeg ou png'
                        ])
                    ]
                ])
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


    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver
            ->setDefaults([
                'is_edit' => false,
                'is_user_edit' => false,
            ]);
        $resolver->setAllowedTypes('is_edit', "bool");
        $resolver->setAllowedTypes('is_user_edit', "bool");
    }

}
