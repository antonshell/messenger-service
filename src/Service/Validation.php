<?php

namespace App\Service;

use App\Message\Transport\Telegram;
use App\Message\Transport\Viber;
use App\Message\Transport\WhatsApp;
use App\Queue\QueueManager;

/**
 * Class Verification
 * @package App\Service
 */
class Validation
{
    private $errors = [];

    private $messages = [];

    /**
     * @param $params
     * @return bool
     */
    public function validateParams($params){
        $this->validateRequired($params, 'message');
        $this->validateRequired($params, 'recipients');
        $this->validateIsArray($params, 'recipients');

        foreach ($params['recipients'] as $recipient){
            $this->validateRequired($recipient, 'transport');
            $this->validateRequired($recipient, 'recipient');
            $this->validateDuplicate($recipient);
        }

        $result = count($this->errors) == 0;
        return $result;
    }

    /**
     * @return array
     */
    public function getErrors(){
        return $this->errors;
    }

    /**
     * @param $params
     * @param $field
     */
    private function validateRequired($params, $field){
        if(!isset($params[$field]) || empty($params[$field])){
            $this->errors[] = '%' . $field . '% is required field';
        }
    }

    /**
     * @param $params
     * @param $field
     */
    private function validateIsArray($params, $field){
        if(!is_array($params[$field])){
            $this->errors[] = '%' . $field . '% must be array';
        }
    }

    /**
     * @param $item
     */
    private function validateDuplicate($item){
        $transport = $item['transport'] ?? '';
        $recipient = $item['recipient'] ?? '';

        $key = $transport . '_' . $recipient;

        if(isset($this->messages[$key])){
            $this->errors[] = 'error, duplicate ' . $transport . ' recipient: ' . $recipient;
        }

        $this->messages[$key] = $key;
    }
}