<?php

/**
 * This file is part of the Nagoya.Doukaku
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
    protected $registerCapability = [
        1 => 2,
        2 => 7,
        3 => 3,
        4 => 5,
        5 => 2,
    ];
    protected $registerQueue = [
        1 => [],
        2 => [],
        3 => [],
        4 => [],
        5 => [],
    ];

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

        $output = implode(',', $this->getRegisterQueuePersonNumber());
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
        $queueArray = $this->getRegisterQueuePersonNumber();

        $minRegisterId = 1;
        $minNumber = $queueArray[1];

        foreach ($queueArray as $registerId => $number) {
            if ($minNumber > $number) {
                $minRegisterId = $registerId;
                $minNumber = $queueArray[$registerId];
            }
        }

        return $minRegisterId;
    }

    protected function getRegisterQueuePersonNumber()
    {
        $register = [
            1 => 0,
            2 => 0,
            3 => 0,
            4 => 0,
            5 => 0,
        ];

        foreach ($this->registerQueue as $registerId => $queue) {
            foreach ($queue as $number) {
                if ($number === 'x') {
                    $number = 1;
                }
                $register[$registerId] += $number;
            }
        }

        return $register;
    }
}
