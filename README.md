# php-code
A PHP module for code forms of objects.

## Version
2025-9-20

## PHP Version
8.4.11

## Installation
This is a PHP module meant to be copied into [one of your PHP "include" directories](https://www.php.net/manual/en/ini.core.php#ini.include-path). Copy the "Code.php" file into one of those directories.

## Usage
This module defines an interface `HasCode` for a managed `code` property representing the code form of a class. The class then specifies how the code form translates into the other properties of the class.

```php
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

$code = "42";
$exampleInstance = new ExampleClass;

// When the code is set, it will be interpreted as the value.
$exampleInstance->code = "42";
```
    
Furthermore, this module defines an interface `ConstructableFromCode` for a custom constructor directly from code. The other properties will be interpreted. It also defines a trait `CustomCodeConstructor` for this custom constructor which fulfils the interface, referring to a `code` property contracted for by the `HasCode` interface.

```php
class ExampleClass implements HasCode, ConstructableFromCode {
    
    // Previous class body.
    
    use CustomCodeConstructor;
    
}

// Construction of the class directly using the custom code constructor.
$exampleInstance = ExampleClass::fromCode("42");
```
    
There is also a trait `CodeStringConverter` containing a special string conversion method that refers to the code property.

```php
class ExampleClass implements HasCode, ConstuctableFromCode {
    
    // Previous class body.
    
    use CodeStringConverter;
    
}

var_dump("String form of class with code form:", (string)$exampleInstance); // Expected output: `"42"`.
```

This module is particularly useful when writing custom languages. For example, a class for an emphasis element in Markdown can specify a managed `code` property that interprets a string enclosed in asterisks.

```php
$myCode = "*Hello, world!*";

class EmphasisElement implements HasCode, ConstructableFromCode {
    
    /** The enclosed string. This can be parsed from the code form. */
    public string $enclosed;
    
    /** The managed code property. When set, asterisks are stripped, if present, then the resulting enclosed string is assigned to the `enclosed` property. Thus the code is a PHP virtual property. */
    public string $code {
        
        set {
            
            // Code to parse a given code form by stripping the asterisks.
            
        }
        
        get {
            
            // Code to add asterisks.
            
        }
        
    }
    
    use CodeStringConverter;
    use CustomCodeConstructor;
    
}

$emphasisElement = EmphasisElement::fromCode($myCode);
var_dump("Enclosed string of emphasis element parsed from code:", $emphasisElement->enclosed) // Expected output: `"Hello, world!"`.
```

## Testing
There are test cases in the file "CodeTest.php". With the "Code.php" module installed, run this file as a PHP script on the command line.

```bash
php CodeTest.php
```

