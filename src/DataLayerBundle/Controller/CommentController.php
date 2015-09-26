<?php

namespace DataLayerBundle\Controller;

use DataLayerBundle\Entity\Comment;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class CommentController extends EntityController
{
    ////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////  GET
    public function getArticleCommentsAction()
    {

    }

    ////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////  POST
    public function postArticleCommentsAction($slug, Request $request)
    {

        //check if the article exists.
        $article = $this->getDoctrine()
            ->getRepository('DataLayerBundle:Article')
            ->find($slug);

        if (!$article) {
            throw $this->createNotFoundException(
                'No article found for id '.$slug
            );
        }

        //get parameters
        $parameters = $request->query->all();

        $this->get("logger")->info(var_export($request->query->all(),true));

        //create the comment
        $newComment = new Comment();
        $this->_updateEntity($newComment, $parameters);

        //for the bidirectional
        $article->addComment($newComment);

        //save
        $em = $this->getDoctrine()->getManager();
        $em->persist($newComment);
        $em->flush();

        return new Response(sprintf('{"result":%s}' , $newComment->getId()));


//        $comment = new Comment();
//        $comment->setArticle($article);
//
//        $this->_updateEntity($comment, $parameters);
//
//        //save
//        $em = $this->getDoctrine()->getManager();
//        $em->persist($comment);
//        $em->flush();
//
//        return new Response(sprintf('{"result":%s}' , $comment->getId()));
    }
}
