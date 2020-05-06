<?php
    include_once "../inc/base.php";

    if (isset($_GET["loc"])) {
        $_SESSION["Location"] = $_GET["loc"];
        header("Location: default.php");
    }

    $page = $website_structure["default"];
    if (isset($_SESSION["Location"])) {
        foreach ($website_structure as $tls_name => $tls) {
            if ($tls instanceof Page) {
                if ($tls_name === $_SESSION["Location"]) {
                    $page = $tls;
                    $found_page = true;
                }
            } else if (gettype($tls) === "array") {
                foreach ($website_structure[$tls_name] as $sls_name => $sls) {
                    if ($sls_name === $_SESSION["Location"]) {
                        $page = $sls;
                        $found_page = true;
                    }
                }
            }
            if ($found_page) {
                break;
            }
        }
    }

    echo $page->render();
?>