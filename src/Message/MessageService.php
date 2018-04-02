<?php

namespace App\Message;

use App\Message\Transport\TransportInterface;
use App\Queue\QueueManager;

/**
 * Class MessageService
 * @package App\Message
 */
class MessageService
{
    /**
     * @var QueueManager
     */
    private $queueManager;

    /**
     * MessageService constructor.
     * @param QueueManager $queueManager
     */
    public function __construct(
        QueueManager $queueManager
    ) {
        $this->queueManager = $queueManager;
    }

    /**
     * @param $params
     */
    public function queueMessage($params){
        $recipients = $params['recipients'];

        foreach ($recipients as $recipient){
            $item = [
                'message' => $params['message'],
                'transport' => $recipient['transport'],
                'recipient' => $recipient['recipient'],
            ];

            $key = QueueManager::QUEUE_KEY;
            $this->queueManager->addItem($key, $item);
        }
    }

    /**
     * @param $data
     * @return bool
     * @throws \Exception
     */
    public function send($data){

        $message = $data['message'];
        $recipient = $data['recipient'];
        $transport = $data['transport'];

        $transport = $this->getTransport($transport);
        $result = $transport->send($message, $recipient);

        if(!$result) {
            $key = QueueManager::FAILED_KEY;
            $this->queueManager->addItem($key, $data);
        }

        return $result;
    }

    /**
     * @param $name
     * @return TransportInterface
     * @throws \Exception
     */
    private function getTransport($name){

        $className = 'App\\Message\\Transport\\' . ucfirst($name);

        if(!class_exists($className)){
            throw new \Exception('Invalid transport name');
        }

        $transport = new $className();
        return $transport;
    }
}