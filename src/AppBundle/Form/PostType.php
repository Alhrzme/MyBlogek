<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

class PostType extends AbstractType {
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', TextType::class, [
                'label' => 'label.postTitle',
                'attr' => [
                    'autofocus' => true,
                    'class' => 'form-control'
                    ]
                ])
            ->add('body', TextareaType::class, [
                'label' => 'label.postBody',
                'attr' => [
                    'class' => 'form-control',
                    'rows' => 4
                ]
            ])
            ->add('summary', TextareaType::class, [
                'label' => 'label.postSummary',
                'attr' => [
                    'class' => 'form-control',
                    'rows' => 2
                ]
            ])
        ;
    }
}