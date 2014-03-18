<?php

namespace Nagoya\Doukaku;

class RegisterCollection
{
    /**
     * @var array
     */
    protected $registers;

    /**
     *
     * @var RegisterSelector
     */
    protected $registerSelector;

    public function __construct($registerList, RegisterSelector $registerSelector)
    {
        foreach ($registerList as $id => $capability) {
            $this->registers[$id] = new Register($id, $capability);
        }

        $this->registerSelector = $registerSelector;
    }

    /**
     * @param mixed $customers
     */
    public function addCustomers($customers)
    {
        $this->selectRegister()->addCustomers($customers);
    }

    /**
     * @return Register
     */
    protected function selectRegister()
    {
        return $this->registerSelector->select($this);
    }

    public function process()
    {
        /* @var $register Register */
        foreach ($this->registers as $register) {
            $register->process();
        }
    }

    /**
     * @return array
     */
    public function getStatus()
    {
        $status = [];

        /* @var $register Register */
        foreach ($this->registers as $id => $register) {
            $status[$id] = $register->calcCustomerCount();
        }

        return $status;
    }

    public function getRegisters()
    {
        return $this->registers;
    }
}
