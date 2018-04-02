<?php

namespace App\Queue;

/**
 * Class RedisQueue
 * @package DIY\TaskQueue\Queue
 */
class RedisQueue implements QueueInterface
{
    const CONFIG_KEY = 'task_queue';

    //private $config;

    private $redis;

    private $popTimeout = 1;

    /**
     * @return \Credis_Client
     */
    public function getConnection(){
        if(!$this->redis){
            //$configData = $this->config->getConfigData(self::CONFIG_KEY) ?: [];

            $host = '127.0.0.1';
            $port = '6379';
            $password = '';

            $this->redis = new \Credis_Client($host, $port, null,'', 0, $password);
        }

        return $this->redis;
    }

    /**
     * @param $key
     * @param $data
     */
    public function push($key,$data)
    {
        $value  = json_encode($data);

        $redis = $this->getConnection();
        $redis->lPush($key, $value);
    }

    /**
     * @param $key
     * @return array
     */
    public function pop($key) : array
    {
        $redis = $this->getConnection();
        list($queue, $message) = $redis->brPop($key, $this->popTimeout);

        $result = [
            'queue' => $queue,
            'message' => $message
        ];

        return $result;
    }

    /**
     * @return bool
     * @throws \Exception
     */
    public function testConnection(){
        $expected = 'absolutely';

        $redis = $this->getConnection();
        $redis->set('awesome', $expected);
        $result = $redis->get('awesome');

        if($expected != $result){
            throw new \Exception('Cant connect to redis');
        }

        return true;
    }
}