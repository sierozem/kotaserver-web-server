<?php declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class AuthController extends Controller
{
    public function redirect(): RedirectResponse
    {
        // @phpstan-ignore-next-line
        return Socialite::driver('google')->redirect();
    }

    public function callback(): RedirectResponse
    {
        // @phpstan-ignore-next-line
        $socialUser = Socialite::driver('google')->user();
        $user = User::firstOrNew(['email' => $socialUser->getEmail()]);
        $user->provider_id = $socialUser->getId();
        $user->provider_name = 'google';
        $user->name = $socialUser->getName();
        $user->save();

        Auth::login($user);

        return redirect('/');
    }

    public function logout(): RedirectResponse
    {
        Auth::logout();
        return redirect('/');
    }
}
