<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PhoneAdvancedFeaturesTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_create_user_with_international_phone_numbers(): void
    {
        // US phone creation
        $usResponse = $this->post(route('users.store'), [
            'name' => 'John US',
            'email' => 'john.us@example.com',
            'country_code' => 'US',
            'phone' => '2025550143',
            'password' => 'secret123',
        ]);

        $usResponse->assertRedirect(route('users.index'));
        $this->assertDatabaseHas('users', [
            'email' => 'john.us@example.com',
            'phone' => '+12025550143',
        ]);

        // IN phone creation
        $inResponse = $this->post(route('users.store'), [
            'name' => 'Rajesh India',
            'email' => 'rajesh.in@example.com',
            'country_code' => 'IN',
            'phone' => '9876543210',
            'password' => 'secret123',
        ]);

        $inResponse->assertRedirect(route('users.index'));
        $this->assertDatabaseHas('users', [
            'email' => 'rajesh.in@example.com',
            'phone' => '+919876543210',
        ]);
    }

    public function test_mock_sms_otp_sending(): void
    {
        $user = User::factory()->create([
            'name' => 'Alice Test',
            'email' => 'alice@example.com',
            'phone' => '+919876543210',
        ]);

        $response = $this->post(route('users.send-otp', $user));

        $response->assertSessionHas('success');
        $this->assertStringContainsString('Mock SMS OTP sent to Alice Test', session('success'));
    }

    public function test_dashboard_displays_country_analytics(): void
    {
        User::factory()->create([
            'phone' => '+919876543210',
        ]);
        User::factory()->create([
            'phone' => '+12025550143',
        ]);

        $response = $this->get(route('users.dashboard'));

        $response->assertStatus(200);
        $response->assertViewHas('countryAnalytics');
        $response->assertSee('Country-wise Phone Distribution Analytics');
    }
}
