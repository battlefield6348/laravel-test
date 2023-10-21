<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;
use App\Services\CurrencyExchangeService;
use InvalidArgumentException;
use Illuminate\Support\Facades\Validator;

class CurrencyExchangeController extends Controller
{
    public function exchange(FormRequest $request) {
        $validator = Validator::make($request->all(), [
            'source' => 'required',
            'target' => 'required',
            'amount' => 'required',
        ]);

        if ($validator->fails()) {
            $errorContent = ['msg' => '缺少欄位'];
            return response()->json($errorContent, Response::HTTP_BAD_REQUEST);
        }

        try {
            $source = $request->query('source');
            $target = $request->query('target');
            $amount = $request->query('amount');
            $currency = ['TWD' => ['TWD' => 1, 'JPY' => 3.669, 'USD' => 0.03281],
                         'JPY' => ['TWD' => 0.26956, 'JPY' => 1, 'USD' => 0.00885],
                         'USD' => ['TWD' => 30.444, 'JPY' => 111.801, 'USD' => 1]];
                         
            $service = new CurrencyExchangeService($currency);
            $result = $service->execute($source, $target, $amount);
        } catch (InvalidArgumentException $e) {
            $errorContent = ['msg' => $e->getMessage()];
            return response()->json($errorContent, Response::HTTP_BAD_REQUEST);
        } catch (\Throwable $th) {
            $errorContent = ['msg' => $th->getMessage()];
            return response()->json($errorContent, Response::HTTP_INTERNAL_SERVER_ERROR);
        }
        return response()->json(['msg' => 'success', 'amount' => $result], Response::HTTP_OK);
    }
}
