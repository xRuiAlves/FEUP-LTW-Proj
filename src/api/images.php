<?php
    function validateImage($img) {
        $img_max_size = ini_get('upload_max_filesize');
        $img_size = $img["size"];
        $img_type = $img["type"];
        $img_error = $img["error"];

        if ($img_error == 1) {
            return "image is too big - max accepted size is $img_max_size bytes";
        }

        if ($img_error) {
            return "failed to upload image";
        }
        
        if ($img_size === 0) {
            return "image is empty";
        } 

        if (!isImageTypeValid($img_type)) {
            return "invalid image type - only png and jpeg formats are accepted";
        }

        return "valid";
    }

    function isImageTypeValid($mime_type) {
        return ($mime_type === "image/png" ||
                $mime_type === "image/jpeg");
    }

    function getImageExtension($mime_type) {
        $mime_type_parts = explode("/", $mime_type);
        return $mime_type_parts[1];
    }

    function uploadUserImage($img, $user_id) {
        $extension = getImageExtension($img["type"]);
        $image_file = $img["tmp_name"];

        $original = null;
        if ($extension ==="jpeg") {
            $original = imagecreatefromjpeg($image_file);
        } else if ($extension === "png") {
            $original = imagecreatefrompng($image_file);
        } else {
            return;
        }

        $original_width = imagesx($original);
        $original_height = imagesy($original);
        $crop_size = min($original_width, $original_height);

        $small_image_size = 64;
        $small_image = imagecreatetruecolor($small_image_size, $small_image_size);
        imagecopyresized(
            $small_image, 
            $original, 
            0, 0, 
            ($original_width > $crop_size) ? ($original_width - $crop_size)/2 : 0, 
            ($original_height > $crop_size) ? ($original_height - $crop_size)/2 : 0, 
            $small_image_size, $small_image_size, 
            $crop_size, $crop_size
        );

        $big_image_size = 512;
        $big_image = imagecreatetruecolor($big_image_size, $big_image_size);
        imagecopyresized(
            $big_image, 
            $original, 
            0, 0, 
            ($original_width > $crop_size) ? ($original_width - $crop_size)/2 : 0, 
            ($original_height > $crop_size) ? ($original_height - $crop_size)/2 : 0, 
            $big_image_size, $big_image_size, 
            $crop_size, $crop_size
        );

        $small_path = "../db/images/user" . $user_id . "_small";
        $big_path = "../db/images/user" . $user_id . "_big";
        $target_small_file = $small_path . "." . $extension;
        $target_big_file = $big_path . "." . $extension;

        // delete old files if existant
        if (file_exists($small_path . ".jpeg")) {
            unlink($small_path . ".jpeg");
        }
        if (file_exists($small_path . ".png")) {
            unlink($small_path . ".png");
        }
        if (file_exists($big_path . ".jpeg")) {
            unlink($big_path . ".jpeg");
        }
        if (file_exists($big_path . ".png")) {
            unlink($big_path . ".png");
        }

        if ($extension === "jpeg") {
            imagejpeg($small_image, $target_small_file);
            imagejpeg($big_image, $target_big_file);
        } else if ($extension === "png") {
            imagepng($small_image, $target_small_file);
            imagepng($big_image, $target_big_file);
        }
    }

    function uploadStoryImage($img, $story_id) {
        $extension = getImageExtension($img["type"]);
        $target_file = "../db/images/story" . $story_id . "." . $extension;

        if (move_uploaded_file($img["tmp_name"], $target_file)) {
            return "uploaded";
        } else {
            return "failed to upload image";
        }
    }

    function api_getUserImgJSON($user_id, $size) {
        if ($size !== "small" && $size !== "big") {
            return null;
        }

        $relative_file_path = "/db/images/user" . $user_id . "_" . $size;
        $file_path = '..' . $relative_file_path;
        $isJpeg = file_exists($file_path . ".jpeg");
        $relative_file_path = $relative_file_path . ($isJpeg ? ".jpeg" : ".png");
        
        return ["user_img_".$size => $relative_file_path];
    }

    function api_getStoryImgJSON($story_id) {
        $relative_file_path = "/db/images/story" . $story_id;
        $file_path = '..' . $relative_file_path;
        
        if (file_exists($file_path . ".jpeg")) {
            $relative_file_path = $relative_file_path . ".jpeg";
            $file_path = $file_path . ".jpeg";
        } else if (file_exists($file_path . ".png")) {
            $relative_file_path = $relative_file_path . ".png";
            $file_path = $file_path . ".png";
        } else {
            return null;
        }

        list($img_width, $img_height) = getimagesize($file_path);
        
        return [
            "story_img" => $relative_file_path,
            "story_img_width" => $img_width,
            "story_img_height" => $img_height
        ];
    }
?>