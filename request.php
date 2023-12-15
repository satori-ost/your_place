<?php
$message = ""; // Ініціалізуємо змінну повідомлення перед її використанням

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $servername = "localhost";
    $username = "root"; // Ваше ім'я користувача MySQL
    $password = "root"; // Ваш пароль MySQL
    $dbname = "local"; // Назва вашої бази даних

    // Отримання даних з форми
    $first_name = $_POST["first_name"];
    $last_name = $_POST["last_name"];
    $phone_number = $_POST["phone_number"];
    $project_details = $_POST["project_details"];

    // Перевірка на заповненість полів
    if (!empty($first_name) && !empty($last_name) && !empty($phone_number) && !empty($project_details)) {
        // Підключення до бази даних
        $conn = new mysqli($servername, $username, $password, $dbname);

        // Перевірка з'єднання
        if ($conn->connect_error) {
            die("Помилка з'єднання з базою даних: " . $conn->connect_error);
        }

        // Підготовка SQL-запиту для вставки даних у таблицю
        $sql = "INSERT INTO request (firstname, lastname, phone_number, project_info)
        VALUES ('$first_name', '$last_name', '$phone_number', '$project_details')";

        // Виконання SQL-запиту
        if ($conn->query($sql) === TRUE) {
            $message = "Заявка успішно відправлена";
        } else {
            $message = "Помилка при відправці заявки: " . $conn->error;
        }

        // Закриття з'єднання з базою даних
        $conn->close();
    } else {
        $message = "Будь ласка, заповніть усі поля форми";
    }
}
?>
