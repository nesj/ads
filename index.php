<!DOCTYPE html>
<html lang="ru">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Main page</title>
	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap" rel="stylesheet">
	<link rel="stylesheet" href="css/normalize.css">
	<link rel="stylesheet" href="css/main.css">
	<link rel="stylesheet" href="css/index.css">
</head>
<body>
	<header class="header">
		<div class="container header__container">
			<div class="header__content">
				<div class="header__top">
					<span class="header__logo">
						<a href="index.php" class="header__logo-link">
							<img class="header__img" src="img/logo.png" alt="">
						</a>
					</span>
					<a class="header__top-link" href="#">
						<h1 class="header__top-link">****.lv <br> Доска интимных объявлений по Латвии и прибалтике</h1>
					</a>
					<div class="header__languages">
						<button class="btn-reset header__languages-btns">
							Английский
						</button>
						<button class="btn-reset header__languages-btns">
							Русский
						</button>
						<button class="btn-reset header__languages-btns">
							Латышский
						</button>
						<button class="btn-reset header__languages-btns">
							Эстонский
						</button>
						<button class="btn-reset header__languages-btns">
							Литовский
						</button>
					</div>
				</div>
				<div class="header__bottom">
					<nav class="nav">
						<ul class="nav__list list-reset">
							<li class="nav__list-elements">
								<a href="#" class="nav__list-links">Добавить объявление</a>
							</li>
							<li class="nav__list-elements">
								<a href="#" class="nav__list-links">Все объявления</a>
							</li>
							<li class="nav__list-elements">
								<a href="#" class="nav__list-links">Поиск</a>
							</li>
							<li class="nav__list-elements">
								<a href="#" class="nav__list-links">О нас/связь с нами</a>
							</li>
							<li class="nav__list-elements">
								<a href="#" class="nav__list-links">Правила</a>
							</li>
						</ul>
					</nav>
				</div>
			</div>
		</div>
	</header>
	<main class="main">
			<div class="container main__content">
				<section class="left">
					<div class="left__inner">
						<ul class="left__list list-reset">
							<li class="left__list-elements">
								<p class="left__paragraph">Пользоваться доской объявлений разрешено только персонам, достигших совершеннолетия, не моложе 18 лет.</p>
							</li>
							<li class="left__list-elements">
								<p class="left__paragraph">Ваше объявление должно совпадать с тематикой раздела, в который помещено.</p>
							</li>
							<li class="left__list-elements">
								<p class="left__paragraph">Запрещено писать объявления от чужих лиц или без их ведома и согласия.</p>
							</li>
							<li class="left__list-elements">
								<p class="left__paragraph">Запрещено указывать фамилии и персональные коды в теле сообщения и в других полях.</p>
							</li>
							<li class="left__list-elements">
								<p class="left__paragraph">Запрещается в тексте объявления оставлять ссылки на сайты, е-майлы, номера телефонов - вписывать эти данные можно только специально отведённые поля.</p>
							</li>
							<li class="left__list-elements">
								<p class="left__paragraph">Запрещено писать объявления о продаже или рекламе рецептурны лекарств Viagra, Cialis, Levitra (и др.) а так же незарегистрированные лекарства Kamagra, Vigora и др. - доступ к порталу будет закрыт а данные об авторе объявления будут переданы Инспекции Здравоохранения - Отделу по контролю за лекарствами</p>
							</li>
							<li class="left__list-elements">
								<p class="left__paragraph">Администрация сайта не несет никакую ответственность за содержимое объявления и никак не связана с деятельностью персоны, подавающей объявление.</p>
							</li>
							<li class="left__list-elements left__last-element">
								<p class="left__paragraph">...</p>
							</li>
						</ul>
						<form action="rules.html" class="left__form">
							<button class="btn-reset left__form-btn">Перейти к правилам</button>
						</form>
					</div>
				</section>
				<section class="center">
						<h2 class="center__h2">Последние объявления</h2>
						<div class="center__ads">
							<div class="center__ads-header">
								<div class="center__photo-header">
									<img src="./img/photo-icon-center.png" alt="" class="center__photo-img">
								</div>
								<div class="center__name-header">
									<p class="center__name-header-p">Имя</p>
								</div>
								<div class="center__descr-header">
									<p class="center__descr-header-p">Заголовок</p>
								</div>
								<div class="center__country-age-header">
									<div class="center__age-header">
										<p class="center__age-header-p">Возраст</p>
									</div>
									<div class="center__country-header">
										<p class="center__country-header-p">Страна</p>
									</div>
								</div>
							</div>
							<?php
								// Устанавливаем параметры подключения к базе данных
								$dsn = 'mysql:host=localhost;dbname=ads';
								$username = 'root';
								$password = 'mysql';

								// Создаем объект PDO и устанавливаем режим ошибок на исключения
								$pdo = new PDO($dsn, $username, $password, [
										PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
								]);

								// Подготавливаем и выполняем SQL запрос с использованием JOIN и сортировки по id объявления в обратном порядке
								$sql = "SELECT adss.*, countries.countries_name 
												FROM adss 
												JOIN countries ON adss.country_id = countries.id 
												ORDER BY adss.id DESC";
								$stmt = $pdo->query($sql);

								// Обрабатываем результаты запроса
								while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
								// Разбиваем строку из поля "filename" на массив
									$filenames = explode(",", $row["filename"]);
								
								// Получаем первую фотографию для текущего объявления
									$first_photo = trim($filenames[0]); // удаляем пробелы в начале и конце строки
																	
										// Выводим информацию о каждом объявлении, включая название страны
										echo "<article class='center__article'>";
										echo "<a class='center__link' href='ad_page.php?id=" . $row["id"] . "'>";
										echo "<img class='center__img' src='uploads/$first_photo' alt='First photo'>";
										echo "<h2 class='center__name'>" . $row["name"] . "</h2>";
										echo "<p class='center__descr'>" . $row["header"] . "</p>";
										echo "<p class='center__age'>" . $row["age"] . "</p>";
										echo "<p class='center__country'>" . $row["countries_name"] . "</p>";
										echo "</a>";
										echo "</article>";
								}
								// Закрываем соединение с базой данных
								$pdo = null;
							?>
						</div>
				</section>
				<section class="right">
					<form class="right__form" action="add_ad.html">
						<button class="btn-reset right__form-btn">Добавить объявление</button>
					</form>
					<h2 class="right__h2">Категории:</h2>
					<ul class="right__list list-reset">
						<li class="right_list-elements">
							<a href="#" class="right__list-links">Женщины ищут мужчину для секса</a>
						</li>
						<li class="right_list-elements">
							<a href="#" class="right__list-links">Женщины ищут мужчину для серьёзных отношений</a>
						</li>
						<li class="right_list-elements">
							<a href="#" class="right__list-links">Sexwife</a>
						</li>
						<li class="right_list-elements">
							<a href="#" class="right__list-links">Женщины ищут женщин</a>
						</li>
						<li class="right_list-elements">
							<a href="#" class="right__list-links">Мужчины ищут женщину для секса</a>
						</li>
						<li class="right_list-elements">
							<a href="#" class="right__list-links">Мужчины ищут женщину для серьёзных отношений</a>
						</li>
						<li class="right_list-elements">
							<a href="#" class="right__list-links">Мужчины ищут мужчин</a>
						</li>
						<li class="right_list-elements">
							<a href="#" class="right__list-links">Парочки</a>
						</li>
						<li class="right_list-elements">
							<a href="#" class="right__list-links">Секс-вечеринки</a>
						</li>
						<li class="right_list-elements">
							<a href="#" class="right__list-links">Садо-мазо</a>
						</li>
						<li class="right_list-elements">
							<a href="#" class="right__list-links">Кто-то ищет что-то другое</a>
						</li>
						<li class="right_list-elements">
							<a href="#" class="right__list-links">Эскорт и массаж</a>
						</li>
						<li class="right_list-elements">
							<a href="#" class="right__list-links">Мужской эскорт</a>
						</li>
						<li class="right_list-elements">
							<a href="#" class="right__list-links">Виртуальные услуги, видеозвонки, фото</a>
						</li>
						<li class="right_list-elements">
							<a href="#" class="right__list-links">Транссексуалы и трансвеститы</a>
						</li>
						<li class="right_list-elements">
							<a href="#" class="right__list-links">Вопросы и ответы</a>
						</li>
						<li class="right_list-elements">
							<a href="#" class="right__list-links">Стриптиз</a>
						</li>
						<li class="right_list-elements">
							<a href="#" class="right__list-links">Вакансии и коммерческие предложения</a>
						</li>
						<li class="right_list-elements">
							<a href="#" class="right__list-links">Ищут работу</a>
						</li>
						<li class="right_list-elements">
							<a href="#" class="right__list-links">Игрушки для хорошего секса</a>
						</li>
						<li class="right_list-elements">
							<a href="#" class="right__list-links">Мужские разговоры</a>
						</li>
						<li class="right_list-elements">
							<a href="#" class="right__list-links">Эротические истории</a>
						</li>
					</ul>
				</section>
		</div>
	</main>
</body>
</html>