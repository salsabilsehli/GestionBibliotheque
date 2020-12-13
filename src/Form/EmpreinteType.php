<?php

namespace App\Form;

use App\Entity\Empreinte;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EmpreinteType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('dateretour',DateType::class,['widget' => 'single_text' ,
        'attr' => ['class' => 'form-control'],
        'label' =>'Date de retour'])

        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Empreinte::class,
        ]);
    }
}
