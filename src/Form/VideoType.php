<?php

namespace App\Form;

use App\Entity\Media;
use App\Entity\Video;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;

class VideoType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title')
            ->add('description')
            ->add('duration')
            ->add('number_view')
            ->add('sampling')
            ->add('timer_sampling')
            ->add('difficulty')
            ->add('programming_date')
            ->add('average_grade')
            ->add('media', FileType::class,[
                'label' => 'Joindre votre video',
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
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Video::class,
        ]);
    }
}
