<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Админ-панель — Горизонт</title>
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
    <link rel="shortcut icon" href="{{ asset('assets/img/fav.png') }}" type="image/x-icon">

</head>

<body class="page">
    <header class="hero__header header">
        <div class="header__inner">
            <a class="header__logo" href="#"><img src="{{ asset('assets/img/logo.svg') }}" alt=""></a>

            <button class="burger-btn" id="burgerBtn" aria-label="Меню">
                <span></span><span></span><span></span>
            </button>

            <div class="header__panel desktop-panel">
                <nav class="header__nav" aria-label="Основное меню" style="color: #1a1a1a">
                    <a class="header__link" href="/">Главная</a>
                    <a class="header__link" href="{{ url('/') }}#view-3d">Выбрать квартиру</a>
                    <a class="header__link" href="{{ url('/') }}#developer">О застройщике</a>
                    <a class="header__link" href="/apartments">Каталог</a>

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

    <main class="page__main">
        <div class="page__main" style="padding: 40px 0;">
            <div style="max-width: 1600px; margin: 0 auto; ">

                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px;">
                    <h1 style="font-family: var(--font-display); font-size: 32px; color: #1a1a1a; margin: 0;">Мои
                        клиенты</h1>

                </div>

                <div style="background: #fff; border-radius: 15px; box-shadow: var(--shadow-card); overflow: hidden;">
                    <div style="overflow-x: auto;">
                        <table style="width: 100%; border-collapse: collapse; text-align: left;">
                            <thead style="background: #f9f9f9;">
                                <tr>
                                    <th style="padding: 15px; font-weight: 500; ">Клиент</th>
                                    <th style="padding: 15px; font-weight: 500; ">Квартира</th>
                                    <th style="padding: 15px; font-weight: 500;">Желаемое время</th>
                                    <th style="padding: 15px; font-weight: 500; ">Комментарий</th>
                                    <th style="padding: 15px; font-weight: 500; ">Статус</th>
                                    <th style="padding: 15px; font-weight: 500; ">Действие</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($applications as $app)
                                    <tr style="border-bottom: 1px solid #eee;">
                                        <td style="padding: 15px;">
                                            @if ($app->user)
                                                <div style="font-weight: 600;">{{ $app->user->name }}</div>
                                                <a href="tel:{{ $app->user->phone }}"
                                                    style="font-size: 12px; color: var(--color-primary); text-decoration: none;">
                                                    {{ $app->user->phone ?? 'Нет телефона' }}
                                                </a>
                                            @else
                                                <div style="font-weight: 600;">{{ $app->name ?? 'Гость' }}</div>
                                                <div style="font-size: 12px; color: grey;">
                                                    {{ $app->phone ?? 'Нет телефона' }}</div>
                                            @endif
                                        </td>
                                        <td style="padding: 15px;">
                                            @if ($app->apartment)
                                                <div style="font-weight: 500;">{{ $app->apartment->title }}</div>
                                                <div style="font-size: 16px; color: grey;">
                                                    {{ number_format($app->apartment->price, 0, '', ' ') }}
                                                    ₽
                                                </div>
                                            @else
                                                <div style="font-weight: 500; color: #666;">Просмотр комплекса</div>
                                                <div style="font-size: 16px; color: grey;">Без привязки к квартире</div>
                                            @endif
                                        </td>
                                        <td style="padding: 15px; font-size: 16px;">
                                            {{ $app->viewing_date ? \Carbon\Carbon::parse($app->viewing_date)->format('d.m.Y H:i') : 'Не указано' }}
                                        </td>
                                        <td style="padding: 20px; max-width: 200px;">
                                            <div style="font-size: 16px; color: #4b5563; line-height: 1.4;">
                                                {{ Str::limit($app->comment, 60) ?: 'Без комментария' }}
                                            </div>
                                        </td>
                                        <td style="padding: 20px;">
                                            @php
                                                $statusMap = [
                                                    'pending' => 'Новая заявка',
                                                    'approved' => 'Заявка принята',
                                                    'viewing_scheduled' => 'На просмотре',
                                                    'closed' => 'Закрыта',
                                                ];
                                            @endphp
                                            <span
                                                style="color:
                                        @if ($app->status == 'pending') #dc2626
                                        @elseif($app->status == 'viewing_scheduled') #d97706
                                        @elseif($app->status == 'closed') #059669
                                        @else #2563eb @endif;">
                                                {{ $statusMap[$app->status] ?? $app->status }}
                                            </span>
                                        </td>
                                        <td style="padding: 15px;">
                                            <form action="{{ route('realtor.update-status', $app->id) }}"
                                                method="POST" style="display: flex; gap: 5px;">
                                                @csrf
                                                <select name="status"
                                                    style="padding: 5px; border-radius: 5px; border: 1px solid #ccc; font-size: 16px;">
                                                    <option value="pending"
                                                        {{ $app->status == 'pending' ? 'selected' : '' }}>
                                                        Новая
                                                    </option>
                                                    <option value="viewing_scheduled"
                                                        {{ $app->status == 'viewing_scheduled' ? 'selected' : '' }}>
                                                        Назначен просмотр
                                                    </option>
                                                    <option value="closed"
                                                        {{ $app->status == 'closed' ? 'selected' : '' }}>
                                                        Закрыта
                                                    </option>
                                                </select>
                                                <button type="submit" class="btn"
                                                    style="padding: 5px 10px; font-size: 16px; background: var(--color-primary); color: #fff;">
                                                    OK
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" style="padding: 40px; text-align: center; color: grey;">У
                                            вас
                                            пока нет
                                            активных заявок.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div style="padding: 20px;">
                        {{ $applications->links() }}
                    </div>
                </div>
            </div>
        </div>
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
</body>

</html>
