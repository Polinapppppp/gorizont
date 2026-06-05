<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Artisan;

class SetupAuthHorizont extends Command
{
    protected $signature = 'setup:auth-horizont';
    protected $description = 'Полная настройка авторизации (Регистрация/Вход) под верстку проекта Горизонт';

    public function handle()
    {
        $this->info('🚀 Начинаем настройку авторизации для проекта Горизонт...');

        // 1. Создаем стандартные файлы Laravel
        $this->call('make:migration', ['name' => 'create_users_table', '--create' => 'users']);
        $this->call('make:model', ['name' => 'User']);
        $this->call('make:controller', ['name' => 'AuthController']);

        // 2. Создаем директории для views
        File::makeDirectory(resource_path('views/auth'), 0755, true, true);

        // 3. Генерируем содержимое файлов
        $this->updateMigration();
        $this->updateModel();
        $this->updateController();
        $this->createRegisterView();
        $this->createLoginView();
        $this->updateRoutes();

        // 4. Запускаем миграцию
        if ($this->confirm('Запустить миграцию базы данных сейчас?')) {
            Artisan::call('migrate');
            $this->info('✅ Миграция выполнена успешно.');
        }

        $this->info('✨ Готово! Теперь у вас есть страницы /register и /login.');
        return 0;
    }

