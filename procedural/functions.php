<?php

/**
 * main
 * 
 * @param string $input
 * @return string
 */
function main($input)
{
    $registerCapability = [
        1 => 2,
        2 => 7,
        3 => 3,
        4 => 5,
        5 => 2,
    ];
    $registerQueue = [
        1 => [],
        2 => [],
        3 => [],
        4 => [],
        5 => [],
    ];
    
    $inputArray = str_split($input);
    
    foreach ($inputArray as $val) {
        if ($val === '.') {
            $registerQueue = processRegister($registerQueue, $registerCapability);
        } else {
            $registerQueue = addToQueue($val, $registerQueue);
        }
    }
    
    $output = implode(',', getRegisterQueuePersonNumber($registerQueue));
    return $output;
}

function processRegister($registerQueue, $registerCapability)
{
    foreach ($registerQueue as $registerId => $queue) {
        $newQueue = [];
        $capability = $registerCapability[$registerId];
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
                exit('Illegal value: ' . $item . PHP_EOL);
            }
        }
        $registerQueue[$registerId] = $newQueue;
    }
    
    return $registerQueue;
}

function addToQueue($item, $registerQueue)
{
    $registerId = getMinRegister($registerQueue);
    if (is_numeric($item)) {
        $item = intval($item);
    }
    $registerQueue[$registerId][] = $item;

    return $registerQueue;
}

function getMinRegister($registerQueue)
{
    $queueArray = getRegisterQueuePersonNumber($registerQueue);
    
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

function getRegisterQueuePersonNumber($registerQueue)
{
    $register = [
        1 => 0,
        2 => 0,
        3 => 0,
        4 => 0,
        5 => 0,
    ];
    
    foreach ($registerQueue as $registerId => $queue) {
        foreach ($queue as $number) {
            if ($number === 'x') {
                $number = 1;
            }
            $register[$registerId] += $number;
        }
    }
    
    return $register;
}
