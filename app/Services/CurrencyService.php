<?php

namespace App\Services;

use App\Contracts\Services\CurrencyServiceInterface;
use App\Helpers\RequestHelper;
use App\Models\Settings;
use Exception;
use GeoIP;
use Request;

class CurrencyService implements CurrencyServiceInterface
{
    private $currency;

    // Available currencies in whole application.
    public const CURRENCIES = [
        'USA',
        'Russia',
    ];

    public function __construct()
    {
        $this->setCurrency();
    }

    public function setCurrency(): void
    {
        $country = self::getCountry();

        $isApiRequest = RequestHelper::isApiRequest();

        if ($isApiRequest) {
            if ($country === 'USA' || $country === 'США') {
                $currency = trans('labels.currency.USA.unicode');
            } else {
                $currency = trans('labels.currency.Russia.unicode');
            }
        } else {
            if ($country === 'USA' || $country === 'США') {
                $currency = trans('labels.currency.USA.name');
            } else {
                $currency = trans('labels.currency.Russia.name');
            }
        }

        // If not defined
        if (is_null($currency)) {
            $currency = trans('labels.currency.Russia.name');
        }

        $this->currency = $currency;
    }

    public function getCurrency(): string
    {
        return $this->currency;
    }

    public function convertFromRub(float $price): float
    {
        $country = self::getCountry();
        $exchange = self::getExchange();

        if ($country === 'USA' || $country === 'США') {
            $price = (float) number_format($price / $exchange, 2, '.', '');
        } else {
            $price = (float) number_format($price, 2, '.', '');
        }

        return $price;
    }

    public function convertToRub(float $price): float
    {
        $country = self::getCountry();
        $exchange = self::getExchange();

        if ($country === 'USA' || $country === 'США') {
            $price = (float) number_format($price * $exchange, 2, '.', '');
        } else {
            $price = (float) number_format($price, 2, '.', '');
        }

        return $price;
    }

    public function getCurrencyCode(): string
    {
        $currencyCode = 'RUB'; // Currency by default RUB

        /*if ($this->currency === 'usd') {
            $currencyCode = 'USD';
        }*/

        return $currencyCode;
    }

    public static function getCountry(): string
    {
        if (!$country = session()->get('country')) {
            try {
                //$country = GeoIP::getLocation(Request::ip())['country'];
            } catch (Exception $exception) {
                $country = 'Russia';
            }
        }

        if (!$country) {
            $country = 'Russia';
        }

        return $country;
    }

    public static function getCurrencies(): array
    {
        return self::CURRENCIES;
    }

    public static function getExchange(): float
    {
        $settings = Settings::getInstance(['exchange_rate_rub_uah']);

        if (!$settings) {
            return 0;
        }

        return $settings->exchange_rate_rub_uah;
    }
}
