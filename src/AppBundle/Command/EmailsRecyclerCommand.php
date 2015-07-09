<?php namespace AppBundle\Command;

use AppBundle\Communication\Email\Message;
use AppBundle\Document\Email;
use AppBundle\Event\Communication\Email\EmailEvent;
use AppBundle\Service\Communication\CommunicationService;
use Doctrine\ODM\MongoDB\DocumentManager;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\EventDispatcher\EventDispatcher;

class EmailsRecyclerCommand extends ContainerAwareCommand
{
    /**     *      * @var CommunicationService */
    private $communicationService;
    /**     *      * @var DocumentManager */
    private $documentManager;
    /**     *      * @var EventDispatcher */
    private $eventDispatcher;

    protected function configure()
    {
        parent::configure();
        $this->setName('app:communication:recycler:emails');
        $this->setDescription('Retries the sending of emails with temporary error');
        $this->addOption('limit', '-l', InputOption::VALUE_OPTIONAL, 'Number of emails to resend', 10);
    }

    protected function initialize(InputInterface $input, OutputInterface $output)
    {
        parent::initialize($input, $output);
        $this->communicationService = $this->getContainer()->get(CommunicationService::ID);
        $this->documentManager      = $this->getContainer()->get('doctrine_mongodb')->getManager();
        $this->eventDispatcher      = $this->getContainer()->get('event_dispatcher');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $limit            = $input->getOption('limit');
        $emailsRepository = $this->documentManager->getRepository(Email::REPOSITORY);
        $emails           = $emailsRepository->findBy(array('status' => Email::STATUS_TEMPORARY_ERROR), null, $limit);
        foreach ($emails as $email) {
            /* @var $email Email */
            $type         = $email->getType();
            $emailAddress = $email->getEmailAddress();
            $arguments    = $email->getArguments();
            $this->eventDispatcher->dispatch(EmailEvent::RESEND, new EmailEvent($type, $emailAddress, $arguments));
            $status = $this->communicationService->sendEmail($type, $emailAddress, $arguments);
            $email->setStatus($status);
            $this->documentManager->persist($email);
        }
        $this->documentManager->flush();
    }
}
