<?php

namespace App\Service;

use App\Models\Payment;
use App\Models\User;

class PaymentMessage implements MessageInterface
{
    public function __construct(protected ?User $user, protected Payment $payment)
    {
    }

    public function getMessage(): string
    {
        $paymentMessage = "Телефон: " . ($this->payment->user->phone) . "\n";
        $paymentMessage .= "E-mail: " . ($this->payment->user->email) . "\n";
        $paymentMessage .= "Id платежа: " .  $this->payment->id . "\n";
        $paymentMessage .= "Способ оплаты: " . $this->payment->payment_method . "\n";
        $paymentMessage .= "Валюта: " . $this->payment->currency . "\n";
        $paymentMessage .= "Количество: " . $this->payment->payment_amount . "\n";
        $link = "storage/uploads/" . $this->payment->attachment;
        $paymentMessage .= "Ссылка на подтверждение оплаты: " . \URL::to($link) . "\n";

        return $paymentMessage;
    }
}