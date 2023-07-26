<?php

namespace App\Http\Controllers;

use App\Service\MoneyConverter;
use Illuminate\Http\Request;

class CurrencyController extends Controller
{
    public function convert(Request $request)
    {
        $moneyConverter = new MoneyConverter(0.1, 0.025);
        $result = $moneyConverter->convert(
            $request->get('amount'),
            $request->get('from'),
            $request->get('type')
        );

        return response()->json(['result' => $result]);
    }
}
