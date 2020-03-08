<?php

$postgres =  new PDO('pgsql:host=localhost;port=5432;dbname=velohub', 'homestead', 'secret');

foreach($postgres->query('SELECT * FROM products JOIN skus ON skus.product_id = products.id
    WHERE products.seo_keywords IS NOT NULL ORDER BY products.id DESC LIMIT 100') as $row) {

    $newId = $row['id'];
    $prodId = $row['product_id'];
    $id = intval($row['seo_keywords']);
    $img = 'photo/big/' . $id . '.jpg';

    //print_r($row);

    if(!file_exists($img)) {
        echo $img . '<br>';
        $query = "UPDATE products SET seo_keywords = NULL WHERE id = " . $prodId;
        $stmt = $postgres->prepare($query);
        $stmt->execute();

        continue;
    }

    $hash = (string)base_convert(md5_file($img), 16, 10);
    $ext = pathinfo($img, PATHINFO_EXTENSION);
    $basePath = 'media/pt/';
    $imgPath = '';

    for($i = 0; $i < 5; $i++) {
        $imgPath .= substr($hash, $i * 2, 2);

        if(!file_exists($basePath.$imgPath)) {
            mkdir($basePath.$imgPath);
            chmod($basePath.$imgPath, 0777);
        }
        $imgPath .= '/';
    }

    $imgPath .= $newId;

    if(!file_exists($basePath.$imgPath)) {
        mkdir($basePath.$imgPath);
        chmod($basePath.$imgPath, 0777);
    }
    $imgPath .= '/';

    $fullPath = $imgPath . $row['latin'] . '.' . $ext;
    $thumbPath = $imgPath . $row['latin'] . '-md';

    copy($img, $basePath.$fullPath);
    chmod($basePath.$fullPath, 0777);

    ResizeImage(500, $img, $basePath.$thumbPath);
    chmod($basePath.$thumbPath . '.' . $ext, 0777);

    $query = "UPDATE products SET images = ?, seo_keywords = ? WHERE id = " . $prodId;
    $stmt = $postgres->prepare($query);
    $stmt->execute([json_encode([0 => $fullPath]), null]);

    $query = "UPDATE skus SET images = ? WHERE id = " . $newId;
    $stmt = $postgres->prepare($query);
    $stmt->execute([json_encode([0 => $fullPath])]);

    echo $fullPath . '<br>';
}


function ResizeImage($newSize, $originalFile, $targetFile) {
    $info = getimagesize($originalFile);
    $mime = $info['mime'];

    switch ($mime) {
        case 'image/jpeg':
            $image_create_func = 'imagecreatefromjpeg';
            $image_save_func = 'imagejpeg';
            $new_image_ext = 'jpg';
            break;

        case 'image/png':
            $image_create_func = 'imagecreatefrompng';
            $image_save_func = 'imagejpeg';
            $new_image_ext = 'jpg';
            break;

        case 'image/gif':
            $image_create_func = 'imagecreatefromgif';
            $image_save_func = 'imagejpeg';
            $new_image_ext = 'jpg';
            break;

        default:
            return '';
    }

    $img = $image_create_func($originalFile);
    list($width, $height) = getimagesize($originalFile);

    if($width > $height)
    {
        $newWidth = $newSize;
        $newHeight = $height/($width/$newSize);
    }
    else
    {
        $newHeight = $newSize;
        $newWidth = $width/($height/$newSize);
    }

    $tmp = imagecreatetruecolor($newWidth, $newHeight);

    $red = imagecolorallocate($tmp, 255, 255, 255);
    imagefill($tmp, 0, 0, $red);

    imagecopyresampled($tmp, $img, 0, 0, 0, 0, $newWidth, $newHeight, $width, $height);

    if (file_exists($targetFile)) {
        unlink($targetFile);
    }
    $image_save_func($tmp, "$targetFile.$new_image_ext");
}




