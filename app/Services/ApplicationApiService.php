<?php

namespace App\Services;

use App\Contracts\Services\ApplicationApiServiceInterface;
use App\Exceptions\AppPricesNotFoundException;
use App\Models\AppPrice;
use App\Models\Country;
use App\Models\Task;

class ApplicationApiService implements ApplicationApiServiceInterface
{
    public function getApplicationPrice(Task $application): float
    {
        $prices = AppPrice::getPrices();

        if (is_null($prices)) {
            throw new AppPricesNotFoundException();
        }

        $days = $application->days;
        switch ($application->time_delay) {
            case 24 * 60 * 60:
                if ($days >= 3 && $days <= 6) {
                    $app_price = $prices->android_daily_price_first_user;
                } elseif ($days >= 7 && $days <= 14) {
                    $app_price = $prices->android_daily_price_second_user;
                } elseif ($days >= 15 && $days <= 29) {
                    $app_price = $prices->android_daily_price_third_user;
                } elseif ($days >= 30 && $days <= 50) {
                    $app_price = $prices->android_daily_price_fourth_user;
                } else {
                    throw new AppPricesNotFoundException();
                }
                break;
            case 48 * 60 * 60:
                if ($days >= 6 && $days <= 10) {
                    $app_price = $prices->android_48h_price_first_user;
                } elseif ($days >= 11 && $days <= 20) {
                    $app_price = $prices->android_48h_price_second_user;
                } elseif ($days >= 21 && $days <= 30) {
                    $app_price = $prices->android_48h_price_third_user;
                } elseif ($days >= 31 && $days <= 50) {
                    $app_price = $prices->android_48h_price_fourth_user;
                } else {
                    throw new AppPricesNotFoundException();
                }
                break;
            case 72 * 60 * 60:
                if ($days >= 3 && $days <= 6) {
                    $app_price = $prices->android_72h_price_first_user;
                } elseif ($days >= 7 && $days <= 14) {
                    $app_price = $prices->android_72h_price_second_user;
                } elseif ($days >= 15 && $days <= 29) {
                    $app_price = $prices->android_72h_price_third_user;
                } elseif ($days >= 30 && $days <= 50) {
                    $app_price = $prices->android_72h_price_fourth_user;
                } else {
                    throw new AppPricesNotFoundException();
                }
                break;
            default:
                throw new AppPricesNotFoundException();
        }

        return $app_price;
    }

    public function generateCountryGroups(Task $application): array
    {
        $countryGroups = [];
        $groupsInit = Country::GROUPS;
        if ($application->country_group) {
            if ($application->isCis()) {
                $groupsInit = array_intersect_key($groupsInit, ['cis' => null]);
            } else {
                $groupsInit = array_diff_key($groupsInit, ['cis' => null]);
            }
        }

        foreach ($groupsInit as $group => $countries) {
            $countryGroups[$group] = array_reduce($countries, function ($result, $countryName) {
                if ($countryName === 'All') {
                    $result[0] = trans('labels.all.countries');
                } else {
                    $lang = app()->getLocale();
                    $country = Country::whereCountryNameEn($countryName)->first(['id', "country_name_$lang"]);
                    if ($country) {
                        $id = '' . $country->id;
                        $result[$id] = $country->country_name_ru;
                    }
                }

                return $result;
            }, []);
        }

        return $countryGroups;
    }
}
