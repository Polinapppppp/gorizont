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

                <h1 class="admin-title">Панель Администратора</h1>

                <div class="admin-stats">
                    <div class="stat-card">
                        <h3 class="stat-label">Всего заявок</h3>
                        <p class="stat-value">{{ \App\Models\Application::count() }}</p>
                    </div>
                    <div class="stat-card">
                        <h3 class="stat-label">Новых сегодня</h3>
                        <p class="stat-value">{{ \App\Models\Application::whereDate('created_at', today())->count() }}
                        </p>
                    </div>
                    <div class="stat-card">
                        <h3 class="stat-label">Всего квартир</h3>
                        <p class="stat-value">{{ \App\Models\Apartment::count() }}</p>
                    </div>
                </div>

                <div class="admin-panel-card">
                    <div class="panel-header flex-between">
                        <h2 class="panel-title">Заявки</h2>

                        <form method="GET" action="{{ route('admin.dashboard') }}"
                            style="display: flex; gap: 10px; align-items: center;">
                            <select name="status" class="filter-select">
                                <option value="">Все статусы</option>
                                <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Ожидает
                                </option>
                                <option value="approved" {{ request('status') == 'approved' ? 'selected' : '' }}>
                                    Подтверждена</option>
                                <option value="viewing_scheduled"
                                    {{ request('status') == 'viewing_scheduled' ? 'selected' : '' }}>Назначен просмотр
                                </option>
                                <option value="closed" {{ request('status') == 'closed' ? 'selected' : '' }}>Закрыта
                                </option>
                            </select>

                            <select name="realtor_id" class="filter-select">
                                <option value="">Все риэлторы</option>
                                @foreach ($realtors as $realtor)
                                    <option value="{{ $realtor->id }}"
                                        {{ request('realtor_id') == $realtor->id ? 'selected' : '' }}>
                                        {{ $realtor->name }}
                                    </option>
                                @endforeach
                            </select>


                            <select name="sort" class="filter-select">
                                <option value="newest" {{ request('sort', 'newest') == 'newest' ? 'selected' : '' }}>
                                    Сначала новые</option>
                                <option value="oldest" {{ request('sort') == 'oldest' ? 'selected' : '' }}>Сначала
                                    старые</option>
                            </select>

                            <button type="submit" class="filter-btn">Применить</button>

                            @if (request('status') ||
                                    request('realtor_id') ||
                                    request('date_from') ||
                                    request('date_to') ||
                                    request('sort') != 'newest')
                                <a href="{{ route('admin.dashboard') }}" class="filter-reset">Сбросить</a>
                            @endif
                        </form>
                    </div>

                    <div class="table-wrapper">
                        <table class="data-table">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Клиент</th>
                                    <th>Квартира</th>
                                    <th>Риэлтор</th>
                                    <th>Статус</th>
                                    <th>Дата</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($applications as $app)
                                    <tr>
                                        <td>{{ $app->id }}</td>
                                        <td>
                                            <div class="client-name">{{ $app->user->name }}</div>
                                        </td>
                                        <td>
                                            @if ($app->apartment)
                                                <a href="{{ route('apartments.show', $app->apartment->id) }}"
                                                    class="link-primary">
                                                    {{ $app->apartment->title }}
                                                </a>
                                            @else
                                                <span class="text-muted">Просмотр комплекса</span>
                                            @endif
                                        </td>
                                        <td>
                                            <form action="{{ route('admin.assign-realtor', $app->id) }}"
                                                method="POST" class="assign-form">
                                                @csrf
                                                <select name="realtor_id" class="assign-select"
                                                    onchange="this.form.submit()">
                                                    <option value="">Не назначен</option>
                                                    @foreach ($realtors as $realtor)
                                                        <option value="{{ $realtor->id }}"
                                                            {{ $app->realtor_id == $realtor->id ? 'selected' : '' }}>
                                                            {{ $realtor->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </form>
                                        </td>
                                        <td>
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
                                                $color = $statusColors[$app->status] ?? ['text' => '#333'];
                                            @endphp
                                            <span class="status-badge" style="color: {{ $color['text'] }}">
                                                {{ $label }}
                                            </span>
                                        </td>
                                        <td class="date-cell">
                                            {{ $app->created_at->format('d.m.Y H:i') }}
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="empty-state">
                                            Заявок не найдено.
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

                <div class="admin-panel-card">
                    <div class="panel-header flex-between">
                        <h2 class="panel-title">Квартиры</h2>
                        <a href="/apartments/create" class="btn-add">+ Добавить</a>
                    </div>

                    <div class="table-wrapper">
                        <table class="data-table">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Название</th>
                                    <th>Дом</th>
                                    <th>Этаж</th>
                                    <th>Зона</th>
                                    <th>Площадь</th>
                                    <th>Цена</th>
                                    <th>Статус</th>
                                    <th>Действия</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse(\App\Models\Apartment::latest()->get() as $apt)
                                    <tr>
                                        <td>{{ $apt->id }}</td>
                                        <td class="client-name">
                                            <a href="{{ route('apartments.show', $apt->id) }}" class="link-primary">
                                                {{ $apt->title }}
                                            </a>
                                        </td>
                                        <td>Дом {{ $apt->building_id }}</td>
                                        <td>{{ $apt->floor }}</td>
                                        <td>{{ $apt->zone_number }}</td>
                                        <td>{{ $apt->area }} м²</td>
                                        <td>{{ number_format($apt->price, 0, '', ' ') }} ₽</td>
                                        <td>
                                            @php
                                                $aptColors = [
                                                    'free' => ['text' => '#27ae60'],
                                                    'booked' => ['text' => '#f39c12'],
                                                    'sold' => ['text' => '#c0392b'],
                                                ];
                                                $aptColor = $aptColors[$apt->status] ?? ['text' => '#333'];
                                            @endphp
                                            <span class="status-badge" style="color: {{ $aptColor['text'] }}">
                                                {{ $apt->status == 'free' ? 'Свободна' : ($apt->status == 'booked' ? 'Забронирована' : 'Продана') }}
                                            </span>
                                        </td>
                                        <td>
                                            <a href="{{ route('apartments.edit', $apt->id) }}"
                                                class="action-btn btn-edit">Ред.</a>
                                            <form action="{{ route('apartments.destroy', $apt->id) }}" method="POST"
                                                style="display:inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="action-btn btn-delete"
                                                    onclick="return confirm('Удалить?')">Удал.</button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="9" class="empty-state">
                                            Квартир пока нет.
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
                        <p class="site-footer__logo">
                            <a class="header__logo" href="#"><img src="{{ asset('assets/img/logo.svg') }}"
                                    alt=""></a>
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
