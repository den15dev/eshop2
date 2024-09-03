<?php

namespace Tests\Feature\Common;

use App\Modules\Languages\LanguageService;
use Tests\TestCase;

class LanguageTest extends TestCase
{
    public function test_set_cookie_on_language_switching(): void
    {
        $new_lang = 'ru';
        $data = [
            'new_language' => $new_lang,
        ];

        $response = $this->post(route('language.set'), $data);

        $response->assertStatus(302);
        $response->assertCookie(LanguageService::COOKIE, $new_lang);
    }


    public function test_redirect_to_preferred_language_route(): void
    {
        $new_lang = 'ru';
        $response = $this->withCookie(LanguageService::COOKIE, $new_lang)->get(route('catalog', 'cpu'));

        $new_url = str_replace('/en/', '/' . $new_lang . '/', route('catalog', 'cpu'));

        $response->assertRedirect($new_url);
    }
}
