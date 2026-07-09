<?php

namespace App\Support;

use App\Models\Setting;

/**
 * Resolves Booking.com, TripAdvisor, Google, WhatsApp, contact email, and
 * optional manually maintained review stats (scores, counts, short summaries):
 * settings row overrides config/hotel_channels.php (which reads .env).
 */
final class HotelChannels
{
    private static ?array $cache = null;

    public static function forgetCache(): void
    {
        self::$cache = null;
    }

    /**
     * @return array<string, string|int|float|null>
     */
    public static function all(): array
    {
        if (self::$cache !== null) {
            return self::$cache;
        }

        $base = config('hotel_channels', []);
        $s = Setting::first();

        if ($s === null) {
            self::$cache = $base;

            return self::$cache;
        }

        $str = static function (?string $v): bool {
            return $v !== null && trim($v) !== '';
        };

        $publicEmail = $str($s->channel_contact_email ?? null)
            ? trim((string) $s->channel_contact_email)
            : ($str($s->email ?? null) ? trim((string) $s->email) : ($base['public_email'] ?? null));

        $intOrNull = static function ($v): ?int {
            if ($v === null || $v === '') {
                return null;
            }

            return (int) $v;
        };

        $floatOrNull = static function ($v): ?float {
            if ($v === null || $v === '') {
                return null;
            }

            return (float) $v;
        };

        self::$cache = [
            'booking_com_url' => $str($s->booking_com_url ?? null)
                ? trim((string) $s->booking_com_url)
                : ($base['booking_com_url'] ?? null),
            'booking_com_review_score' => $floatOrNull($s->booking_com_review_score ?? null),
            'booking_com_review_count' => $intOrNull($s->booking_com_review_count ?? null),
            'booking_com_review_summary' => $str($s->booking_com_review_summary ?? null)
                ? trim((string) $s->booking_com_review_summary)
                : null,
            'booking_com_write_review_url' => $str($s->booking_com_write_review_url ?? null)
                ? trim((string) $s->booking_com_write_review_url)
                : null,
            'tripadvisor_location_id' => $str($s->tripadvisor_location_id ?? null)
                ? trim((string) $s->tripadvisor_location_id)
                : ($base['tripadvisor_location_id'] ?? null),
            'tripadvisor_hotel_url' => $str($s->tripadvisor_hotel_url ?? null)
                ? trim((string) $s->tripadvisor_hotel_url)
                : ($base['tripadvisor_hotel_url'] ?? null),
            'tripadvisor_write_review_url' => $str($s->tripadvisor_write_review_url ?? null)
                ? trim((string) $s->tripadvisor_write_review_url)
                : ($base['tripadvisor_write_review_url'] ?? null),
            'tripadvisor_review_score' => $floatOrNull($s->tripadvisor_review_score ?? null),
            'tripadvisor_review_count' => $intOrNull($s->tripadvisor_review_count ?? null),
            'tripadvisor_review_summary' => $str($s->tripadvisor_review_summary ?? null)
                ? trim((string) $s->tripadvisor_review_summary)
                : null,
            'google_place_url' => $str($s->google_place_url ?? null)
                ? trim((string) $s->google_place_url)
                : ($base['google_place_url'] ?? null),
            'google_maps_embed_url' => $str($s->google_maps_embed_url ?? null)
                ? trim((string) $s->google_maps_embed_url)
                : ($base['google_maps_embed_url'] ?? null),
            'google_review_score' => $floatOrNull($s->google_review_score ?? null),
            'google_review_count' => $intOrNull($s->google_review_count ?? null),
            'google_review_summary' => $str($s->google_review_summary ?? null)
                ? trim((string) $s->google_review_summary)
                : null,
            'google_write_review_url' => $str($s->google_write_review_url ?? null)
                ? trim((string) $s->google_write_review_url)
                : null,
            'whatsapp_e164' => (static function () use ($s, $str, $base): ?string {
                $digits = $str($s->whatsapp_e164 ?? null)
                    ? preg_replace('/\D+/', '', (string) $s->whatsapp_e164) ?: null
                    : null;
                if ($digits !== null && $digits !== '') {
                    return $digits;
                }
                $fromReception = $str($s->reception_phone ?? null)
                    ? preg_replace('/\D+/', '', (string) $s->reception_phone) ?: null
                    : null;
                if ($fromReception !== null && $fromReception !== '') {
                    return $fromReception;
                }

                return $base['whatsapp_e164'] ?? null;
            })(),
            'whatsapp_default_message' => $str($s->whatsapp_default_message ?? null)
                ? trim((string) $s->whatsapp_default_message)
                : ($base['whatsapp_default_message'] ?? null),
            'public_email' => $publicEmail,
        ];

        return self::$cache;
    }
}
