<?php
    interface Component {
        public function render();
        public function getScriptPaths();
        public function getStyleSheet();
        public function getCategory();
    }
?>