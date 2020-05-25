<?php

namespace Tests\Feature\Http\Controllers;

use Illuminate\Support\Facades\Config;
use Tests\TestCase;

class WelcomeTest extends TestCase
{

    /** @test */
    public function can_not_access_welcome_page_without_pin() {
        $response = $this->get(route('root'));
        $response->assertStatus(302);
        $response->assertRedirect(route('pin.create'));
    }

    /** @test */
    public function can_access_welcome_page_with_pin_cookie() {
        $response = $this->withCookie('access', 'pass')->get(route('root'));
        $response->assertStatus(200);
    }

    /** @test */
    public function can_enter_pin_and_access_root_page() {
        Config::set('settings.PIN', '5678');
        $response = $this->post(route('pin.store', [
            'pin' => '5678',
        ]));
        $response->assertCookie('access', 'pass');
    }

    /** @test */
    public function blocks_for_one_minute_after_three_attemps() {
        $this->post(route('pin.store', [
            'pin' => '1',
        ]));
        $this->post(route('pin.store', [
            'pin' => '2',
        ]));
        $this->post(route('pin.store', [
            'pin' => '3',
        ]));
        $response = $this->post(route('pin.store', [
            'pin' => '3',
        ]));
        $response->assertStatus(429);
    }
}
