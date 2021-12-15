<?php declare(strict_types=1);

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Socialite\Facades\Socialite;
use Mockery;
use Tests\TestCase;

/**
 * @internal
 */
class AuthTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();

        $this->user = Mockery::mock('Laravel\Socialite\Two\User');
        $this->user
            ->shouldReceive('getId')
            ->andReturn(uniqid())
            ->shouldReceive('getEmail')
            ->andReturn(uniqid() . '@example.com')
            ->shouldReceive('getName')
            ->andReturn('Pseudo');

        $this->provider = Mockery::mock('Laravel\Socialite\Contracts\Provider');
        $this->provider->shouldReceive('user')->andReturn($this->user);
    }

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

    /**
     * @test
     */
    public function Googleアカウントでユーザー登録できる(): void
    {
        Socialite::shouldReceive('driver')
            ->with('google')
            ->andReturn($this->provider);

        $this->get(route('auth.callback'))
            ->assertRedirect(route('dashboard'));

        $this->assertDatabaseHas('users', [
            'provider_id' => $this->user->getId(),
            'provider_name' => 'google',
            'name' => $this->user->getName(),
            'email' => $this->user->getEmail(),
        ]);
        $this->assertAuthenticated();
    }
}
