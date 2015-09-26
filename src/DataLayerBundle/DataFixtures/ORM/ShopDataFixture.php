<?php
namespace Acme\HelloBundle\DataFixtures\ORM;

use DataLayerBundle\Entity\Article;
use DataLayerBundle\Entity\Comment;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class ShopDataFixture implements FixtureInterface
{
    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager)
    {
        //Create an article
        $article = new Article();
        $article->setTitle('Title1');
        $article->setDescription('Desc1');
        $article->setRating(1);
        $manager->persist($article);
        $manager->flush();


        //Create an article with a comment
        $article = new Article();
        $article->setTitle('Title2');
        $article->setDescription('Desc2');
        $article->setRating(1);
        $manager->persist($article);
        $manager->flush();

        $comment = new Comment();
        $comment->setEmail('user1@test.com');
        $comment->setContent('user1 Content');
        $article->addComment($comment);
        $manager->persist($comment);
        $manager->flush();



        //Create an article with few comments
        $article = new Article();
        $article->setTitle('Title3');
        $article->setDescription('Desc3');
        $article->setRating(5);
        $manager->persist($article);
        $manager->flush();

        for($i = 0 ; $i < 6 ; $i++)
        {
            $comment = new Comment();
            $comment->setEmail("user$i@test.com");
            $comment->setContent("user$i Content");
            $article->addComment($comment);
            $manager->persist($comment);
            $manager->flush();
        }
    }
}