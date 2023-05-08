<?php
// Подключение к базе данных
$host = "localhost";
$user = "root";
$password = "mysql";
$dbname = "ads";
$conn = mysqli_connect($host, $user, $password, $dbname);

// Проверка соединения
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Получаем значения из формы
$category_id = $_POST['add__select-category'];
$name = $_POST['name'];
$age = $_POST['age'];
$email = $_POST['email'];
$number = $_POST['phone-number'];
$site = $_POST['web-site'];
$country_id = $_POST['country'];
$header = $_POST['add__header'];
$text = $_POST['text-in-ad'];
$text = str_replace(["\r\n", "\r", "\n"], "\n", $text); // замена всех символов новой строки на \n
$text = preg_replace("/\n+/", "<br>", $text); // замена нескольких \n подряд на один <br>
$text = trim($text);

// переменная с папкой для фото
$folder_name = "uploads";

$new_file_name = '';
$new_file_names = [];

if($_FILES) {
	foreach ($_FILES["photos"]["error"] as $key => $error) {
			if ($error == UPLOAD_ERR_OK) {
				// 	// Получаем имя файла и его расширение
				$file_name = basename($_FILES["photos"]["name"][$key]);
				$file_ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
				// Генерируем уникальное имя файла
				$new_file_name = uniqid() . "." . $file_ext;
				// Полный путь к файлу
				$target_file = "uploads/" . $new_file_name;

				// Проверяем, является ли файл изображением
				$check = getimagesize($_FILES["photos"]["tmp_name"][$key]);
				if ($check === false) {
						echo "Файл не является изображением";
						exit;
				}

				// Проверяем размер файла

				if ($_FILES["photos"]["size"][$key] > 5000000) {
						echo "Файл слишком большой";
						exit;
				}

				$new_file_names[] = $new_file_name;

				$string = implode(', ', $new_file_names);

				$tmp_name = $_FILES["photos"]["tmp_name"][$key];
					move_uploaded_file($tmp_name, "$target_file");

			} else {
				echo "Ошибка <br>";
			}
	}
	echo "Файлы загружены <br>";
}


// Защита от SQL-инъекций
$category_id = mysqli_real_escape_string($conn, $category_id);
$name = mysqli_real_escape_string($conn, $name);
$age = mysqli_real_escape_string($conn, $age);
$email = mysqli_real_escape_string($conn, $email);
$number = mysqli_real_escape_string($conn, $number);
$site = mysqli_real_escape_string($conn, $site);
$country_id = mysqli_real_escape_string($conn, $country_id);
$header = mysqli_real_escape_string($conn, $header);
$text = mysqli_real_escape_string($conn, $text);

// Получаем id категории
$sql_category = "SELECT id FROM categories WHERE category_name = '$category_id'";
$result_category = mysqli_query($conn, $sql_category);
if ($result_category && mysqli_num_rows($result_category) > 0) {
    $row = mysqli_fetch_assoc($result_category);
    $category_id_db = $row['id'];
} else {
    // обработка ошибок, если категория не найдена
    mysqli_close($conn);
    die("Error: Category not found");
}

// Создание SQL-запроса
if (!empty($age)) {
	$age = mysqli_real_escape_string($conn, $age);
} else {
	$age = null;
}

if (!empty($number)) {
	$number = mysqli_real_escape_string($conn, $number);
} else {
	$number = null;
}

// Создание SQL-запроса
$sql = "INSERT INTO adss (category_id, name, age, email, number, site, country_id, text, filename, header, created_at) 
			VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, NOW())";

			echo $new_file_name . "<br>";

$stmt = mysqli_prepare($conn, $sql);

// Привязка параметров и выполнение запроса
mysqli_stmt_bind_param($stmt, "isssssisss", $category_id_db, $name, $age, $email, $number, $site, $country_id, $text, $string, $header);
if (mysqli_stmt_execute($stmt)) {
	echo "New record created successfully";
} else {
	echo "Error: " . mysqli_stmt_error($stmt);
}

// Закрытие соединения
mysqli_stmt_close($stmt);
mysqli_close($conn);
header('Location: index.php');
?>

