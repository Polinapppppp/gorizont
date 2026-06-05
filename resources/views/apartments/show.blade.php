<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Горизонт — {{ $apartment->title }}</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700&family=Unbounded:wght@400;500;600;700&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
    <link rel="shortcut icon" href="{{ asset('assets/img/fav.png') }}" type="image/x-icon">

    <style>
        /* --- Стили модального окна (существующие) --- */
        .modal-content {
            background: #fff;
            padding: 40px;
            border-radius: 20px;
            width: 90%;
            max-width: 500px;
            position: relative;
            box-shadow: 0 20px 50px rgba(0, 0, 0, 0.3);
        }

        .modal-content h2 {
            margin: 0 0 clamp(20px, 2.5vw, 35px);
            font-family: var(--font-display);
            font-size: clamp(22px, 3vw, 32px);
            font-weight: 400;
            margin-bottom: 20px;
        }

        .modal-close-btn {
            position: absolute;
            top: 15px;
            right: 20px;
            font-size: 30px;
            cursor: pointer;
            color: #999;
            line-height: 1;
        }

        .modal-close-btn:hover {
            color: #333;
        }

        .validation-errors {
            background: #fee2e2;
            color: #b91c1c;
            padding: 10px;
            border-radius: 8px;
            margin-bottom: 15px;
            font-size: 14px;
        }

        .validation-errors ul {
            margin: 0;
            padding-left: 20px;
        }

        /* Form Fields in Modal */
        .auth-field {
            margin-bottom: 15px;
        }

        .auth-field label {
            display: block;
            margin-bottom: 8px;
            font-weight: 500;
            font-size: 14px;
            color: #333;
        }

        .auth-field input,
        .auth-field textarea {
            width: 100%;
            padding: 12px;
            border: 1px solid #ddd;
            border-radius: 10px;
            font-size: 16px;
            box-sizing: border-box;
            font-family: 'Montserrat', sans-serif;
        }

        .auth-field textarea {
            resize: vertical;
        }

        .modal-submit-btn {
            width: 100%;
        }

        /* --- Стили страницы детали квартиры (существующие) --- */
        .apartment-detail {
            max-width: 1200px;
            margin: 0 auto;
            padding: 100px 100px;
        }

        .apartment-detail__breadcrumbs {
            font-size: 14px;
            color: #888;
            margin-bottom: 25px;
        }

        .apartment-detail__breadcrumbs a {
            color: #888;
            text-decoration: none;
            transition: color 0.2s;
        }

        .apartment-detail__breadcrumbs a:hover {
            color: var(--color-primary);
        }

        .apartment-detail__breadcrumbs span {
            margin: 0 8px;
            color: #ccc;
        }

        .apartment-detail__grid {
            display: grid;
            grid-template-columns: 1.2fr 1fr;
            gap: 40px;
            align-items: start;
        }

        @media (max-width: 900px) {
            .apartment-detail__grid {
                grid-template-columns: 1fr;
            }

            .apartment-detail {
                padding: 40px 20px;
            }
        }

        .apartment-detail__left {
            position: relative;
        }

        .apartment-detail__plan-image {
            width: 100%;
            border-radius: 16px;
            border: 1px solid rgba(0, 0, 0, 0.08);
            background: #fff;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.06);
            max-height: 700px;
            object-fit: contain;
        }

        /* Right Column - Card */
        .apartment-detail__card {
            background: #fff;
            border: 1px solid rgba(0, 0, 0, 0.08);
            border-radius: 20px;
            padding: 35px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.06);
        }

        .apartment-detail__card-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 20px;
        }

        .apartment-detail__card-title {
            font-family: 'Unbounded', sans-serif;
            font-size: 16px;
            font-weight: 400;
            color: var(--color-primary);
        }

        .apartment-detail__card-area {
            font-size: 16px;
            font-weight: 600;
            color: var(--color-primary);
        }

        .apartment-detail__price {
            font-family: 'Unbounded', sans-serif;
            font-size: 32px;
            font-weight: 400;
            color: var(--color-primary);
            margin-bottom: 5px;
        }

        .apartment-detail__price-per-m2 {
            font-size: 14px;
            color: #888;
            margin-bottom: 25px;
        }

        .apartment-detail__specs {
            margin-bottom: 30px;
        }

        .spec-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 14px 0;
            border-bottom: 1px solid rgba(0, 0, 0, 0.06);
        }

        .spec-row:last-child {
            border-bottom: none;
        }

        .spec-row__label {
            font-size: 15px;
            color: #888;
        }

        .spec-row__value {
            font-size: 15px;
            font-weight: 600;
            color: var(--color-primary);
        }

        .apartment-detail__actions {
            display: flex;
            flex-direction: column;
            gap: 12px;
        }

        .btn--primary {
            width: 100%;
            background: var(--color-primary);
            color: #fff;
            border: none;
            border-radius: 16px;
            cursor: pointer;
            transition: opacity 0.2s;
            font-family: 'Montserrat', sans-serif;
            text-align: center;
            text-decoration: none;
            display: block;
            padding: 14px 20px;
            font-size: 16px;
        }

        .btn--primary:hover {
            opacity: 0.9;
        }

        .btn--secondary {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-family: var(--font-body);
            font-weight: 400;
            font-size: clamp(14px, 1.4vw, 20px);
            line-height: normal;
            border: none;
            cursor: pointer;
            border-radius: clamp(12px, 1.2vw, 16px);
            padding: clamp(10px, 1.2vw, 14px) clamp(20px, 2.2vw, 30px);
            transition: 0.5s ease;
            white-space: nowrap;
            background: var(--color-primary);
            color: #fff;
            border: 2px solid var(--color-primary);
            text-decoration: none;
            width: 100%;
            box-sizing: border-box;
        }

        .btn--secondary:hover {
            color: var(--color-primary);
            background: #fff;
        }

        .btn--danger {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-family: var(--font-body);
            font-weight: 400;
            font-size: clamp(14px, 1.4vw, 20px);
            line-height: normal;
            border: none;
            cursor: pointer;
            border-radius: clamp(12px, 1.2vw, 16px);
            padding: clamp(10px, 1.2vw, 14px) clamp(20px, 2.2vw, 30px);
            transition: 0.5s ease;
            white-space: nowrap;
            width: 100%;
            background: #c0392b;
            border: 2px solid #c0392b;
            color: #fff;
            box-sizing: border-box;
        }

        .btn--danger:hover {
            background: #fff;
            color: #c0392b;
        }

        .status-badge {
            display: inline-block;
            font-size: 15px;
            font-weight: 600;
            letter-spacing: 0.5px;
            padding: 4px 8px;
            border-radius: 6px;
        }



        .delete-form {
            width: 100%;
        }

        /* --- Стили для Алерта (Новые) --- */
        .custom-alert {
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 9999;
            background: #fff;
            padding: 15px 20px;
            border-radius: 12px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);
            display: flex;
            align-items: center;
            min-width: 300px;
            max-width: 400px;
            transform: translateX(120%);
            transition: transform 0.4s cubic-bezier(0.68, -0.55, 0.27, 1.55);
            border-left: 5px solid #10b981;
        }

        .custom-alert.show {
            transform: translateX(0);
        }

        .custom-alert__content {
            display: flex;
            align-items: center;
            width: 100%;
            gap: 15px;
        }

        .custom-alert__icon {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 40px;
            height: 40px;
            background: #d1fae5;
            color: #10b981;
            border-radius: 50%;
            flex-shrink: 0;
        }

        .custom-alert__message {
            font-size: 15px;
            font-weight: 500;
            color: #333;
            line-height: 1.4;
        }

        .custom-alert__close {
            background: none;
            border: none;
            font-size: 20px;
            color: #999;
            cursor: pointer;
            margin-left: auto;
            padding: 0 5px;
        }

        .custom-alert__close:hover {
            color: #333;
        }

        @media (max-width: 480px) {
            .custom-alert {
                top: auto;
                bottom: 20px;
                right: 10px;
                left: 10px;
                min-width: auto;
                transform: translateY(120%);
            }

            .custom-alert.show {
                transform: translateY(0);
            }
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

    <section class="apartment-detail">
        <div class="apartment-detail__grid">
            <div class="apartment-detail__left">
                <img src="{{ $apartment->image ? asset('storage/' . $apartment->image) : asset('assets/img/no-image.jpg') }}"
                    alt="{{ $apartment->title }}" class="apartment-detail__plan-image">
            </div>

            <div class="apartment-detail__card">
                <div class="apartment-detail__card-header">
                    <span class="apartment-detail__card-title">{{ $apartment->title }}</span>
                    <span class="apartment-detail__card-area">{{ $apartment->area }} м²</span>
                </div>

                <div class="apartment-detail__price">
                    @if ($apartment->price)
                        {{ number_format($apartment->price, 0, ' ', ' ') }} ₽
                    @else
                        Цена по запросу
                    @endif
                </div>


                <div class="apartment-detail__specs">
                    <div class="spec-row">
                        <span class="spec-row__label">Номер квартиры</span>
                        <span class="spec-row__value">{{ $apartment->id }}</span>
                    </div>
                    <div class="spec-row">
                        <span class="spec-row__label">Этаж</span>
                        <span class="spec-row__value">{{ $apartment->floor }} из 7</span>
                    </div>
                    <div class="spec-row">
                        <span class="spec-row__label">Площадь</span>
                        <span class="spec-row__value">{{ $apartment->area }} м²</span>
                    </div>
                    @if ($apartment->living_area)
                        <div class="spec-row">
                            <span class="spec-row__label">Жилая площадь</span>
                            <span class="spec-row__value">{{ $apartment->living_area }} м²</span>
                        </div>
                    @endif
                    @if ($apartment->ceiling_height)
                        <div class="spec-row">
                            <span class="spec-row__label">Высота потолков</span>
                            <span class="spec-row__value">{{ $apartment->ceiling_height }} м</span>
                        </div>
                    @endif
                    <div class="spec-row">
                        <span class="spec-row__label">Отделка</span>
                        <span class="spec-row__value">
                            @if ($apartment->finishing == 'whitebox')
                                White box
                            @elseif($apartment->finishing == 'rough')
                                Черновая
                            @elseif($apartment->finishing == 'clean')
                                Чистовая
                            @elseif($apartment->finishing == 'design')
                                С отделкой
                            @else
                                Не указано
                            @endif
                        </span>
                    </div>
                    <div class="spec-row">
                        <span class="spec-row__label">Статус</span>
                        <span class="spec-row__value">
                            <span class="status-badge status-badge--{{ $apartment->status }}">
                                @if ($apartment->status == 'free')
                                    Свободна
                                @elseif($apartment->status == 'booked')
                                    Забронирована
                                @else
                                    Продана
                                @endif
                            </span>
                        </span>
                    </div>
                </div>

                <div class="apartment-detail__actions">
                    @if (auth()->check() && auth()->user()->isAdmin())
                        <a href="/apartments/{{ $apartment->id }}/edit" class="btn--secondary">
                            Редактировать
                        </a>
                        <form action="{{ route('apartments.destroy', $apartment->id) }}" method="POST"
                            class="delete-form" onsubmit="return confirm('Удалить эту квартиру?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn--danger">Удалить</button>
                        </form>
                    @else
                        @auth
                            <button onclick="openModal()" class="btn btn--primary">Оставить заявку</button>
                        @else
                            <a href="/login?redirect={{ urlencode(request()->url()) }}" class="btn btn--primary">
                                Оставить заявку
                            </a>
                        @endauth
                    @endif
                </div>
            </div>
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

    <div id="applicationModal" class="modal-overlay"
        style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.6); z-index: 1000; justify-content: center; align-items: center; backdrop-filter: blur(5px);">
        <div class="modal-content">

            <span onclick="closeModal()" class="modal-close-btn">&times;</span>

            <h2>Заявка на просмотр</h2>

            @if ($errors->any())
                <div class="validation-errors">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('applications.store') }}" method="POST">
                @csrf
                <input type="hidden" name="apartment_id" value="{{ $apartment->id }}">


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

                <button type="submit" class="btn--primary modal-submit-btn" style=" font-family: var(--font-body); font-weight:400;font-size: clamp(14px, 1.4vw, 20px);">Отправить заявку</button>
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

        function openModal() {
            document.getElementById('applicationModal').style.display = 'flex';
            document.body.style.overflow = 'hidden';
        }

        function closeModal() {
            document.getElementById('applicationModal').style.display = 'none';
            document.body.style.overflow = 'auto';
        }

        window.onclick = function(e) {
            if (e.target == document.getElementById('applicationModal')) closeModal();
        }

        document.addEventListener('DOMContentLoaded', function() {
            @if (session('success'))
                showAlert("{{ session('success') }}");
            @endif

            @if ($errors->any())
                openModal();
            @endif

            const modalPhoneInput = document.getElementById('modal-phone');
            if (modalPhoneInput) {
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
            }
        });
    </script>
</body>

</html>
