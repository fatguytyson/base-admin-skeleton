<?php
/**
 * Created by PhpStorm.
 * User: fatguy
 * Date: 6/2/17
 * Time: 8:13 PM
 */

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

class QuestionnaireType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('issues_one', TextType::class, [
                'label' => 'What are 3 mental or physical health issues you would like to treat naturally?',
                'attr' => [
                    'placeholder' => 'What are 3 mental or physical health issues you would like to treat naturally?'
                ]
            ])
            ->add('issues_two', TextType::class, [
                'label' => 'What beauty issues would you like to treat with essential oils?',
                'attr' => [
                    'placeholder' => 'What beauty issues would you like to treat with essential oils?'
                ]
            ])
            ->add('issues_three', TextType::class, [
                'label' => 'Do you have any allergies?',
                'attr' => [
                    'placeholder' => 'Do you have any allergies? (coconut oil, gluten...)'
                ]
            ])
            ->add('address', TextareaType::class, [
                'label' => 'What is your mailing address?',
                'attr' => [
                    'placeholder' => "What is your mailing address?\n123 Las Vegas Blvd.\nLas Vegas, NV 89123",
                    'rows' => 3
                ]
            ])
            ->add('phone', TextType::class, [
                'label' => 'Phone number?',
                'attr' => [
                    'placeholder' => 'Phone number?'
                ]
            ])
            ->add('message', CheckboxType::class, [
                'label' => 'Would you like to be part of a once a month text regarding specials and discounts?',
                'required' => false
            ])
            ->add('email', EmailType::class, [
                'label' => 'Email?',
                'attr' => [
                    'placeholder' => 'Email?'
                ]
            ])
        ;
    }
}