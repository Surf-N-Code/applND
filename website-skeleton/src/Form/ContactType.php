<?php

namespace App\Form;

use App\Entity\Contacts;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ContactType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', TextType::class, array('label' => 'Anrede'))
            ->add('firstName', TextType::class, array('label' => 'Vorname'))
            ->add('lastName', TextType::class, array('label' => 'Nachname'))
            ->add('email', EmailType::class, array('label' => 'Email'))
            ->add('telephone', TextType::class, array('label' => 'Rückrufnummer'))
            ->add('message', TextType::class, array('label' => 'Nachricht'))

            ->add('street', TextType::class, array('label' => 'Straße'))
            ->add('street_no', NumberType::class, array('label' => 'Hausnummer'))
            ->add('postcode', NumberType::class, array('label' => 'PLZ'))
            ->add('city', TextType::class, array('label' => 'Ort'))
            ->add('subject', TextType::class, array('label' => 'Betreff'))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Contacts::class,
        ]);
    }
}
