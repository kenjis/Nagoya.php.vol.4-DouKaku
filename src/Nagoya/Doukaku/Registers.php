<?php

/**
 * このファイルは、1クラスでの解答例です。
 * これ以外のファイルは、クラスを分割して実装し直したものです。
 *
 * @license http://opensource.org/licenses/bsd-license.php BSD
 */

namespace Nagoya\Doukaku;

/**
 * Nagoya.Doukaku
 *
 * @package Nagoya.Doukaku
 */
class Registers
{
    /**
     * Capability of each register
     * 
     * @var array [int registerId => int number]
     */
    protected $registerCapability;
    
    /**
     * Queue of each register
     * 
     * @var array [int registerId => array queue]
     */
    protected $registerQueue;

    public function __construct($registerCapability)
    {
        $this->registerCapability = $registerCapability;
        
        // Initialize $this->registerQueue
        foreach ($registerCapability as $registerId => $number) {
            $this->registerQueue[$registerId] = [];
        }
    }

    /**
     * main process
     * 
     * @param string $input
     * @return string
     */
    public function process($input)
    {
        $inputArray = str_split($input);

        foreach ($inputArray as $val) {
            if ($val === '.') {
                $this->processRegister();
            } else {
                $this->addToQueue($val);
            }
        }

        $output = implode(',', $this->getRegisterQueueNumbers());
        return $output;
    }

    protected function processRegister()
    {
        foreach ($this->registerQueue as $registerId => $queue) {
            $newQueue = [];
            $capability = $this->registerCapability[$registerId];
            foreach ($queue as $item) {
                if (is_numeric($item)) {
                    if ($item <= $capability) {
                        $capability -= $item;
                    } else {
                        $item -= $capability;
                        $capability = 0;
                        $newQueue[] = $item;
                    }
                } elseif ($item === 'x') {
                    $newQueue[] = $item;
                    $capability = 0;
                } else {
                    throw new Exception\RuntimeException('Illegal value: ' . $item);
                }
            }
            $this->registerQueue[$registerId] = $newQueue;
        }
    }

    protected function addToQueue($item)
    {
        $registerId = $this->getMinRegister();
        if (is_numeric($item)) {
            $item = intval($item);
        }
        $this->registerQueue[$registerId][] = $item;
    }

    protected function getMinRegister()
    {
        $queueArray = $this->getRegisterQueueNumbers();
        $min = min($queueArray);
        return array_search($min, $queueArray);
    }

    /**
     * Get numbers of customer in each register's queue
     * 
     * @return array [int registerId => int number]
     */
    protected function getRegisterQueueNumbers()
    {
        foreach ($this->registerQueue as $registerId => $queue) {
            $registers[$registerId] = 0;
            
            foreach ($queue as $number) {
                if ($number === 'x') {
                    $number = 1;
                }
                $registers[$registerId] += $number;
            }
        }

        return $registers;
    }
}
