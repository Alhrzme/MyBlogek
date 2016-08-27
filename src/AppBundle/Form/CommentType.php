<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;

class CommentType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('body', TextareaType::class, [
                'label' => 'label.commentBody',
                'attr' => [
                    'rows' => 5,
                    'placeholder' => 'comment.placeholder',
                    'class' => 'form-control'
                ]
            ]);
    }

}