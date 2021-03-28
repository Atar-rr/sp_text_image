<?php

function createImage(): string
{
    $imageLink = __DIR__ . '/img/banner.jpg';
    $font = __DIR__ . "/font/ptsans.ttf";
    $imageCoverLink = 'https://img2.pngio.com/transparent-grey-background-png-6-png-image-grey-background-png-1920_1080.png';
    $logoLink = __DIR__ . '/img/logo.png';
    $newImageName = __DIR__  . '/tmp/' . generateRandomName() . '.png';

    $title = 'Пользуясь случаем';
    $titleSize = 40;
    $xTitle = 30;
    $yTitle = 200;

    $text = 'Анна Махмудова: Сенсорная комната для детей! Проект Гармония';
    $textSize = 20;
    $xText = 50;
    $yText= 300;

    $angle = 0;

    // получаем изображение
    $image = imagecreatefromjpeg($imageLink);

    //получаем фильтр для затемнения
    $imageCover = imagecreatefrompng($imageCoverLink);

    //получем лого
    $logo = imagecreatefrompng($logoLink);

    //накладываем затемнение
    imagealphablending($imageCover, true);
    imagesavealpha($imageCover, true);
    imagealphablending($image, true);
    imagesavealpha($image, true);
    imagecopy($image, $imageCover, 0, 0, 0, 0, imagesx($imageCover), imagesy($imageCover));

    //накладываем лого
    imagealphablending($logo, true);
    imagesavealpha($logo, true);
    imagealphablending($image, true);
    imagesavealpha($image, true);
    imagecopy($image, $logo, 44, 44, 0, 0, imagesx($logo), imagesy($logo));

    //создаем цвет надписи
    $color = imagecolorallocate($image, 0xFF, 0xFF, 0xFF);

    //накладываем заголовок
    imagettftext($image, $titleSize, $angle, $xTitle, $yTitle, $color, $font, $title);

    //накладываем текст
    imagettftext($image, $textSize, $angle, $xText, $yText, $color, $font, $text);

    //сохраняем изображение во временный файл
    imagepng($image, $newImageName);

    //получаем изображение
    $data = file_get_contents($newImageName);

    //удаляем временный файл
//    unlink($newImageName);

    //уничожаем изображение над которым работали
    imagedestroy($image);

    //возвращем изображение в base64
    return "data:image/png;base64," . base64_encode($data);
}

function generateRandomName(int $length = 10): string
{
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[random_int(0, $charactersLength - 1)];
    }
    return $randomString;
}
