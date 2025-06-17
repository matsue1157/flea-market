<?php

namespace App\Providers;

use App\Actions\Fortify\CreateNewUser;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\ServiceProvider;
use Laravel\Fortify\Fortify;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Laravel\Fortify\Contracts\RegisterResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\RegisterRequest;
use Laravel\Fortify\Contracts\LoginResponse;

class FortifyServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // 新規ユーザー登録処理を登録
        Fortify::createUsersUsing(CreateNewUser::class);

        // 会員登録画面
        Fortify::registerView(function () {
            return view('auth.register');
        });

        // ログイン画面
        Fortify::loginView(function () {
            return view('auth.login');
        });

        // ログイン試行のレート制限設定
        RateLimiter::for('login', function (Request $request) {
            $email = (string) $request->email;
            return Limit::perMinute(10)->by($email . $request->ip());
        });

        // カスタム認証処理（必要に応じて）
        Fortify::authenticateUsing(function (Request $request) {
            $user = User::where('email', $request->email)->first();

            if ($user && Hash::check($request->password, $user->password) && $user->hasVerifiedEmail()) {
                return $user;
            }

            return null;
        });

        // ✅ 登録完了後のリダイレクト先を profile.edit に指定
        $this->app->singleton(RegisterResponse::class, function () {
            return new class implements RegisterResponse {
                public function toResponse($request): RedirectResponse
                {
                    $user = $request->user();

                    if ($user && !$user->hasVerifiedEmail()) {
                        return redirect()->route('verification.notice'); // => /email/verify
                    }

                    return redirect()->route('profile.edit'); // 認証済みの場合
                }
            };
        });
        // ✅ ログイン後のリダイレクト先を mypage に指定
        $this->app->singleton(LoginResponse::class, function () {
            return new class implements LoginResponse {
                public function toResponse($request): \Illuminate\Http\RedirectResponse
                {
                    return redirect()->route('products.index');
                }
            };
        });
    }
}