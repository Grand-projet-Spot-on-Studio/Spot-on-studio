<?php

namespace App\Form;

use App\Entity\Coach;
use App\Entity\Media;
use App\Entity\Status;
use App\Entity\Studio;
use App\Entity\Video;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;

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
            ->add('programming_date', DateTimeType::class,[
                'date_label' => 'date de publication'
            ])
            ->add('average_grade')
            //demander si la video doit etre plublie ou pas
            ->add('status', CheckboxType::class,[
                'label' => 'veuillez cocher si la vidéo doit être publié plus tard',
                'data_class' => Status::class,
                'mapped' => false,
                'required' => false
            ])
            //choisir le coach qui a fait la video
            ->add('coach', EntityType::class, [
                'label' => 'choisissez le coach',
                'class'=>Coach::class,
                'choice_label'=>'name'
            ])
            //mettre en place la miniature
            ->add('media', FileType::class,[
                'label' => 'Joindre votre miniature',
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
