<?php
    class StyleSheet {
        private $_styles = array();

        public function set_query_styles($query, $styles) {
            $this->_styles[$query] = $styles;
        }
        public function add_query_styles($query, $styles) {
            if (isset($this->_styles[$query])) {
                // This overwrites any shared keys with the value in the new styles object by default
                array_merge($this->_styles[$query], $styles);
            } else {
                $this->_styles[$query] = $styles;
            }
        }
        public function merge_stylesheet($stylesheet) {
            if ($stylesheet instanceof StyleSheet) {
                foreach ($stylesheet->get_styles() as $query => $styles) {
                    if (array_key_exists($query, $this->_styles)) {
                        array_merge($this->_styles[$query], $styles);
                    } else {
                        $this->_styles[$query] = $styles;
                    }
                }
            } else {
                throw new InvalidArgumentException();
            }
        }
        public function get_styles() {
            return $this->_styles;
        }

        // Utitlity functions
        public function set_query_text_colour($query, $colour) {
            $this->set_attribute($query, "color", $colour);
        }
        public function set_query_background_colour($query, $colour) {
            $this->set_attribute($query, "background-color", $colour);
        }
        public function set_query_border($query, $border_width = "1px", $border_style = "solid", $border_colour = COLOUR_SCHEME["black"]) {
            $this->set_attribute($query, "border", $border_width." ".$border_style." ".$border_colour);
        }
        public function set_query_shadow($query, $shadow_horizontal_displacement, $shadow_vertical_displacement, $shadow_smudge_radius = 0, $shadow_colour = "black") {
            $this->set_attribute($query, "box-shadow", $shadow_horizontal_displacement."px ".$shadow_vertical_displacement."px ".$shadow_smudge_radius."px ".$shadow_colour);
        }

        private function set_attribute($query, $attribute, $value) {
            $this->handle_query_existence($query);
            $this->_styles[$query][$attribute] = $value;
        }
        private function handle_query_existence($query) {
            if (!isset($this->_styles[$query])) {
                $this->_styles[$query] = array();
            }
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