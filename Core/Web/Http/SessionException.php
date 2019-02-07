<?php

namespace Core\Web\Http;

/**
 * An exception class, which is thrown when a session does not exist.
 */
class SessionException extends \Core\Web\Http\HttpException{
    
    protected $sessionStatus;
    
    /**
     * Initializes a new instance of SessionException with a $message and
     * the session status.
     */
    public function __construct(string $message, int $sessionStatus) {
        parent::__construct($message);
        $this->sessionStatus = $sessionStatus;
    }
    
    /**
     * Gets the session status.
     */
    public function getStatus() : int{
        return $this->sessionStatus;
    }
}
