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



    }
}