<?php

namespace App\Http\Controllers;

use App\Dto\RegistrationDto;
use App\Http\Requests\PayAndRegisterRequest;
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

                $data = $request->safe()->only([
                    'donation_type',
                    'currency',
                    'payment_amount',
                    'payment_method',
                ]);

                if ($request->file()) {
                    $fileName = time() . '_' . $request->file('file')?->getClientOriginalName();
                    $filePath = $request->file('file')?->storeAs(public_path('uploads'), $fileName, 'public');
                    $data['attachment'] = $filePath;
                }

                $registrationDto->user->payments()->create($data);

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
}
