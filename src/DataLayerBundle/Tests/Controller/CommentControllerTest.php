<?php

namespace DataLayerBundle\Tests\Controller;


class CommentControllerTest extends EntityControllerTestBase
{
    public function testGetArticleCommentsAction()
    {
        $client = static::createClient();


        $crawler = $client->request('GET', '/api/v1/articles');


    }

}
