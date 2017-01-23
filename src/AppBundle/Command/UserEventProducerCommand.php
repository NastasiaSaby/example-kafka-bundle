<?php

namespace AppBundle\Command;

use M6Web\Bundle\DaemonBundle\Command\DaemonCommand;
use M6Web\Bundle\KafkaBundle\Manager\ProducerManager;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputOption;

/**
 * Class UserEventProducerCommand
 * @package AppBundle\Command
 */
class UserEventProducerCommand extends DaemonCommand
{
    /**
     * @var ProducerManager
     */
    protected $producer;

    /**
     * @var string
     */
    protected $message;

    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this
            ->setName('example-kafka:producer:user-events')
            ->setDescription('Launch producer to launch user events')
            ->addOption(
                'message',
                null,
                InputOption::VALUE_OPTIONAL | InputOption::VALUE_IS_ARRAY,
                'Message to produce',
                []
            );
    }

    /**
     * {@inheritdoc}
     */
    protected function setup(InputInterface $input, OutputInterface $output)
    {
        $this->producer = $this->getContainer()->get('m6_web_kafka.producer.eventusers');
        $message = $input->getOption('message');
        $this->message = !empty($message) ? reset($message) : "Default message";
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->producer->produce($this->message);
    }
}
