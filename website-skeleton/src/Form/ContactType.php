<?php

namespace App\Form;

use App\Entity\Contacts;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ContactType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', TextType::class, array('label' => 'Anrede'))
            ->add('title', ChoiceType::class, array('choices' => array(
                'Herr' => 'Herr',
                'Frau' => 'Frau'
            )))
            ->add('firstName', TextType::class, array('label' => 'Vorname'))
            ->add('lastName', TextType::class, array('label' => 'Nachname'))
            ->add('email', EmailType::class, array('label' => 'Email'))
            ->add('telephone', TextType::class, array('label' => 'Rückrufnummer'))
            ->add('message', TextareaType::class, array('label' => 'Nachricht'))

            ->add('street', TextType::class, array('label' => 'Straße', 'required'  => false))
            ->add('street_no', TextType::class, array('label' => 'Hausnummer', 'required'  => false))
            ->add('postcode', IntegerType::class, array('label' => 'PLZ', 'required'  => false))
            ->add('city', TextType::class, array('label' => 'Ort', 'required'  => false))
            ->add('subject', TextType::class, array('label' => 'Betreff', 'required'  => false))
            ->add('submit', SubmitType::class, array('label' => 'Senden'))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Contacts::class,
        ]);
    }
}
