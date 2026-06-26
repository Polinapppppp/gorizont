<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules\Password;
use App\Models\User;

class AuthController extends Controller
{
    public function showRegister()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $messages = [
            'name.required'     => 'Пожалуйста, введите ваше имя.',
            'name.min'          => 'Имя должно содержать минимум 2 символа.',

            'phone.required'    => 'Введите номер телефона.',
            'phone.unique'      => 'Этот номер телефона уже зарегистрирован.',

            'email.required'    => 'Введите email адрес.',
            'email.email'       => 'Некорректный формат email.',
            'email.unique'      => 'Этот email уже занят другим пользователем.',

            'password.required' => 'Придумайте пароль.',
            'password.confirmed'=> 'Пароли не совпадают.',
            'password.min'      => 'Пароль должен быть не менее 6 символов.',
            'password.letters'  => 'Пароль должен содержать хотя бы одну букву.',
            'password.numbers'  => 'Пароль должен содержать хотя бы одну цифру.',
        ];

        $request->validate([
            'name'     => 'required|string|min:2',
            'phone'    => 'required|string|unique:users,phone',
            'email'    => 'required|email|unique:users,email',
            'password' => [
                'required',
                'confirmed',
                Password::min(6)->letters()->numbers()
            ],
        ], $messages);

        User::create([
            'name'     => $request->name,
            'phone'    => $request->phone,
            'email'    => $request->email,
            'password' => bcrypt($request->password),
        ]);

        if (Auth::attempt($request->only(['email', 'password']))) {
            return redirect('/')->with('success', 'Вы успешно зарегистрировались!');
        }

        return back()->withErrors(['email' => 'Произошла ошибка при входе. Попробуйте войти вручную.'])->withInput();
    }

    public function showLogin()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $messages = [
            'email.required' => 'Введите email.',
            'email.exists'   => 'Пользователь с таким email не найден.',
            'password.required' => 'Введите пароль.',
        ];

        $request->validate([
            'email'    => 'required|email|exists:users,email',
            'password' => 'required',
        ], $messages);

        if (Auth::attempt($request->only(['email', 'password']))) {
            $request->session()->regenerate();
            return redirect('/')->with('success', 'С возвращением!');
        }

        return back()->withErrors([
            'email' => 'Неверный email или пароль. Проверьте данные и попробуйте снова.',
        ])->withInput();
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/')->with('success', 'Вы вышли из аккаунта.');
    }

    public function profile(Request $request)
{
    $query = \App\Models\Application::where('user_id', Auth::id())
        ->with(['apartment', 'realtor']);

    // Фильтр по статусу
    if ($request->filled('status') && in_array($request->status, ['pending', 'approved', 'viewing_scheduled', 'closed'])) {
        $query->where('status', $request->status);
    }

    // Сортировка
    $sort = $request->get('sort', 'newest');
    switch ($sort) {
        case 'oldest':
            $query->oldest();
            break;
        case 'viewing_asc':
            $query->orderByRaw('viewing_date IS NULL, viewing_date ASC');
            break;
        case 'viewing_desc':
            $query->orderByRaw('viewing_date IS NULL, viewing_date DESC');
            break;
        default:
            $query->latest();
            break;
    }

    $applications = $query->paginate(10)->withQueryString();

    return view('user.profile', compact('applications', 'sort'));
}
}
