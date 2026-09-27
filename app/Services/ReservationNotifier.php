<?php

namespace App\Services;

use App\Mail\BookingSubmittedAdminMail;
use App\Mail\BookingSubmittedGuestMail;
use App\Mail\ContactEnquiryAdminMail;
use App\Mail\ContactEnquiryGuestMail;
use App\Models\Booking;
use App\Models\Message;
use App\Support\HotelChannels;
use Illuminate\Mail\Mailable;

class ReservationNotifier
{
    /**
     * @return array{admin_sent: bool, guest_sent: bool, whatsapp_url: ?string}
     */
    public static function notifyBooking(Booking $booking, string $channel): array
    {
        $booking->loadMissing(['room', 'facility', 'tourActivity']);

        return self::dispatch(
            $channel,
            new BookingSubmittedAdminMail($booking),
            new BookingSubmittedGuestMail($booking),
            $booking->email,
            self::bookingWhatsAppText($booking)
        );
    }

    /**
     * @return array{admin_sent: bool, guest_sent: bool, whatsapp_url: ?string}
     */
    public static function notifyEnquiry(Message $enquiry, string $channel): array
    {
        $enquiry->loadMissing('room');

        return self::dispatch(
            $channel,
            new ContactEnquiryAdminMail($enquiry),
            new ContactEnquiryGuestMail($enquiry),
            $enquiry->email,
            self::enquiryWhatsAppText($enquiry)
        );
    }

    public static function whatsappDigits(): string
    {
        return preg_replace('/\D+/', '', (string) (HotelChannels::all()['whatsapp_e164'] ?? '')) ?: '';
    }

    public static function webSendUrl(string $text): ?string
    {
        $digits = self::whatsappDigits();
        if ($digits === '') {
            return null;
        }

        return 'https://web.whatsapp.com/send?phone='.$digits.'&text='.rawurlencode($text);
    }

    /**
     * @return array{admin_sent: bool, guest_sent: bool, whatsapp_url: ?string}
     */
    protected static function dispatch(string $channel, Mailable $adminMail, Mailable $guestMail, string $guestEmail, string $whatsappText): array
    {
        $adminSent = SiteNotificationMail::sendToTeam($adminMail);
        $guestSent = false;
        $whatsappUrl = null;

        if ($channel === 'whatsapp') {
            $whatsappUrl = self::webSendUrl($whatsappText);
        } else {
            $guestSent = SiteNotificationMail::sendToGuest($guestEmail, $guestMail);
        }

        return [
            'admin_sent' => $adminSent,
            'guest_sent' => $guestSent,
            'whatsapp_url' => $whatsappUrl,
        ];
    }

    public static function bookingWhatsAppText(Booking $booking): string
    {
        $hotel = config('app.name', 'Bethel Hotel');
        $prefix = trim((string) (HotelChannels::all()['whatsapp_default_message'] ?? ''));
        $lines = [
            $prefix !== '' ? $prefix : 'Hello '.$hotel.',',
            '',
            'I would like to request a reservation.',
            'Name: '.$booking->names,
            'Email: '.$booking->email,
            'Phone: '.$booking->phone,
        ];

        $type = $booking->reservation_type ?? 'room';
        if ($type === 'room' && $booking->room) {
            $lines[] = 'Room: '.$booking->room->title;
        } elseif ($type === 'facility' && $booking->facility) {
            $lines[] = 'Facility: '.$booking->facility->title;
        } elseif ($type === 'tour_activity' && $booking->tourActivity) {
            $lines[] = 'Activity: '.($booking->tourActivity->title ?? '');
        }

        if ($booking->checkin_date) {
            $lines[] = 'Check-in: '.$booking->checkin_date->format('Y-m-d');
        }
        if ($booking->checkout_date) {
            $lines[] = 'Check-out: '.$booking->checkout_date->format('Y-m-d');
        }
        $guestBits = [];
        if ($booking->adults !== null) {
            $guestBits[] = 'Adults: '.$booking->adults;
        }
        if ($booking->children !== null) {
            $guestBits[] = 'Children: '.$booking->children;
        }
        if ($guestBits !== []) {
            $lines[] = implode(', ', $guestBits);
        }
        if (filled($booking->rooms) && (int) $booking->rooms > 0) {
            $lines[] = 'Rooms: '.$booking->rooms;
        }
        if (filled($booking->message)) {
            $lines[] = '';
            $lines[] = trim((string) $booking->message);
        }

        return implode("\n", $lines);
    }

    public static function enquiryWhatsAppText(Message $enquiry): string
    {
        $hotel = config('app.name', 'Bethel Hotel');
        $prefix = trim((string) (HotelChannels::all()['whatsapp_default_message'] ?? ''));
        $lines = [
            $prefix !== '' ? $prefix : 'Hello '.$hotel.',',
            '',
            'Enquiry type: '.str_replace('_', ' ', (string) ($enquiry->enquiry_type ?? 'general')),
            'Name: '.$enquiry->names,
            'Email: '.$enquiry->email,
            'Phone: '.$enquiry->phone,
        ];
        if (filled($enquiry->subject)) {
            $lines[] = 'Subject: '.$enquiry->subject;
        }
        if ($enquiry->room) {
            $lines[] = 'Room: '.$enquiry->room->title;
        }
        if ($enquiry->checkin_date) {
            $lines[] = 'Check-in: '.$enquiry->checkin_date->format('Y-m-d');
        }
        if ($enquiry->checkout_date) {
            $lines[] = 'Check-out: '.$enquiry->checkout_date->format('Y-m-d');
        }
        if (filled($enquiry->message)) {
            $lines[] = '';
            $lines[] = trim((string) $enquiry->message);
        }

        return implode("\n", $lines);
    }
}
