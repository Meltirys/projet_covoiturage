<?php

namespace App\Validators;

use CodeIgniter\Validation\Validation;
use Config\Services;

abstract class BaseValidator
{
    protected Validation $validation;

    public function __construct()
    {
        $this->validation = Services::validation();
    }

    /**
     * @param array $data An array that contains the datas to validate
     * 
     * @return bool True if the data provided are valid, false otherwise
     */
    public function validate(array $data): bool
    {
        $this->validation->setRules($this->rules());
        return $this->validation->run($data);
    }

    /**
     * @return array An array with all the errors
     */
    public function getErrors(): array
    {
        return $this->validation->getErrors();
    }

    /**
     * @param string $field The field we want the error from
     * 
     * @return string The error for the given string
     */
    public function getError(string $field): string
    {
        return $this->validation->getError($field);
    }

    
    /**
     * @return array An array that contains all the rules for the given class
     */
    // Each childrens must implementents it's own rules
    abstract protected function rules(): array;
}
