<?php

namespace App\Queue;

/**
 * Interface QueueInterface
 * @package DIY\TaskQueue\Queue
 */
interface QueueInterface
{
    /**
     * @param $key
     * @param $data
     */
    public function push($key, $data);

    /**
     * @param $key
     * @return mixed
     */
    public function pop($key);
}