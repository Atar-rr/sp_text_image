<?php

function createImage(): string
{
    $imageLink = __DIR__ . '/img/banner.jpg';
    $font = __DIR__ . "/font/ptsans.ttf";
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

createImage();


//$conv = new Converter();
//try {
//    $conv->source(__DIR__ . '/index.html')
//        ->toPng()
//        ->save(__DIR__ . '/img/google.png');
//}catch (\Exception $e) {
//    echo  $e->getMessage();
//}

//$conv->source('http://localhost:8000/index.html')
//    ->toJpg()
//    ->save(__DIR__ . '/images/godogle.jpg');
//$test = $conv->source('<html><body><h1>Welcome to PhantomMagick</h1></body></html>');
//$conv->toJpg();
//$conv->save(__DIR__ . '/images/test.jpg');