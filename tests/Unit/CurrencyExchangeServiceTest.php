<?php

namespace Tests\Unit;

use App\Services\CurrencyExchangeService;
use PHPUnit\Framework\TestCase;
use InvalidArgumentException;

class CurrencyExchangeServiceTest extends TestCase
{
    /**
     * 測試匯率轉換成功
     * @return void
     */
    public function testSuccess()
    {
        $currency = ['TWD' => ['TWD' => 1, 'JPY' => 3.669, 'USD' => 0.03281],
                     'JPY' => ['TWD' => 0.26956, 'JPY' => 1, 'USD' => 0.00885],
                     'USD' => ['TWD' => 30.444, 'JPY' => 111.801, 'USD' => 1]];
        $service = new CurrencyExchangeService($currency);
        $result = $service->execute('TWD', 'JPY', '123,456.78');
        $this->assertEquals('452,962.93', $result);

        $result = $service->execute('TWD', 'JPY', '123,456.78999');
        $this->assertEquals('452,962.96', $result);

        $result = $service->execute('TWD', 'USD', '30');
        $this->assertEquals('0.98', $result);

        $result = $service->execute('USD', 'TWD', '30');
        $this->assertEquals('913.32', $result);
    }

    /**
     * 測試不提供的匯率
     * @return void
     */
    public function testNotInService()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage("source 不在服務範圍");

        $currency = ['TWD' => ['TWD' => 1, 'JPY' => 3.669, 'USD' => 0.03281],
                     'JPY' => ['TWD' => 0.26956, 'JPY' => 1, 'USD' => 0.00885],
                     'USD' => ['TWD' => 30.444, 'JPY' => 111.801, 'USD' => 1]];
        $service = new CurrencyExchangeService($currency);
        $service->execute('RMB', 'JPY', '123,456');
    }

    /**
     * 測試非數字的輸入
     * @return void
     */
    public function testNotExceptInput()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage("amount 非數字");

        $currency = ['TWD' => ['TWD' => 1, 'JPY' => 3.669, 'USD' => 0.03281],
                     'JPY' => ['TWD' => 0.26956, 'JPY' => 1, 'USD' => 0.00885],
                     'USD' => ['TWD' => 30.444, 'JPY' => 111.801, 'USD' => 1]];
        $service = new CurrencyExchangeService($currency);
        $service->execute('TWD', 'JPY', '測試');
    }
}
