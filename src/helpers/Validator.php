<?php
class Validator {
    private $errors = [];

    // Validar que un campo no esté vacío
    public function required($field, $value, $message = null) {
        if (empty(trim($value))) {
            $this->errors[$field][] = $message ?? "El campo $field es obligatorio.";
        }
    }

    // Validar longitud mínima
    public function minLength($field, $value, $min, $message = null) {
        if (strlen(trim($value)) < $min) {
            $this->errors[$field][] = $message ?? "El campo $field debe tener al menos $min caracteres.";
        }
    }

    public function maxLength($field, $value, $max, $message = null) {
        if (strlen(trim($value)) > $max) {
            $this->errors[$field][] = $message ?? "El campo $field no puede tener más de $max caracteres.";
        }
    }

    // Validar que un campo sea numérico
    public function numeric($field, $value, $message = null) {
        if (!is_numeric($value)) {
            $this->errors[$field][] = $message ?? "El campo $field debe ser un número.";
        }
    }

    // Validar que un campo esté en una lista
    public function inArray($field, $value, $array, $message = null) {
        if (!in_array($value, $array)) {
            $this->errors[$field][] = $message ?? "El campo $field tiene un valor inválido.";
        }
    }

    public function getErrors() {
        return $this->errors;
    }

    public function hasErrors() {
        return !empty($this->errors);
    }
}
