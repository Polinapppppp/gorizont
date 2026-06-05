<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Горизонт — каталог</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700&family=Unbounded:wght@400;500;600;700&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/noUiSlider/15.7.0/nouislider.min.css">
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
    <link rel="shortcut icon" href="{{ asset('assets/img/fav.png') }}" type="image/x-icon">

    <style>
        /* Pill Buttons (Rooms Filter) */
        .pill-group {
            display: flex;
            gap: 10px;
        }

        .pill {
            min-width: 64px;
            padding: 12px 24px;
            border-radius: 12px;
            border: 2px solid #e5e7eb;
            background: #fff;
            color: #888;
            font-size: 16px;
            font-weight: 600;
            font-family: 'Montserrat', sans-serif;
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .pill:hover {
            border-color: var(--color-primary);
            color: var(--color-primary);
        }

        .pill--active {
            background: var(--color-primary);
            border-color: var(--color-primary);
            color: #fff;
        }

        .pill--active:hover {
            background: #1a2d3d;
            border-color: #1a2d3d;
            color: #fff;
        }

        /* Catalog Page Specific Styles */
        .catalog__head {
            margin-bottom: 30px;
        }

        .btn-add-apartment {
            background: var(--color-primary);
            color: #fff;
            margin-bottom: 20px;
            display: inline-block;
        }

        .success-message {
            background: #d4edda;
            color: #155724;
            padding: 15px;
            border-radius: 10px;
            margin-bottom: 20px;
            text-align: center;
        }

        .catalog-filters-container {
            padding: 30px;
            background: #fff;
            border-radius: var(--radius-lg);
            box-shadow: var(--shadow-card);
            margin-bottom: 40px;
        }

        .filters-row-top {
            display: flex;
            flex-wrap: wrap;
            gap: 40px;
            align-items: flex-start;
            margin-bottom: 30px;
        }

        .filter-item-rooms {
            flex: 1 1 200px;
        }

        .filter-item-price {
            flex: 2 1 300px;
        }

        .filter-item-area {
            flex: 2 1 300px;
        }

        .filter-item-floor {
            flex: 1 1 200px;
        }

        .slider-container {
            margin: 15px 0 10px 0;
        }

        .slider-values {
            display: flex;
            justify-content: space-between;
            font-weight: 500;
            font-size: 16px;
        }

        .filters-row-bottom {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            align-items: center;
            justify-content: space-between;
        }

        .sort-select-wrapper {
            flex: 0 0 auto;
        }

        .sort-select {
            border-radius: 15px;
            border: 1px solid #ccc;
        }

        .filters-actions {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            align-items: center;
        }

        .btn-submit-filter {
            background: var(--color-primary);
            color: #fff;
            padding: 14px 40px;
            border-radius: 15px;
        }

        /* Card Specifics */
        .card-meta-info {
            display: flex;
            justify-content: space-between;
            margin-top: 10px;
            color: var(--color-text-muted);
            font-size: 14px;
        }

        .card-action-btn {
            margin-top: 20px;
        }

        .pagination-wrapper {
            margin-top: 40px;
            display: flex;
            justify-content: center;
        }

        .no-results {
            grid-column: 1 / -1;
            text-align: center;
            color: grey;
        }
    </style>
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

    <section class="page__main catalog">
        <div class="catalog__head">
            <h1 class="catalog__title">Выбрать квартиру</h1>
            @if (auth()->check() && auth()->user()->role_id == 2)
                <a href="{{ route('apartments.create') }}" class="btn btn-add-apartment">
                    + Добавить планировку
                </a>
            @endif
        </div>

        @if (session('success'))
            <div class="success-message">
                {{ session('success') }}
            </div>
        @endif

        <div class="catalog-filters-container">
            <form action="{{ route('apartments.index') }}" method="GET" id="filter-form">

                <div class="filters-row-top">

                    <div class="filter-item-rooms">
                        <label class="catalog-filter__label">Комнат</label>
                        <div class="pill-group">
                            <button type="button" class="pill {{ request('rooms') == 1 ? 'pill--active' : '' }}"
                                onclick="setRoomFilter(1)">1</button>
                            <button type="button" class="pill {{ request('rooms') == 2 ? 'pill--active' : '' }}"
                                onclick="setRoomFilter(2)">2</button>
                            <button type="button" class="pill {{ request('rooms') == 3 ? 'pill--active' : '' }}"
                                onclick="setRoomFilter(3)">3</button>
                        </div>
                        <input type="hidden" name="rooms" id="rooms-input" value="{{ request('rooms') }}">
                    </div>

                    <div class="filter-item-price">
                        <label class="catalog-filter__label">Стоимость, ₽</label>
                        <div id="slider-price" class="slider-container"></div>
                        <div class="slider-values">
                            <span>от <span
                                    id="val-price-min">{{ number_format(request('price_min', 5000000), 0, '', ' ') }}</span></span>
                            <span>до <span
                                    id="val-price-max">{{ number_format(request('price_max', 40000000), 0, '', ' ') }}</span></span>
                        </div>
                        <input type="hidden" name="price_min" id="input-price-min"
                            value="{{ request('price_min', 5000000) }}">
                        <input type="hidden" name="price_max" id="input-price-max"
                            value="{{ request('price_max', 40000000) }}">
                    </div>

                    <div class="filter-item-area">
                        <label class="catalog-filter__label">Площадь, м²</label>
                        <div id="slider-area" class="slider-container"></div>
                        <div class="slider-values">
                            <span>от <span id="val-area-min">{{ request('area_min', 20) }}</span> м²</span>
                            <span>до <span id="val-area-max">{{ request('area_max', 100) }}</span> м²</span>
                        </div>
                        <input type="hidden" name="area_min" id="input-area-min"
                            value="{{ request('area_min', 20) }}">
                        <input type="hidden" name="area_max" id="input-area-max"
                            value="{{ request('area_max', 100) }}">
                    </div>

                    <div class="filter-item-floor">
                        <label class="catalog-filter__label">Этаж</label>
                        <div id="slider-floor" class="slider-container"></div>
                        <div class="slider-values">
                            <span>от <span id="val-floor-min">{{ request('floor_min', 1) }}</span></span>
                            <span>до <span id="val-floor-max">{{ request('floor_max', 7) }}</span></span>
                        </div>
                        <input type="hidden" name="floor_min" id="input-floor-min"
                            value="{{ request('floor_min', 1) }}">
                        <input type="hidden" name="floor_max" id="input-floor-max"
                            value="{{ request('floor_max', 7) }}">
                    </div>
                </div>

                <div class="filters-row-bottom">
                    <div class="sort-select-wrapper">
                        <div class="select sort-select">
                            <select name="sort" class="select__native"
                                onchange="document.getElementById('filter-form').submit()">
                                <option value="default" {{ request('sort') == 'default' ? 'selected' : '' }}>По
                                    умолчанию</option>
                                <option value="price_asc" {{ request('sort') == 'price_asc' ? 'selected' : '' }}>
                                    Сначала дешевле</option>
                                <option value="price_desc" {{ request('sort') == 'price_desc' ? 'selected' : '' }}>
                                    Сначала дороже</option>
                            </select>
                            <svg width="12" height="8" viewBox="0 0 12 8" fill="none">
                                <path d="M1 1L6 6L11 1" stroke="#1E1E1E" stroke-opacity="0.7" stroke-width="2" />
                            </svg>
                        </div>
                    </div>

                    <div class="filters-actions">
                        <a href="/apartments" class="btn btn--light">Сбросить фильтры</a>
                        <button type="submit" class="btn btn-submit-filter">Показать
                            квартиры</button>
                    </div>
                </div>
            </form>
        </div>

        <div class="catalog__grid">
            @forelse($apartments as $apartment)
                <article class="catalog-card">
                    <a href="{{ route('apartments.show', $apartment->id) }}">
                        <div class="catalog-card__media">
                            <img src="{{ asset('storage/' . $apartment->image) }}" alt="{{ $apartment->title }}"
                                class="catalog-card__img">
                        </div>
                    </a>

                    <div class="catalog-card__body">
                        <h3 class="catalog-card__title">{{ $apartment->title }}</h3>

                        <div class="card-meta-info">
                            <span>{{ $apartment->area }} м²</span>
                            <span>{{ $apartment->rooms }} комн.</span>
                        </div>

                        <div class="card-price"
                            style="margin-top: 15px; font-family: 'Unbounded', sans-serif; font-size: clamp(18px, 2vw, 24px); font-weight: 400; color: var(--color-primary);">
                            @if ($apartment->price)
                                {{ number_format($apartment->price, 0, ' ', ' ') }} ₽
                            @else
                                Цена по запросу
                            @endif
                        </div>

                        <div class="card-action-btn">
                            <a href="{{ route('apartments.show', $apartment->id) }}" class="btn btn--block"
                                style="background: var(--color-primary); color: #fff;">
                                Подробнее
                            </a>
                        </div>
                    </div>
                </article>
            @empty
                <p class="no-results">Квартиры не найдены. Попробуйте изменить фильтры.</p>
            @endforelse
        </div>

        <div class="pagination-wrapper">
            {{ $apartments->links('vendor.simple') }}
        </div>
    </section>
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

    <script src="https://cdnjs.cloudflare.com/ajax/libs/noUiSlider/15.7.0/nouislider.min.js"></script>
    <script>
        function setRoomFilter(rooms) {
            const input = document.getElementById('rooms-input');
            const currentValue = input.value;

            if (currentValue == rooms) {
                input.value = '';
            } else {
                input.value = rooms;
            }

            const buttons = document.querySelectorAll('.pill-group .pill');
            buttons.forEach(btn => {
                btn.classList.remove('pill--active');
                if (btn.textContent.trim() === input.value) {
                    btn.classList.add('pill--active');
                }
            });

            document.getElementById('filter-form').submit();
        }

        function initSlider(sliderId, minValId, maxValId, inputMinId, inputMaxId, min, max, startMin, startMax, isPrice =
            false) {
            const slider = document.getElementById(sliderId);
            const valMin = document.getElementById(minValId);
            const valMax = document.getElementById(maxValId);
            const inputMin = document.getElementById(inputMinId);
            const inputMax = document.getElementById(inputMaxId);

            noUiSlider.create(slider, {
                start: [startMin, startMax],
                connect: true,
                range: {
                    'min': min,
                    'max': max
                },
                step: 1,
                format: {
                    to: function(value) {
                        return Math.round(value);
                    },
                    from: function(value) {
                        return Number(value);
                    }
                }
            });

            slider.noUiSlider.on('update', function(values, handle) {
                const v1 = Math.round(values[0]);
                const v2 = Math.round(values[1]);

                if (handle === 0) {
                    valMin.innerText = isPrice ? new Intl.NumberFormat('ru-RU').format(v1) : v1;
                    inputMin.value = v1;
                } else {
                    valMax.innerText = isPrice ? new Intl.NumberFormat('ru-RU').format(v2) : v2;
                    inputMax.value = v2;
                }
            });
        }

        document.addEventListener('DOMContentLoaded', function() {
            const urlParams = new URLSearchParams(window.location.search);

            initSlider('slider-price', 'val-price-min', 'val-price-max', 'input-price-min', 'input-price-max',
                5000000, 40000000,
                parseInt(urlParams.get('price_min')) || 5000000,
                parseInt(urlParams.get('price_max')) || 40000000,
                true
            );

            initSlider('slider-area', 'val-area-min', 'val-area-max', 'input-area-min', 'input-area-max',
                20, 100,
                parseInt(urlParams.get('area_min')) || 20,
                parseInt(urlParams.get('area_max')) || 100
            );

            initSlider('slider-floor', 'val-floor-min', 'val-floor-max', 'input-floor-min', 'input-floor-max',
                1, 7,
                parseInt(urlParams.get('floor_min')) || 1,
                parseInt(urlParams.get('floor_max')) || 7
            );
        });
    </script>
</body>

</html>
