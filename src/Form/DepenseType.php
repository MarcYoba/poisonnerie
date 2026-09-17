<?php

namespace App\Form;

use App\Entity\Depense;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class DepenseType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('description', TextareaType::class, [
                'label' => 'Description / Motif',
                'required' => false,
                'attr' => [
                    'class' => 'form-control',
                    'rows' => 3,
                    'placeholder' => 'Détails ou motif de la dépense...',
                ],
            ])
            ->add('montant', MoneyType::class, [
                'label' => 'Montant',
                'currency' => 'XAF', // Adapté en Franc CFA
                'scale' => 0,
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'Ex: 15000',
                ],
            ])
            ->add('typedepense', ChoiceType::class, [
                'label' => 'Type de dépense',
                'placeholder' => 'Sélectionnez un type',
                'choices' => [
                    'Carburant / Transport' => 'transport',
                    'Fournitures & Matériel' => 'materiel',
                    'Entretien & Réparation' => 'entretien',
                    'Services & Factures' => 'service',
                    'impots' => 'impots',
                    'taxes' => 'taxes',
                    'electricité' => 'electricite',
                    'eau' => 'eau',
                    'Communication & Internet' => 'communication',
                    'Autre' => 'autre',
                ],
                'attr' => [
                    'class' => 'form-select',
                ],
            ])
            ->add('createtAt', DateType::class, [
                'label' => 'Date de la dépense',
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
            'data_class' => Depense::class,
        ]);
    }
}
