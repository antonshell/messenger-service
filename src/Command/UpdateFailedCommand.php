<?php

namespace App\Command;

use App\Message\MessageService;
use App\Queue\QueueManager;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class UpdateFailedCommand
 * @package App\Command
 */
class UpdateFailedCommand extends Command
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
     * UpdateFailedCommand constructor.
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
            ->setName('app:update-failed')
            ->setDescription('Update failed');
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return int|null|void
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $index = 1;

        while (true) {
            $key = QueueManager::FAILED_KEY;
            $item = $this->queueManager->getItem($key);
            $data = json_decode($item['message'],true);

            if(!$item){
                break;
            }

            $key = QueueManager::QUEUE_KEY;
            $this->queueManager->addItem($key, $data);

            $output->writeln("Restore message #" . $index);
            $index++;
        }
    }
}