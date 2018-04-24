<?php
/**
 * Created by PhpStorm.
 * User: fatguy
 * Date: 6/2/17
 * Time: 8:13 PM
 */

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ContactType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'Full Name',
                'attr' => [
                    'placeholder' => 'Your Name... *'
                ]
            ])
            ->add('email', EmailType::class, [
                'label' => 'Email',
                'attr' => [
                    'placeholder' => 'E-mail address... *'
                ]
            ])
            ->add('truck', TextType::class, [
                'label' => 'Subject',
                'attr' => [
                    'placeholder' => 'Make & Model of Truck'
                ]
            ])
//            ->add('message', TextareaType::class, [
//                'label' => 'Message',
//                'attr' => [
//                    'rows' => 3
//                ]
//            ])
        ;
    }

    public function configureOptions( OptionsResolver $resolver )
    {
	    $resolver->setDefaults(array(
	    	'data_class' => 'AppBundle\Entity\Contact'
	    ));
    }

    public function getBlockPrefix()
    {
	    return 'contact';
    }
}