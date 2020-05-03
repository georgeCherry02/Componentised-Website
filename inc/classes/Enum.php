<?php
    abstract class Enum {
        private static $_instanced_enums;

        private $_name;
        protected $_properties;

        private function __construct($properties, $name) {
            $this->_name = $name;
            $this->_properties = $properties;
        }

        private static function _fromProperty($property, $value) {
            // Attain a copy of the Enum class
            $enum_type = get_called_class();
            $class_reflection = new ReflectionClass($enum_type);
            // Attain a list of all Enums from that class
            $methods = $class_reflection->getMethods(ReflectionMethod::IS_STATIC && ReflectionMethod::IS_PUBLIC);

            foreach ($methods as $method) {
                // Check if the Enum is of the called class
                if ($method-> class === $enum_type) {
                    $enum_item = $method->invoke(NULL);
                    if ($enum_item instanceof $enum_type && $enum_item->_getProperty($property) === $value) {
                        return $enum_item;
                    }
                }
            }

            throw new OutOfRangeException();
        }

        public static function fromName($name) {
            $enum_type = get_called_class();
            $class_reflection = new ReflectionClass($enum_type);
            $methods = $class_reflection->getMethods(ReflectionMethod::IS_STATIC && ReflectionMethod::IS_PUBLIC);

            foreach ($methods as $method) {
                if ($method-> class === $enum_type) {
                    $enum_item = $method->invoke(NULL);
                    if ($enum_item instanceof $enum_type && $enum_item->getName() === $name) {
                        return $enum_item;
                    }
                }
            }

            throw new OutOfRangeException();
        }

        protected static function _initialise($properties, $valid_properties) {

            // Validate properties
            foreach ($properties as $prop_name => $prop_value) {
                if (!array_key_exists($prop_name, $valid_properties) || gettype($prop_value) !== $valid_properties[$prop_name]) {
                    throw new UnexpectedValueException();
                }
            }

            if (self::$_instanced_enums === NULL) {
                self::$_instanced_enums = array();
            }

            $enum_type = get_called_class();
            
            if (!isset(self::$_instanced_enums[$enum_type])) {
                self::$_instanced_enums[$enum_type] = array();
            }

            $debug_trace = debug_backtrace();
            $last_caller = array_shift($debug_trace);

            while($last_caller["class"] !== $enum_type && count($debug_trace) > 0) {
                $last_caller = array_shift($debug_trace);
            }

            $enum_name = $last_caller["function"];

            if (!isset(self::$_instanced_enums[$enum_type][$enum_name])) {
                self::$_instanced_enums[$enum_type][$enum_name] = new static ($properties, $enum_name);
            }

            return self::$_instanced_enums[$enum_type][$enum_name];
        }

        public function getProperty($property) {
            return $this->_properties[$property];
        }

        public function getName() {
            return $this->_name;
        }
    }
?>