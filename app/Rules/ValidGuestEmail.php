<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class ValidGuestEmail implements ValidationRule
{
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $email = strtolower(trim((string) $value));

        if ($email === '' || filter_var($email, FILTER_VALIDATE_EMAIL) === false) {
            $fail('Enter a valid email address.');

            return;
        }

        $at = strrpos($email, '@');
        if ($at === false) {
            $fail('Enter a valid email address.');

            return;
        }

        $domain = substr($email, $at + 1);
        if (! is_string($domain) || ! preg_match('/^(?:[a-z0-9](?:[a-z0-9-]{0,61}[a-z0-9])?\.)+[a-z]{2,}$/i', $domain)) {
            $fail('Enter a valid email address.');

            return;
        }

        $hasMx = @checkdnsrr($domain, 'MX');
        $hasA = @checkdnsrr($domain, 'A');
        $hasAaaa = @checkdnsrr($domain, 'AAAA');

        if (! $hasMx && ! $hasA && ! $hasAaaa) {
            $fail('That email domain cannot receive mail. Please use a real email address.');
        }
    }
}
