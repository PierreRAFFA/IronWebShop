<?php

namespace DataLayerBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\Console\Input\ArrayInput;

class EntityControllerTestBase extends WebTestCase
{
    ////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////  LOAD FIXTURES
    protected function loadFixtures($client)
    {
        $application = new Application($client->getKernel());
        $application->setAutoExit(false);

        //drop the database
//        $input = new ArrayInput(array(
//            'command' => 'doctrine:database:drop',
//            '--force' => true
//        ));
//        $application->run($input);

        //create the database
//        $input = new ArrayInput(array(
//            'command' => 'doctrine:database:create',
//        ));
//        $application->run($input);

        //create the tables
//        $input = new ArrayInput(array(
//            'command' => 'doctrine:schema:update',
//            '--force' => true
//        ));
//        $application->run($input);


        //clean and apply the fixture
        $input = new ArrayInput(array(
            'command' => 'doctrine:fixtures:load',
            '--purge-with-truncate' => ''
        ));
        $application->run($input);
    }
    ////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////
    protected function isResponseOK($response)
    {
        $statusCode = $response->getStatusCode();
        $this->assertEquals($statusCode , 200);
    }

}
