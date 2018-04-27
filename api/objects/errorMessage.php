<?php
class ErrorMessage  
{
    private $message;
    private $errors;

    function __construct() {
        
    }

    public static function singleError(string $message)
    {
        $instance = new self();
        $instance->loadSingleError($message);
        return $instance;
    }

    public static function multipleErrors(array $errors)
    {
        $instance = new self();
        $instance->loadMultipleErrors($errors);
        return $instance;
    }

    protected function loadSingleError(string $message)
    {
        $this->message = $message;
    }

    protected function loadMultipleErrors(array $errors)
    {
        $this->errors = $errors;
    }

    public function get()
    {
        $result = array(
            'message' => $this->message,
            'errors' => $this->errors
        );
        return $result;
    }

    /**
     * Get the value of message
     */ 
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * Set the value of message
     *
     * @return  self
     */ 
    public function setMessage($message)
    {
        $this->message = $message;

        return $this;
    }
}
