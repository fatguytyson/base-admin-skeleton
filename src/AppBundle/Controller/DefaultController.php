<?php

namespace AppBundle\Controller;

use AppBundle\Annotation\Menu;
use AppBundle\Entity\Category;
use AppBundle\Entity\CategorySTEData;
use AppBundle\Entity\CategoryType;
use AppBundle\Entity\Entry;
use AppBundle\Entity\SeasonTypeEntry;
use AppBundle\Form\ContactType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    /**
     * @Menu("Home", route="homepage", order="1")
     * @Menu("Frontpage", route="homepage", order="6", group="admin", icon="check-square-o")
     * @Route("/", name="homepage", methods={"GET"})
     */
    public function indexAction(Request $request)
    {
        $ret = $this->getBaseInfo('homepage');
        $em = $this->getDoctrine()->getManager();

        $ret['season'] = $em->getRepository('AppBundle:Season')->getCurrentID();
        $request->getSession()->set('SeasonCurrent', $ret['season']);
        $ret['categories'] = $em->getRepository('AppBundle:Category')->findAll();

        return $this->render('default/index.html.twig', $ret);
    }

    /**
     * @Route("/category/{category}", name="category_refresh", methods={"GET"}, requirements={"category": "\d+"})
     */
    public function categoryRefreshAction(Request $request, Category $category)
    {
        $em = $this->getDoctrine()->getManager();
        /** @var Category $data */
        $data = $this->getDoctrine()->getRepository('AppBundle:Category')->findSeasonCategoryData($request->getSession()->get('SeasonCurrent'), $category);

        if ($data->getType()->isCount()) {
            /** @var SeasonTypeEntry $ste */
            foreach($data->getType()->getSte() as $ste) {
                if ($ste->getCsd()->count() == 0) {
                    $csd = new CategorySTEData();
                    $csd->setCategory($category)->setSte($ste)->setData(0);
                    $em->persist($csd);
                    $em->flush();
                    return $this->redirectToRoute('category_refresh', ['category' => $category->getId()]);
                }
            }
        }

        return $this->render('default/panel.html.twig', ['category' => $category, 'data' => $data]);
    }

    /**
     * @Route("/category/{category}/add", name="category_add", requirements={"category": "\d+"})
     */
    public function categoryAddAction(Request $request, Category $category)
    {
        $em = $this->getDoctrine()->getManager();
        $season = $em->getRepository('AppBundle:Season')->find($request->getSession()->get('SeasonCurrent')->getId());
        $ret = [
            'success' => true,
            'html' => '',
            'error' => ''
        ];

        if ($category->getType()->getFlags() & CategoryType::PERSON) {
            $entryType = $em->getRepository('AppBundle:EntryType')->findOneByTitle('person');
        } elseif ($category->getType()->getFlags() & CategoryType::PHRASE) {
            $entryType = $em->getRepository('AppBundle:EntryType')->findOneByTitle('phrase');
        } else {
            $entryType = $em->getRepository('AppBundle:EntryType')->findOneBy([]);
        }

        if ($category->getType()->getFlags() & CategoryType::COUNT) {
            $data = false;
        } elseif ($category->getType()->getFlags() == (CategoryType::PHRASE | CategoryType::PERSON)) {
            $data = $em->getRepository('AppBundle:EntryType')->findOneByTitle('phrase');
        } else {
            $data = false;
        }

        $form = $this->createFormBuilder(null, ['action' => $this->generateUrl('category_add', ['category' => $category->getId()])])
            ->add($entryType->__toString(), TextType::class);
        if ($data) {
            $form->add($data->__toString(), TextType::class);
        }
        $form = $form->getForm();

        if ($request->isMethod('POST')) {
            $form->handleRequest($request);
            $title = $form->get($entryType->__toString())->getData();
            $entry = $em->getRepository('AppBundle:Entry')->findOneBy(['title' => $title, 'type' => $entryType]);
            if (!$entry) {
                $entry = new Entry();
                $entry->setTitle($title)->setType($entryType);
                $em->persist($entry);
                $em->flush();
            }
            $ste = $em->getRepository('AppBundle:SeasonTypeEntry')->findOneBy(['season' => $season->getId(), 'type' => $category->getType()->getId(), 'entry' => $entry->getId()]);
            if (!$ste) {
                $ste = new SeasonTypeEntry();
                $ste->setSeason($season)->setType($category->getType())->setEntry($entry);
                $em->persist($ste);
                $em->flush();
            }
            $count = 0;
            $criteria = ['category' => $category->getId(), 'ste' => $ste];
            if ($data) {
                $title2 = $form->get($data->__toString())->getData();
                $phrase = $em->getRepository('AppBundle:Entry')->findOneBy(['title' => $title2, 'type' => $data]);
                if (!$phrase) {
                    $phrase = new Entry();
                    $phrase->setTitle($title2)->setType($data);
                    $em->persist($phrase);
                    $em->flush();
                }
                $count = $phrase->getId();
                $criteria['data'] = $count;
            }
            $csd = $em->getRepository('AppBundle:CategorySTEData')->findOneBy($criteria);
            if (!$csd) {
                $csd = new CategorySTEData();
                $csd->setCategory($category)->setSte($ste)->setData($count);
                $em->persist($csd);
                $em->flush();
            }
            $ret['html'] = $this->renderView('default/modal.html.twig', ['category' => $category]);

            return new JsonResponse($ret);
        }

        $ret['html'] = $this->renderView('default/modal.html.twig', ['form' => $form->createView(), 'category' => $category]);

        return new JsonResponse($ret);
    }

    /**
     * @Route("/tick/{csd}", name="counter_tick", methods={"GET"}, requirements={"csd": "\d+"})
     */
    public function counterTickAction(Request $request, CategorySTEData $csd)
    {
        $em = $this->getDoctrine()->getManager();
        $csd->setData($csd->getData()+1);
        $em->persist($csd);
        $em->flush();
        return $this->render('default/button.html.twig', ['entry' => $em->getRepository('AppBundle:SeasonTypeEntry')->findFromCSD($csd)]);
    }

    /**
     * @Route("/contact", name="contact_form", methods={"POST"})
     */
    public function contactAction(Request $request)
    {
        $form = $this->createForm(ContactType::class);
        $form->handleRequest($request);
        $message = new \Swift_Message('A Message from your Contact Form', $this->renderView(':emails:contact.text.twig', $form->getData()), 'text/plain');
        $message->setSender('no-reply@'.$this->getParameter('site_domain'))->setFrom('no-reply@'.$this->getParameter('site_domain'))->setTo($this->getParameter('admin_email'));
        $this->get('swiftmailer.mailer')->send($message);
        $this->addFlash('success', 'Message has been sent!');
        return $this->redirectToRoute('homepage');
    }

    /**
     * @param $path
     * @return array
     */
    private function getBaseInfo($path)
    {
        $em = $this->getDoctrine()->getManager();

        $ret = [
            'canonical' => $this->generateUrl($path),
        ];
        switch ($path) {
            default:
            case 'homepage':
                $ret['author'] = 'author';
                $ret['description'] = 'description';
                $ret['keywords'] = 'keywords';
                break;
        }
        return $ret;
    }
}
