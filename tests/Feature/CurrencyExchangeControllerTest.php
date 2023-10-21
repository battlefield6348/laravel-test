<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Response;
use Tests\TestCase;

class CurrencyExchangeControllerTest extends TestCase
{
    /**
     * 測試轉換成功
     * @return void
     */
    public function testSuccess()
    {
        $response = $this->json('GET', '/api/currency_exchange?source=TWD&target=USD&amount=500');
        $response
            ->assertStatus(Response::HTTP_OK)
            ->assertJson(['msg' => 'success', 'amount' => '16.41']);
    }

    /**
     * 測試缺少必填欄位
     * @return void
     */
    public function testNoRequiredColumn()
    {
        $response = $this->json('GET', '/api/currency_exchange');
        $response
            ->assertStatus(Response::HTTP_BAD_REQUEST)
            ->assertJson(['msg' => '缺少欄位']);
    }
}
