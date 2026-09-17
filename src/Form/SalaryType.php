<?php

namespace App\Form;

use App\Entity\Employee;
use App\Entity\Salary;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SalaryType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('employee', EntityType::class, [
                'class' => Employee::class,
                'choice_label' => 'nom',
                'label' => 'Employé',
                'placeholder' => 'Sélectionnez un employé',
                'attr' => ['class' => 'form-select']
            ])
            ->add('mois', ChoiceType::class, [
                'label' => 'Mois de paie',
                'choices' => [
                    'Janvier' => 'Janvier',
                    'Février' => 'Février',
                    'Mars' => 'Mars',
                    'Avril' => 'Avril',
                    'Mai' => 'Mai',
                    'Juin' => 'Juin',
                    'Juillet' => 'Juillet',
                    'Août' => 'Août',
                    'Septembre' => 'Septembre',
                    'Octobre' => 'Octobre',
                    'Novembre' => 'Novembre',
                    'Décembre' => 'Décembre',
                ],
                'attr' => ['class' => 'form-select']
            ])
            ->add('annee', DateType::class, [
                'label' => 'Année',
                'widget' => 'single_text',
                
                'attr' => ['class' => 'form-control']
            ])
            ->add('montantDeBase', MoneyType::class, [
                'label' => 'Salaire de base',
                'currency' => 'XAF',
                'attr' => ['class' => 'form-control']
            ])
            ->add('prime', MoneyType::class, [
                'label' => 'Primes / Bonus',
                'currency' => 'XAF',
                'required' => false,
                'attr' => ['class' => 'form-control']
            ])
            ->add('reductions', MoneyType::class, [
                'label' => 'Retenues / Avances',
                'currency' => 'XAF',
                'required' => false,
                'attr' => ['class' => 'form-control']
            ])
            ->add('statut', ChoiceType::class, [
                'label' => 'Statut du paiement',
                'choices' => [
                    'En attente' => 'EN_ATTENTE',
                    'Payé' => 'PAYE',
                    'Annulé' => 'ANNULE'
                ],
                'attr' => ['class' => 'form-select']
            ])
            ->add('paidAt', DateType::class, [
                'label' => 'Date de paiement',
                'widget' => 'single_text',
                'required' => false,
                'attr' => ['class' => 'form-control']
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Salary::class,
        ]);
    }
}
