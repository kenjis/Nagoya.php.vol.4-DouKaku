<?php

namespace Nagoya\Doukaku;

class Register
{
    const DESPERATE_CUSMOMER_MARK = 'x';
    const DESPERATE_CUSMOMER_COUNT = 1;

    /**
     * @var int
     */
    protected $id;

    /**
     * @var int
     */
    protected $capability;

    /**
     * @var SplQueue
     */
    protected $queue;

    public function __construct($id, $capability)
    {
        $this->id = $id;
        $this->capability = $capability;
        $this->queue = new \SplQueue();
    }

    /**
     * @param  mixed                      $customers
     * @throws Exception\RuntimeException
     */
    public function addCustomers($customers)
    {
        if (is_numeric($customers)) {
            $customers = intval($customers);
        } elseif ($customers !== static::DESPERATE_CUSMOMER_MARK) {
            throw new Exception\RuntimeException('Illegal value: ' . $customers);
        }
        $this->queue->enqueue($customers);
    }

    public function process()
    {
        $capability = $this->capability;

        while ($capability > 0) {
            try {
                $item = $this->queue->dequeue();
            } catch (\RuntimeException $e) {
                break;
            }

            if (is_int($item)) {
                if ($item <= $capability) {
                    $capability -= $item;
                } else {
                    $item -= $capability;
                    $capability = 0;
                    $this->queue->unshift($item);
                }
            } elseif ($item === static::DESPERATE_CUSMOMER_MARK) {
                $this->queue->unshift($item);
                $capability = 0;
            }
        }
    }

    /**
     * @return int
     */
    public function calcCustomerCount()
    {
        $count = 0;
        foreach ($this->queue as $number) {
            if ($number === static::DESPERATE_CUSMOMER_MARK) {
                $number = static::DESPERATE_CUSMOMER_COUNT;
            }
            $count += $number;
        }

        return $count;
    }

}
