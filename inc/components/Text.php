<?php
    class Text implements Component {

        private static $_s_align = "left";
        private static $_s_use_dividers = FALSE;
        private static $_s_header;
        private static $_s_sub_header;

        private $_text;
        private $_align;
        private $_use_dividers;

        private $_header;
        private $_sub_header;

        private $_stylesheet;

        private function __construct($text, $align, $use_dividers, $header, $sub_header) {
            $this->_text = $text;
            $this->_align = $align;
            $this->_use_dividers = $use_dividers;
            $this->_header = $header;
            $this->_sub_header = $sub_header;

            $this->_define_style();
        }

        private function _define_style() {
            $this->_stylesheet = new StyleSheet();
            $this->_stylesheet->add_query_styles(".text_block_header_container", array("margin-bottom" => "1em"));
        }

        public static function use_dividers() {
            self::$_s_use_dividers = TRUE;
        }
        public static function align($align) {
            self::$_s_align = $align;
        }
        public static function header($header) {
            self::$_s_header = $header;
        }
        public static function sub_header($sub_header) {
            self::$_s_sub_header = $sub_header;
        }
        public static function create($text_bodies) {
            $class = get_called_class();
            $result = new $class($text_bodies, self::$_s_align, self::$_s_use_dividers, self::$_s_header, self::$_s_sub_header);
            self::$_s_header = NULL;
            self::$_s_sub_header = NULL;
            self::$_s_align = "left";
            self::$_s_use_dividers = FALSE;
            return $result;
        }

        public function render() {
            $html = "<div class=\"container\">"
                  .     "<div class=\"text_block_header_container\">";
            if (!is_null($this->_header)) {
                $html.=     "<h2>".$this->_header."</h2>";
                if (!is_null($this->_sub_header)) {
                    $html.= "<h3>".$this->_sub_header."</h3>";
                }
            }
            $html.=     "</div>";
            foreach ($this->_text as $text_body) {
                $html.= "<p class=\"text-".$this->_align." text-break\">".$text_body."</p>";
            }
            $html.= "</div>";
            return $html;
        }
        public function getStyleSheet() {
            return $this->_stylesheet;
        }
        public function getCategory() {
            return ComponentCategories::Base();
        }
        public function getScriptPaths() {
            return array();
        }
    }
?>