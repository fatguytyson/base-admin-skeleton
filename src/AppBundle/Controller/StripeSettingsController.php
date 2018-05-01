<?php

namespace AppBundle\Controller;

use AppBundle\Form\SettingsType;
use AppBundle\Util\SettingLoggerCallable;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use FGC\MenuBundle\Annotation\Menu;
use Symfony\Component\HttpFoundation\Request;

class StripeSettingsController extends Controller
{
    /**
     * @Route("/admin/stripesettings")
     * @Menu("Stripe Settings", route="app_stripesettings_default", icon="money", order=2, group="admin", role="ROLE_ADMIN")
     */
    public function defaultAction(Request $request)
    {
    	$sm = $this->get('AppBundle\Util\SettingManager');
    	$settings = $sm->getSettingsEntities('stripe');
    	if (count($settings) != 5) {
    		// Set default settings
		    $sm->createSettingEntity('stripe.test', '1', 'Use Test Keys', 'This is a setting to switch between test and live easily.');
		    $sm->createSettingEntity('stripe.test.sk', 'sk_test_ThisIsAPlaceholder', 'Test Secret Key', 'This stores the Test Secret API Key.');
		    $sm->createSettingEntity('stripe.test.pk', 'pk_test_ThisIsAPlaceholder', 'Test Publishable Key', 'This stores the Test Publishable API Key.');
		    $sm->createSettingEntity('stripe.live.sk', 'sk_live_ThisIsAPlaceholder', 'Live Secret Key', 'This stores the Live Secret API Key.');
		    $sm->createSettingEntity('stripe.live.pk', 'pk_live_ThisIsAPlaceholder', 'Live Publishable Key', 'This stores the Live Publishable API Key.');
		    $settings = $sm->getSettingsEntities('stripe');
	    }

		$form = $this->createForm(SettingsType::class, ['settings' => $settings]);

    	$form->handleRequest($request);
    	if ($form->isSubmitted() && $form->isValid()) {
    		$this->getDoctrine()->getManager()->flush();
    		$this->addFlash('success', 'Settings updated.');
    		return $this->redirectToRoute('app_stripesettings_default');
	    }

        return $this->render('admin/stripesettings.html.twig', array(
            'form' => $form->createView()
        ));
    }

}
