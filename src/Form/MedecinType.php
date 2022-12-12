<?php

namespace App\Form;

use App\Entity\Docteur;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Regex;

class MedecinType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom', TextType::class, [
                'required' => true,
                'constraints' => [new Length(['min' => 3,'minMessage' => 'Le nom doit comporter au moins 3 caractères'])],
            ])
            ->add('description', TextType::class, [
                'required' => true,
            ])
            ->add('ville', TextType::class, [
                'required' => true,
            ])
            ->add('telephone', TextType::class,[
                'required' => true,
                'constraints' => [new Regex(['pattern'=>'/^[0-9]{10}$/',
                'message'=>'Le numéros de télephone doit avoir 10 chiffre'])] 
            ])
            ->add('Ajouter', SubmitType::class);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Docteur::class,
        ]);
    }
}