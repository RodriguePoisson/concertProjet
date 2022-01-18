<?php

namespace App\Form;

use App\Entity\ConcertBand;
use App\Entity\ConcertArtist;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Validator\Constraints\Image;

class BandFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name')
            ->add('picture',FileType::class,[
                'required' => true,
                'mapped' => false,
                'constraints'=>[
                    new Image([
                        'maxSize' => '3500k'
                    ])
                ]
            ])
            ->add('description',TextareaType::class)
            ->add('artist',EntityType::class,[
                'class' => ConcertArtist::class,
                'choice_label'=>'pseudo',
                'multiple'=>true
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => ConcertBand::class,
        ]);
    }
}
