<?php

namespace App\Validators;

class FormValidator
{
    private $data;
    private $errors = [];

    public function __construct($data)
    {
        $this->data = $data;
    }

    public function validate()
    {
        // Add your validation logic here
        // For example, check if a field is empty:
        if (empty($this->data['title'])) {
            $this->errors['title'] = 'Title is required';
        }
        if (empty($this->data['body'])) {
            $this->errors['body'] = 'Title is required';
        }
        // Repeat for other fields as necessary

        // If there are no errors, return true
        if (empty($this->errors)) {
            return true;
        }
        // If there are errors, return false
        return false;
    }

    public function getErrors()
    {
        return $this->errors;
    }
}
