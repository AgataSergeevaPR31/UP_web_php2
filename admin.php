<?php
// admin.php

// Настройки подключения к базе данных
$servername = "127.0.0.1"; // или ваш сервер базы данных
$username = "root"; // замените на ваше имя пользователя
$password = ""; // замените на ваш пароль
$dbname = "books"; // имя вашей базы данных

// Создание подключения
$conn = new mysqli($servername, $username, $password, $dbname);

// Проверка подключения
if ($conn->connect_error) {
    die("Ошибка подключения: " . $conn->connect_error);
}

// Получение данных из формы
$naimenovanie = $_POST['title']; // Наименование
$avtor = $_POST['author']; // Автор
$zhanr = $_POST['genre']; // Жанр
$god_izdaniya = (int)$_POST['year']; // Год издания
$izdatelstvo = $_POST['house']; // Издательство

// Подготовка SQL-запроса
$sql = "INSERT INTO `Books` (`Наименование`, `Автор`, `Жанр`, `Год_издания`, `Издательство`) 
        VALUES (?, ?, ?, ?, ?)";
$stmt = $conn->prepare($sql);

// Проверка на успешность подготовки запроса
if ($stmt === false) {
    die("Ошибка подготовки запроса: " . $conn->error);
}

// Привязка параметров
$stmt->bind_param("sssss", $naimenovanie, $avtor, $zhanr, $god_izdaniya, $izdatelstvo);

// Выполнение запроса
if ($stmt->execute()) {
    echo "<script> 
            alert('Добавление произошло успешно!'); 
            window.location.href = 'login.html';
          </script>";
} else {
    echo "<div style='color: red; font-weight: bold;'>Ошибка при вставке в таблицу: " . $stmt->error . "</div>";
}

// Закрытие соединения
$stmt->close();
$conn->close();
?>
