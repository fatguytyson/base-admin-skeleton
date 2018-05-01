<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SettingType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
	    $fieldOptions = [
	    	'label' => 'Setting Label',
		    'attr'  => [
		    	'data-toggle' => 'tooltip',
			    'title' => 'Note.'
		    ]
	    ];
    	$data = isset($options['data']) ? $options['data'] : null;
    	if ($data) {
		    $fieldOptions['label'] = $data->getLabel();
		    $fieldOptions['attr']['title'] = $data->getNote();
	    }
        $builder
//	        ->add('label')
	        ->add('name', HiddenType::class)
	        ->add('value', TextType::class, $fieldOptions)
//	        ->add('note')
		;
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Setting'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_setting';
    }


}
