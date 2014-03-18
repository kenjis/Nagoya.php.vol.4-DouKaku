<?php

namespace Nagoya\Doukaku;

class App
{
    const PROCESS_MARK = '.';

    /**
     * @var RegisterCollection
     */
    protected $registerCollection;

    public function __construct($registerList)
    {
        $registerSelector = new RegisterSelector;
        $this->registerCollection = new RegisterCollection(
            $registerList, $registerSelector
        );
    }

    /**
     * main
     *
     * @param  string $input
     * @return string
     */
    public function process($input)
    {
        $inputArray = str_split($input);

        foreach ($inputArray as $val) {
            if ($val === static::PROCESS_MARK) {
                $this->registerCollection->process();
            } else {
                $this->registerCollection->addCustomers($val);
            }
        }

        $output = implode(',', $this->registerCollection->getStatus());

        return $output;
    }

}
