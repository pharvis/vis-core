<?php

namespace Core\Web\View;

/**
 * Exception thrown when a view file is not found.
 */
class ViewFileNotFoundException extends \Exception{
    
    protected $viewFiles = [];
    
    /**
     * Initializes a new instance of ViewFileNotFoundException with a $message
     * and the $viewFiles.
     */
    public function __construct(string $message, array $viewFiles) {
        parent::__construct($message);
        $this->viewFiles = $viewFiles;
    }
    
    /**
     * Gets an array of view files.
     */
    public function getViewFiles() : array{
        return $this->viewFiles;
    }
}