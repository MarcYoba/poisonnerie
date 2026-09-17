<?php

namespace App\Form;

use App\Entity\LigneVente;
use App\Entity\Produit;
use App\Entity\User;
use App\Entity\Vente;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class LigneVenteType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('quantitePoids')
            ->add('prixUnitaire')
            ->add('produit', EntityType::class, [
                'class' => Produit::class,
                'choice_label' => 'nomCommercial',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => LigneVente::class,
        ]);
    }
}
