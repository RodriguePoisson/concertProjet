<?php

namespace App\Form;

use App\Entity\ConcertArtist;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Validator\Constraints\Image;

class ArtistFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name')
            ->add('last_name')
            ->add('pseudo')
            ->add('picture',FileType::class,[
                'required' => true,
                'mapped' => false,
                'constraints'=>[
                    new Image([
                        'maxSize' => '3500k'
                    ])
                ]
            ])
            ->add('biography',TextareaType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => ConcertArtist::class,
        ]);
    }
}
