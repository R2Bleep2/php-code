<?php

/** Test of the Code module version 2025-9-20. */

namespace Code;

include "Code.php";
// Define a simple class with an integer value that can be interpreted as code.

class IntegerClass implements \Code\HasCode, \Code\ConstructableFromCode {
    
    public int $value;
    
    /** When set, the code is converted to the value by simple string conversion, and when gotten, the value is converted to code. */
    public string $code {
        
        set(string $code) {
            $this->value = (int)$code;
        }
        
        get => (string)$this->value;
        
    }
    
    use \Code\CodeStringConverter;
    
    // The class can be constructed either from value or from code.
    
    /** The special construction method is private, so either the value or code custom constructors must be used. */
    private function __construct() {}
    
    static function fromValue(int $value): static {
        $new = new static;
        $new->value = $value;
        return $new;
    }
    
    use \Code\CustomCodeConstructor;
    
}

// Create an integer from value.

$integer = IntegerClass::fromValue(42);
var_dump("Integer from value:", $integer);
var_dump("Code of integer from value:", $integer->code);

// Create an integer from code.

$integer = IntegerClass::fromCode("42");
var_dump("Integer from code:", $integer);
var_dump("Value of integer from code:", $integer->value);