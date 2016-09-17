<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class PostType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', TextType::class, [
                'label' => 'label.postTitle',
                'attr' => [
                    'autofocus' => true,
                    'class' => 'form-control',
                    'placeholder' => 'placeholder.post.title',
                    ]
                ])
            ->add('body', TextareaType::class, [
                'label' => 'label.postBody',
                'attr' => [
                    'placeholder' => 'placeholder.post.body',
                    'class' => 'form-control',
                    'rows' => 10
                ]
            ])
            ->add('summary', TextareaType::class, [
                'label' => 'label.postSummary',
                'required' => false,
                'attr' => [
                    'class' => 'form-control',
                    'rows' => 5,
                    'placeholder' => 'placeholder.post.summary',
                ]
            ])
            ->add('tags', TextType::class, [
                'label' => 'label.tagTitle',
                'required' => false,
                'mapped' => false,
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'placeholder.post.tages',
                ]
            ])
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver) {
        parent::setDefaultOptions($resolver);
        $resolver->setDefaults(
            array(
                'allow_extra_fields' => true
            )
        );
    }


}