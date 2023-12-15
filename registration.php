<?php
$message = ""; // Ініціалізуємо змінну повідомлення перед її використанням

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $full_name = $_POST["full_name"];
    $password = $_POST["password"];

    if (!empty($full_name) && !empty($password)) {
        // Підключення до локальної бази даних
        $servername = "localhost"; 
        $username = "root"; 
        $db_password = "root"; 
        $dbname = "local"; 
        
        $conn = new mysqli($servername, $username, $db_password, $dbname);
        
        // Перевірка з'єднання
        if ($conn->connect_error) {
            die("Помилка з'єднання: " . $conn->connect_error);
        }
        
        // Перевірка чи існує користувач з таким же ім'ям
        $check_existing_user = "SELECT * FROM users WHERE username = '$full_name'";
        $result = $conn->query($check_existing_user);
        
        if ($result->num_rows > 0) {
            $message = "Користувач з таким іменем вже існує";
        } else {
            // Підготовка запиту на додавання користувача до локальної бази даних
            $sql = "INSERT INTO users (username, password) VALUES ('$full_name', '$password')";
        
            if ($conn->query($sql) === TRUE) {
                $message = "Реєстрація пройшла успішно!";
            } else {
                $message = "Помилка при реєстрації: " . $conn->error;
            }
        }

        // Закриття з'єднання з локальною базою даних
        $conn->close();
    } else {
        $message = "Будь ласка, заповніть усі поля форми.";
    }
}
?>
