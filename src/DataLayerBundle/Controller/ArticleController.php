<?php

namespace DataLayerBundle\Controller;

use DataLayerBundle\Entity\Article;
use FOS\RestBundle\View\View;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class ArticleController extends EntityController
{
    ////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////  GET
    /**
     * Returns an article with all comments
     *
     * @param $slug
     * @return mixed
     */
    public function getArticleAction($slug)
    {
        $article = $this->getDoctrine()
            ->getRepository('DataLayerBundle:Article')
            ->find($slug);

        if (!$article) {
            throw $this->createNotFoundException(
                'No article found for id '.$slug
            );
        }

        $view = View::create()
            ->setStatusCode(200)
            ->setData($article);

        return $this->get('fos_rest.view_handler')->handle($view);
    }
    public function getArticlesAction()
    {
        $articles = $this->getDoctrine()
            ->getRepository('DataLayerBundle:Article')
            ->findAll();

        $view = View::create()
            ->setStatusCode(200)
            ->setData($articles);

        return $this->get('fos_rest.view_handler')->handle($view);
    }
    ////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////  POST
    public function postArticleAction(Request $request)
    {
        $parameters = $request->query->all();

        $this->get("logger")->info(var_export($request->query->all(),true));
        $article = new Article();

        $this->_updateEntity($article, $parameters);

        //save
        $em = $this->getDoctrine()->getManager();
        $em->persist($article);
        $em->flush();

        return new Response(sprintf('{"result":%s}' , $article->getId()));
    }
    ////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////  PUT
    public function putArticleAction($slug, Request $request)
    {
        $parameters = $request->query->all();

        $article = $this->getDoctrine()
            ->getRepository('DataLayerBundle:Article')
            ->find($slug);

        if (!$article) {
            throw $this->createNotFoundException(
                'No product found for id '.$slug
            );
        }

        $this->_updateEntity($article, $parameters);

        //save
        $em = $this->getDoctrine()->getManager();
        $em->persist($article);
        $em->flush();

        $view = View::create()
            ->setStatusCode(200)
            ->setData($article);

        return $this->get('fos_rest.view_handler')->handle($view);
    }
}
