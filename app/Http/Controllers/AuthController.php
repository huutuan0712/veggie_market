<?php

namespace App\Http\Controllers;

use App\DTOs\User\User as UserDTO;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;
use App\Http\Requests\User\UpdatePasswordRequest;
use App\Http\Requests\User\UpdateProfileRequest;
use App\Models\CartItem;
use App\Models\User;
use App\Services\UserService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    protected $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }


    public function showLoginForm()
    {
        return view('pages.auth.login');
    }


    public function login(LoginRequest $request)
    {
        try {
            $credentials = $request->validated();

            if (Auth::guard('web')->attempt($credentials, $request->remember)) {
                $request->session()->regenerate();

                $user = Auth::user();

                if ($user->isAdmin()) {
                    return redirect()->route('admin.dashboard')->with('success', 'Đăng nhập với quyền quản trị');
                } elseif (!$user->isAdmin()) {
                    return redirect()->route('home')->with('success', 'Đăng nhập thành công');
                } else {
                    Auth::logout();
                    return back()->withErrors(['error' => 'Tài khoản không có quyền truy cập']);
                }
            }

            throw ValidationException::withMessages([
                'email' => ['Email hoặc mật khẩu không chính xác.'],
            ]);
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Đã xảy ra lỗi: ' . $e->getMessage()]);
        }
    }

    public function showRegisterForm()
    {
        return view('pages.auth.register');
    }

    public function register(RegisterRequest $request)
    {
        try {
            $dto = UserDTO::fromRequest($request->validated());
            $user = $this->userService->createDTO($dto);

            Auth::login($user);

            return redirect()->route('home')->with('success', 'Đăng ký thành công, bạn đã đăng nhập!');

        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Đã xảy ra lỗi: ' . $e->getMessage()]);
        }
    }


    public function showForgotPasswordForm()
    {
        return view('pages.auth.forgot-password');
    }

    public function forgotPassword(Request $request)
    {
        try {
            $request->validate([
                'email' => 'required|email|exists:users,email',
            ]);

            $status = Password::sendResetLink(
                $request->only('email')
            );

            return $status === Password::RESET_LINK_SENT
                ? back()->with(['success' => __($status)])
                : back()->withErrors(['email' => __($status)]);

        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Đã xảy ra lỗi: ' . $e->getMessage()]);
        }
    }


    public function showRestPasswordForm(Request $request, $token = null)
    {
        return view('pages.auth.reset-password')->with([
            'token' => $token,
            'email' => $request->email,
        ]);
    }

    public function reset(Request $request)
    {
        try {
            $request->validate([
                'email' => 'required|email|exists:users,email',
                'password' => 'required|confirmed|min:8',
                'token' => 'required'
            ]);

            $user = User::where('email', $request->email)->first();

            $status = Password:: reset(
                $request->only('email', 'password', 'password_confirmation', 'token'), function ($user) use ($request) {
                $user->password = Hash::make($request->password);
                $user->save();
            }
            );

            if ($status === Password::PASSWORD_RESET) {
                return redirect()->route('login')->with('success', 'Your password has been reset!');
            } else {
                return back()->withErrors(['email' => 'The provided token is invalid.']);
            }

        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Đã xảy ra lỗi' . $e->getMessage()]);
        }

    }

    public function logout(Request $request)
    {
        Auth::guard('web')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login');
    }

    public function showAccount(Request $request)
    {
        $user = Auth::user();
        $tab = $request->get('tab', 'profile');
        $data = ['profile' => $user];

        if ($tab === 'orders') {
            $orders = $user->orders()->withCount('items')->latest()->get();
            $data['orderHistory'] = $orders;
        }

        if ($tab === 'favorites') {
            $favorites = $user->favorites()->latest()->get();
            $data['favoriteProducts'] = $favorites;
        }

        return view('pages.account.index', $data);
    }

    public function updateAccount(UpdateProfileRequest $request)
    {
        $dto = UserDTO::fromRequest($request->validated());
        $user = Auth::user();

        $this->userService->updateDTO($user->id, $dto);

        return back()->with('status', 'Thông tin tài khoản đã được cập nhật.');
    }

    public function updatePassword(UpdatePasswordRequest $request)
    {
        $data = $request->validated();

        $user = Auth::user();

        if (!Hash::check($data['current_password'], $user->password)) {
            return back()->withErrors(['current_password' => 'Mật khẩu hiện tại không đúng.']);
        }

        $user->update([
            'password' => Hash::make($data['new_password']),
        ]);

        return back()->with('status', 'Mật khẩu đã được cập nhật thành công.');
    }
}
