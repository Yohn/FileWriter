# FileWriter PHP Utility

## Overview

The `FileWriter` class provides a simple and robust utility for writing content to files with various operations like overwriting, appending, and prepending.

## Installation

Install via Composer:
```bash
composer require yohns/filewriter
```

## Requirements

- PHP 7.4+
- Ext-fileinfo recommended

## Usage Examples

### Basic File Writing

```php
use Yohns\Util\FileWriter;

// Create a new FileWriter instance
$fileWriter = new FileWriter('path/to/your/file.txt');

// Overwrite file content
$fileWriter->overwrite("Hello, world!\n");

// Append to file
$fileWriter->append("Additional content\n");

// Prepend to file
$fileWriter->prepend("Initial content\n");
```

### Handling File Operations

```php
$fileWriter = new FileWriter('logs/app.log');

// Safely write content, with error handling
if (!$fileWriter->append("Log entry: " . date('Y-m-d H:i:s') . "\n")) {
    // Handle writing error
    error_log("Could not write to log file");
}
```

## Features

- Automatic directory creation
- File creation if not exists
- Overwrite, append, and prepend operations
- File locking to prevent race conditions

## Error Handling

Methods return boolean values:
- `true`: Operation successful
- `false`: Operation failed

## License

MIT License