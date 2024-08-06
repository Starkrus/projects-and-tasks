<?php
// Параметры подключения к базе данных
$server = 'localhost'; // Хост сервера базы данных
$username = 'root';    // Имя пользователя для подключения к базе данных
$password = '';        // Пароль для подключения к базе данных
$dbname = 'act';       // Имя базы данных

// Создание подключения
$mysqli = new mysqli($server, $username, $password, $dbname);

// Проверка соединения
if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

// Возвращаем объект подключения
return $mysqli;

