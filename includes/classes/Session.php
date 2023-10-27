<?php

class Session
{
    private $isOpen = false;
    private $sessionOptions = [];

    function __construct($options = [])
    {
        session_start($options);
        $this->sessionOptions = $options;
        $this->isOpen = true;
    }

    function __destruct()
    {
        session_write_close();
        $this->isOpen = false;
    }

    function set(string $key, mixed $value, bool $closeAfterWrite = true): bool
    {
        try {
            if (!$this->isOpen) {
                session_start($this->sessionOptions);
                $this->isOpen = true;
            }

            $_SESSION[$key] = $value;

            if ($closeAfterWrite) {
                session_write_close();
            }
        } catch (Exception $e) {
            error_log($e->getMessage());
            return false;
        }
        return true;
    }

    function get(string $key): mixed
    {
        if (isset($_SESISON[$key]))
            return $_SESISON[$key];
        else
            return null;
    }
}
