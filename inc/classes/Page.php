<?php
    class Page {
        private $_name;
        private $_title;
        private $_root;
        private $_page_category;
        private $_components = array();

        private $_header;
        private $_footer;

        public function __construct($name, $title, $root, $page_category) {
            $this->_name = $name;
            $this->_title = $title;
            $this->_root = $root;
            $this->_page_category = $page_category;

            $this->_header = new Header($this);
            $this->_footer = new Footer();
        }

        public function addComponent($component) {
            // Verify the thing you're tring to add actually is a component
            if ($component instanceof Component) {
                array_push($this->_components, $component);
            }
        }
        
        public function getTitle() {
            return $this->_title;
        }
        public function getCSSPaths() {
            $css_paths = array("./".$this->_page_category->getProperty("uri_name")."/css/".$this->_root.".css");
            for ($i = 0; $i < sizeof($this->_components); $i++) {
                array_push($css_paths, "./".$this->_components[$i]->getCategory()->getProperty("uri_name")."/css/components/".get_class($this->_components[$i]).".css");
            }
            return $css_paths;
        }
        public function getPageName() {
            return $this->_name;
        }
        public function getScriptPaths() {
            $script_paths = array();
            for ($i = 0; $i < sizeof($this->_components); $i++) {
                $component_script_paths = $this->_components[$i]->getScriptPaths();
                for ($j = 0; $j < sizeof($component_script_paths); $j++) {
                    // Maybe add some validation here
                    array_push($script_paths, $component_script_paths[$j]);
                }
            }
            return $script_paths;
        }
        public function getRoot() {
            return $this->_root;
        }

        public function render() {
            $html = $this->_header->render()
                  . "<div class=\"fluid-container\">";
            for ($i = 0; $i < sizeof($this->_components); $i++) {
                $html .= $this->_components[$i]->render();
            }
            $html.= "</div>"
                  . $this->_footer->render();
            return $html;
        }
    }
?>