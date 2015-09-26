<?php

namespace DataLayerBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\Console\Input\ArrayInput;

class ArticleControllerTest extends WebTestCase
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
        $this->assertEquals(count($json) , 1);

    }

    ////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////  LOAD FIXTURES
    public function loadFixtures($client)
    {
        $application = new Application($client->getKernel());
        $application->setAutoExit(false);

        //clean and apply the fixture
        $input = new ArrayInput(array(
            'command' => 'doctrine:fixtures:load',
        ));
        $application->run($input);
    }
    ////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////
    public function isResponseOK($response)
    {
        $statusCode = $response->getStatusCode();
        $this->assertEquals($statusCode , 200);
    }

}
