<?php declare(strict_types=1);

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * @internal
 */
class AuthTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function Googleの認証画面を表示できる(): void
    {
        $response = $this->get(route('auth.redirect'));

        $target = parse_url($response->headers->get('location'));
        $query = explode('&', $target['query']);

        $response->assertRedirect();
        $this->assertEquals('accounts.google.com', $target['host']);
        $this->assertContains('redirect_uri=' . urlencode(config('services.google.redirect')), $query);
        $this->assertContains('client_id=' . config('services.google.client_id'), $query);
    }
}
