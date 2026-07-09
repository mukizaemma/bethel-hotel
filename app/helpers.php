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
