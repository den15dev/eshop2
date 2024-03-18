<?php

namespace Database\Seeders;

use Stichoza\GoogleTranslate\GoogleTranslate;

class Translator
{
    const SLEEP = 5; // seconds


    public static function get(string $text_in, string $from_lang, string $to_lang): string
    {
        $text_out = '';
        try {
            $tr = new GoogleTranslate();
            $tr->setSource($from_lang);
            $tr->setTarget($to_lang);
            $text_out = $tr->translate($text_in);

            if (!empty($text_in) && empty($text_out)) {
                throw new \Exception('Got an empty string while trying translate not empty one (length: ' . strlen($text_in) . ')');
            }

        } catch (\Exception $e) {
            echo 'Exception: ',  $e->getMessage(), "\n";
        }

        return $text_out;
    }
}