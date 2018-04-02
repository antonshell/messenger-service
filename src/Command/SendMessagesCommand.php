<?php

namespace App\Command;

use App\Message\MessageService;
use App\Queue\QueueManager;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class SendMessagesCommand
 * @package App\Command
 */
class SendMessagesCommand extends Command
{
    /**
     * @var QueueManager
     */
    private $queueManager;

    /**
     * @var MessageService
     */
    private $messageService;

    /**
     * SendMessagesCommand constructor.
     * @param null|string $name
     * @param QueueManager $queueManager
     * @param MessageService $messageService
     */
    public function __construct(
        ?string $name = null,
        QueueManager $queueManager,
        MessageService $messageService
    )
    {
        parent::__construct($name);
        $this->queueManager = $queueManager;
        $this->messageService = $messageService;
    }

    protected function configure()
    {
        $this
            ->setName('app:send-messaged')
            ->setDescription('Test');
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return int|null|void
     * @throws \Exception
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $index = 1;

        while (true) {
            $key = QueueManager::QUEUE_KEY;
            $item = $this->queueManager->getItem($key);

            if(!$item){
                break;
            }

            $data = json_decode($item['message'],true);

            $status = $this->messageService->send($data);
            $status = $status ? 'success' : 'failed!';

            $message = "Send message #" . $index . ' - ' . $status . ' - ' . $item['message'];
            $output->writeln($message);
            $index++;
        }
    }
}