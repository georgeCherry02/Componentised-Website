<?php
    final class ComponentCategories extends Enum {
        private static $_valid_properties = array("uri_name" => "string");
        public static function Base() { return self::_initialise(array("uri_name" => ""), self::$_valid_properties); }
        public static function AccountSystem() { return self::_initialise(array("uri_name" => ""), self::$_valid_properties); }
    }
?>