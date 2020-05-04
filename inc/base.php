<?php
    // Include Constants
    include_once "../inc/constants.php";

    // Include all default classes
    foreach (glob("../inc/classes/*.php") as $file) {
        include_once $file;
    }
    // Include all default enums
    foreach (glob("../inc/enums/*.php") as $file) {
        include_once $file;
    }
    // Include all default page components
    foreach (glob("../inc/components/*.php") as $file) {
        include_once $file;
    }

    // Declare all pages
    $home_page = new Page("Home", "Welcome!", "default", ComponentCategories::Base());
    $test_page_1 = new Page("Test 1", "Test Page", "test1", ComponentCategories::Base());
    $test_page_2 = new Page("Test 2", "Test Page", "test2", ComponentCategories::Base());
    $test_page_3 = new Page("Test 3", "Test Page", "test3", ComponentCategories::Base());
    // Define the website structure
    $website_structure = array("default" => $home_page, "test1" => $test_page_1, "Test Group Name" => array("test2" => $test_page_2, "test3" => $test_page_3));
    // Build the pages up with components...
    $home_page->addComponent(new NavBar($website_structure, $home_page));

    Text::header("Test Header 1");
    Text::sub_header("Test Subheader 1");
    $text1 = Text::create(array("This is a test set of text", "Hopefully this'll work even if it's a bit large"));
    $home_page->addComponent($text1);
    Text::header("Test Header 2");
    $text2 = Text::create(array("This is the second body of the text"));
    $home_page->addComponent($text2);

    // Set initial location
    $location = array("default");
?>