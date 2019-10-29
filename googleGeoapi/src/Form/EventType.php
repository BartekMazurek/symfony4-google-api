<?php

namespace App\Form;

use App\Entity\EventLocalisation;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EventType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $currentDate = new \DateTime('now + 7 days');

        $builder
            ->add('place', TextType::class, [
                'attr' => [
                    'placeholder' => 'eg. Fancy restaurant'
                ]
            ])
            ->add('description', TextareaType::class, [
                'attr' => [
                    'placeholder' => 'Place description...'
                ]
            ])
            ->add('address', TextType::class, [
                'label' => 'Address (*only latin letters & digits allowed)',
                'attr' => [
                    'placeholder' => 'eg. Warszawa Domaniewska'
                ]
            ])
            ->add('email', TextType::class)
            ->add('date_from', DateType::class, [
                'data' => $currentDate
            ])
            ->add('date_to', DateType::class, [
                'data' => $currentDate
            ])
            ->add('Save', SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => EventLocalisation::class,
        ]);
    }
}
