<?php

namespace App\Form;

use App\Entity\Message;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class FormMessageType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name')
            ->add('lastname')
            ->add('email')
            ->add('message', TextareaType::class, [
                'attr'=> array(
                    'style'=> 'width: 400px; 
                    max-width: 400px; 
                    min-width: 400px; 
                    height: 40px; 
                    min-height: 40px; 
                    max-height: 3000px; 
                    font-size: 25px; 
                    padding: 3px;
                    border: none;
                    border-bottom: 1px solid #707070;
                    margin-top: 6px;
                    ',
                )
            ])
            ->add('submit', SubmitType::class, [
                'label'=>'>',
                'attr' => array(
                    'class' => 'btn'
                )
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Message::class,
        ]);
    }
}
