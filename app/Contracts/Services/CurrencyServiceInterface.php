<?php

namespace App\Contracts\Services;

interface CurrencyServiceInterface
{
    public function setCurrency(): void;

    public function getCurrency(): string;

    public function convertFromRub(float $price): float;

    public function convertToRub(float $price): float;

    public function getCurrencyCode(): string;

    public static function getCountry(): string;

    public static function getCurrencies(): array;

    public static function getExchange(): float;
}
