<?php

namespace App\Form;

use App\Entity\Film;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;

use Symfony\Component\OptionsResolver\OptionsResolver;

class FilmType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('titre')
            ->add('annee')
            ->add('duree')
            ->add('couverture',FileType::class, array( 'data_class' => null, 'required' => false) )
            //->add('categorie')
            //->add('realisateurs')
            //->add('salles')
            ->add('categorie',EntityType::class, array(
                'class' => 'App\Entity\Categorie',
                'label' => 'Choisir la categorie :',
                'choice_label' =>'nom'))

            ->add( 'realisateurs', EntityType::class, array(
                'class' => 'App\Entity\Realisateur',
                'label' => 'Choisir les realisateurs :',
                'expanded' => true,
                'multiple' => true,
                'choice_label' => 'nom'. 'prenom'))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Film::class,
        ]);
    }
}
