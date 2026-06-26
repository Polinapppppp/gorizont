<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Регистрация — Горизонт</title>
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
    <link rel="shortcut icon" href="{{asset('assets/img/fav.png')}}" type="image/x-icon">

</head>

<body class="page">
     <header class="hero__header header">
        <div class="header__inner">
            <a class="header__logo" href="/"><img src="{{ asset('assets/img/logo2.svg') }}" alt=""></a>

            <button class="burger-btn" id="burgerBtn" aria-label="Меню">
                <span></span><span></span><span></span>
            </button>

            <div class="header__panel desktop-panel">
                <nav class="header__nav" aria-label="Основное меню" style="color: #1a1a1a">
                    <a class="header__link" href="/">Главная</a>
                    <a class="header__link" href="{{ url('/') }}#view-3d">Выбрать квартиру</a>
                    <a class="header__link" href="{{ url('/') }}#developer">О застройщике</a>
                    <a class="header__link" href="/apartments">Каталог</a>
                    @if (auth()->user() && auth()->user()->role_id == 1)
                        <a class="header__link" href="/profile">Личный кабинет</a>
                    @endif
                    @if (auth()->check() && auth()->user()->isAdmin())
                        <a class="header__link" href="/admin/dashboard">Админ-панель</a>
                    @endif
                    @if (auth()->check() && auth()->user()->isRealtor())
                        <a class="header__link" href="/dashboard">Админ-панель</a>
                    @endif
                    @guest
                        <a class="header__link" href="/register">Регистрация</a>
                    @endguest
                </nav>
                <div class="header__actions">
                    @auth()
                        <form action="/logout" method="post">
                            @csrf
                            <button class="btn view-toggle__btn--active" type="submit">Выйти</button>
                        </form>
                    @endauth
                    <a class="header__callback btn btn--light" href="#booking">Заказать звонок</a>
                </div>
            </div>
        </div>
    </header>

    <div class="mobile-menu-overlay" id="mobileMenuOverlay">
        <nav class="mobile-nav">
            <a class="mobile-link" href="/">Главная</a>
            <a class="mobile-link" href="{{ url('/') }}#view-3d">Выбрать квартиру</a>
            <a class="mobile-link" href="{{ url('/') }}#developer">О застройщике</a>
            <a class="mobile-link" href="/apartments">Каталог</a>

            @if (auth()->check() && auth()->user()->isAdmin())
                <a class="mobile-link" href="/admin/dashboard">Админ-панель</a>
            @endif
            @if (auth()->check() && auth()->user()->isRealtor())
                <a class="mobile-link" href="/dashboard">Админ-панель</a>
            @endif
            @guest
                <a class="mobile-link" href="/register">Регистрация</a>
            @endguest
        </nav>

        <div class="mobile-actions">
            @auth()
                <form action="/logout" method="post">
                    @csrf
                    <button class="btn view-toggle__btn--active" type="submit">Выйти</button>
                </form>
            @endauth
            <a class="header__callback btn btn--light" href="#booking">Заказать звонок</a>
        </div>
    </div>

    <main class="page__s">
        <section class="auth-section">
            <div class="auth-card">
                <h1 class="auth-title">Регистрация</h1>
                <form class="auth-form" action="{{ route('register.store') }}" method="POST">
                    @csrf
                    <div class="auth-field">
                        <input type="text" name="name" placeholder="Имя" value="{{ old('name') }}" required />
                        @error('name')
                            <span style="color:red">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="auth-field">
                        <input type="tel" name="phone" id="phone" placeholder="+7 (___) ___-__-__"
                            value="{{ old('phone') }}" required />
                        @error('phone')
                            <span style="color:red">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="auth-field">
                        <input type="email" name="email" placeholder="Email" value="{{ old('email') }}" required />
                        @error('email')
                            <span style="color:red">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="auth-field">
                        <input type="password" name="password" placeholder="Пароль" required />
                        @error('password')
                            <span style="color:red">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="auth-field">
                        <input type="password" name="password_confirmation" placeholder="Подтвердите пароль" required />
                    </div>
                    <div class="auth-options">
                        <label class="auth-checkbox">
                            <input type="checkbox" required /> Согласен с обработкой <a href="#"
                                class="auth-link"> персональных данных</a>
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
        <div class="site-footer__container">
            <div class="site-footer__top">

                <div class="site-footer__left-col">
                    <div class="site-footer__brand">
                        <p class="site-footer__logo"> <a class="header__logo" href="#"><img
                                    src="{{ asset('assets/img/logo.svg') }}" alt=""></a>
                        </p>
                        <div class="site-footer__contacts">
                            <div class="site-footer__contact">
                                <p class="site-footer__label">Электронная почта:</p>
                                <a class="site-footer__value" href="mailto:horizont@mail.ru">horizont@mail.ru</a>
                            </div>
                            <div class="site-footer__contact">
                                <p class="site-footer__label">Режим работы:</p>
                                <p class="footer__value" style="margin:0">ПН-ВС 8:00-20:00</p>
                            </div>
                        </div>
                    </div>

                    <nav class="site-footer__nav" aria-label="Нижнее меню">
                        <a class="site-footer__link" href="#apartment">Выбрать квартиру</a>
                        <a class="site-footer__link" href="#microdistrict">О проекте</a>
                        <a class="site-footer__link" href="#developer">О застройщике</a>
                    </nav>
                </div>

                <div class="site-footer__map-container">
                    <iframe src="https://yandex.ru/map-widget/v1/?ll=37.617698%2C55.755864&z=10"
                        class="site-footer__map-frame" allowfullscreen="true">
                    </iframe>
                </div>

            </div>

            <div class="site-footer__divider">
                <img src="{{ asset('assets/img/footer-line.svg') }}" alt="" aria-hidden="true"
                    width="1400" height="2">
            </div>
            <p class="site-footer__copy">©Все права защищены</p>
        </div>
    </footer>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const phoneInput = document.getElementById('phone');

            const formatPhone = (value) => {
                let digits = value.replace(/\D/g, '');

                if (digits.length > 0 && (digits[0] === '8' || digits[0] === '7')) {
                    digits = digits.substring(1);
                }

                digits = digits.substring(0, 10);

                let result = '+7';

                if (digits.length > 0) {
                    result += ' (' + digits.substring(0, 3);
                }
                if (digits.length >= 3) {
                    result += ') ' + digits.substring(3, 6);
                }
                if (digits.length >= 6) {
                    result += '-' + digits.substring(6, 8);
                }
                if (digits.length >= 8) {
                    result += '-' + digits.substring(8, 10);
                }

                return result;
            };

            phoneInput.addEventListener('focus', function() {
                if (this.value === '' || this.value === '+7') {
                    this.value = '+7 ';
                }
            });

            phoneInput.addEventListener('input', function(e) {
                const cursorPosition = this.selectionStart;
                const oldLength = this.value.length;

                this.value = formatPhone(this.value);

                const newLength = this.value.length;
                this.setSelectionRange(cursorPosition + (newLength - oldLength), cursorPosition + (
                    newLength - oldLength));
            });

            phoneInput.addEventListener('blur', function() {
                const digits = this.value.replace(/\D/g, '');
                if (digits.length < 11) {
                    this.value = '';
                }
            });

            phoneInput.addEventListener('keydown', function(e) {
                if ([8, 46, 9, 27, 13, 37, 38, 39, 40].includes(e.keyCode)) {
                    return;
                }
                if ((e.ctrlKey || e.metaKey) && [65, 67, 86, 88].includes(e.keyCode)) {
                    return;
                }
                if ((e.keyCode < 48 || e.keyCode > 57) && (e.keyCode < 96 || e.keyCode > 105)) {
                    e.preventDefault();
                }
            });
        });
    </script>
</body>

</html>
