<?php

namespace App\Dto;

class ConvertedCurrencyDto
{
    public array $apiResponseData = [];
    public float $usdToThb;
    public float $usdToBtc;
    public float $usdToEth;
    public float $usdToRub;
    public float $usdToUsdt = 1;
}