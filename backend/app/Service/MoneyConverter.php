<?php

namespace App\Service;

use App\Dto\ConvertedCurrencyDto;
use App\Dto\MoneyDto;
use GuzzleHttp\Client;
use \Cache;
use GuzzleHttp\Exception\GuzzleException;

class MoneyConverter
{
    public const API_KEY = 'cur_live_lJ1B3ROUfpJFH7fWpLP0f99YKXnlMpSB0sMXMhVN';
    public const TYPE_PRESALE = 1;
    public const TYPE_TOURNAMENT = 2;

    public function __construct(protected float $presaleRate, protected float $tournamentRate)
    {
    }

    /**
     * @param  string  $base
     * @param  array   $to
     * @throws GuzzleException
     * @return ConvertedCurrencyDto
     */
    public function getCurrencyRates(string $base, array $to): ConvertedCurrencyDto
    {
        $responseData = Cache::get('currency_rates');

        if ($responseData === null) {
            $client = new Client([
                'base_uri' => 'https://api.currencyapi.com/v3/',
            ]);

            $response = $client->get('latest?apikey=' . self::API_KEY . '&currencies='
                . implode('%2C', $to) . '&base_currency=' . $base);
            $response = json_decode($response->getBody(), true);

            if (!isset($response['data'])) {
                throw new \RuntimeException("Can't get currency exchange rates");
            }

            Cache::put('currency_rates', $response['data'], now()->addMinutes(240));

            $responseData = $response['data'];
        }

        $result = new ConvertedCurrencyDto();
        $result->apiResponseData = $responseData;
        $result->usdToBtc = $responseData['BTC']['value'];
        $result->usdToEth = $responseData['ETH']['value'];
        $result->usdToRub = $responseData['RUB']['value'];
        $result->usdToThb = $responseData['THB']['value'];

        return $result;
    }

    /**
     * @param  float   $amt
     * @param  string  $from
     * @param  int     $type
     * @throws GuzzleException
     * @return MoneyDto
     */
    public function convert(float $amt, string $from, int $type): MoneyDto
    {
        $rates = $this->getCurrencyRates('USD', ['BTC', 'ETH', 'RUB', 'THB', 'BNB']);
        $rate = match ($from) {
            'USDT' => $rates->usdToUsdt,
            'THB' => $rates->usdToThb,
            'RUB' => $rates->usdToRub,
            'ETH' => $rates->usdToEth,
            'BTC' => $rates->usdToBtc,
            'USD' => 1,
        };

        $usdAmt = $amt / $rate;

        $result = match ($type) {
            self::TYPE_PRESALE => $usdAmt / $this->presaleRate,
            self::TYPE_TOURNAMENT => $usdAmt / $this->tournamentRate,
        };

        $moneyDto = new MoneyDto();
        $moneyDto->initialAmt = $amt;
        $moneyDto->usdAmt = $usdAmt;
        $moneyDto->tokensAmt = floor($result);
        $moneyDto->conversionRate = $rate;

        return $moneyDto;
    }
}