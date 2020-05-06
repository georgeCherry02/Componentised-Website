<?php
    class AccountTypes extends Enum {
        private static $_valid_properties = array("index" => "integer");
        public static function User() { return self::_initialise(array("index" => 0), self::$_valid_properties); )}
        public static function Admin() { return self::_initialise(array("index" => 1), self::$_valid_properties); )}
    }
?>