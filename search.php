<?php
$servername = "127.0.0.1"; // или ваш сервер
$username = "root"; // замените на ваше имя пользователя
$password = ""; // замените на ваш пароль
$dbname = "books"; // замените на имя вашей базы данных

// Создание соединения
$conn = new mysqli($servername, $username, $password, $dbname);

// Проверка соединения
if ($conn->connect_error) {
    die("Ошибка подключения: " . $conn->connect_error);
}

if (isset($_POST['search'])) {
    $search = $_POST['search'];
    $search = mysqli_real_escape_string($conn, $search); 

    $sql = "SELECT * FROM Books WHERE
            Номер LIKE '%$search%' OR
            Наименование LIKE '%$search%' OR
            Автор LIKE '%$search%' OR
            Жанр LIKE '%$search%' OR
            Год_издания LIKE '%$search%' OR
            Издательство LIKE '%$search%'";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) > 0) {
        echo "<ul>"; // Начало списка
        while ($row = mysqli_fetch_assoc($result)) {
            echo "<li>";
            echo "<strong>Наименование:</strong> " . $row['Наименование'] . "<br>";
            echo "<strong>Автор:</strong> " . $row['Автор'] . "<br>";
            echo "<strong>Жанр:</strong> " . $row['Жанр'] . "<br>";
            echo "<strong>Год издания:</strong> " . $row['Год_издания'] . "<br>";
            echo "<strong>Издательство:</strong> " . $row['Издательство'] . "<br>";
            echo "</li><hr>"; // Разделитель между записями
        }
        echo "</ul>"; // Конец списка
    } else {
        echo "Результаты не найдены";
    }
} else {
    echo "Запрос на поиск не предоставлен";
}
?>