    private function updateMigration()
    {
        $files = File::files(database_path('migrations'));
        foreach ($files as $file) {
            if (strpos($file->getFilename(), 'create_users_table') !== false) {
                $path = $file->getPathname();
                $content = File::get($path);

                // Заменяем схему таблицы на нужную нам
                $newSchema = <<<'PHP'
Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('phone')->unique();
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();
            $table->timestamps();
        });
PHP;

                // Простая замена через регулярку или поиск блока
                // Для надежности просто перезапишем весь метод up, если он стандартный,
                // но лучше найти блок Schema::create и заменить его.
                // Здесь используем простой str_replace для демонстрации, предполагая стандартную структуру

                $pattern = '/Schema::create\(\'users\', function \(Blueprint \$table\) \{(.*?)\}\);/s';
                $replacement = $newSchema;

                File::put($path, preg_replace($pattern, $replacement, $content));
                $this->info('✅ Миграция обновлена (добавлены name, phone).');
                break;
            }
        }
    }

    private function updateModel()
    {
        $path = app_path('Models/User.php');
        $content = File::get($path);

        // Заменяем $fillable на $guarded = []
        $content = preg_replace('/protected \$fillable = \[(.*?)\];/s', 'protected $guarded = [];', $content);

        File::put($path, $content);
        $this->info('✅ Модель User обновлена ($guarded = []).');
    }

    private function updateController()
    {
        $path = app_path('Http/Controllers/AuthController.php');
        $code = <<<'PHP'
<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules\Password;
use App\Models\User;

class AuthController extends Controller
{
    public function showRegister() { return view('auth.register'); }

    public function register(Request $request)
    {
        $request->validate([
            'name'     => 'required|string|min:2',
            'phone'    => 'required|string|unique:users,phone',
            'email'    => 'required|email|unique:users,email',
            'password' => ['required', 'confirmed', Password::min(6)->letters()->numbers()],
        ]);

        User::create([
            'name'     => $request->name,
            'phone'    => $request->phone,
            'email'    => $request->email,
            'password' => bcrypt($request->password),
        ]);

        if (Auth::attempt($request->only(['email', 'password']))) {
            return redirect('/');
        }
        return back()->withErrors(['email' => 'Ошибка входа'])->withInput();
    }

    public function showLogin() { return view('auth.login'); }

    public function login(Request $request)
    {
        $request->validate([
            'email'    => 'required|email|exists:users,email',
            'password' => 'required',
        ]);

        if (Auth::attempt($request->only(['email', 'password']))) {
            $request->session()->regenerate();
            return redirect('/');
        }

        return back()->withErrors(['email' => 'Неверный email или пароль.'])->withInput();
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
}
PHP;
        File::put($path, $code);
        $this->info('✅ Контроллер AuthController создан.');
    }

    private function createRegisterView()
    {
        $path = resource_path('views/auth/register.blade.php');
        $html = <<<'HTML'
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Регистрация — Горизонт</title>
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
</head>
<body class="page">
    <header class="hero__header header">
        <div class="header__inner">
            <a class="header__logo" href="/">Горизонт</a>
            <input type="checkbox" id="nav-toggle" class="header__nav-toggle">
            <label for="nav-toggle" class="header__burger"><span class="header__burger-line"></span><span class="header__burger-line"></span><span class="header__burger-line"></span></label>
            <div class="header__panel">
                <nav class="header__nav">
                    <a class="header__link" href="#apartment">Выбрать квартиру</a>
                    <a class="header__link" href="#microdistrict">О проекте</a>
                    <a class="header__link" href="#developer">О застройщике</a>
                </nav>
                <div class="header__actions">
                    <p class="header__schedule">Режим работы: 8:00 - 18:00</p>
                    <a class="header__callback btn btn--light" href="#booking">Заказать звонок</a>
                </div>
            </div>
        </div>
    </header>

    <main class="page__s">
        <section class="auth-section">
            <div class="auth-card">
                <h1 class="auth-title">Регистрация</h1>
                <form class="auth-form" action="{{ route('register.store') }}" method="POST">
                    @csrf
                    <div class="auth-field">
                        <input type="text" name="name" placeholder="Имя" value="{{ old('name') }}" required />
                        @error('name') <span style="color:red">{{ $message }}</span> @enderror
                    </div>
                    <div class="auth-field">
                        <input type="tel" name="phone" placeholder="Телефон" value="{{ old('phone') }}" required />
                        @error('phone') <span style="color:red">{{ $message }}</span> @enderror
                    </div>
                    <div class="auth-field">
                        <input type="email" name="email" placeholder="Email" value="{{ old('email') }}" required />
                        @error('email') <span style="color:red">{{ $message }}</span> @enderror
                    </div>
                    <div class="auth-field">
                        <input type="password" name="password" placeholder="Пароль" required />
                        @error('password') <span style="color:red">{{ $message }}</span> @enderror
                    </div>
                    <div class="auth-field">
                        <input type="password" name="password_confirmation" placeholder="Подтвердите пароль" required />
                    </div>
                    <div class="auth-options">
                        <label class="auth-checkbox">
                            <input type="checkbox" required /> Согласен с <a href="#" class="auth-link">условиями</a>
                        </label>
                    </div>
                    <button type="submit" class="btn auth-submit">Зарегистрироваться</button>
                </form>
                <p class="auth-footer">
                    Уже есть аккаунт? <a href="{{ route('login.show') }}" class="auth-link">Войти</a>
                </p>
            </div>
        </section>
    </main>

    <footer class="site-footer">
        <div class="site-footer__top">
            <div class="site-footer__brand">
                <p class="site-footer__logo">Горизонт</p>
                <div class="site-footer__contacts">
                    <div class="site-footer__contact">
                        <p class="site-footer__label">Электронная почта:</p>
                        <a class="site-footer__value" href="mailto:horizont@mail.ru">horizont@mail.ru</a>
                    </div>
                    <div class="site-footer__contact">
                        <p class="site-footer__label">Телефон:</p>
                        <a class="site-footer__value" href="tel:+79777777777">+7(977)-777-77-77</a>
                    </div>
                </div>
            </div>
            <nav class="site-footer__nav">
                <a class="site-footer__link" href="#apartment">Выбрать квартиру</a>
                <a class="site-footer__link" href="#microdistrict">О проекте</a>
                <a class="site-footer__link" href="#developer">О застройщике</a>
            </nav>
        </div>
        <div class="site-footer__divider">
            <img src="{{ asset('assets/img/footer-line.svg') }}" alt="" width="1400" height="2">
        </div>
        <p class="site-footer__copy">©Все права защищены</p>
    </footer>
</body>
</html>
HTML;
        File::put($path, $html);
        $this->info('✅ View регистрации создан.');
    }

    private function createLoginView()
    {
        $path = resource_path('views/auth/login.blade.php');
        $html = <<<'HTML'
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Вход — Горизонт</title>
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
</head>
<body class="page">
    <header class="hero__header header">
        <div class="header__inner">
            <a class="header__logo" href="/">Горизонт</a>
            <input type="checkbox" id="nav-toggle" class="header__nav-toggle">
            <label for="nav-toggle" class="header__burger"><span class="header__burger-line"></span><span class="header__burger-line"></span><span class="header__burger-line"></span></label>
            <div class="header__panel">
                <nav class="header__nav">
                    <a class="header__link" href="#apartment">Выбрать квартиру</a>
                    <a class="header__link" href="#microdistrict">О проекте</a>
                    <a class="header__link" href="#developer">О застройщике</a>
                </nav>
                <div class="header__actions">
                    <p class="header__schedule">Режим работы: 8:00 - 18:00</p>
                    <a class="header__callback btn btn--light" href="#booking">Заказать звонок</a>
                </div>
            </div>
        </div>
    </header>

    <main class="page__s">
        <section class="auth-section">
            <div class="auth-card">
                <h1 class="auth-title">Вход</h1>
                <form class="auth-form" action="{{ route('login.store') }}" method="POST">
                    @csrf
                    <div class="auth-field">
                        <input type="email" name="email" placeholder="Email" value="{{ old('email') }}" required />
                        @error('email') <span style="color:red">{{ $message }}</span> @enderror
                    </div>
                    <div class="auth-field">
                        <input type="password" name="password" placeholder="Пароль" required />
                        @error('password') <span style="color:red">{{ $message }}</span> @enderror
                    </div>
                    <div class="auth-options">
                        <label class="auth-checkbox">
                            <input type="checkbox" name="remember" /> Запомнить меня
                        </label>
                        <a href="#" class="auth-link">Забыли пароль?</a>
                    </div>
                    <button type="submit" class="btn auth-submit">Войти</button>
                </form>
                <p class="auth-footer">
                    Нет аккаунта? <a href="{{ route('register.show') }}" class="auth-link">Зарегистрироваться</a>
                </p>
            </div>
        </section>
    </main>

    <footer class="site-footer">
        <div class="site-footer__top">
            <div class="site-footer__brand">
                <p class="site-footer__logo">Горизонт</p>
                <div class="site-footer__contacts">
                    <div class="site-footer__contact">
                        <p class="site-footer__label">Электронная почта:</p>
                        <a class="site-footer__value" href="mailto:horizont@mail.ru">horizont@mail.ru</a>
                    </div>
                    <div class="site-footer__contact">
                        <p class="site-footer__label">Телефон:</p>
                        <a class="site-footer__value" href="tel:+79777777777">+7(977)-777-77-77</a>
                    </div>
                </div>
            </div>
            <nav class="site-footer__nav">
                <a class="site-footer__link" href="#apartment">Выбрать квартиру</a>
                <a class="site-footer__link" href="#microdistrict">О проекте</a>
                <a class="site-footer__link" href="#developer">О застройщике</a>
            </nav>
        </div>
        <div class="site-footer__divider">
            <img src="{{ asset('assets/img/footer-line.svg') }}" alt="" width="1400" height="2">
        </div>
        <p class="site-footer__copy">©Все права защищены</p>
    </footer>
</body>
</html>
HTML;
        File::put($path, $html);
        $this->info('✅ View входа создан.');
    }

    private function updateRoutes()
    {
        $path = base_path('routes/web.php');
        $content = File::get($path);

        $routes = <<<'PHP'

// --- AUTH ROUTES START ---
use App\Http\Controllers\AuthController;

Route::middleware('guest')->group(function () {
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register.show');
    Route::post('/register', [AuthController::class, 'register'])->name('register.store');
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login.show');
    Route::post('/login', [AuthController::class, 'login'])->name('login.store');
});

Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});
// --- AUTH ROUTES END ---

PHP;

        // Добавляем роуты в конец файла, если их там нет
        if (strpos($content, 'AUTH ROUTES START') === false) {
            File::append($path, $routes);
            $this->info('✅ Роуты добавлены в web.php.');
        } else {
            $this->warn('⚠️ Роуты уже существуют в web.php.');
        }
    }
}
