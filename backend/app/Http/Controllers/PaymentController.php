<?php

namespace App\Http\Controllers;

use App\Dto\RegistrationDto;
use App\Http\Requests\PayAndRegisterRequest;
use App\Http\Requests\PayRequest;
use App\Models\Payment;
use App\Service\MoneyConverter;
use App\Service\PaymentMessage;
use App\Service\TelegramService;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    use Registration;

    public function payAndRegister(PayAndRegisterRequest $request)
    {
        try {
            /** @var RegistrationDto $registrationDto */
            $transactionDto = \DB::transaction(function () use ($request) {
                $registrationDto = $this->registerUser($request, random_int(100, 1000000));
                $payment = $registrationDto->user->payments()->create($this->getData($request));

                return ['dto' => $registrationDto, 'payment' => $payment];
            });
        } catch (\Throwable $exception) {
            abort(422, $exception->getMessage());
        }

        $registrationDto = $transactionDto['dto'];
        /** @var Payment $payment */
        $payment = $transactionDto['payment'];
        $paymentMessage = new PaymentMessage($payment->user, $payment);
        $tgService = new TelegramService([131231613, 463609933, 6138432791]);
        $tgService->send($paymentMessage);

        return response()->json([
            'access_token'   => $registrationDto->token->plainTextToken,
            'token_type'     => 'Bearer',
            'payment_status' => 'success',
            'payment_id' => $payment->id,
        ]);
    }

    public function pay(PayRequest $request)
    {
        try {
            /** @var RegistrationDto $registrationDto */
            /** @var Payment $payment */
            $payment = \DB::transaction(function () use ($request) {
                return auth()->user()->payments()->create($this->getData($request));
            });
        } catch (\Throwable $exception) {
            abort(422, $exception->getMessage());
        }

        $paymentMessage = new PaymentMessage($payment->user, $payment);
        $tgService = new TelegramService([131231613, 463609933, 6138432791]);
        $tgService->send($paymentMessage);

        return response()->json([
            'payment_status' => 'success',
            'payment_id' => $payment->id,
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


        if ($request->file()) {
            $fileName = time() . '_' . $request->file('file')?->getClientOriginalName();
            $filePath = $request->file('file')?->storeAs('uploads', $fileName, 'public');
            $data['attachment'] = $fileName;
        }

        return $data;
    }
}
