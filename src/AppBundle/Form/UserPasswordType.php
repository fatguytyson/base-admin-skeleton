<?php
/**
 * Copyright (c) 2018. Lorem ipsum dolor sit amet, consectetur adipiscing elit.
 * Morbi non lorem porttitor neque feugiat blandit. Ut vitae ipsum eget quam lacinia accumsan.
 * Etiam sed turpis ac ipsum condimentum fringilla. Maecenas magna.
 * Proin dapibus sapien vel ante. Aliquam erat volutpat. Pellentesque sagittis ligula eget metus.
 * Vestibulum commodo. Ut rhoncus gravida arcu.
 */

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Security\Core\Validator\Constraints\UserPassword;

class UserPasswordType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
//	        ->add('username', TextType::class, [
//	        	'label' => 'Username'
//	        ])
//	        ->add('usernameCanon')
//	        ->add('email', TextType::class, [
//	        	'label' => 'E-Mail'
//	        ])
	        ->add('plainPassword', RepeatedType::class, [
	        	'type'            => PasswordType::class,
		        'invalid_message' => 'Password Fields must match.',
		        'first_options'   => array('label' => 'New Password'),
		        'second_options'  => array('label' => 'Repeat New Password')
	        ])
	        ->add('currentPassword', PasswordType::class, [
	        	'label'       => 'Current Password',
		        'mapped'      => false,
		        'constraints' => new UserPassword()
	        ])
//	        ->add('emailCanon')
//	        ->add('enabled')
//	        ->add('password')
//	        ->add('lastLogin')
//	        ->add('expired')
//	        ->add('expiresAt')
//	        ->add('locked')
//	        ->add('confirmationToken')
//	        ->add('passwordRequestedAt')
//	        ->add('roles')
//	        ->add('jobsJoined')
//	        ->add('jobsNotified')
//	        ->add('jobsViewed')
        ;
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\User'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_account';
    }


}
