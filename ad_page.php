<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<?php
	// Устанавливаем параметры подключения к базе данных
	$dsn = 'mysql:host=localhost;dbname=ads';
	$username = 'root';
	$password = 'mysql';
	
	// Создаем объект PDO и устанавливаем режим ошибок на исключения
	$pdo = new PDO($dsn, $username, $password, [
			PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
	]);
	// Получаем имя пользователя и возраст из базы данных
	$id = $_GET['id']; // получаем id объявления из URL
	$sql = "SELECT name, age FROM adss WHERE id = :id";
	$stmt = $pdo->prepare($sql);
	$stmt->execute(['id' => $id]);
	$result = $stmt->fetch(PDO::FETCH_ASSOC);

	// Формируем заголовок страницы
	$title = $result['name'] . ' (' . $result['age'] . ')';

	// Выводим заголовок страницы
	echo "<title>$title</title>";
	?>
	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap" rel="stylesheet">
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.css">
	<link rel="stylesheet" href="https://unpkg.com/accordion-js@3.3.2/dist/accordion.min.css">
	<link rel="stylesheet" href="css/normalize.css">
	<link rel="stylesheet" href="css/main.css">
	<link rel="stylesheet" href="css/ad_page.css">
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
			<section class="ad">
				<div class="ad__border">
					<?php
					// Устанавливаем параметры подключения к базе данных
					$dsn = 'mysql:host=localhost;dbname=ads';
					$username = 'root';
					$password = 'mysql';

					// Создаем объект PDO и устанавливаем режим ошибок на исключения
					$pdo = new PDO($dsn, $username, $password, [
							PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
					]);

					if (isset($_GET["id"])) {
						$id = $_GET["id"];
						// Выполнить SQL-запрос для получения информации об объявлении
						$stmt = $pdo->prepare("SELECT adss.*, categories.category_name 
																	FROM adss 
																	JOIN categories ON adss.category_id = categories.id 
																	WHERE adss.id = ?");
						$stmt->execute([$id]);
						$row = $stmt->fetch(PDO::FETCH_ASSOC);

						echo "<div class='ad__main-header'>";
						echo "<p class='ad__category'>" . $row["category_name"] . " |" . "</p>";
						echo "<p class='ad__date'>" . "&nbsp;Дата: " . $row["created_at"] . " |" . "</p>";
						echo "<p class='ad__id'>" . "&nbsp;ID: " . $row["id"] . "</p>";
						echo "</div>";
						echo "<div class='ad__main'>";
						echo "<h2 class='ad__name'>" . $row["name"] . "(" . $row["age"] . ")" . "</h2>";
						echo "<p class='ad__descr'>" . $row["text"] . "</p>";
						// Выполнить SQL-запрос для получения всех фотографий объявления
						$stmt = $pdo->prepare("SELECT * FROM adss WHERE id = ?");
						$stmt->execute([$id]);
						$ad = $stmt->fetch(PDO::FETCH_ASSOC);

						// Получить имена файлов фотографий из формы filename
						$filenamesArray = explode(',', $ad["filename"]);

						// Если в объявлении только одна фотография, то выводим её без слайдера
						if (count($filenamesArray) <= 1) {
								echo "<div class='swiper-slide'>";
								echo "<img class='swiper-img img' src='uploads/" . $filenamesArray[0] . "' alt='" . $ad["name"] . "'>";
								echo "</div>";
						} else {
								// Иначе выводим слайдер
								// Выполнить SQL-запрос для получения всех фотографий объявления
								$stmt = $pdo->prepare("SELECT * FROM adss WHERE id = ?");
								$stmt->execute([$id]);
								$photos = $stmt->fetchAll(PDO::FETCH_ASSOC);

								// Выводим слайдер Swiper
								echo "<div class='swiper'>";
								echo "<div class='swiper-wrapper'>";
								foreach ($filenamesArray as $filename) {
										echo "<div class='swiper-slide'>";
										echo "<img class='swiper-img' src='uploads/" . trim($filename) . "' alt=''>";
										echo "</div>";
								}
								echo "</div>";
								echo "<div class='swiper-pagination'></div>";
								echo "<div class='swiper-button-next'></div>";
								echo "<div class='swiper-button-prev'></div>";
								echo "</div>";
						}
					}
						echo "</div>";
						// Информация об объявлении
						?>
						<div class="accordion-container">
							<div class="ac">
								<h2 class="ac-header">
									<button type="button" class="ac-trigger">Написать сообщение</button>
								</h2>
								<div class="ac-panel">
									<form action="" class="ac-form">
										<div class="ac__message-block">
											<div class="ac__mesage-label">
												<label for="message-input">Ваше имя:</label>
											</div>
											<div class="ac__message-input">
												<input type="text" name="ac__message-name">
											</div>
										</div>
										<div class="ac__message-block">
											<div class="ac__mesage-label">
												<label for="message-input">Email:</label>
											</div>
											<div class="ac__message-input">
												<input type="email" name="ac__message-email">
											</div>
										</div>
										<div class="ac__message-block">
											<div class="ac__mesage-label">
												<label for="message-input">Фотография:</label>
											</div>
											<div class="ac__message-input">
												<input type="file" name="ac__message-photo">
											</div>
										</div>
										<div class="ac__message-block">
											<div class="ac__mesage-label">
												<label for="message-input">Текст сообщения:</label>
											</div>
											<div class="ac__message-input">
												<input type="text" name="ac__message-text">
											</div>
										</div>
										<button class="btn-reset ac__message-btn">Отправить сообщение</button>
									</form>
								</div>
							</div>
						</div>
						<?php
						echo "<div class='ad__info'>";
						echo "<h2 class='ad__info-h2'>" . "Информация об объявлении:" . "</h2>";
						echo "<div class='ad__info-border'>";
						echo "<p class='ad__info-category'>" . "Категория: " . "<strong>" . $row["category_name"] . "</strong>" . "</p>";
						echo "<p class='ad__info-name'>" . "Имя: " . $row["name"] . "</p>";
						if ($row["age"] == null) {
								echo "<p class='ad__info-age'>" . "Возраст: не указан" . "</p>";
						} else {
								echo "<p class='ad__info-age'>" . "Возраст: " . $row["age"] . "</p>";
						}
						if ($row["number"] == null) {
								echo "<p class='ad__info-age'>" . "Номер телефона: не указан" . "</p>";
						} else {
								echo "<p class='ad__info-age'>" . "Номер телефона: " . "<a href='tel:" . $row["number"] . "'>" . $row["number"] . "</a>" . "</p>";
						}
						echo "<p class='ad__info-email'>" . "Email: " . "<a href='mailto:" . $row["email"] . "'>" . $row["email"] . "</a>" . "</p>";
						echo "<p class='ad__info-date'>" . "Дата добавления: " . $row["created_at"] . "</p>";
						echo "<p class='ad__info-id'>" . "ID объявления: " . $row["id"] . "</p>";
						echo "</div>";
						echo "</div>";
						// Закрываем соединение с базой данных
						$pdo = null;
						?>
				</div>
				<h2 class="ad__comm-h2">Комментарии к объявлению:</h2>
				<div class="ad__add-comm">
					<form action="" class="ad__comm-form">
						<h2 class="ad_comm-form-h2">Добавить новый комментарий:</h2>
						<div class="ad_comm-block">
							<div class="right__comment-block">
								<div class="ac__mesage-label">
									<label for="message-input">Ваше имя: <span class="red-star">*</span></label>
								</div>
								<div class="ac__message-input">
									<input type="text" name="ac__message-name">
								</div>
							</div>
							<div class="right__comment-block">
								<div class="ac__mesage-label">
									<label for="message-input">Текст комментария: <span class="red-star">*</span></label>
								</div>
								<div class="ac__message-input">
									<textarea class="right__comm-textarea" type="text" name="ac__message-text"></textarea>
								</div>
							</div>
							<button class="btn-reset right__comm-btn">Отправить комментарий</button>
						</div>
					</form>
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
	<script src="https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.js"></script>
	<script src="js/scripts/swiper.js"></script>
	<script src="https://unpkg.com/accordion-js@3.3.2/dist/accordion.min.js"></script>
	<script src="js/scripts/accordion.js"></script>
</body>
</html>
