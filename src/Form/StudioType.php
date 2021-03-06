<?php

namespace App\Form;

use App\Entity\Media;
use App\Entity\Studio;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class StudioType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('phone')
            ->add('adress')
            ->add('zipcode')
            ->add('city')
            ->add('email')
            ->add('media', FileType::class,[
                'label' => 'Télécharger votre miniature',
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
            'data_class' => Studio::class,
        ]);
    }
}
