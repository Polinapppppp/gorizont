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

    <main class="page__s">
        <div class="page__main" style="padding: 40px 0;">
            <div class="container" style="max-width: 1400px; margin: 0 auto; padding: 0 20px;">

                <h1 style="font-family: var(--font-display); font-size: 32px; margin-bottom: 30px;">Панель
                    Администратора</h1>

                <div style="display: flex; gap: 20px; margin-bottom: 40px;">
                    <div
                        style="background: #fff; padding: 20px; border-radius: 15px; box-shadow: var(--shadow-card); flex: 1;">
                        <h3 style="margin: 0; color: grey; font-size: 15px; font-weight: 500;">Всего заявок</h3>
                        <p style="font-size: 24px; font-weight: bold; margin-top: 5px;">
                            {{ \App\Models\Application::count() }}</p>
                    </div>
                    <div
                        style="background: #fff; padding: 20px; border-radius: 15px; box-shadow: var(--shadow-card); flex: 1;">
                        <h3 style="margin: 0; color: grey; font-size: 15px; font-weight: 500;">Новых сегодня</h3>
                        <p style="font-size: 24px; font-weight: bold; margin-top: 5px;">
                            {{ \App\Models\Application::whereDate('created_at', today())->count() }}</p>
                    </div>
                    <div
                        style="background: #fff; padding: 20px; border-radius: 15px; box-shadow: var(--shadow-card); flex: 1;">
                        <h3 style="margin: 0; color: grey; font-size: 15px; font-weight: 500;">Всего квартир</h3>
                        <p style="font-size: 24px; font-weight: bold; margin-top: 5px;">
                            {{ \App\Models\Apartment::count() }}</p>
                    </div>
                </div>

                {{-- Таблица заявок --}}
                <div
                    style="background: #fff; border-radius: 15px; box-shadow: var(--shadow-card); overflow: hidden; margin-bottom: 40px;">
                    <div style="padding: 20px; border-bottom: 1px solid #eee;">
                        <h2 style="margin: 0; font-size: 20px; font-weight:500;">Заявки</h2>
                    </div>

                    <div style="overflow-x: auto;">
                        <table style="width: 100%; border-collapse: collapse; text-align: left;">
                            <thead style="background: #f9f9f9;">
                                <tr>
                                    <th style="padding: 15px; font-weight: 500; color: #555;">ID</th>
                                    <th style="padding: 15px; font-weight: 500; color: #555;">Клиент</th>
                                    <th style="padding: 15px; font-weight: 500; color: #555;">Квартира</th>
                                    <th style="padding: 15px; font-weight: 500; color: #555;">Риэлтор</th>
                                    <th style="padding: 15px; font-weight: 500; color: #555;">Статус</th>
                                    <th style="padding: 15px; font-weight: 500; color: #555;">Дата</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($applications as $app)
                                    <tr style="border-bottom: 1px solid #eee;">
                                        <td style="padding: 15px;">{{ $app->id }}</td>
                                        <td style="padding: 15px;">
                                            <div style="font-weight: 600;">{{ $app->user->name }}</div>
                                        </td>
                                        <td style="padding: 15px;">
                                            @if ($app->apartment)
                                                <a href="{{ route('apartments.show', $app->apartment->id) }}"
                                                    style="color: var(--color-primary); text-decoration: none;">
                                                    {{ $app->apartment->title }}
                                                </a>
                                            @else
                                                <span style="color: #999; font-size: 18px;">Просмотр комплекса</span>
                                            @endif
                                        </td>
                                        <td style="padding: 15px;">
                                            @if ($app->realtor)
                                                @php
                                                    $roleLabels = [
                                                        'realtor' => 'Риэлтор',
                                                        'admin' => 'Администратор',
                                                        'user' => 'Клиент',
                                                    ];
                                                    $role = $roleLabels[$app->realtor->role] ?? $app->realtor->role;
                                                @endphp
                                                <span style="font-size: 18px; padding-left: 20px;">
                                                    {{ $app->realtor_id }}
                                                </span>
                                            @else
                                                <span style="color: orange; font-size: 12px;">Не назначен</span>
                                            @endif
                                        </td>
                                        <td style="padding: 15px;">
                                            @php
                                                $statusLabels = [
                                                    'pending' => 'Ожидает',
                                                    'approved' => 'Подтверждена',
                                                    'viewing_scheduled' => 'Назначен просмотр',
                                                    'closed' => 'Закрыта',
                                                ];
                                                $statusColors = [
                                                    'pending' => ['text' => '#92400e'],
                                                    'approved' => ['text' => '#1e40af'],
                                                    'viewing_scheduled' => ['text' => '#065f46'],
                                                    'closed' => ['text' => '#374151'],
                                                ];
                                                $label = $statusLabels[$app->status] ?? $app->status;
                                                $color = $statusColors[$app->status] ?? [
                                                    'bg' => '#eee',
                                                    'text' => '#333',
                                                ];
                                            @endphp
                                            <span
                                                style="color: {{ $color['text'] }}; padding: 4px 8px; border-radius: 4px; font-size: 18px; ">
                                                {{ $label }}
                                            </span>
                                        </td>
                                        <td style="padding: 15px; font-size: 18px; color: #666;">
                                            {{ $app->created_at->format('d.m.Y H:i') }}
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" style="padding: 40px; text-align: center; color: grey;">
                                            Заявок пока
                                            нет.
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

                <div style="background: #fff; border-radius: 15px; box-shadow: var(--shadow-card); overflow: hidden;">
                    <div
                        style="padding: 20px; border-bottom: 1px solid #eee; display: flex; justify-content: space-between; align-items: center;">
                        <h2 style="margin: 0; font-size: 20px; font-weight:500;">Квартиры</h2>
                        <a href="/apartments/create" class="btn"
                            style="padding: 8px 16px; font-size: 14px; background: var(--color-primary); color: #fff; text-decoration: none; border-radius: 8px;">+
                            Добавить</a>
                    </div>

                    <div style="overflow-x: auto;">
                        <table style="width: 100%; border-collapse: collapse; text-align: left;">
                            <thead style="background: #f9f9f9;">
                                <tr>
                                    <th style="padding: 15px; font-weight: 500; color: #555;">ID</th>
                                    <th style="padding: 15px; font-weight: 500; color: #555;">Название</th>
                                    <th style="padding: 15px; font-weight: 500; color: #555;">Дом</th>
                                    <th style="padding: 15px; font-weight: 500; color: #555;">Этаж</th>
                                    <th style="padding: 15px; font-weight: 500; color: #555;">Зона</th>
                                    <th style="padding: 15px; font-weight: 500; color: #555;">Площадь</th>
                                    <th style="padding: 15px; font-weight: 500; color: #555;">Цена</th>
                                    <th style="padding: 15px; font-weight: 500; color: #555;">Статус</th>
                                    <th style="padding: 15px; font-weight: 500; color: #555;">Действия</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse(\App\Models\Apartment::latest()->get() as $apt)
                                    <tr style="border-bottom: 1px solid #eee;">
                                        <td style="padding: 15px;">{{ $apt->id }}</td>
                                        <td style="padding: 15px; font-weight: 600;">
                                            <a href="{{ route('apartments.show', $apt->id) }}"
                                                style="color: var(--color-primary); text-decoration: none;">
                                                {{ $apt->title }}
                                            </a>
                                        </td>
                                        <td style="padding: 15px;">Дом {{ $apt->building_id }}</td>
                                        <td style="padding: 15px;">{{ $apt->floor }}</td>
                                        <td style="padding: 15px;">{{ $apt->zone_number }}</td>
                                        <td style="padding: 15px;">{{ $apt->area }} м²</td>
                                        <td style="padding: 15px;">{{ number_format($apt->price, 0, '', ' ') }} ₽</td>
                                        <td style="padding: 15px;">
                                            @php
                                                $aptColors = [
                                                    'free' => ['text' => '#27ae60'],
                                                    'booked' => ['text' => '#f39c12'],
                                                    'sold' => ['text' => '#c0392b'],
                                                ];
                                                $aptColor = $aptColors[$apt->status] ?? [
                                                    'bg' => '#eee',
                                                    'text' => '#333',
                                                ];
                                            @endphp
                                            <span
                                                style="color: {{ $aptColor['text'] }}; padding: 4px 8px; border-radius: 4px; font-size: 18px;">
                                                {{ $apt->status == 'free' ? 'Свободна' : ($apt->status == 'booked' ? 'Забронирована' : 'Продана') }}
                                            </span>
                                        </td>
                                        <td style="padding: 15px;">
                                            <a href="{{ route('apartments.edit', $apt->id) }}" class="btn"
                                                style="padding: 5px 10px; font-size: 12px; background: #eee; text-decoration: none; margin-right: 5px;">✏️</a>
                                            <form action="{{ route('apartments.destroy', $apt->id) }}" method="POST"
                                                style="display:inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn"
                                                    style="padding: 5px 10px; font-size: 12px; background: #fee2e2; color: #c0392b; border: none; cursor: pointer;"
                                                    onclick="return confirm('Удалить?')">🗑️
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="9" style="padding: 40px; text-align: center; color: grey;">
                                            Квартир пока
                                            нет.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
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
