<?php

namespace App\Form;


use App\Entity\Annonce;
use App\Entity\Categorie;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AnnonceFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('titre', TextType::class, [
                'required' => true,
                'label' => "Titre de l'annonce",
                'attr' => [
                    'placeholder' => "Titre de l'annonce"
                ]
            ])
            ->add('categorie', EntityType::class, [
                'class' => Categorie::class,
                'choice_label' => 'nom',
                'expanded' => false,
                'multiple' => false,
                'label' => false
            ])
            ->add('contenu', TextareaType::class, [
                'label' => "Contenu de l'annonce"
            ])
            ->add('featuredImage', FileType::class, [
                'label' => "Glissez votre photo",
                'attr' => [
                    'class' => "dropify"
                ]
            ])
            ->add('submit', SubmitType::class, [
                'label' => "Publier mon annonce",
                'attr' => [
                    'class' => "btn-block   "
                ]
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefault('data_class', Annonce::class);
    }

    public function getBlockPrefix()
    {
        return 'form';
    }
}
