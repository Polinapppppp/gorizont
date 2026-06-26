<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Горизонт — Добавить планировку</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700&family=Unbounded:wght@400;500;600;700&display=swap"
        rel="stylesheet">
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

    <section class="page__main auth-section">
        <div class="auth-card">
            <h2 class="auth-title">Добавить новую планировку</h2>

            <form action="{{ route('apartments.store') }}" method="POST" enctype="multipart/form-data"
                class="auth-form">
                @csrf

                <div class="auth-field">
                    <label for="building_id" style="display:block; margin-bottom: 8px; font-weight: 500;">Дом</label>
                    <div class="custom-select">
                        <select name="building_id" id="building_id" required>
                            <option value="1" {{ old('building_id') == 1 ? 'selected' : '' }}>Дом 1</option>
                            <option value="2" {{ old('building_id') == 2 ? 'selected' : '' }}>Дом 2</option>
                        </select>
                    </div>
                </div>

                <div class="auth-field">
                    <label for="title" style="display:block; margin-bottom: 8px; font-weight: 500;">Название
                        планировки</label>
                    <input type="text" name="title" id="title" value="{{ old('title') }}"
                        placeholder="Например: 2-к квартира, 64 м²" required
                        style="width: 100%; padding: 12px 16px; border: 1px solid rgba(0,0,0,0.1); border-radius: 12px; font-size: 16px; font-family: 'Montserrat', sans-serif;">
                    @error('title')
                        <span style="color:red; font-size: 12px;">{{ $message }}</span>
                    @enderror
                </div>

                <div style="display: flex; gap: 15px;">
                    <div class="auth-field" style="flex: 1;">
                        <label for="area" style="display:block; margin-bottom: 8px; font-weight: 500;">Общая
                            площадь (м²)</label>
                        <input type="number" name="area" id="area" value="{{ old('area') }}"
                            placeholder="64" required
                            style="width: 100%; padding: 12px 16px; border: 1px solid rgba(0,0,0,0.1); border-radius: 12px; font-size: 16px; font-family: 'Montserrat', sans-serif;">
                        <small style="color: grey; font-size: 12px;">С учётом кухни, коридоров</small>
                        @error('area')
                            <span style="color:red; font-size: 12px;">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="auth-field" style="flex: 1;">
                        <label for="living_area" style="display:block; margin-bottom: 8px; font-weight: 500;">Жилая
                            площадь (м²)</label>
                        <input type="number" name="living_area" id="living_area" step="0.1"
                            value="{{ old('living_area') }}" placeholder="45.2"
                            style="width: 100%; padding: 12px 16px; border: 1px solid rgba(0,0,0,0.1); border-radius: 12px; font-size: 16px; font-family: 'Montserrat', sans-serif;">
                        <small style="color: grey; font-size: 12px;">Только комнаты</small>
                        @error('living_area')
                            <span style="color:red; font-size: 12px;">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div style="display: flex; gap: 15px;">
                    <div class="auth-field" style="flex: 1;">
                        <label for="rooms" style="display:block; margin-bottom: 8px; font-weight: 500;">Количество
                            комнат</label>
                        <input type="number" name="rooms" id="rooms" value="{{ old('rooms') }}"
                            placeholder="2" required
                            style="width: 100%; padding: 12px 16px; border: 1px solid rgba(0,0,0,0.1); border-radius: 12px; font-size: 16px; font-family: 'Montserrat', sans-serif;">
                        <small style="color: grey; font-size: 12px;">Максимум 3 комнаты</small>
                        @error('rooms')
                            <span style="color:red; font-size: 12px;">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="auth-field" style="flex: 1;">
                        <label for="floor"
                            style="display:block; margin-bottom: 8px; font-weight: 500;">Этаж</label>
                        <input type="number" name="floor" id="floor" value="{{ old('floor') }}"
                            placeholder="3" min="1" max="7" required
                            style="width: 100%; padding: 12px 16px; border: 1px solid rgba(0,0,0,0.1); border-radius: 12px; font-size: 16px; font-family: 'Montserrat', sans-serif;">
                        <small style="color: grey; font-size: 12px;">1–7 этаж</small>
                        @error('floor')
                            <span style="color:red; font-size: 12px;">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div style="display: flex; gap: 15px; align-items: flex-start;">
                    <div class="auth-field" style="flex: 1;">
                        <label for="zone_number" style="display:block; margin-bottom: 8px; font-weight: 500;">Зона на
                            плане</label>
                        <input type="number" name="zone_number" id="zone_number" value="{{ old('zone_number') }}"
                            placeholder="1" min="1" max="5" required
                            style="width: 100%; padding: 12px 16px; border: 1px solid rgba(0,0,0,0.1); border-radius: 12px; font-size: 16px; font-family: 'Montserrat', sans-serif;">
                        <small style="color: grey; font-size: 12px;">1–5 зона</small>
                        @error('zone_number')
                            <span style="color:red; font-size: 12px;">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="auth-field" style="flex: 1;">
                        <label for="ceiling_height"
                            style="display:block; margin-bottom: 8px; font-weight: 500;">Высота потолков (м)</label>
                        <input type="number" name="ceiling_height" id="ceiling_height" step="0.01"
                            value="{{ old('ceiling_height', 2.7) }}" placeholder="2.70"
                            style="width: 100%; padding: 12px 16px; border: 1px solid rgba(0,0,0,0.1); border-radius: 12px; font-size: 16px; font-family: 'Montserrat', sans-serif;">
                        <small style="color: grey; font-size: 12px;">Например: 2.70</small>
                        @error('ceiling_height')
                            <span style="color:red; font-size: 12px;">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="auth-field">
                    <label style="display:block; margin-bottom: 8px; font-weight: 500;">Балкон / лоджия</label>
                    <div class="checkbox-field">
                        <input type="checkbox" name="has_balcony" id="has_balcony" value="1"
                            {{ old('has_balcony') ? 'checked' : '' }}>
                        <label for="has_balcony">Есть балкон или лоджия</label>
                    </div>
                    @error('has_balcony')
                        <span style="color:red; font-size: 12px;">{{ $message }}</span>
                    @enderror
                </div>

                <div class="auth-field">
                    <label for="finishing"
                        style="display:block; margin-bottom: 8px; font-weight: 500;">Отделка</label>
                    <div class="custom-select">
                        <select name="finishing" id="finishing">
                            <option value="">Не указано</option>
                            <option value="whitebox" {{ old('finishing') == 'whitebox' ? 'selected' : '' }}>White box
                            </option>
                            <option value="rough" {{ old('finishing') == 'rough' ? 'selected' : '' }}>Черновая
                            </option>
                            <option value="clean" {{ old('finishing') == 'clean' ? 'selected' : '' }}>Чистовая
                            </option>
                            <option value="design" {{ old('finishing') == 'design' ? 'selected' : '' }}>С дизайнерским
                                ремонтом</option>
                        </select>
                    </div>
                    @error('finishing')
                        <span style="color:red; font-size: 12px;">{{ $message }}</span>
                    @enderror
                </div>

                <div class="auth-field">
                    <label for="price" style="display:block; margin-bottom: 8px; font-weight: 500;">Стоимость
                        (₽)</label>
                    <input type="number" name="price" id="price" value="{{ old('price') }}"
                        placeholder="15000000"
                        style="width: 100%; padding: 12px 16px; border: 1px solid rgba(0,0,0,0.1); border-radius: 12px; font-size: 16px; font-family: 'Montserrat', sans-serif;">
                    <small style="color: grey; font-size: 12px;">Макс. 40 млн ₽, можно оставить пустым</small>
                    @error('price')
                        <span style="color:red; font-size: 12px;">{{ $message }}</span>
                    @enderror
                </div>

                <div class="auth-field">
                    <label for="status" style="display:block; margin-bottom: 8px; font-weight: 500;">Статус</label>
                    <div class="custom-select">
                        <select name="status" id="status" required>
                            <option value="free" {{ old('status') == 'free' ? 'selected' : '' }}>Свободна</option>
                            <option value="booked" {{ old('status') == 'booked' ? 'selected' : '' }}>Забронирована
                            </option>
                            <option value="sold" {{ old('status') == 'sold' ? 'selected' : '' }}>Продана</option>
                        </select>
                    </div>
                </div>

                <div class="auth-field">
                    <label style="display:block; margin-bottom: 8px; font-weight: 500;">Фото планировки</label>
                    <div class="file-upload" id="fileUpload">
                        <input type="file" name="image" id="image" accept="image/*"
                            onchange="handleFileSelect(this)">
                        <img class="file-upload__preview" id="previewImg" alt="Preview">
                        <button type="button" class="file-upload__remove" onclick="removeFile(event)">×</button>
                        <div class="file-upload__content">
                            <div class="file-upload__text">
                                <strong>Нажмите</strong> или перетащите фото сюда
                            </div>
                            <div class="file-upload__hint">JPG, PNG до 2 МБ</div>
                        </div>
                    </div>
                    @error('image')
                        <span style="color:red; font-size: 12px;">{{ $message }}</span>
                    @enderror
                </div>

                <div class="auth-field">
                    <label for="description"
                        style="display:block; margin-bottom: 8px; font-weight: 500;">Описание</label>
                    <textarea name="description" id="description" rows="3" placeholder="Дополнительная информация..."
                        style="width: 100%; padding: 12px 16px; border: 1px solid rgba(0,0,0,0.1); border-radius: 12px; outline: none; font-size: 16px; font-family: 'Montserrat', sans-serif; resize: vertical;">{{ old('description') }}</textarea>
                </div>

                <button type="submit" class="auth-submit" style="margin-top: 20px;">Сохранить</button>

                <a href="{{ route('apartments.index') }}"
                    style="text-align: center; color: var(--color-text-muted); text-decoration: none; margin-top: 15px; display: block;">←
                    Вернуться к списку</a>
            </form>
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

    <script>
        function handleFileSelect(input) {
            const file = input.files[0];
            const upload = document.getElementById('fileUpload');
            const preview = document.getElementById('previewImg');

            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    preview.src = e.target.result;
                    upload.classList.add('has-file');
                };
                reader.readAsDataURL(file);
            }
        }

        function removeFile(e) {
            e.preventDefault();
            e.stopPropagation();
            const input = document.getElementById('image');
            const upload = document.getElementById('fileUpload');
            const preview = document.getElementById('previewImg');

            input.value = '';
            preview.src = '';
            upload.classList.remove('has-file');
        }

        const uploadZone = document.getElementById('fileUpload');

        ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
            uploadZone.addEventListener(eventName, preventDefaults, false);
        });

        function preventDefaults(e) {
            e.preventDefault();
            e.stopPropagation();
        }

        ['dragenter', 'dragover'].forEach(eventName => {
            uploadZone.addEventListener(eventName, highlight, false);
        });

        ['dragleave', 'drop'].forEach(eventName => {
            uploadZone.addEventListener(eventName, unhighlight, false);
        });

        function highlight(e) {
            uploadZone.style.borderColor = 'var(--color-primary)';
            uploadZone.style.background = 'rgba(21, 37, 50, 0.05)';
        }

        function unhighlight(e) {
            uploadZone.style.borderColor = 'rgba(0,0,0,0.15)';
            uploadZone.style.background = '#fafafa';
        }

        uploadZone.addEventListener('drop', handleDrop, false);

        function handleDrop(e) {
            const dt = e.dataTransfer;
            const files = dt.files;
            const input = document.getElementById('image');

            input.files = files;
            handleFileSelect(input);
        }
    </script>
</body>

</html>
