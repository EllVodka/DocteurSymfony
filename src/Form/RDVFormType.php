<?php

namespace App\Form;

use App\Entity\RDV;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class RDVFormType extends AbstractType
{
    private $medecin;

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $this->medecins=$options['medecins'];

        $builder
            ->add('creneau')
            ->add('medecin',ChoiceType::class,[
                'choices'=> $this->medecins,
                'choice_label' => 'nom'
            ])
            ->add('Ajouter', SubmitType::class);
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => RDV::class,
            'medecins'=>null,
        ]);
        $resolver->setRequired('medecins');
    }
}
