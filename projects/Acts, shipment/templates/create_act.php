<?php
// Подключаемся к базе данных
$mysqli = require_once '../connect/db.php';

// Проверяем, отправлена ли форма
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Получаем данные из формы
    $itemNames = $_POST['item_name'];
    $itemCounts = $_POST['item_count'];
    $itemSent = $mysqli->real_escape_string($_POST['item_sent']);
    $itemDate = $mysqli->real_escape_string($_POST['item_date']);
    $itemReceived = $mysqli->real_escape_string($_POST['item_received']);
    $itemComments = $mysqli->real_escape_string($_POST['item_comments']);

    // Выполняем запрос на вставку данных в базу данных
    $actId = null;

    // Сначала добавляем основной акт, чтобы получить его ID
    $actSql = "INSERT INTO acts (sent, date, received, comments) VALUES ('$itemSent', '$itemDate', '$itemReceived', '$itemComments')";

    if ($mysqli->query($actSql)) {
        $actId = $mysqli->insert_id; // Получаем ID нового акта

        // Теперь добавляем товары в этот акт
        foreach ($itemNames as $index => $itemName) {
            $itemNameEscaped = $mysqli->real_escape_string($itemName);
            $itemCount = intval($itemCounts[$index]);

            $sql = "INSERT INTO act_items (act_id, name, count) VALUES ($actId, '$itemNameEscaped', $itemCount)";

            if (!$mysqli->query($sql)) {
                echo "Ошибка: " . $sql . "<br>" . $mysqli->error;
                break; // Прерываем цикл в случае ошибки
            }
        }

        // Перенаправляем на страницу документов после успешной вставки
        header("Location: ../public/index.php");
        exit();
    } else {
        echo "Ошибка создания акта: " . $mysqli->error;
    }
}

// Закрытие подключения
$mysqli->close();
?>
