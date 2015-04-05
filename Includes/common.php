<?php

    define("STOCK_IMAGE_SRC", "images/stock_image.png");

    function getImageSrc($imagesrc) {
        if (is_null($imagesrc) || $imagesrc == "") {
            return STOCK_IMAGE_SRC;
        } else {
            return $imagesrc;
        }
    }

    function alert($type, $error_text) {
        if ($type == "success") {
            echo '<div class="alert alert-success" role="alert">' . $error_text . '</div>';
        } elseif ($type == "failure") {
            echo '<div class="alert alert-danger" role="alert">' . $error_text . '</div>';
        }
    }

?>