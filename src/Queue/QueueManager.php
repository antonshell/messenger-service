<?php

namespace App\Queue;

/**
 * Class QueueManager
 * @package DIY\ElasticSuite\Queue
 */
class QueueManager implements QueueManagerInterface
{
    const QUEUE_KEY = 'message';

    const FAILED_KEY = 'failed';

    private $queue;

    /**
     * QueueManager constructor.
     * @param RedisQueue $queue
     */
    public function __construct(
        RedisQueue $queue
    ) {
        $this->queue = $queue;
    }

    public function addItem($key, $data){
        $this->queue->push($key, $data);
    }

    public function getItem($key)
    {
        $res = $this->queue->pop($key);

        if(!$res['message']){
            $res = null;
        }

        return $res;
    }
}