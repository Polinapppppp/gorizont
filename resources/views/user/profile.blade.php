<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Личный кабинет — Горизонт</title>
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
            @if (auth()->check() && !auth()->user()->isAdmin() && !auth()->user()->isRealtor())
                <a class="mobile-link" href="/profile">Личный кабинет</a>
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
        <div class="page__main user-section">
            <div class="user-container">

                <h1 class="user-title">Личный кабинет</h1>

                <div class="user-panel-card">
                    <div class="panel-header flex-between">
                        <h2 class="panel-title">Мои заявки</h2>

                        <form method="GET" action="{{ route('user.profile') }}"
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

                            <select name="sort" class="filter-select">
                                <option value="newest" {{ $sort == 'newest' ? 'selected' : '' }}>Сначала новые</option>
                                <option value="oldest" {{ $sort == 'oldest' ? 'selected' : '' }}>Сначала старые
                                </option>
                                <option value="viewing_asc" {{ $sort == 'viewing_asc' ? 'selected' : '' }}>Просмотр:
                                    ближайшие</option>
                                <option value="viewing_desc" {{ $sort == 'viewing_desc' ? 'selected' : '' }}>Просмотр:
                                    поздние</option>
                            </select>

                            <button type="submit" class="filter-btn">Применить</button>

                            @if (request('status') || request('sort') != 'newest')
                                <a href="{{ route('user.profile') }}" class="filter-reset">Сбросить</a>
                            @endif
                        </form>
                    </div>

                    <div class="table-wrapper">
                        <table class="data-table">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Квартира</th>
                                    <th>Цена</th>
                                    <th>Статус</th>
                                    <th>Запланировано на</th>
                                    <th>Риэлтор</th>
                                    <th>Комментарий</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($applications as $app)
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
                                    <tr>
                                        <td>{{ $app->id }}</td>
                                        <td>
                                            @if ($app->apartment)
                                                <a href="{{ route('apartments.show', $app->apartment->id) }}"
                                                    class="link-primary client-name">
                                                    {{ $app->apartment->title }}
                                                </a>
                                                <div class="text-muted">Дом {{ $app->apartment->building_id }}, этаж
                                                    {{ $app->apartment->floor }}</div>
                                            @else
                                                <span class="text-muted">Просмотр комплекса</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if ($app->apartment)
                                                <span
                                                    class="price-tag">{{ number_format($app->apartment->price, 0, '', ' ') }}
                                                    ₽</span>
                                            @else
                                                <span class="text-muted">—</span>
                                            @endif
                                        </td>
                                        <td>
                                            <span class="status-badge" style="color: {{ $color['text'] }}">
                                                {{ $label }}
                                            </span>
                                        </td>
                                        <td class="date-cell">
                                            @if ($app->viewing_date)
                                                {{ \Carbon\Carbon::parse($app->viewing_date)->format('d.m.Y H:i') }}
                                            @else
                                                <span class="no-viewing">Не назначена</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if ($app->realtor)
                                                <div class="realtor-info">

                                                    <div class="realtor-details">
                                                        <span class="realtor-name">{{ $app->realtor->name }}</span>
                                                        @if ($app->realtor->phone)
                                                            <a href="tel:{{ $app->realtor->phone }}"
                                                                class="realtor-phone">
                                                                {{ $app->realtor->phone }}
                                                            </a>
                                                        @endif

                                                    </div>
                                                </div>
                                            @else
                                                <span class="status-unassigned">Не назначен</span>
                                            @endif
                                        </td>
                                        <td>
                                            <div class="comment-text">
                                                {{ $app->comment ?: 'Без комментария' }}
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="empty-state">
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
