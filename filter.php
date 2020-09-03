<?php
// if ($handle = opendir('./xmls')) {
//  while (false !== ($entry = readdir($handle))) {
//      if ($entry != "." && $entry != "..") {
//          echo "$entry\n";
//      }
//  }

//  closedir($handle);
// }

$path    = './dataset';
$savedpath    = './newdataset';
$files = scandir($path);
$files = array_diff(scandir($path), array('.', '..'));

foreach ($files as $file) {
    $fileImage = $path . "/".$file;
    $ext = pathinfo($fileImage, PATHINFO_EXTENSION);

    if ($ext == "jpeg" || $ext == "JPG" || $ext == "jpg") {
        $img = imagecreatefromjpeg($fileImage);
    } elseif ($ext == "png" || $ext == "PNG") {
        $img = imagecreatefrompng($fileImage);
    } else {
        continue;
    }
    // echo $ext;
    // echo "<br>";
    if($img && imagefilter($img, IMG_FILTER_BRIGHTNESS, 80) && imagefilter($img, IMG_FILTER_CONTRAST, -20)) // arg3 can be -255 to +255)
    {
        echo 'Image filtered.';
        echo "<br>";
        if ($ext == "jpeg" || $ext == "JPG" || $ext == "jpg") {
            imagejpeg($img, $savedpath . "/" . $file);
        } elseif ($ext == "png" || $ext == "PNG") {
            imagepng($img, $savedpath . "/" . $file);
        }
    }
    else
    {
        echo 'Filtering failed.';
    }
    imagedestroy($img);
}