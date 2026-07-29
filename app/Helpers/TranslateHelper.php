<?php

namespace App\Helpers;

use Stichoza\GoogleTranslate\GoogleTranslate;
use Illuminate\Support\Facades\Cache;

class TranslateHelper
{
    public static function translate($text)
    {
        if (!$text) return $text;

        $locale = session('locale', 'en');

        // Default English হলে translate এর দরকার নেই
        if ($locale === 'en') {
            return $text;
        }

        // Cache key
        $cacheKey = 'trans_' . md5($locale . $text);

        // যদি cache already থাকে → সরাসরি return
        if (Cache::has($cacheKey)) {
            return Cache::get($cacheKey);
        }

        try {
            $tr = new GoogleTranslate($locale);
            $translated = $tr->translate($text);

            // Cache for 1 year
            Cache::put($cacheKey, $translated, now()->addYear());

            return $translated;

        } catch (\Exception $e) {
            return $text; // সমস্যা হলে original টেক্সট দেখাবে
        }
    }
}
