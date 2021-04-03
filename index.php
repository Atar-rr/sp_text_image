<?php

function createImage()
{
    $imageLink = __DIR__ . '/img/banner.jpg';
    $font = __DIR__ . "/font/ptsans.ttf";
    $imageCoverLink = 'https://img2.pngio.com/transparent-grey-background-png-6-png-image-grey-background-png-1920_1080.png';
    $logoLink = __DIR__ . '/img/logo.png';
    $newImageName = generateRandomName();
    $newImagePath = __DIR__  . '/tmp/' . $newImageName . '.png';

    $title = 'Анна Махмудова: ';
    $titleSize = 45;
    $xTitle = 30;
    $yTitle = 250;

    $text = 'Анна Махмудова: !';
    $textSize = 26;
    $xText = 30;
    $yText= 350;

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

    //разбиваем на строки и считываемих кол-во
    [$title, $countLineTitle] = explodeText($title,35);
    [$text, ] = explodeText($text,58);
    if ($countLineTitle > 1) {
        $yText += $countLineTitle * $titleSize;
    }

    //накладываем заголовок
    imagettftext($image, $titleSize, $angle, $xTitle, $yTitle, $color, $font, $title);

    //накладываем текст
    imagettftext($image, $textSize, $angle, $xText, $yText, $color, $font, $text);

    //сохраняем изображение во временный файл
    imagepng($image, $newImagePath);

    //получаем инф о получившемся изображение
    $imgInfo = getimagesize($newImagePath);
    $imgSize = filesize($newImagePath);

    //записыаем данные в $_FILES
    $_FILES[] = [
        'name' => $newImageName,
        'type' => $imgInfo['mime'],
        'tmp_name' => $newImagePath,
        'error' => 0,
        'size' => $imgSize,
    ];

    //уничожаем изображение над которым работали
    imagedestroy($image);
}

function explodeText($text, $maxChar)
{
    $line = '';
    $return = '';
    $text = explode(' ', $text);
    $count = count($text);
    $countLines = 0;

    for ($i = 0; $i < $count; $i++) {
        $len = mb_strlen($line) + mb_strlen($text[$i]);
        if ($i === $count - 1 || $len >= $maxChar) {
            $return .= trim($line, ' ') . "\n";
            $countLines++;
            $line = '';
        }
        $line .= $text[$i] . ' ';
    }

    return [$return, $countLines];
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
