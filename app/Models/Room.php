<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    use HasFactory;
    protected $table='rooms';

    protected $fillable = [
        'title',
        'slug',
        'room_number',
        'description',
        'image',
        'cover_image',
        'status',
        'room_status',
        'user_id',
        'category',
        'room_type',
        'number_of_rooms',
        'price',
        'couplePrice',
        'guests_included_in_price',
        'extra_adult_price',
        'extra_child_price',
        'extra_bed_price',
        'max_occupancy',
        'bed_count',
        'bed_type',
        'amenity_id',
    ];

    public function amenities()
    {
        return $this->belongsToMany(Amenity::class);
    }

    public function images(){
        return $this->hasMany(Roomimage::class);
    }

    public function bookings(){
        return $this->hasMany(Booking::class, 'assigned_room_id');
    }

    /**
     * Nightly rate for a guest mix: base price covers up to guests_included_in_price people
     * (adults first, then children). Extra adults/children pay their add-on rates; extra beds optional.
     */
    public function nightlyRateForGuests(int $adults, int $children, int $extraBeds = 0): float
    {
        $adults = max(0, $adults);
        $children = max(0, $children);
        $extraBeds = max(0, $extraBeds);

        $included = max(1, (int) ($this->guests_included_in_price ?? 2));
        $remaining = $included;
        $adultsCovered = min($adults, $remaining);
        $remaining -= $adultsCovered;
        $childrenCovered = min($children, $remaining);
        $extraAdults = $adults - $adultsCovered;
        $extraChildren = $children - $childrenCovered;

        $base = (float) ($this->price ?? 0);
        $ea = (float) ($this->extra_adult_price ?? 0);
        $ec = (float) ($this->extra_child_price ?? 0);
        $eb = (float) ($this->extra_bed_price ?? 0);

        return $base + ($extraAdults * $ea) + ($extraChildren * $ec) + ($extraBeds * $eb);
    }

    /**
     * Public URL for listing cards and "Other rooms" blocks.
     * Paths in DB are relative to the storage disk root (same as asset('storage/…')).
     */
    public function publicThumbnailUrl(): string
    {
        if (filled($this->cover_image)) {
            return asset('storage/'.ltrim($this->cover_image, '/'));
        }

        $firstImg = $this->relationLoaded('images')
            ? $this->images->sortBy('id')->first()
            : $this->images()->orderBy('id')->first();

        if ($firstImg && filled($firstImg->image)) {
            $path = $firstImg->image;

            return asset('storage/'.ltrim($this->normalizeRoomImagePath($path), '/'));
        }

        if (filled($this->image)) {
            return asset('storage/'.ltrim($this->normalizeRoomImagePath($this->image), '/'));
        }

        return asset('storage/rooms/default.jpg');
    }

    /**
     * @param  string  $path  Filename only, or path under storage (e.g. images/rooms/photo.jpg)
     */
    private function normalizeRoomImagePath(string $path): string
    {
        $path = ltrim($path, '/');

        return str_contains($path, '/') ? $path : 'images/rooms/'.$path;
    }
}
