<?php
namespace matt127127\MigrationPath\Exceptions;


use Exception;

class InvalidPathException extends Exception
{
    public function __construct($path)
    {
        parent::__construct(sprintf('The directory "%s" does not exist', $path));
    }
}
