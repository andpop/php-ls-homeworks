<?php
ini_set('error_reporting', E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);


require "vendor/autoload.php";

use Intervention\Image\ImageManagerStatic as IImage;

$sourceFile = 'source.jpg';
$rotatedFile = 'rotated.jpg';
$resizedFile = 'resized.jpg';
$watermarkedFile = 'watermarked.jpg';

//phpinfo();

IImage::make($sourceFile)
    ->rotate(45)
    ->save($rotatedFile, 80);

IImage::make($rotatedFile)
    ->resize(200, null, function ($image) {
        $image->aspectRatio();
    })
    ->save($resizedFile);

$image = IImage::make($resizedFile);
$image->text("Очкарик", $image->width()/2,$image->height()/2,
                function ($font) {
                $font->file('./arial.ttf');
                $font->size(36);
                $font->color(array(255, 0, 0, 0.5));
                $font->align('center');
                $font->valign('center');
        });
$image->save($watermarkedFile);


?>
<h1>Было</h1>
<img src="source.jpg" alt="">
<h1>Перевернули на 45 градусов</h1>
<img src="rotated.jpg" alt="">
<h1>Ужали на 200</h1>
<img src="resized.jpg" alt="">
<h1>Добавили надпись</h1>
<img src="watermarked.jpg" alt="">
