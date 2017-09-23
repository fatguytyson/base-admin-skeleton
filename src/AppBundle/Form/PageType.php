<?php

namespace AppBundle\Form;

use FM\ElfinderBundle\Form\Type\ElFinderType;
use Ivory\CKEditorBundle\Form\Type\CKEditorType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PageType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
//            ->add('pageName')
            ->add('title')
            ->add('bgImage', ElFinderType::class, array(
                'instance' => 'form',
                'enable' => true
            ))
            ->add('header')
            ->add('subheader')
            ->add('content', CKEditorType::class)
            ->add('flags')
        ;
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Page'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_page';
    }


}
