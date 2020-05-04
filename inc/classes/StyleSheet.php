<?php
    class StyleSheet {
        private $_styles = array();

        public function add_query_styles($query, $styles) {
            $this->_styles[$query] = $styles;
        }

        public function render() {
            $style ="<style>";
            foreach ($this->_styles as $query => $item_styles) {
                $style.=$query." {";
                foreach ($item_styles as $attribute => $value) {
                    $style.=$attribute.": ".$value.";";
                }
                $style.="}";
            }
            $style.="</style>";
            return $style;
        }
    }
?>