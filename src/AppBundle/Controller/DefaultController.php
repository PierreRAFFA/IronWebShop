<?php

namespace AppBundle\Controller;

use DataLayerBundle\Entity\Article;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {
        // create a task and give it some dummy data for this example
        $article = new Article();

        $form = $this->createFormBuilder($article)
            ->add('title', 'text')
            ->add('description', 'textarea')
            ->add('email', 'email')
            ->add('save', 'submit', array('label' => 'Create an article'))
            ->getForm();


        $form->handleRequest($request);

        if ($form->isValid()) {

            $nextAction = $form->get('save')->isClicked()
                ? 'congrats'
                : 'homepage';

            $em = $this->getDoctrine()->getManager();
            $em->persist($article);
            $em->flush();

            return $this->redirectToRoute($nextAction);
        }else{
            return $this->render('default/index.html.twig', array(
                'articleForm' => $form->createView(),
                'base_dir' => realpath($this->container->getParameter('kernel.root_dir').'/..'),
            ));
        }
    }


    /**
     * @Route("/congrats", name="congrats")
     */
    public function congratsAction()
    {
        return $this->render('default/congrats.html.twig', array());
    }
}
