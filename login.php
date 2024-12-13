<?php
$servername = "127.0.0.1"; // или ваш сервер
$username = "root"; // замените на ваше имя пользователя
$password = ""; // замените на ваш пароль
$dbname = "books"; // имя вашей базы данных

// Создание соединения
$conn = new mysqli($servername, $username, $password, $dbname);

// Проверка соединения
if ($conn->connect_error) {
    die("Ошибка подключения: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Получаем данные из формы
    $login = $_POST['login'];
    $password = $_POST['password'];

    // SQL запрос для проверки существования логина и получения роли
    $sql = "SELECT `Пароль`, `Роль` FROM `Авто` WHERE `Логин` = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $login);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Логин существует, проверяем пароль
        $row = $result->fetch_assoc();
        if (password_verify($password, $row['Пароль'])) {
            // Пароль верный, проверяем роль
            if ($row['Роль'] == 'Админ') {
                // Перенаправляем на страницу администратора
                header("Location: admin.html");
                exit();
            } else {
                // Перенаправляем на страницу пользователя
                header("Location: search.html");
                exit();
            }
        } else {
            // Неправильный пароль
            echo "<script>
                    alert('Неправильный пароль');
                    window.location.href = 'login.html';
                  </script>";
        }
    } else {
        // Логин не существует
        echo "<script>
                alert('Такого логина нет. Зарегистрируйтесь');
                window.location.href = 'login.html';
              </script>";
    }

    $stmt->close(); // Закрываем подготовленный запрос
}

$conn->close(); // Закрываем соединение
?>