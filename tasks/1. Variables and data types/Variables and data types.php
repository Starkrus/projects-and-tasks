<?php

//1. Создайте переменную типа integer и присвойте ей значение.

$number = 5;

//2. Создайте переменную типа float и присвойте ей значение.

$number = 2.5;

//3. Создайте переменную типа string и присвойте ей значение.

$str = "5";

//4. Создайте переменную типа boolean и присвойте ей значение.

$isAdult = true;
$isAdult1 = false;

//5. Создайте переменную типа array и присвойте ей значение.

$arr = ['name', 'age'];

//6. Напишите скрипт, который выводит на экран тип данных любой переменной.

var_dump($str) . PHP_EOL;

//7. Напишите скрипт, который конвертирует переменную из одного типа в другой.

$num = (int)"5";
var_dump(gettype($num)) . PHP_EOL;

//8. Напишите скрипт, который определяет, является ли переменная числом.

$num1 = 5;
var_dump(is_int($num1)) . PHP_EOL;

//9. Напишите скрипт, который определяет, является ли переменная строкой.

$str1 = "5";
var_dump(is_string($str1)) . PHP_EOL;

//10. Напишите скрипт, который проверяет, существует ли переменная.

$number2 = 1;
var_dump(isset($number2));
