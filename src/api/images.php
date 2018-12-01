<?php 
    function validateImage($img) {
        $img_max_size = 256000;  // in bytes
        $img_size = $img["size"];
        $img_type = $img["type"];
        
        if ($img_size === 0) {
            return "image is empty";
        } else if ($img_size > $img_max_size) {
            return "image is too big - max accepted size is $img_max_size bytes";
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

    function uploadImage($img, $img_name) {
        $extension = getImageExtension($img["type"]);
        $target_file = $_SERVER["DOCUMENT_ROOT"] . "/db/images/" . $img_name . "." . $extension;

        if (move_uploaded_file($img["tmp_name"], $target_file)) {
            return "uploaded";
        } else {
            return "failed to upload image";
        }
    }

    function api_getUserImgJSON($user_id) {
        $relative_file_path = "/db/images/user" . $user_id;
        $file_path = $_SERVER["DOCUMENT_ROOT"] . $relative_file_path;
        $isJpeg = file_exists($file_path . ".jpeg");
        $relative_file_path = $relative_file_path . ($isJpeg ? ".jpeg" : ".png");
        
        return ["user_img" => $relative_file_path];
    }

    function api_getStoryImgJSON($story_id) {
        $relative_file_path = "/db/images/story" . $story_id;
        $file_path = $_SERVER["DOCUMENT_ROOT"] . $relative_file_path;
        
        if (file_exists($file_path . ".jpeg")) {
            $relative_file_path = $relative_file_path . ".jpeg";
        } else if (file_exists($file_path . ".png")) {
            $relative_file_path = $relative_file_path . ".png";
        } else {
            return null;
        }
        
        return ["story_img" => $relative_file_path];
    }
?>