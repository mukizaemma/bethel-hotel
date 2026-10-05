<?php

declare(strict_types=1);

if (! function_exists('hotel_price')) {
    /**
     * Format a room or site price using the hotel's currency setting (USD or RWF).
     */
    function hotel_price(mixed $value, ?object $setting): string
    {
        $amount = (float) ($value ?? 0);
        $currency = strtolower((string) ($setting?->price_currency ?? 'usd'));
        if ($currency === 'rwf') {
            return 'RWF ' . number_format($amount, 0);
        }

        return '$' . number_format($amount, 0);
    }
}

if (! function_exists('hotel_phone_digits')) {
    function hotel_phone_digits(?string $value): string
    {
        return preg_replace('/\D+/', '', (string) $value) ?: '';
    }
}

if (! function_exists('hotel_phone_display')) {
    /**
     * Readable phone for public pages. Keeps a number that is already spaced, otherwise groups a Rwanda number.
     */
    function hotel_phone_display(?string $value): string
    {
        $raw = trim((string) $value);
        if ($raw === '') {
            return '';
        }
        if (preg_match('/[^\d+]/', $raw)) {
            return $raw;
        }

        $digits = hotel_phone_digits($raw);
        if ($digits === '') {
            return $raw;
        }
        if (str_starts_with($digits, '250') && strlen($digits) === 12) {
            return '+250 '.substr($digits, 3, 3).' '.substr($digits, 6, 3).' '.substr($digits, 9);
        }

        return '+'.$digits;
    }
}

if (! function_exists('price_currency_label')) {
    /**
     * Short label for admin room/pricing forms (Settings → website price currency).
     */
    function price_currency_label(?object $setting): string
    {
        return strtolower((string) ($setting?->price_currency ?? 'usd')) === 'rwf'
            ? 'RWF'
            : 'USD ($)';
    }
}

if (! function_exists('terms_content_html')) {
    /**
     * Public Terms page: render CMS HTML from Summernote, or upgrade legacy plain-text
     * (pasted/textarea) into paragraphs and line breaks so the page is readable.
     */
    function terms_content_html(?string $raw): string
    {
        if ($raw === null || $raw === '') {
            return '';
        }

        $t = $raw;
        if (preg_match('/<[a-z!\/][\s\/>]/i', $t)) {
            return $t;
        }

        $parts = preg_split('/\R{2,}/u', trim($t)) ?: [];
        $out = [];
        foreach ($parts as $part) {
            $part = trim($part);
            if ($part === '') {
                continue;
            }
            $out[] = '<p>'.nl2br(e($part), false).'</p>';
        }

        return $out ? implode("\n", $out) : '';
    }
}
