<?php
    class NavBar implements Component {

        private $_website_structure;
        private $_containing_page;

        public function __construct($structure, $containing_page) {
            $this->_website_structure = $structure;
            $this->_containing_page = $containing_page;
        }

        public function render() {
            $html = "<nav class=\"navbar navbar-expand-lg\">"
                            // Outline the header on small devices
                  .         "<div class=\"container\">"
                  .             "<a class=\"navbar-brand\" href=\"?loc=default\">".WEBSITE_NAME."</a>"
                  .             "<button class=\"navbar-toggler\" type=\"button\" data-toggle=\"collapse\" data-target=\"#navbarContent\" aria-expanded=\"false\" aria-label=\"Toggle navigation\">"
                  .                 "<i class=\"fas fa-bars blue-text\"></i>"
                  .             "</button>"
                            // Elaborate on full content of navbar
                      .         "<div id=\"navbarContent\" class=\"navbar-collapse collapse\">"
                      .             "<ul class=\"nav navbar-nav ml-auto\">";
                foreach ($this->_website_structure as $group_name => $top_level_structure) {
                    // List all the pages in structure, note that some may be grouped
                    $html .= $this->render_top_level_structure($group_name, $top_level_structure);
                }
                $html.=             "</ul>"
                      .         "</div>"
                  .         "</div>"
                  .     "</div>"
                  . "</nav>";
            return $html;
        }

        private function render_styling() {
                    }

        private function render_top_level_structure($group_name, $structure) {
            $html = "<li class=\"nav-item";
            if ($structure instanceof Page) {
                // Checks if it's the current page
                $active = $this->_containing_page === $structure;
                if ($active) {
                    $html .= " active";
                }
                $html.= "\">"
                      .     "<a class=\"nav-link\" href=\"?loc=".$structure->getRoot()."\">".$structure->getPageName();
                if ($active) {
                    $html .= "<span class=\"sr-only\">(current)</span>";
                }
                $html.=     "</a>"
                      . "</li>";
            } else if (gettype($structure) === "array") {
                $html.= " dropdown\">"
                      .     "<a class=\"nav-link dropdown-toggle\" href=\"#\" id=\"navbarDropdown\" role=\"button\" data-toggle=\"dropdown\" aria-haspopup=\"true\" aria-expanded=\"false\">"
                      .         $group_name
                      .         "<span class=\"caret\"></span>"
                      .     "</a>"
                      .     "<div class=\"dropdown-menu\" aria-labelledby=\"navbarDropdown\">";
                foreach ($structure as $root => $secondary_structure) {
                    if ($secondary_structure instanceof Page) {
                        $active = $this->_containing_page === $secondary_structure;
                        $html.= "<a href=\"?loc=".$secondary_structure->getRoot()."\" class=\"dropdown-item";
                        if ($active) {
                            $html.= " active";
                        }
                        $html.= "\">".$secondary_structure->getPageName();
                        if ($active) {
                            $html.= "<span class=\"sr-only\">(current)</span>";
                        }
                        $html.= "</a>";
                    }
                }
                $html.=     "</div>"
                      . "</li>";
            }
            return $html;
        }

        public function getStyleSheet() {
            $style = new StyleSheet();
            $style->set_query_shadow("nav.navbar", 0, 2, 5, "#555");
            $style->set_query_background_colour("nav.navbar", COLOUR_SCHEME["white"]);
            $style->set_query_styles("a.nav-link", array("color" => COLOUR_SCHEME["dark"]));
            $style->set_query_styles("a.nav-link:hover", array("color" => HOVER_COLOUR_SCHEME["dark"]));
            $style->set_query_styles("li.active a.nav-link", array("color" => COLOUR_SCHEME["highlight"], "cursor" => "default", "pointer-events" => "none"));
            $style->set_query_styles("a.navbar-brand", array("color" => COLOUR_SCHEME["highlight"]));
            $style->set_query_styles("button.navbar-toggler i", array("color" => COLOUR_SCHEME["highlight"]));
            return $style;
        }
        public function getCategory() {
            return ComponentCategories::Base();
        }
        public function getScriptPaths() {
            return array();
        }
    }
?>