<?php

namespace AppBundle\Command;


use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class NotificationCommand extends ContainerAwareCommand
{
    ///////////////////////////////////////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////////////////////////////////////
    protected function configure()
    {
        $this->setName('notification:newcomments')
            ->setDescription('Send an email to the writer of an article if he has notifications from more than 24 hours');
    }
    ///////////////////////////////////////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////////////////////////////////////
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln('Database query...');

        //Get emails of article with new comments since more than one day.
        $emails = $this->getContainer()->get('doctrine')->getManager()
            ->getRepository('DataLayerBundle:Comment')->getArticleEmailsFromRecentComments(1);

        $output->writeln('New Comments Found');
        $output->writeln('Sending Email to the writer of the articles');

        foreach($emails as $email)
        {
            if ( $this->getContainer()->hasParameter('mailer_email'))
            {
                $emailFrom = $this->getContainer()->getParameter('mailer_email');

                //prepare mail
                $message = \Swift_Message::newInstance()
                    ->setSubject('New Comments for your article')
                    ->setFrom($emailFrom)
                    ->setTo($email)
                    ->setBody('Hello, You have new comments for your article');

                $output->writeln('to: ' . $email);

                //send mail
                $this->getContainer()->get('mailer')->send($message);
            }
        }

        $output->writeln('Completed');
    }
}