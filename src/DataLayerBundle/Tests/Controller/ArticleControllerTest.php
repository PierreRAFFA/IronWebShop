<?php

namespace DataLayerBundle\Tests\Controller;

class ArticleControllerTest extends EntityControllerTestBase
{
    ////////////////////////////////////////////////////////////////////////
    //////////////////////////////////////////////////////////// GET
    public function testGetArticlesAction()
    {
        $client = static::createClient();

        $this->loadFixtures($client);

        $crawler = $client->request('GET', '/api/v1/articles');

        //check the status code
        $this->isResponseOK($client->getResponse());

        //check the response content
        $json = json_decode($client->getResponse()->getContent());
        $this->assertEquals(count($json) , 3);

    }

}
