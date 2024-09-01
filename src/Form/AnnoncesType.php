<?php

namespace App\Form;

use App\Entity\Adresses;
use App\Entity\Annonces;
use App\Entity\Categorys;
use App\Entity\Cordonnes;
use App\Entity\Descriptions;
use App\Entity\References;
use App\Entity\Types;
use App\Entity\Users;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AnnoncesType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title')
            ->add('createdAt', null, [
                'widget' => 'single_text',
            ])
            ->add('updatedAt', null, [
                'widget' => 'single_text',
            ])
            ->add('userId', EntityType::class, [
                'class' => Users::class,
                'choice_label' => 'id',
            ])
            ->add('descriptionId', EntityType::class, [
                'class' => Descriptions::class,
                'choice_label' => 'id',
            ])
            ->add('categoryId', EntityType::class, [
                'class' => Categorys::class,
                'choice_label' => 'id',
            ])
            ->add('adresseId', EntityType::class, [
                'class' => Adresses::class,
                'choice_label' => 'id',
            ])
            ->add('typeId', EntityType::class, [
                'class' => Types::class,
                'choice_label' => 'id',
            ])
            ->add('cordId', EntityType::class, [
                'class' => Cordonnes::class,
                'choice_label' => 'id',
            ])
            ->add('refId', EntityType::class, [
                'class' => References::class,
                'choice_label' => 'id',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Annonces::class,
        ]);
    }
}
