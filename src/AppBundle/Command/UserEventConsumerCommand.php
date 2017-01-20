<?php

namespace AppBundle\Command;

use M6Web\Bundle\DaemonBundle\Command\DaemonCommand;
use M6Web\Bundle\KafkaBundle\Manager\ConsumerManager;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class UserEventConsumerCommand
 */
class UserEventConsumerCommand extends DaemonCommand
{
    /**
     * @var ConsumerManager
     */
    protected $consumer;

    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this
            ->setName('example-kafka:consumer:user-events')
            ->setDescription('Launch consumer to read user events');
    }

    /**
     * {@inheritdoc}
     */
    protected function setup(InputInterface $input, OutputInterface $output)
    {
        $this->consumer = $this->getContainer()->get('m6_web_kafka.consumer.eventusers');
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $message = $this->consumer->consume();
        if ($message->err == RD_KAFKA_RESP_ERR_NO_ERROR) {
            var_dump($message);

            return;
        }

        $output->writeln('waiting');
        sleep(1);
    }
}
