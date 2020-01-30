<?php
date_default_timezone_set("Europe/Moscow");
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
header('Content-type: text/html; charset=utf-8');

/**
 * Выводит на  экран результат совпадений с заданной строкой поиска.
 * @param $lines
 * @param $search
 */
function getResultSearchByFile($lines, $search)
{
    foreach ($lines as $line_num => $line) {
        $matches = mb_strpos($line, $search, 0, 'UTF-8');
        if ($matches !== false) {
            echo "Строка #<b>" . ($line_num + 1) . "</b>" .
                " Cимвол #<b> " . ($matches + 1) . "</b> : " .
                htmlspecialchars($search) . "<br />\n";
        }
    }
}

/**
 * Проверяет файл на соответствие параметрам и доступности файла для чтения
 * @param $fileName
 * @param $params
 * @return bool
 */
function checkFile($fileName, $params)
{
    if (!file_exists($fileName)) {
        die("Внимание! Файл $fileName не найден!");
    }
    if (!in_array(mime_content_type($fileName), $params['mime-type'])) {
        die("Внимание! Неподдерживаемый формат");
    }
    if (!is_readable($fileName)) {
        die("Внимание! Этот файл $fileName невозможно прочесть!");
    }
    if (filesize($fileName) > $params['maxSize']) {
        die("Внимание! Ограничение по размеру файла " . $params['maxSize'] . " бит!");
    }
    return true;
}

// Файл для обработки
$fileName = "base1.txt";

// Строка поиска
$search = 'он';

// Параметры файла
$params = require "config.php";

checkFile($fileName, $params);
$file = file($fileName);
getResultSearchByFile($file, $search);