<?php

namespace App\Services;
use InvalidArgumentException;

class CurrencyExchangeService
{
    private $currency = [];

    public function __construct(array $currency)
    {
        $this->currency = $currency;
    }

    /**
     * @param string $source
     * @param string $target
     * @param string $amount
     * @throws InvalidArgumentException
     * @return string
     */
    public function execute($source, $target, string $amount):string
    {
        if (!array_key_exists($source, $this->currency)) {
            throw new InvalidArgumentException('source 不在服務範圍');
        }

        if (!array_key_exists($target, $this->currency[$source])) {
            throw new InvalidArgumentException('target 不在服務範圍');
        }

        $convertAmount = str_replace(',', '', $amount);

       if (!preg_match('/^\d+(\.\d+)?$/', $convertAmount)) {
            throw new InvalidArgumentException('amount 非數字');
       }

        $floatAmount = (float)$convertAmount;

        $roundAmount = round($floatAmount, 2);

        $exchangeResult = $roundAmount * $this->currency[$source][$target];

        $roundExchange = round($exchangeResult, 2);

        return number_format($roundExchange, 2, '.', ',');
    }
}
