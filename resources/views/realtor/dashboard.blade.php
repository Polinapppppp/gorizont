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
    <div class="page__main admin-section">
        <div class="admin-container">

            <h1 class="admin-title">Мои клиенты</h1>

            <!-- Фильтры -->
            <div class="admin-panel-card">
                <div class="panel-header flex-between">
                    <h2 class="panel-title">Заявки</h2>

                    <form method="GET" action="{{ route('realtor.dashboard') }}"
                        style="display: flex; gap: 10px; align-items: center; flex-wrap: wrap;">

                        <select name="status" class="filter-select">
                            <option value="">Все статусы</option>
                            <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Новая заявка</option>
                            <option value="approved" {{ request('status') == 'approved' ? 'selected' : '' }}>Заявка принята</option>
                            <option value="viewing_scheduled" {{ request('status') == 'viewing_scheduled' ? 'selected' : '' }}>Назначен просмотр</option>
                            <option value="closed" {{ request('status') == 'closed' ? 'selected' : '' }}>Закрыта</option>
                        </select>

                        <select name="type" class="filter-select">
                            <option value="">Все типы</option>
                            <option value="with_apartment" {{ request('type') == 'with_apartment' ? 'selected' : '' }}>С квартирой</option>
                            <option value="complex_only" {{ request('type') == 'complex_only' ? 'selected' : '' }}>Просмотр комплекса</option>
                        </select>

                        <select name="sort" class="filter-select">
                            <option value="newest" {{ request('sort', 'newest') == 'newest' ? 'selected' : '' }}>Сначала новые</option>
                            <option value="oldest" {{ request('sort') == 'oldest' ? 'selected' : '' }}>Сначала старые</option>
                        </select>

                        <button type="submit" class="filter-btn">Применить</button>

                        @if (request('status') || request('type') || request('sort') != 'newest')
                            <a href="{{ route('realtor.dashboard') }}" class="filter-reset">Сбросить</a>
                        @endif
                    </form>
                </div>

                <div class="table-wrapper">
                    <table class="data-table">
                        <thead>
                            <tr>
                                <th>Клиент</th>
                                <th>Квартира</th>
                                <th>Желаемое время</th>
                                <th>Комментарий</th>
                                <th>Статус</th>
                                <th>Действие</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($applications as $app)
                                <tr>
                                    <td>
                                        @if ($app->user)
                                            <div class="client-name">{{ $app->user->name }}</div>
                                            <a href="tel:{{ $app->user->phone }}" class="link-primary" style="font-size: 12px;">
                                                {{ $app->user->phone ?? 'Нет телефона' }}
                                            </a>
                                        @else
                                            <div class="client-name">{{ $app->name ?? 'Гость' }}</div>
                                            <span style="font-size: 12px; color: grey;">{{ $app->phone ?? 'Нет телефона' }}</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if ($app->apartment)
                                            <div class="client-name">{{ $app->apartment->title }}</div>
                                            <span style="font-size: 14px; color: grey;">
                                                {{ number_format($app->apartment->price, 0, '', ' ') }} ₽
                                            </span>
                                        @else
                                            <div class="client-name" style="color: #666;">Просмотр комплекса</div>
                                            <span style="font-size: 14px; color: grey;">Без привязки к квартире</span>
                                        @endif
                                    </td>
                                    <td class="date-cell">
                                        {{ $app->viewing_date ? \Carbon\Carbon::parse($app->viewing_date)->format('d.m.Y H:i') : 'Не указано' }}
                                    </td>
                                    <td style="max-width: 200px;">
                                        <div style="font-size: 14px; color: #4b5563; line-height: 1.4;">
                                            {{ Str::limit($app->comment, 60) ?: 'Без комментария' }}
                                        </div>
                                    </td>
                                    <td>
                                        @php
                                            $statusMap = [
                                                'pending' => 'Новая заявка',
                                                'approved' => 'Заявка принята',
                                                'viewing_scheduled' => 'На просмотре',
                                                'closed' => 'Закрыта',
                                            ];
                                            $statusColors = [
                                                'pending' => '#dc2626',
                                                'approved' => '#2563eb',
                                                'viewing_scheduled' => '#d97706',
                                                'closed' => '#059669',
                                            ];
                                        @endphp
                                        <span class="status-badge" style="color: {{ $statusColors[$app->status] ?? '#333' }}">
                                            {{ $statusMap[$app->status] ?? $app->status }}
                                        </span>
                                    </td>
                                    <td>
                                        <form action="{{ route('realtor.update-status', $app->id) }}"
                                            method="POST" class="assign-form">
                                            @csrf
                                            <select name="status" class="assign-select" onchange="this.form.submit()">
                                                <option value="pending" {{ $app->status == 'pending' ? 'selected' : '' }}>Новая</option>
                                                <option value="viewing_scheduled" {{ $app->status == 'viewing_scheduled' ? 'selected' : '' }}>Назначен просмотр</option>
                                                <option value="closed" {{ $app->status == 'closed' ? 'selected' : '' }}>Закрыта</option>
                                            </select>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="empty-state">
                                        У вас пока нет активных заявок.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="pagination-wrapper">
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
