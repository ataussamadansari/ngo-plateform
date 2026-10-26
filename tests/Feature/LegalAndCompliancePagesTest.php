<?php

namespace Tests\Feature;

use Database\Seeders\NgoWhiteLabelSeeder;
use Database\Seeders\PaymentMethodSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LegalAndCompliancePagesTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(NgoWhiteLabelSeeder::class);
        $this->seed(PaymentMethodSeeder::class);
    }

    public function test_public_can_view_privacy_policy_page(): void
    {
        $response = $this->get(route('legal.privacy'));

        $response->assertOk();
        $response->assertSee('Privacy Policy');
        $response->assertSee('Your Trust Matters');
        $response->assertSee('We Value Your Privacy');
        $response->assertSee('Your Data is Safe');
        $response->assertSee('Section 80G');
        $response->assertSee(setting('80g_reg_number'));
    }

    public function test_public_can_view_terms_and_conditions_page(): void
    {
        $response = $this->get(route('legal.terms'));

        $response->assertOk();
        $response->assertSee('Terms & Conditions', false);
        $response->assertSee('Fee-Free Manual Donation Protocol');
    }

    public function test_public_can_view_legal_hub_and_disclaimer(): void
    {
        $responseLegal = $this->get(route('legal.index'));
        $responseLegal->assertOk();
        $responseLegal->assertSee('Policy & Legal');

        $responseDisclaimer = $this->get(route('legal.disclaimer'));
        $responseDisclaimer->assertOk();
        $responseDisclaimer->assertSee('Disclaimer');
    }

    public function test_footer_contains_active_legal_links(): void
    {
        $response = $this->get(url('/'));

        $response->assertOk();
        $response->assertSee(route('legal.privacy'));
        $response->assertSee(route('legal.terms'));
        $response->assertSee(route('legal.disclaimer'));
    }
}
