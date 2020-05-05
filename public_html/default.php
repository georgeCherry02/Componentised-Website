<?php
    include_once "../inc/base.php";
    $current_page = $website_structure[$location[0]];
    for ($i = 1; $i < sizeof($location); $i++) {
        $current_page = $current_page[$location[$i]];
    }
    echo $current_page->render();
?>