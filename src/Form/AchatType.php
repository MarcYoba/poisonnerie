<?php

namespace App\Form;

use App\Entity\Achat;
use App\Entity\Produit;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;

class AchatType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('produit', EntityType::class, [
                'class' => Produit::class,
                'choice_label' => 'nomCommercial', // Remplacez 'designation' par le nom du champ de votre entité (ex: 'nom', 'libelle')
                'label' => 'Produit / Article',
                'placeholder' => 'Sélectionnez un produit',
                'attr' => [
                    'class' => 'form-select',
                ],
            ])
            ->add('quantite', IntegerType::class, [
                'label' => 'Quantité',
                'attr' => [
                    'class' => 'form-control',
                    'min' => 1,
                    'placeholder' => 'Ex: 10',
                ],
            ])
            ->add('prix', MoneyType::class, [
                'label' => 'Prix Unitaire',
                'currency' => 'XAF', // Adapté en Franc CFA (ou 'EUR' selon votre besoin)
                'scale' => 0,
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'Ex: 5000',
                ],
            ])
            ->add('createtAt', DateType::class, [
                'label' => 'Date de création',
                'widget' => 'single_text',
                'attr' => [
                    'class' => 'form-control',
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Achat::class,
        ]);
    }
}
