<?php
namespace app\Helpers\Currency;
use NumberFormatter;

class Currency{

    public static function format($amount , $currency = 'USD'){

        $foramtter = new NumberFormatter(config('app.locale'), NumberFormatter::CURRENCY );


        return $foramtter->formatCurrency($amount,$currency);

    }
}