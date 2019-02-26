<?php
declare(strict_types=1);

namespace amadden;

class user {

    private $name, $surname, $email;

    function __construct(string $name, string $surname, string $email) {
        $this->name = $this->formatName($name);
        $this->surname = $this->formatName($surname);
        $this->email = $this->formatEmail($email);
    }

    /**
     * Formats an input string so that each word is lowercase except for the first letter
     * of each word which is uppercase
     *
     * @param string $name
     * @return string
     */
    function formatName(string $name): string {
        $name = strtolower($name); // convert name to all lowercase
        $name = ucwords($name); // capitilize each name in the string
        return $name;
    }

    /**
     * Formats an input string so that the whole string is converted to lowercase
     *
     * @param string $email
     * @return string
     */
    function formatEmail(string $email): string {
        $email = strtolower($email); // convert email to all lowercase
        return $email;
    }

    /**
     * Validates that the input email is consistent with modern email standard formats.
     *
     * @param string $email
     * @return boolean
     */
    function isEmailValid(string $email): bool {
        // email validation is contentious on what to include and exclude. Included the edge
        // case in the brief but any email validator using regex should not be relied upon for security.
        $pattern = "/[^@]+@[^\.]+\..+/";

        return preg_match($pattern, $email) === 1;
    }

    /**
     * Validates that the input email is consistent with modern email standard formats.
     *
     * @return boolean
     */
    function hasValidEmail(): bool {
        // email validation is contentious on what to include and exclude. Included the edge
        // case in the brief but any email validator using regex should not be relied upon for security.
        $pattern = "/[^@]+@[^\.]+\..+/";

        return preg_match($pattern, $this->email) === 1;
    }
}