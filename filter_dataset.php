<?php
// Dibuat untuk memfilter gambar yang ngga di kasih label
$files = glob('./fixdataset/xml/*.xml');

// rename('IMG_1519.*', 'IMG_1519.jpg');
foreach ($files as $xml) {
    $filename = basename($xml, ".xml"); // $file is set to "index"
    $images = glob("./fixdataset/$filename.*"); // Will find 2.txt, 2.php, 2.gif

    if (empty($images)) {
        print_r("Copy dari dataset - ");
        $imagesToBeCopy = glob("./dataset/$filename.*"); // Will find 2.txt, 2.php, 2.gif
        
        // Ngambil dari/dataset terus pindah ke /fixdataset
        foreach ($imagesToBeCopy as $imgTBC) {
            $ext = pathinfo($imgTBC, PATHINFO_EXTENSION);
            copy($imgTBC, "./fixdataset/$filename.$ext");
        }
        rename('IMG_1519.*', 'IMG_1519.jpg');
    }
    // Pindahin ke /fixdataset/images
    foreach ($images as $img) {
        $ext = pathinfo($img, PATHINFO_EXTENSION);
        rename($img, "./fixdataset/images/$filename.$ext");
    }
    print_r($filename);
    echo "<br>";
    print_r($images);
    print_r("<hr>");
}

//print_r($files);
