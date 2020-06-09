<?php

class UploadImage
{
    public static function Upload($data)
    {
        if (isset($_FILES["gambar"])) {
            $namagambar = $_FILES["gambar"]["name"];
            $tmpname = $_FILES["gambar"]["tmp_name"];
            $error = $_FILES["gambar"]["error"];
            $sizegambar = $_FILES["gambar"]["size"];

            if ($error == 4) {
                echo "<script>
    alert('pilih gambar terlebih dahulu')
    document.location.href=''; 
    </script>";
                return false;
            }

            $extensivalid = ["jpg", "jpeg", "png"];
            $extensigambar = explode(".", $namagambar);
            $extensigambar = strtolower(end($extensigambar));

            if (!in_array($extensigambar, $extensivalid)) {
                echo "<script>
    alert('Format Gambar Salah!');
    </script>";
                return false;
                exit;
            }

            if ($sizegambar > 6000000) {
                echo "<script>
    alert('Size gambar terlalu besar')
    document.location.href=document.referrer; 
    </script>";
                return false;
                exit;
            }

            $defaultnamagambar = uniqid();
            $defaultnamagambar .= ".";
            $defaultnamagambar .= $extensigambar;


            // move_uploaded_file($tmpname, "img/" . $defaultnamagambar);
            UploadImage::compressImage($tmpname,  $_SERVER['DOCUMENT_ROOT'] . "/mvckembangteratai/public/img/" . $defaultnamagambar, 60);
            return $defaultnamagambar;
        } else {
            return false;
            exit;
        }
    }

    public static function compressImage($source, $destination, $quality)
    {
        $info = getimagesize($source);

        if ($info['mime'] == 'image/jpeg')
            $image = imagecreatefromjpeg($source);

        elseif ($info['mime'] == 'image/gif')
            $image = imagecreatefromgif($source);

        elseif ($info['mime'] == 'image/png')
            $image = imagecreatefrompng($source);

        imagejpeg($image, $destination, $quality);
    }
}
