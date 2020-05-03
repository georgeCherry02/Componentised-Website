<?php
    class Header implements Component {
        private $_containing_page;

        public function __construct($containing_page) {
            $this->_containing_page = $containing_page;
        }

        public function render() {
            $css_links = $this->_containing_page->getCSSPaths();
            $script_links = $this->_containing_page->getScriptPaths();
            $html = "<!DOCTYPE html>"
                  .     "<html lang=\"en\">"
                  .         "<head>"
                                // Add page title
                  .             "<title>".WEBSITE_NAME." | ".$this->_containing_page->getTitle()."</title>"
                                // Add core stylesheet
                  .             "<link rel='stylesheet' type='text/css' href='./base/css/main.css'/>";
            for ($i = 0; $i < sizeof($css_links); $i++) {
                                // Add each component stylesheet
                $html .=        "<link rel='stylesheet' type='text/css' href='".$css_links[$i]."'/>";
            }
            for ($i = 0; $i < sizeof($script_links); $i++) {
                                // Add the scripts for each component
                $html .=        "<script src='".$script_links[$i]."'></script>";
            }
                                // Include requirements for Bootstrap
                                // Meta tags
            $html.=             "<meta charset=\"utf-8\">"
                  .             "<meta name=\"viewport\" content=\"width=device-width, initial-scale=1, shrink-to-fit=no\">"
                                // Include link to Bootstrap CSS
                  .             "<link rel=\"stylesheet\" href=\"https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css\" integrity=\"sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh\" crossorigin=\"anonymous\">"
                  .         "</head>"
                  .         "<body>";
            return $html;
        }
        public function getCategory() {
            return ComponentCategories::Base();
        }
        public function getScriptPaths() {
            return array();
        }
    }
?>