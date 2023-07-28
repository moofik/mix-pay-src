<?php

namespace App\Http\Controllers;

use App\Dto\RegistrationDto;
use App\Http\Requests\PayAndRegisterRequest;
use App\Http\Requests\PayRequest;
use App\Service\MoneyConverter;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    use Registration;

    public function payAndRegister(PayAndRegisterRequest $request)
    {
        try {
            /** @var RegistrationDto $registrationDto */
            $registrationDto = \DB::transaction(function () use ($request) {
                $registrationDto = $this->registerUser($request, random_int(100, 1000000));
                $registrationDto->user->payments()->create($this->getData());

                return $registrationDto;
            });
        } catch (\Throwable $exception) {
            abort(422, $exception->getMessage());
        }

        return response()->json([
            'access_token'   => $registrationDto->token->plainTextToken,
            'token_type'     => 'Bearer',
            'payment_status' => 'success',
        ]);
    }

    public function pay(PayRequest $request)
    {
        try {
            /** @var RegistrationDto $registrationDto */
            \DB::transaction(function () use ($request) {
                auth()->user()->payments()->create($this->getData());
            });
        } catch (\Throwable $exception) {
            abort(422, $exception->getMessage());
        }

        return response()->json([
            'payment_status' => 'success',
        ]);
    }

    /**
     * @param  Request  $request
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @return array
     */
    private function getData(Request $request): array
    {
        $data = $request->safe()->only([
            'currency',
            'payment_amount',
            'payment_method',
        ]);

        $data['donation_type'] = 1;

        $moneyConverter = new MoneyConverter(0.1, 0.025);
        $tokens = $moneyConverter->convert($data['payment_amount'], $data['currency'], $data['donation_type']);
        $data['tokens_amount'] = $tokens->tokensAmt;

        if ($request->file()) {
            $fileName = time() . '_' . $request->file('file')?->getClientOriginalName();
            $filePath = $request->file('file')?->storeAs(storage_path('uploads'), $fileName, 'public');
            $data['attachment'] = $filePath;
        }

        return $data;
    }
}
