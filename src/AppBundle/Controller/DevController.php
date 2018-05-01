<?php

namespace AppBundle\Controller;

use AppBundle\Form\ContactType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

/**
 * Class DevController
 * @package AppBundle\Controller
 *
 * @Route("/dev")
 */
class DevController extends Controller
{
    /**
     * @Route("/")
     */
    public function testAction()
    {
    	$form = $this->createForm(ContactType::class)->createView();
        return $this->render('default/test.html.twig', array(
            'form' => $form
        ));
    }

}
