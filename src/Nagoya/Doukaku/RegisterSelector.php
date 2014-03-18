<?php

namespace Nagoya\Doukaku;

class RegisterSelector
{
    /**
     * @param  RegisterCollection $registerCollection
     * @return Register
     */
    public function select(RegisterCollection $registerCollection)
    {
        $min = PHP_INT_MAX;

        /* @var $register Register */
        foreach ($registerCollection->getRegisters() as $register) {
            if ($min > $register->calcCustomerCount()) {
                $min = $register->calcCustomerCount();
                $choice = $register;
            }
        }

        return $choice;
    }
}
