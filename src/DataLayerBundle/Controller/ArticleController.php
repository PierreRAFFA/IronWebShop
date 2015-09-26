<?php

namespace DataLayerBundle\Controller;

use DataLayerBundle\Entity\Article;
use FOS\RestBundle\View\View;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class ArticleController extends Controller
{
    ////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////  GET
    public function getArticleAction($slug)
    {

    }
    public function getArticlesAction()
    {
        $articles = $this->getDoctrine()
            ->getRepository('DataLayerBundle:Article')
            ->findAll();

        $this->get('logger')->info(var_export($articles,true));

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
    //////////////////////////////////////////////////////////// UTILS
    /**
     * Populates the entity from the parameters
     * This method ignores parameters which does not match the entity.
     *
     * @param $entity
     * @param $parameters array of parameters
     */
    private function _updateEntity($entity, $parameters)
    {
        foreach($parameters as $parameterName=>$parameterValue)
        {
            $methodName = sprintf("set%s", ucfirst($parameterName) );
            $this->get("logger")->info($methodName);

            if ( method_exists($entity,$methodName))
            {
                $entity->$methodName($parameterValue);
            }
        }
    }


}
