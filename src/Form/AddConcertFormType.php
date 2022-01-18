<?php

namespace App\Form;

use App\Entity\ConcertArtist;
use App\Entity\ConcertBand;
use App\Entity\ConcertConcert;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Image;

class AddConcertFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('description',TextareaType::class)
            ->add('picture',FileType::class,[
                'required' => true,
                'mapped' => false,
                'constraints'=>[
                    new Image([
                        'maxSize' => '3500k'
                    ])
                ]
            ])
            ->add('date',DateType::class)
            ->add('duration',NumberType::class)
            ->add('artist_invited',EntityType::class,[
                'class' => ConcertArtist::class,
                'choice_label'=>'pseudo',
                'multiple'=>true,
                'required'=>false
            ])
            ->add('band_in',EntityType::class,[
                'class' => ConcertBand::class,
                'choice_label'=>'name',
                'multiple'=>true
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => ConcertConcert::class,
        ]);
    }
}
