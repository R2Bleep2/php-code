# php-code
A PHP module for code forms of objects.

## Version
2025-9-20

## PHP Version
8.4.11

## Installation
This is a PHP module meant to be copied into [one of your PHP "include" directories](https://www.php.net/manual/en/ini.core.php#ini.include-path). Copy the "Code.php" file into one of those directories.

## Usage
This module defines an interface `HasCode` for a managed `code` property representing the code form of an object. The object then specifies how the code form translates into the other properties of the object.

    class ExampleClass implements HasCode {
        
        /** A property that a code form can be interpreted as. */
        public int $value;
        
        /** The managed code form property. When set, in this case, it is converted to the value property. When gotten, it is converted from the value. */
        public string $code {
            
            set(string $code) {   
                $this->value = (int)$code;
            }
            
            get => (string)$this->value;
            
        }
        
    }
