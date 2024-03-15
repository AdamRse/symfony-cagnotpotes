<?php

namespace App\Form;

use App\Entity\Campaign;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CampaignType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', null, [
                'attr' => ['class' => 'validate']
            ])
            ->add('content', null, [
                'attr' => ['class' => 'validate']
            ])
            ->add('goal', null, [
                'attr' => ['class' => 'validate']
            ])
            ->add('name', null, [
                'attr' => ['class' => 'validate']
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Campaign::class,
        ]);
    }
}
