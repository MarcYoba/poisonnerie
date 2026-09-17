<?php

namespace App\Form;

use App\Entity\Produit;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class ProduitType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nomCommercial', TextType::class, [
                'label' => 'Nom du Produit / Poisson',
                'attr' => [
                    'placeholder' => 'ex: Loup de Mer, Capitaine, Dorade',
                    'class' => 'form-control',
                    'required' => true,
                ],
            ])
            // ->add('nomScientifique', TextType::class, [
            //     'label' => 'Nom Scientifique (Optionnel)',
            //     'required' => false,
            //     'attr' => [
            //         'placeholder' => 'ex: Dicentrarchus labrax',
            //         'class' => 'form-control',
            //         'required' => true,
            //     ],
            // ])
            ->add('unite', ChoiceType::class, [
                'label' => 'Unité de Vente',
                'choices' => [
                    'Au Kilogramme (Kg)' => 'KG',
                    'À la Pièce' => 'PIECE',
                    'Au Carton / Caisse' => 'CARTON',
                    'Alveole' => 'ALVEOL',
                ],
                'attr' => ['class' => 'form-select'],
            ])
            ->add('prix', MoneyType::class, [
                'label' => 'Prix Unitaire (TTC)',
                'currency' => 'XAF', // Remplacez par 'EUR' ou 'USD' selon votre devise
                'scale' => 2,
                'attr' => [
                    'placeholder' => '0.00',
                    'class' => 'form-control',
                    'required' => true,
                ],
            ])
            ->add('quantite', NumberType::class, [
                'label' => 'Quantité en Stock Initial',
                'scale' => 3, // Permet les décimales pour les pesées (ex: 12.500 Kg)
                'html5' => true,
                'attr' => [
                    'placeholder' => '0.000',
                    'step' => '0.001',
                    'class' => 'form-control',
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Produit::class,
        ]);
    }
}
