<?php

namespace Src\Validation;

class ContactValidator
{
    /**
     * Error codes for invalid input data
     */
    const ERROR_INVALID_EMAIL = 'invalidEmail';
    const ERROR_INVALID_TELEPHONE = 'invalidTelephone';

    /**
     * Santizes string
     * @param string $string
     * @return string
     */
    public static function sanitizeString(string $string): string
    {
        return htmlspecialchars(strip_tags($string));
    }

    /**
     * Validates email
     * @param string $email
     * @return bool
     */
    public static function validateEmail(string $email): bool
    {
        return filter_var($email, FILTER_VALIDATE_EMAIL) !== false;
    }

    /**
     * Validates Polish mobile number
     * Possibility to contain +48 (not necessary)
     * @param string $phone
     * @return bool
     */
    public static function validatePhone(string $phone): bool
    {
        return preg_match('/^(\+48)?\d{9}$/', $phone);
    }

    /**
     * Validates if string is integer
     * @param $id
     * @return bool
     */
    public static function validateInteger($id): bool
    {
        return filter_var($id, FILTER_VALIDATE_INT) !== false;
    }

    /**
     * Validates contact data from form
     * @param array $data
     * @return array
     */
    public static function validateContact(array $data): array
    {
        $errors = [];
        $data['name'] = self::sanitizeString($data['name']);
        $data['surname'] = self::sanitizeString($data['surname']);
        $data['telephone'] = self::sanitizeString($data['telephone']);
        $data['email'] = self::sanitizeString($data['email']);
        $data['address'] = self::sanitizeString($data['address']);

        if (!self::validateEmail($data['email'])) {
            $errors[] = self::ERROR_INVALID_EMAIL;
        }

        if (!self::validatePhone($data['telephone'])) {
            $errors[] = self::ERROR_INVALID_TELEPHONE;
        }

        return ['errors' => implode(',', $errors), 'data' => $data];
    }

    /**
     * Validates errors
     * @param string $errors
     * @return array
     */
    public static function validateErrors(string $errors)
    {
        $errorCodes = explode(',', $errors);
        $errorMessages = [];

        foreach ($errorCodes as $errorCode) {
            switch (trim($errorCode)) {
                case self::ERROR_INVALID_TELEPHONE:
                    $errorMessages[] = 'The telephone number format is incorrect. Must be Polish type (ex. XXX XXX XXX or +48 XXX XXX XXX)';
                    break;
                case self::ERROR_INVALID_EMAIL:
                    $errorMessages[] = 'The email address format is invalid.';
                    break;
            }
        }

        return $errorMessages;
    }
}