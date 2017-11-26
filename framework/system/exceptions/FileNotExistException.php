<?php

namespace Justify\Exceptions;

class FileNotExistException extends JustifyException
{
    /**
     * Returns name of exception
     *
     * @return string
     */
    public function getName()
    {
        return 'File not exist exception';
    }

    /**
     * FileNotExistException constructor
     *
     * @param string $what type of file
     * @param int $file path to file
     */
    public function __construct($what, $file)
    {
        $message = "$what $file doesn't exist";

        parent::__construct($message);
    }
}
