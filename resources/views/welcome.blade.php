<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Горизонт — Главная</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700&family=Unbounded:wght@400;500;600;700&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/style2.css') }}">
    <link rel="apple-touch-icon" href="../assets/img/fav.png">
    <script src="{{ asset('assets/js/script.js') }}" defer></script>
</head>

<body class="page">
    <section class="hero">
        <div class="hero__bg">
            <img class="hero__bg-img" src="assets/img/hero-bg.png" alt="" width="1514" height="750"
                decoding="async">
        </div>
        <header class="hero__header header">
            <div class="header__inner">
                <a class="header__logo" href="#"><img src="{{ asset('assets/img/logo.svg') }}" alt=""></a>

                <button class="burger-btn" id="burgerBtn" aria-label="Меню">
                    <span></span><span></span><span></span>
                </button>

                <div class="header__panel desktop-panel">
                    <nav class="header__nav" aria-label="Основное меню">
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
        <div class="hero__content">
            <div class="hero__text-block">
                <p class="hero__lead">
                    Просторные квартиры в современном жилом комплексе с продуманной инфраструктурой и парковыми зонами.
                    Ваш
                    комфорт — наш приоритет.
                </p>
                <h1 class="hero__title">Горизонт - жизнь на новом уровне</h1>
                <a class="hero__cta hero__cta--mobile" href="#layout-tour">
                    <span class="hero__cta-text">Смотреть 3D тур</span>
                    <span class="hero__cta-icon" aria-hidden="true">
                        <img src="assets/img/icon-arrow.svg" alt="" width="10" height="11">
                    </span>
                </a>
            </div>
            <aside class="hero__tour tour-card">
                <div class="tour-card__media">
                    <img class="tour-card__img" src="assets/img/tour-thumb.png" alt="Превью онлайн-тура" width="266"
                        height="177" decoding="async">
                </div>
                <p class="tour-card__title">Интерактивная карта проекта</p>
                <a class="tour-card__btn" href="#view-3d">
                    <span class="tour-card__btn-text">Открыть карту</span>
                    <span class="tour-card__btn-icon" aria-hidden="true">
                        <img src="assets/img/icon-arrow.svg" alt="" width="12" height="15">
                    </span>
                </a>
            </aside>
        </div>
    </section>

    <main class="page__main">
        <section class="microdistrict" id="microdistrict">
            <div class="microdistrict__intro">
                <h2 class="microdistrict__title">Микрорайон, где хочется жить</h2>
                <p class="microdistrict__text">
                    Мы создали не просто дома, а полноценный микрорайон для жизни в гармонии. ЖК «Горизонт» — это
                    современная
                    архитектура, качественные материалы, безопасная территория и все необходимое для комфортной жизни в
                    шаговой
                    доступности
                </p>
            </div>
            <div class="microdistrict__grid">
                <article class="microdistrict-card microdistrict-card--large">
                    <img class="microdistrict-card__bg" src="assets/img/neighborhood-location.png" alt=""
                        decoding="async">
                    <div class="microdistrict-card__content">
                        <h3 class="microdistrict-card__title">Идеальное расположение</h3>
                        <p class="microdistrict-card__desc">В 10 минутах от центра и основных транспортных развязок.
                        </p>
                    </div>
                </article>
                <div class="microdistrict__column">
                    <div class="microdistrict__row">
                        <article class="microdistrict-card microdistrict-card--photo">
                            <img class="microdistrict-card__bg" src="assets/img/neighborhood-developer.png"
                                alt="" decoding="async">
                            <h3 class="microdistrict-card__title microdistrict-card__title--overlay">Надежный
                                застройщик</h3>
                        </article>
                        <article class="microdistrict-card microdistrict-card--solid">
                            <h3 class="microdistrict-card__title">Умные технологии</h3>
                            <p class="microdistrict-card__desc">Система видеонаблюдения, умная система безопасности</p>
                        </article>
                    </div>
                    <div class="microdistrict__row">
                        <article class="microdistrict-card microdistrict-card--solid">
                            <h3 class="microdistrict-card__title">Гибкие условия оплаты</h3>
                            <p class="microdistrict-card__desc">Ипотека от ведущих банков, рассрочка, материнский
                                капитал.</p>
                        </article>
                        <article class="microdistrict-card microdistrict-card--photo">
                            <img class="microdistrict-card__bg" src="assets/img/neighborhood-eco.png" alt=""
                                decoding="async">
                            <h3 class="microdistrict-card__title microdistrict-card__title--overlay">Экологичная среда
                            </h3>
                        </article>
                    </div>
                </div>
            </div>
        </section>

        <section class="developer" id="developer">
            <h2 class="developer__heading">О застройщике</h2>
            <div class="developer__layout">
                <div class="developer__cards">
                    <article class="developer-card">
                        <h3 class="developer-card__title">14 лет на рынке</h3>
                        <p class="developer-card__text">
                            С 2012 года мы создаём жилые комплексы, в которых сочетаются современная архитектура,
                            надёжные
                            технологии
                            и продуманная инфраструктура. За это время ни один проект не стал долгостроем — все дома
                            сданы в
                            срок и с
                            полным соблюдением обязательств.
                        </p>
                    </article>
                    <article class="developer-card">
                        <h3 class="developer-card__title">20 жилых комплексов</h3>
                        <p class="developer-card__text">
                            Мы завершили строительство более чем 18 жилых комплексов в Казани и Набережных Челнах.
                            Каждый из
                            них — это
                            не просто здание, а полноценная среда для жизни: с озеленёнными дворами, безопасными зонами
                            для
                            детей и
                            качественной отделкой «под ключ».
                        </p>
                    </article>
                    <article class="developer-card">
                        <h3 class="developer-card__title">Работаем по 214-ФЗ</h3>
                        <p class="developer-card__text">
                            Все договоры заключаются в соответствии с Федеральным законом №214-ФЗ через эскроу-счета.
                            Ваши
                            средства
                            находятся в защищённом банковском счёте и разблокируются только после государственной
                            приёмки
                            дома.
                        </p>
                    </article>
                </div>
                <div class="developer__photo-wrap">
                    <img class="developer__photo" src="assets/img/developer-photo.png" alt="Двор жилого комплекса"
                        width="728" height="761" decoding="async">
                </div>
            </div>
        </section>

        <section class="apartment-picker" id="apartment">

            <div class="apartment-picker__head">
                <h2 class="apartment-picker__title" id="mainTitle">Выбрать квартиру</h2>
                <div class="view-toggle" id="viewToggle">
                    <button class="view-toggle__btn view-toggle__btn--active" id="btn-3d"
                        onclick="show3D()">3D</button>
                    <button class="view-toggle__btn" id="btn-list" onclick="showList()">Списком</button>
                </div>
            </div>

            <div class="apartment-picker__view" id="view-3d">
                <div class="apartment-picker__stage">
                    <img class="apartment-picker__render" src="assets/img/apartment-3d.png" alt="Генплан">

                    <svg class="house-svg house-svg--1" viewBox="0 0 520 514" preserveAspectRatio="xMidYMid meet">
                        <a href="#" class="house-link" onclick="showFloors(1); return false;">
                            <path class="house-shape"
                                d="M38.3689 295.318L0 116.52L105.515 80.861L151.961 116.52L145.398 91.4081L114.097 60.2691L140.35 51.7309V36.6637L305.942 0L486.175 68.8072V80.861L520 91.4081L486.175 106.475L493.748 121.543L520 140.126V226.511L493.748 259.659L480.117 295.318L472.544 335.498L193.359 448L38.3689 295.318Z" />
                            <path class="house-shape" d="M47 334.5L41 295L196 446.5L193 458L165 474L47 334.5Z" />
                            <path class="house-shape"
                                d="M232.439 464.277L199 446.336L473.002 331L474 340.227L462.022 347.403L457.53 345.866L456.033 358.168L440.561 369.958L436.069 397.639L434.073 419.681L436.069 431.983L411.613 446.849L397.14 424.294L385.162 405.328L374.681 407.378L369.191 421.731L356.713 434.034L361.205 440.697L348.728 454.025L330.76 443.773L316.786 440.697L303.31 461.714L305.307 495.546L261.886 514L248.909 477.605L232.439 464.277Z" />
                        </a>
                    </svg>

                    <svg class="house-svg house-svg--2" viewBox="0 0 484 489" preserveAspectRatio="xMidYMid meet">
                        <a href="#" class="house-link" onclick="showFloors(2); return false;">
                            <path class="house-shape"
                                d="M66 23.5L20.5 33.5L32 42V72.5L8 74V77.5L18.5 83.5L19.5 112.5L16.5 114.5V117L19.5 121L18.5 147.5H12L9.5 150L19.5 156.5L18.5 183L0 177.5L18.5 193V219.5L16.5 222L21 226V230L22.5 261L16.5 279.5L32 300L27.5 279.5L32 277L37 276L42 281L46.5 278.5L49.5 281L45.5 284.5L51.5 285.5L54 284.5L58 287L55.5 292.5L61 295.5L63.5 282.5L65.5 284.5L66.5 310.5L71.5 314.5L75 326.5L78 323.5C79.8721 323.222 80.5888 323.752 81 326.5L82 340C84.9281 342.576 86.4807 344.233 88.5 349V355C94.8527 357.594 97.2286 359.88 100 365L94 372.5V376H104.5L114.5 382C119.678 377.561 122.984 375.51 129.5 372.5L140 366C147.791 365.396 150.645 366.737 154.5 370.5L165 384.5V400H171L180 405.5C181.923 407.776 182.985 409.185 184.5 415C183.301 419.174 182.35 420.892 180 422.5L181 434.5L191 440V455.5L225.5 483L240 489V487L260.5 472.5L254 461V444V422.5C251.124 418.333 250.116 414.306 250.5 401C254.628 397.506 257.335 396.493 262.5 395.5C265.612 392.823 267.823 391.66 273 390.5L270.5 385.5L265 377L273 362L285.5 346.5L286.5 339L290 335L299 327.5L310.5 318.5L321.5 312.5L329 310H338.5L349 317.5L355 323.5L360.5 327.5V338L366.5 355.5C367.906 364.599 367.975 368.096 367.5 373L376.5 384.5C379.4 389.94 381.629 388.554 387 376L391 363C391 363 390.14 361.961 393.5 357.5C396.86 353.039 399.66 352.994 404.5 352.5L405.5 338C410.289 332.667 412.911 330.781 417.5 329C420.561 324.493 422.484 321.973 427.5 317.5L433 302.5L434 290.5H440L455 297L459 278L464 249L471 241L474.5 225L453.5 227.5L454.5 215.5L474.5 207L484 199.5L472 191V169.5L475.5 167.5L474.5 162.5L353.5 118H352L354.5 92.5L376.5 86V83L356.5 75.5L359 53L204 0L66 23.5Z" />
                        </a>
                    </svg>

                    <span class="apartment-picker__label apartment-picker__label--1">Дом 1</span>
                    <span class="apartment-picker__label apartment-picker__label--2">Дом 2</span>
                </div>
            </div>

            <div class="apartment-picker__view" id="view-floor" style="display:none;">
                <div class="apartment-picker__card">

                    <div class="apartment-picker__info-panel">
                        <button class="btn btn--light info-panel-back-btn" onclick="backTo3D()">← Назад
                        </button>
                        <p class="apartment-picker__stats-title">Всего квартир: <span id="floorTotal">5</span></p>
                        <ul class="apartment-picker__stats-list">
                            <li>Свободно: <span id="floorFree">3</span></li>
                            <li>Продано: <span id="floorSold">1</span></li>
                            <li>Забронировано: <span id="floorBooked">1</span></li>
                        </ul>
                        <div class="select apartment-picker__floor-select">
                            <select class="select__native" id="floorSelect" onchange="changeFloor(this.value)">
                                <option value="1" selected>Этаж 1</option>
                                <option value="2">Этаж 2</option>
                                <option value="3">Этаж 3</option>
                                <option value="4">Этаж 4</option>
                                <option value="5">Этаж 5</option>
                                <option value="6">Этаж 6</option>
                                <option value="7">Этаж 7</option>
                            </select>
                            <svg width="12" height="8" viewBox="0 0 12 8">
                                <path d="M1 1L6 6L11 1" stroke="#1E1E1E" stroke-opacity="0.7" stroke-width="2" />
                            </svg>
                        </div>
                        <button class="btn apartment-picker__cta-btn" onclick="openModal()">Оставить заявку</button>
                    </div>

                    <div class="floor-plan">
                        <img src="{{ asset('assets/img/card.png') }}" alt="План этажа" class="floor-plan__img"
                            id="floorImage">

                        <svg class="apt apt--1" viewBox="0 0 212 212" preserveAspectRatio="none">
                            <a href="#" class="apt-link" id="apt--1" data-status="free"
                                onclick="showApartmentCard(1); return false;">
                                <path class="apt-shape" d="M3 212V67H71.3365V0H212V212H3Z" />
                            </a>
                        </svg>

                        <svg class="apt apt--2" viewBox="0 0 343 145" preserveAspectRatio="none">
                            <a href="#" class="apt-link" id="apt--2" data-status="sold"
                                onclick="showApartmentCard(2); return false;">
                                <path class="apt-shape" d="M0 144.5V4.5V0H343V144.5H0Z" />
                            </a>
                        </svg>

                        <svg class="apt apt--3" viewBox="0 0 148 280" preserveAspectRatio="none">
                            <a href="#" class="apt-link" id="apt--3" data-status="booked"
                                onclick="showApartmentCard(3); return false;">
                                <path class="apt-shape" d="M0 280V0H147.5V280H0Z" />
                            </a>
                        </svg>

                        <svg class="apt apt--4" viewBox="0 0 268 184" preserveAspectRatio="none">
                            <a href="#" class="apt-link" id="apt--4" data-status="free"
                                onclick="showApartmentCard(4); return false;">
                                <path class="apt-shape" d="M0 184V2.5L267.5 0L265 184H0Z" />
                            </a>
                        </svg>

                        <svg class="apt apt--5" viewBox="0 0 149 205" preserveAspectRatio="none">
                            <a href="#" class="apt-link" id="apt--5" data-status="free"
                                onclick="showApartmentCard(5); return false;">
                                <path class="apt-shape" d="M144 0H35.5V130.5H0V205H35.5V200.5H148.5L144 0Z" />
                            </a>
                        </svg>
                    </div>
                </div>
            </div>

            <div class="apartment-picker__view" id="view-list" style="display:none;">
                <div class="apartment-picker__card apartments-list-wrapper">
                    <div class="apartments-list-controls">
                        <div class="back-btn-wrapper">
                            <button class="btn btn--light" onclick="backTo3D()">← Назад</button>
                        </div>
                        <div class="select floor-select-wrapper">
                            <select class="select__native" id="listFloorSelect"
                                onchange="changeListFloor(this.value)">
                                <option value="1" selected>Этаж 1</option>
                                <option value="2">Этаж 2</option>
                                <option value="3">Этаж 3</option>
                                <option value="4">Этаж 4</option>
                                <option value="5">Этаж 5</option>
                                <option value="6">Этаж 6</option>
                                <option value="7">Этаж 7</option>
                            </select>
                            <svg width="12" height="8" viewBox="0 0 12 8">
                                <path d="M1 1L6 6L11 1" stroke="#1E1E1E" stroke-opacity="0.7" stroke-width="2" />
                            </svg>
                        </div>
                    </div>
                    <div class="catalog__grid vers2" id="apartmentsList"></div>
                </div>
            </div>

        </section>

        <section class="finishing">
            <div class="finishing__tabs" role="tablist">
                <span class="finishing__tab finishing__tab--active" role="tab" aria-selected="true"
                    data-tab="finishing" onclick="switchTab(this)" style="cursor: pointer;">Варианты отделки</span>
                <span class="finishing__tab" role="tab" aria-selected="false" data-tab="yard"
                    onclick="switchTab(this)" style="cursor: pointer;">Двор</span>
                <span class="finishing__tab" role="tab" aria-selected="false" data-tab="parking"
                    onclick="switchTab(this)" style="cursor: pointer;">Парковка</span>
            </div>

            <div class="finishing__content" id="tab-finishing">
                <div class="finishing__text">
                    <p>В ЖК «Горизонт» все квартиры сдаются с качественной чистовой отделкой,
                        которая избавляет вас от самых
                        сложных, пыльных и затратных этапов ремонта. Мы выполняем полный
                        комплекс подготовительных работ,
                        чтобы вы
                        могли сразу приступить к финальному оформлению пространства под свой
                        вкус — без необходимости
                        нанимать
                        бригаду для черновых работ.</p>
                    <p>Все материалы, используемые в отделке, соответствуют ГОСТам, имеют
                        сертификаты качества и
                        экологической
                        безопасности, что гарантирует долговечность и комфорт вашего будущего
                        дома.</p>
                </div>
                <div class="finishing__gallery">
                    <div class="finishing__col">
                        <div class="finishing__cell finishing__cell--img">
                            <img src="assets/img/finishing-top.png" alt="Интерьер" decoding="async">
                        </div>
                        <div class="finishing__cell finishing__cell--accent" aria-hidden="true"><img
                                src="{{ asset('assets/img/furnish.jpg') }}" alt="Интерьер" decoding="async"></div>
                    </div>
                    <div class="finishing__cell finishing__cell--large">
                        <img src="assets/img/finishing-side.png" alt="Комната с отделкой" decoding="async">
                    </div>
                </div>
            </div>

            <div class="finishing__content" id="tab-yard" style="display: none;">
                <div class="finishing__text">
                    <p>Во дворе ЖК «Горизонт» создана безопасная и комфортная среда для жителей любого возраста.
                        Территория полностью закрыта от посторонних автомобилей и оснащена современными системами
                        видеонаблюдения. Мы предусмотрели всё для активного отдыха: яркие детские площадки с мягким
                        покрытием, зоны для воркаута и тихие уголки с ландшафтным дизайном, где можно отдохнуть от
                        городского шума в окружении зелени.</p>
                </div>
                <div class="finishing__gallery">
                    <div class="finishing__col">
                        <div class="finishing__cell finishing__cell--img">
                            <img src="{{ asset('assets/img/yard.jpg') }}" alt="Интерьер" decoding="async">
                        </div>
                        <div class="finishing__cell finishing__cell--accent" aria-hidden="true">
                            <img src="{{ asset('assets/img/yard2.jpg') }}" alt="Интерьер" decoding="async">

                        </div>
                    </div>
                    <div class="finishing__cell finishing__cell--large">
                        <img src="{{ asset('assets/img/yard3.jpg') }}" alt="Интерьер" decoding="async">

                    </div>
                </div>
            </div>

            <div class="finishing__content" id="tab-parking" style="display: none;">
                <div class="finishing__text">
                    <p>В ЖК «Горизонт» мы позаботились о том, чтобы вопрос парковки не становился источником стресса. На
                        территории комплекса предусмотрены просторные наземные парковочные места с четкой разметкой и
                        удобным въездом. Продуманная логистика двора исключает хаотичную стоянку машин, обеспечивая
                        безопасность пешеходов и сохранность автомобилей.</p>
                    <p>Для жителей, ценящих максимальный комфорт и защиту от непогоды, доступны места в крытых
                        паркингах. Это идеальное решение для тех, кто хочет сохранить автомобиль в pristine-состоянии
                        круглый год, не тратя время на очистку от снега зимой или пыли летом. Система доступа в паркинг
                        контролируется, что гарантирует дополнительную безопасность вашего транспортного средства.</p>
                </div>
                <div class="finishing__gallery">
                    <div class="finishing__col">
                        <div class="finishing__cell finishing__cell--img">
                            <img src="{{ asset('assets/img/parking1.jpg') }}" alt="Парковка" decoding="async">
                        </div>
                        <div class="finishing__cell finishing__cell--accent" aria-hidden="true">
                            <img src="{{ asset('assets/img/parking2.jpg') }}" alt="Парковка" decoding="async">
                        </div>
                    </div>
                    <div class="finishing__cell finishing__cell--large">
                        <img src="{{ asset('assets/img/parking3.jpg') }}" alt="Парковка" decoding="async">
                    </div>
                </div>
            </div>
        </section>

        <section class="purchase">
            <h2 class="purchase__title">Варианты покупки</h2>
            <div class="purchase__grid">
                <article class="purchase-card purchase-card--media">
                    <div class="purchase-card__media-inner">
                        <img class="purchase-card__img" src="assets/img/purchase-photo.png" alt="Уютный интерьер"
                            decoding="async">
                    </div>
                </article>
                <article class="purchase-card purchase-card--dark">
                    <div class="purchase-card__body">
                        <h3 class="purchase-card__name">Семейная <br> ипотека</h3>
                        <ul class="purchase-card__list">
                            <li>Ставка от 3,5% годовых</li>
                            <li>ПВ от 20,1%</li>
                        </ul>
                        <p class="purchase-card__note">Срок кредита от 12 до 360 месяцев, сумма
                            кредита от 300 000 до 6 млн.
                            р.</p>
                    </div>
                    <a class="purchase-card__btn btn btn--light btn--block" href="#booking">Узнать
                        стоимость</a>
                </article>
                <article class="purchase-card purchase-card--dark">
                    <div class="purchase-card__body">
                        <h3 class="purchase-card__name">Рассрочка с ПВ
                            от 20%</h3>
                        <ul class="purchase-card__list">
                            <li>ПВ от 20 до 50%</li>
                        </ul>
                        <p class="purchase-card__note purchase-card__note--emphasis">Ежемесячный
                            платеж от 35 000 до 50 000
                            р. в
                            месяц в зависимости от площади квартиры.</p>
                    </div>
                    <a class="purchase-card__btn btn btn--light btn--block" href="#booking">Узнать
                        стоимость</a>
                </article>
                <article class="purchase-card purchase-card--dark">
                    <div class="purchase-card__body">
                        <h3 class="purchase-card__name">Стандартная
                            ипотека</h3>
                        <ul class="purchase-card__list">
                            <li>Ставка 7,9% на 12 мес</li>
                            <li>ПВ от 20,1%</li>
                        </ul>
                        <p class="purchase-card__note">Срок кредита до 30 лет. Ипотека по
                            минимальной ставке 7,9% на первый
                            год</p>
                    </div>
                    <a class="purchase-card__btn btn btn--light btn--block" href="#booking">Узнать
                        стоимость</a>
                </article>
            </div>
        </section>

        <section class="mortgage-calculator container top_mar">
            <div class="mortgage-calculator__inner">

                <h2 class="mortgage-calculator__title">Ипотечный калькулятор</h2>
                <p class="mortgage-calculator__subtitle">Рассчитайте ежемесячный платёж для квартиры в ЖК «Горизонт»
                </p>

                <div class="mortgage-calculator__content">
                    <div class="mortgage-calculator__inputs">

                        <div class="mortgage-row">
                            <div class="mortgage-field">
                                <label class="mortgage-field__label">Стоимость квартиры</label>
                                <input type="text" class="mortgage-field__input" id="price-input"
                                    value="4 000 000">
                            </div>
                            <div class="mortgage-field">
                                <label class="mortgage-field__label">Первоначальный взнос</label>
                                <input type="text" class="mortgage-field__input" id="downpayment-input"
                                    value="2 500 000">
                            </div>
                        </div>

                        <div class="mortgage-row">
                            <div class="mortgage-field mortgage-field--select">
                                <label class="mortgage-field__label">Срок кредита</label>
                                <div class="mortgage-select">
                                    <input type="number" class="mortgage-field__input" id="years-input"
                                        value="20" max="30">
                                    <span class="mortgage-select__suffix">лет</span>
                                </div>
                            </div>
                        </div>

                        <div class="mortgage-row">
                            <div class="mortgage-field">
                                <label class="mortgage-field__label">Ставка по ипотеке</label>
                                <input type="number" class="mortgage-field__input" id="rate-input" max="35"
                                    value="3.5" step="0.1">
                            </div>
                        </div>

                    </div>

                    <div class="mortgage-calculator__results">
                        <div class="mortgage-results-grid">
                            <div class="mortgage-result mortgage-result--highlight">
                                <span class="mortgage-result__value" id="monthly-payment">14 976 ₽</span>
                                <span class="mortgage-result__label">Ежемесячный платёж</span>
                            </div>


                            <div class="mortgage-result">
                                <span class="mortgage-result__value" id="credit-amount">1 500 000 ₽</span>
                                <span class="mortgage-result__label">Сумма кредита</span>
                            </div>
                            <div class="mortgage-result">
                                <span class="mortgage-result__value" id="overpayment">2 094 168 ₽</span>
                                <span class="mortgage-result__label">Переплата по кредиту</span>
                            </div>
                            <div class="mortgage-result">
                                <span class="mortgage-result__value" id="total-payment">3 594 168 ₽</span>
                                <span class="mortgage-result__label">Общая выплата</span>
                            </div>
                            <div class="mortgage-result">
                                <span class="mortgage-result__value" id="recommended-income">49 951 ₽</span>
                                <span class="mortgage-result__label">Рекомендуемый доход</span>
                            </div>
                            <div class="mortgage-result">
                                <span class="mortgage-result__value" id="tax-deduction">532 242 ₽</span>
                                <span class="mortgage-result__label">Налоговый вычет</span>
                            </div>
                        </div>

                        <a href="#booking" class="mortgage-schedule-btn">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none"
                                stroke="currentColor" stroke-width="2">
                                <rect x="3" y="4" width="18" height="18" rx="2" ry="2">
                                </rect>
                                <line x1="16" y1="2" x2="16" y2="6"></line>
                                <line x1="8" y1="2" x2="8" y2="6"></line>
                                <line x1="3" y1="10" x2="21" y2="10"></line>
                            </svg>
                            Оставить заявку на ипотеку
                        </a>
                    </div>
                </div>
            </div>
        </section>

        <section class="faq" aria-labelledby="faq-title">
            <h2 class="faq__title" id="faq-title">Часто задаваемые вопросы</h2>
            <p class="faq__intro">
                Мы собрали самые частые вопросы наших клиентов — чтобы вы могли принять решение
                с полной уверенностью.
                Ответы
                проверены юристами, инженерами и менеджерами по продажам.
            </p>
            <div class="faq__columns">
                <div class="faq__col">
                    <details class="faq-item">
                        <summary class="faq-item__summary">Когда планируется сдача дома
                        </summary>
                        <div class="faq-item__content">
                            <p>Информация уточняется у менеджера отдела продаж.</p>
                        </div>
                    </details>
                    <details class="faq-item" open>
                        <summary class="faq-item__summary">Какие документы нужны для покупки
                            квартиры?
                        </summary>
                        <div class="faq-item__content">
                            <p>Для оформления договора долевого участия (ДДУ) потребуются:</p>
                            <ul>
                                <li>Паспорт гражданина РФ</li>
                                <li>СНИЛС</li>
                                <li>Документы, подтверждающие доход (при оформлении ипотеки)
                                </li>
                            </ul>
                        </div>
                    </details>
                </div>
                <div class="faq__col">
                    <details class="faq-item">
                        <summary class="faq-item__summary">Когда планируется сдача дома
                        </summary>
                        <div class="faq-item__content">
                            <p>Информация уточняется у менеджера отдела продаж.</p>
                        </div>
                    </details>
                    <details class="faq-item">
                        <summary class="faq-item__summary">Когда планируется сдача дома
                        </summary>
                        <div class="faq-item__content">
                            <p>Информация уточняется у менеджера отдела продаж.</p>
                        </div>
                    </details>
                    <details class="faq-item">
                        <summary class="faq-item__summary">Когда планируется сдача дома
                        </summary>
                        <div class="faq-item__content">
                            <p>Информация уточняется у менеджера отдела продаж.</p>
                        </div>
                    </details>
                    <details class="faq-item">
                        <summary class="faq-item__summary">Когда планируется сдача дома
                        </summary>
                        <div class="faq-item__content">
                            <p>Информация уточняется у менеджера отдела продаж.</p>
                        </div>
                    </details>
                </div>
            </div>
        </section>

        <section class="booking" id="booking">
            <div class="booking__bg">
                <img src="assets/img/cta-bg.png" alt="" decoding="async">
            </div>
            <div class="booking__inner">
                <div class="booking__text">
                    <h2 class="booking__title">Хотите увидеть ваш будущий дом лично?</h2>
                    <p class="booking__lead">Запишитесь на индивидуальный просмотр — покажем всё: от планировки и
                        отделки до
                        двора и паркинга.</p>
                </div>

                <form class="booking__form booking-form" action="{{ route('applications.store') }}" method="post">
                    @csrf


                    <label class="booking-form__field">
                        <span class="visually-hidden">Ваш телефон</span>
                        <input class="booking-form__input" type="tel" name="phone" id="booking-phone"
                            placeholder="+7 (___) ___-__-__" autocomplete="tel" required
                            value="{{ old('phone') }}">
                    </label>
                    @error('phone')
                        <span class="error-message">{{ $message }}</span>
                    @enderror

                    <label class="booking-form__field">
                        <span class="visually-hidden">Выберите удобную дату</span>
                        <input class="booking-form__input" type="date" name="viewing_date"
                            placeholder="Выберите удобную дату" min="{{ date('Y-m-d') }}"
                            max="{{ date('Y-m-d', strtotime('+3 months')) }}" value="{{ old('viewing_date') }}"
                            required>
                    </label>
                    @error('viewing_date')
                        <span class="error-message">{{ $message }}</span>
                    @enderror

                    <button class="booking-form__submit btn btn--light btn--block" type="submit">Забронировать
                        просмотр
                    </button>
                </form>
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
                                <p class="footer__value footer-value-static">ПН-ВС 8:00-20:00</p>
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

    <div id="applicationModal" class="modal-overlay">
        <div class="modal-content">
            <button onclick="closeModal()" class="modal-close-btn">&times;</button>
            <h2 class="modal-title">Оставить заявку</h2>

            @if ($errors->any())
                <div class="modal-error-box">
                    <ul class="modal-error-list">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('applications.store') }}" method="POST">
                @csrf


                <div class="auth-field">
                    <label>Телефон</label>
                    <input type="tel" name="phone" id="modal-phone" required value="{{ old('phone') }}"
                        placeholder="+7 (___) ___-__-__">
                </div>

                <div class="auth-field">
                    <label>Удобное время</label>
                    <input type="datetime-local" name="viewing_date" required>
                </div>

                <div class="auth-field">
                    <label>Комментарий</label>
                    <textarea name="comment" rows="3" placeholder="Комментарий">{{ old('comment') }}</textarea>
                </div>

                <button type="submit" class="btn modal-submit-btn" style=" font-family: var(--font-body); font-weight:400;font-size: clamp(14px, 1.4vw, 20px);">Отправить заявку</button>
            </form>
        </div>
    </div>

    <div id="custom-alert" class="custom-alert" style="display: none;">
        <div class="custom-alert__content">
            <div class="custom-alert__icon">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <polyline points="20 6 9 17 4 12"></polyline>
                </svg>
            </div>
            <div class="custom-alert__message" id="alert-message-text">
                Заявка успешно отправлена!
            </div>
            <button class="custom-alert__close" onclick="hideAlert()">
                &times;
            </button>
        </div>
    </div>

    <div class="menu-overlay" id="menuOverlay"></div>

    <script>
        function openModal() {
            document.getElementById('applicationModal').style.display = 'flex';
            document.body.style.overflow = 'hidden';
        }

        function closeModal() {
            document.getElementById('applicationModal').style.display = 'none';
            document.body.style.overflow = 'auto';
        }

        window.onclick = function(e) {
            if (e.target == document.getElementById('applicationModal')) {
                closeModal();
            }
        }

        document.addEventListener('DOMContentLoaded', function() {
            const modalPhoneInput = document.getElementById('modal-phone');
            if (!modalPhoneInput) return;

            const formatPhone = (value) => {
                let digits = value.replace(/\D/g, '');
                if (digits.length > 0 && (digits[0] === '8' || digits[0] === '7')) {
                    digits = digits.substring(1);
                }
                digits = digits.substring(0, 10);
                let result = '+7';
                if (digits.length > 0) result += ' (' + digits.substring(0, 3);
                if (digits.length >= 3) result += ') ' + digits.substring(3, 6);
                if (digits.length >= 6) result += '-' + digits.substring(6, 8);
                if (digits.length >= 8) result += '-' + digits.substring(8, 10);
                return result;
            };

            modalPhoneInput.addEventListener('focus', function() {
                if (this.value === '' || this.value === '+7') this.value = '+7 ';
            });

            modalPhoneInput.addEventListener('input', function(e) {
                const cursorPosition = this.selectionStart;
                const oldLength = this.value.length;
                this.value = formatPhone(this.value);
                const newLength = this.value.length;
                this.setSelectionRange(cursorPosition + (newLength - oldLength), cursorPosition + (
                    newLength - oldLength));
            });

            modalPhoneInput.addEventListener('keydown', function(e) {
                if ([8, 46, 9, 27, 13, 37, 38, 39, 40].includes(e.keyCode)) return;
                if ((e.ctrlKey || e.metaKey) && [65, 67, 86, 88].includes(e.keyCode)) return;
                if ((e.keyCode < 48 || e.keyCode > 57) && (e.keyCode < 96 || e.keyCode > 105)) e
                    .preventDefault();
            });
        });

        @if ($errors->any())
            document.addEventListener('DOMContentLoaded', function() {
                openModal();
            });
        @endif

        const floorLayouts = {
            1: [{
                    zone: 1,
                    path: 'M3 212V67H71.3365V0H212V212H3Z',
                    viewBox: '0 0 212 212'
                },
                {
                    zone: 2,
                    path: 'M0 144.5V4.5V0H343V144.5H0Z',
                    viewBox: '0 0 343 145'
                },
                {
                    zone: 3,
                    path: 'M0 280V0H147.5V280H0Z',
                    viewBox: '0 0 148 280'
                },
                {
                    zone: 4,
                    path: 'M0 184V2.5L267.5 0L265 184H0Z',
                    viewBox: '0 0 268 184'
                },
                {
                    zone: 5,
                    path: 'M144 0H35.5V130.5H0V205H35.5V200.5H148.5L144 0Z',
                    viewBox: '0 0 149 205'
                }
            ],
            2: [{
                    zone: 1,
                    path: 'M3 212V67H71.3365V0H212V212H3Z',
                    viewBox: '0 0 212 212'
                },
                {
                    zone: 2,
                    path: 'M0 144.5V4.5V0H343V144.5H0Z',
                    viewBox: '0 0 343 145'
                },
                {
                    zone: 3,
                    path: 'M0 280V0H147.5V280H0Z',
                    viewBox: '0 0 148 280'
                },
                {
                    zone: 4,
                    path: 'M0 184V2.5L267.5 0L265 184H0Z',
                    viewBox: '0 0 268 184'
                },
                {
                    zone: 5,
                    path: 'M144 0H35.5V130.5H0V205H35.5V200.5H148.5L144 0Z',
                    viewBox: '0 0 149 205'
                }
            ],
            3: [{
                    zone: 1,
                    path: 'M3 212V67H71.3365V0H212V212H3Z',
                    viewBox: '0 0 212 212'
                },
                {
                    zone: 2,
                    path: 'M0 144.5V4.5V0H343V144.5H0Z',
                    viewBox: '0 0 343 145'
                },
                {
                    zone: 3,
                    path: 'M0 280V0H147.5V280H0Z',
                    viewBox: '0 0 148 280'
                },
                {
                    zone: 4,
                    path: 'M0 184V2.5L267.5 0L265 184H0Z',
                    viewBox: '0 0 268 184'
                },
                {
                    zone: 5,
                    path: 'M144 0H35.5V130.5H0V205H35.5V200.5H148.5L144 0Z',
                    viewBox: '0 0 149 205'
                }
            ],
            4: [{
                    zone: 1,
                    path: 'M3 212V67H71.3365V0H212V212H3Z',
                    viewBox: '0 0 212 212'
                },
                {
                    zone: 2,
                    path: 'M0 144.5V4.5V0H343V144.5H0Z',
                    viewBox: '0 0 343 145'
                },
                {
                    zone: 3,
                    path: 'M0 280V0H147.5V280H0Z',
                    viewBox: '0 0 148 280'
                },
                {
                    zone: 4,
                    path: 'M0 184V2.5L267.5 0L265 184H0Z',
                    viewBox: '0 0 268 184'
                },
                {
                    zone: 5,
                    path: 'M144 0H35.5V130.5H0V205H35.5V200.5H148.5L144 0Z',
                    viewBox: '0 0 149 205'
                }
            ],
            5: [{
                    zone: 1,
                    path: 'M3 212V67H71.3365V0H212V212H3Z',
                    viewBox: '0 0 212 212'
                },
                {
                    zone: 2,
                    path: 'M0 144.5V4.5V0H343V144.5H0Z',
                    viewBox: '0 0 343 145'
                },
                {
                    zone: 3,
                    path: 'M0 280V0H147.5V280H0Z',
                    viewBox: '0 0 148 280'
                },
                {
                    zone: 4,
                    path: 'M0 184V2.5L267.5 0L265 184H0Z',
                    viewBox: '0 0 268 184'
                },
                {
                    zone: 5,
                    path: 'M144 0H35.5V130.5H0V205H35.5V200.5H148.5L144 0Z',
                    viewBox: '0 0 149 205'
                }
            ],
            6: [{
                    zone: 1,
                    path: 'M3 212V67H71.3365V0H212V212H3Z',
                    viewBox: '0 0 212 212'
                },
                {
                    zone: 2,
                    path: 'M0 144.5V4.5V0H343V144.5H0Z',
                    viewBox: '0 0 343 145'
                },
                {
                    zone: 3,
                    path: 'M0 280V0H147.5V280H0Z',
                    viewBox: '0 0 148 280'
                },
                {
                    zone: 4,
                    path: 'M0 184V2.5L267.5 0L265 184H0Z',
                    viewBox: '0 0 268 184'
                },
                {
                    zone: 5,
                    path: 'M144 0H35.5V130.5H0V205H35.5V200.5H148.5L144 0Z',
                    viewBox: '0 0 149 205'
                }
            ],
            7: [{
                    zone: 1,
                    path: 'M3 212V67H71.3365V0H212V212H3Z',
                    viewBox: '0 0 212 212'
                },
                {
                    zone: 2,
                    path: 'M0 144.5V4.5V0H343V144.5H0Z',
                    viewBox: '0 0 343 145'
                },
                {
                    zone: 3,
                    path: 'M0 280V0H147.5V280H0Z',
                    viewBox: '0 0 148 280'
                },
                {
                    zone: 4,
                    path: 'M0 184V2.5L267.5 0L265 184H0Z',
                    viewBox: '0 0 268 184'
                },
                {
                    zone: 5,
                    path: 'M144 0H35.5V130.5H0V205H35.5V200.5H148.5L144 0Z',
                    viewBox: '0 0 149 205'
                }
            ]
        };

        let apartmentsCache = {};
        let currentHouseId = 1;
        let currentFloorId = 1;

        async function fetchFloorData(houseId, floorId) {
            const cacheKey = `${houseId}-${floorId}`;
            if (apartmentsCache[cacheKey]) return apartmentsCache[cacheKey];

            try {
                const response = await fetch(`/api/building/${houseId}/floor/${floorId}`);
                const data = await response.json();
                apartmentsCache[cacheKey] = data;
                return data;
            } catch (e) {
                const mock = [];
                for (let z = 1; z <= 5; z++) {
                    mock.push({
                        id: parseInt(`${houseId}${floorId}0${z}`),
                        zone_number: z,
                        title: `Квартира ${houseId}-${floorId}0${z}`,
                        area: [45, 58, 42, 65, 75][z - 1],
                        rooms: [1, 2, 1, 2, 3][z - 1],
                        price: [6200000, 9800000, 5500000, 8500000, 12500000][z - 1],
                        status: ['free', 'sold', 'booked', 'free', 'free'][z - 1],
                    });
                }
                apartmentsCache[cacheKey] = mock;
                return mock;
            }
        }

        async function changeFloor(floorId) {
            currentFloorId = floorId;
            const data = await fetchFloorData(currentHouseId, floorId);
            const layout = floorLayouts[floorId] || floorLayouts[1];

            const stats = {
                free: 0,
                sold: 0,
                booked: 0
            };
            data.forEach(apt => stats[apt.status]++);

            document.getElementById('floorTotal').textContent = data.length;
            document.getElementById('floorFree').textContent = stats.free;
            document.getElementById('floorSold').textContent = stats.sold;
            document.getElementById('floorBooked').textContent = stats.booked;

            const floorPlan = document.querySelector('.floor-plan');
            const img = floorPlan.querySelector('.floor-plan__img');

            floorPlan.querySelectorAll('.apt').forEach(el => el.remove());

            data.forEach((apt, index) => {
                const zoneData = layout.find(l => l.zone === apt.zone_number) || layout[index];
                if (!zoneData) return;

                const svg = document.createElementNS('http://www.w3.org/2000/svg', 'svg');
                svg.setAttribute('class', `apt apt--${apt.zone_number}`);
                svg.setAttribute('viewBox', zoneData.viewBox);
                svg.setAttribute('preserveAspectRatio', 'none');

                const link = document.createElementNS('http://www.w3.org/2000/svg', 'a');
                link.setAttribute('href', '#');
                link.setAttribute('class', 'apt-link');
                link.setAttribute('id', `apt--${apt.zone_number}`);
                link.setAttribute('data-status', apt.status);
                link.setAttribute('onclick', `showApartmentCard(${apt.id}); return false;`);

                const path = document.createElementNS('http://www.w3.org/2000/svg', 'path');
                path.setAttribute('class', 'apt-shape');
                path.setAttribute('d', zoneData.path);

                link.appendChild(path);
                svg.appendChild(link);
                floorPlan.appendChild(svg);
            });
        }

        async function changeListFloor(floorId) {
            const data = await fetchFloorData(currentHouseId, floorId);

            const grid = document.getElementById('apartmentsList');
            grid.innerHTML = data.map(apt => `
                <article class="catalog-card">
                    <a href="/apartment/${apt.id}" class="list-card-link">
                        <div class="catalog-card__media">
                            ${apt.image ?
                                `<img src="/storage/${apt.image}" alt="${apt.title}" class="list-card-img">` :
                                `<div class="list-card-placeholder">
                                                                        ${apt.status === 'sold' ? 'Продана' : apt.status === 'booked' ? 'Забронирована' : 'Свободна'}
                                                                    </div>`
                            }
                        </div>
                    </a>
                    <div class="catalog-card__body">
                        <h3 class="catalog-card__title">${apt.title}</h3>
                        <div class="list-card-meta">
                            <span>${apt.area} м²</span>
                            <span>${apt.rooms} комн.</span>
                        </div>

                        <div class="card-price">
                            ${apt.price ? new Intl.NumberFormat('ru-RU').format(apt.price) + ' ₽' : 'Цена по запросу'}
                        </div>

                        <div style="margin-top: 15px;">
                            <a href="/apartment/${apt.id}" class="list-card-btn">
                                Подробнее
                            </a>
                        </div>
                    </div>
                </article>
            `).join('');
        }

        function show3D() {
            document.getElementById('view-3d').style.display = 'block';
            document.getElementById('view-floor').style.display = 'none';
            document.getElementById('view-list').style.display = 'none';
            document.getElementById('mainTitle').textContent = 'Выбрать квартиру';
            document.getElementById('viewToggle').style.display = 'flex';
            document.getElementById('btn-3d').classList.add('view-toggle__btn--active');
            document.getElementById('btn-list').classList.remove('view-toggle__btn--active');
        }

        function showList() {
            document.getElementById('view-3d').style.display = 'none';
            document.getElementById('view-floor').style.display = 'none';
            document.getElementById('view-list').style.display = 'block';
            document.getElementById('mainTitle').textContent = 'Список квартир';
            document.getElementById('viewToggle').style.display = 'flex';
            document.getElementById('btn-3d').classList.remove('view-toggle__btn--active');
            document.getElementById('btn-list').classList.add('view-toggle__btn--active');
            changeListFloor(currentFloorId);
        }

        function showFloors(houseId) {
            currentHouseId = houseId;
            document.getElementById('view-3d').style.display = 'none';
            document.getElementById('view-floor').style.display = 'block';
            document.getElementById('view-list').style.display = 'none';
            document.getElementById('mainTitle').textContent = 'Выбрать квартиру — Дом ' + houseId;


            document.getElementById('floorSelect').value = '1';
            changeFloor(1);
        }

        function backTo3D() {
            show3D();
        }

        function showApartmentCard(id) {
            window.location.href = `/apartment/${id}`;
        }

        show3D();

        document.addEventListener('DOMContentLoaded', function() {
            const phoneInput = document.getElementById('booking-phone');
            if (!phoneInput) return;

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

        function switchTab(element) {
            document.querySelectorAll('.finishing__tab').forEach(tab => {
                tab.classList.remove('finishing__tab--active');
                tab.setAttribute('aria-selected', 'false');
            });

            document.querySelectorAll('.finishing__content').forEach(content => {
                content.style.display = 'none';
            });

            element.classList.add('finishing__tab--active');
            element.setAttribute('aria-selected', 'true');

            const tabName = element.getAttribute('data-tab');
            document.getElementById('tab-' + tabName).style.display = '';
        }

        document.addEventListener('DOMContentLoaded', function() {
            const priceInput = document.getElementById('price-input');
            const downpaymentInput = document.getElementById('downpayment-input');
            const yearsInput = document.getElementById('years-input');
            const rateInput = document.getElementById('rate-input');

            const MAX_RATE = 35;
            const MAX_YEARS = 30;

            function parseValue(str) {
                return parseInt(str.replace(/\s/g, '')) || 0;
            }

            function formatNumber(num) {
                return Math.round(num).toLocaleString('ru-RU') + ' ₽';
            }

            function calculate() {
                const price = parseValue(priceInput.value);
                const downpayment = parseValue(downpaymentInput.value);

                let rate = parseFloat(rateInput.value) || 3.5;
                if (rate > MAX_RATE) rate = MAX_RATE;

                let years = parseInt(yearsInput.value) || 20;
                if (years > MAX_YEARS) years = MAX_YEARS;
                if (years < 1) years = 1;

                const months = years * 12;
                const monthlyRate = rate / 100 / 12;

                const creditAmount = Math.max(0, price - downpayment);

                let monthlyPayment = 0;
                if (monthlyRate > 0 && creditAmount > 0) {
                    monthlyPayment = creditAmount * (monthlyRate * Math.pow(1 + monthlyRate, months)) / (Math.pow(
                        1 + monthlyRate, months) - 1);
                } else {
                    monthlyPayment = creditAmount / months;
                }

                const totalPayment = monthlyPayment * months;
                const overpayment = totalPayment - creditAmount;
                const recommendedIncome = monthlyPayment * 2;
                const taxDeduction = Math.min(creditAmount * 0.13, 260000) + Math.min(overpayment * 0.13, 390000);

                document.getElementById('monthly-payment').textContent = formatNumber(monthlyPayment);
                document.getElementById('credit-amount').textContent = formatNumber(creditAmount);
                document.getElementById('overpayment').textContent = formatNumber(overpayment);
                document.getElementById('total-payment').textContent = formatNumber(totalPayment);
                document.getElementById('recommended-income').textContent = formatNumber(recommendedIncome);
                document.getElementById('tax-deduction').textContent = formatNumber(taxDeduction);
            }

            [priceInput, downpaymentInput].forEach(input => {
                input.addEventListener('blur', function() {
                    const val = parseValue(this.value);
                    this.value = val.toLocaleString('ru-RU');
                    calculate();
                });

                input.addEventListener('focus', function() {
                    this.value = parseValue(this.value).toString();
                });
            });

            rateInput.addEventListener('input', function() {
                if (parseFloat(this.value) > MAX_RATE) this.value = MAX_RATE;
                calculate();
            });
            rateInput.addEventListener('change', function() {
                if (parseFloat(this.value) > MAX_RATE) this.value = MAX_RATE;
                if (parseFloat(this.value) < 0) this.value = 0;
                calculate();
            });

            yearsInput.addEventListener('input', function() {
                if (parseInt(this.value) > MAX_YEARS) this.value = MAX_YEARS;
                if (parseInt(this.value) < 1 && this.value !== '') this.value = 1;
                calculate();
            });

            yearsInput.addEventListener('change', function() {
                let val = parseInt(this.value);
                if (val > MAX_YEARS) this.value = MAX_YEARS;
                if (val < 1 || isNaN(val)) this.value = 1;
                calculate();
            });

            calculate();
        });
    </script>
    <script>
        function showAlert(message, duration = 5000) {
            const alertBox = document.getElementById('custom-alert');
            const messageText = document.getElementById('alert-message-text');

            if (!alertBox || !messageText) return;

            messageText.textContent = message;
            alertBox.style.display = 'flex';

            setTimeout(() => {
                alertBox.classList.add('show');
            }, 10);

            if (duration > 0) {
                setTimeout(() => {
                    hideAlert();
                }, duration);
            }
        }

        function hideAlert() {
            const alertBox = document.getElementById('custom-alert');
            if (alertBox) {
                alertBox.classList.remove('show');
                setTimeout(() => {
                    alertBox.style.display = 'none';
                }, 400);
            }
        }

        document.addEventListener('DOMContentLoaded', function() {
            @if (session('success'))
                showAlert("{{ session('success') }}");
            @endif

            @if ($errors->any())
                showAlert("Проверьте правильность заполнения полей", 8000);
            @endif
        });
    </script>

</body>

</html>
