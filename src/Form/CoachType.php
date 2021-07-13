<?php

namespace App\Form;

use App\Entity\Coach;
use App\Entity\Media;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CoachType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('firstname')
            ->add('media', FileType::class,[
                'label' => 'Joindre vos document',
                'data_class' => Media::class,
                'mapped' => false,
                'required' => false,
//                'constraints' => [
//                    new File([
//                        'maxSize' => '50M',
//                        'mimeTypesMessage' => 'Veuillez choisir un document au format pdf ou pptx',
//                        'mimeTypes' => [
//                            new File([
//                                'maxSize' => '50M',
//                                'mimeTypesMessage' => 'Veuillez choisir une video de type .mpeg, .ogv, .webm ',
//                                'mimeTypes' => [
//                                    'video/x-msvideo',
//                                    'video/mpeg',
//                                    'video/ogg',
//                                    'video/webm'
//                                ]
//                            ])
//
//                        ]
//                    ]),
//                ],
            ])
//            ->add('video')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Coach::class,
        ]);
    }
}
