<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\HotelContact;
use App\Models\About;
use App\Models\TermsCondition;
use App\Models\SeoData;
use App\Models\User;
use App\Models\Role;
use Illuminate\Validation\Rule;
use App\Models\Service;
use App\Models\Room;
use App\Models\Facility;
use App\Models\Amenity;
use App\Models\Gallery;
use App\Models\Slide;
use App\Models\ServiceImage;
use App\Models\Roomimage;
use App\Models\Facilityimage;
use App\Models\PageHero;
use App\Models\Booking;
use App\Models\BookingTrash;
use App\Models\MediaImage;
use App\Services\MediaLibrary;
use App\Services\ImageOptimizer;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;

class ContentManagementController extends Controller
{
    public function dashboard()
    {
        $stats = [
            'rooms' => Room::count(),
            'services' => Service::count(),
            'facilities' => Facility::count(),
            'users' => User::count(),
        ];
        
        return view('content-management.dashboard', compact('stats'));
    }

    /**
     * Reservations overview for Content Manager (rooms vs facilities).
     */
    public function reservations()
    {
        $roomReservations = Booking::where('reservation_type', 'room')
            ->with(['room', 'assignedRoom'])
            ->latest()
            ->take(200)
            ->get();

        $facilityReservations = Booking::where('reservation_type', 'facility')
            ->with('facility')
            ->latest()
            ->take(200)
            ->get();

        return view('content-management.reservations.index', compact('roomReservations', 'facilityReservations'));
    }

    /**
     * Fetch single reservation (for modal view).
     */
    public function showReservation($id)
    {
        $booking = Booking::with(['room', 'assignedRoom', 'facility', 'tourActivity'])->findOrFail($id);
        return response()->json($booking);
    }

    /**
     * Reply to reservation with status & custom message.
     * Status options: confirmed, rejected, full-booked, scam.
     * Rejected or scam bookings are moved to trash table.
     */
    public function replyReservation(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:confirmed,rejected,full-booked,scam',
            'admin_reply' => 'required|string|max:2000',
        ]);

        $booking = Booking::with(['room', 'facility', 'tourActivity'])->findOrFail($id);

        $booking->status = $request->status;
        $booking->admin_reply = $request->admin_reply;
        $booking->admin_replied_at = now();

        // Prepare email if guest has an email
        $guestEmail = $booking->email;
        if ($guestEmail) {
            $itemName = 'Reservation';
            if ($booking->reservation_type === 'facility' && $booking->facility) {
                $itemName = $booking->facility->title;
            } elseif ($booking->reservation_type === 'tour_activity' && $booking->tourActivity) {
                $itemName = $booking->tourActivity->title;
            } elseif ($booking->room) {
                $itemName = $booking->room->title;
            }

            $statusLabelMap = [
                'confirmed'   => 'Confirmed',
                'rejected'    => 'Rejected',
                'full-booked' => 'Full-booked',
                'scam'        => 'Marked as Scam',
            ];
            $statusLabel = $statusLabelMap[$request->status] ?? ucfirst($request->status);

            $subject = 'Reservation ' . $statusLabel . ' - ' . $itemName;
            $body = "Hello " . $booking->names . ",\n\n";
            $body .= "Your reservation for " . $itemName . " has been " . strtolower($statusLabel) . ".\n\n";
            $body .= "Message from the hotel:\n" . $request->admin_reply . "\n\n";

            if ($booking->checkin_date || $booking->checkout_date) {
                $body .= "Check-in: " . ($booking->checkin_date ? $booking->checkin_date->format('Y-m-d') : '') . "\n";
                $body .= "Check-out: " . ($booking->checkout_date ? $booking->checkout_date->format('Y-m-d') : '') . "\n\n";
            }

            $body .= "Thank you.";

            try {
                Mail::raw($body, function ($message) use ($guestEmail, $subject) {
                    $message->to($guestEmail)->subject($subject);
                });
            } catch (\Exception $e) {
                return response()->json([
                    'success' => false,
                    'message' => 'Reply saved but email could not be sent: ' . $e->getMessage(),
                ], 500);
            }
        }

        // Move to trash if rejected or scam
        if (in_array($request->status, ['rejected', 'scam'])) {
            BookingTrash::create([
                'original_booking_id' => $booking->id,
                'names' => $booking->names,
                'email' => $booking->email,
                'phone' => $booking->phone,
                'reservation_type' => $booking->reservation_type,
                'status' => $booking->status,
                'payload' => $booking->toArray(),
            ]);

            $booking->delete();
        } else {
            $booking->save();
        }

        return response()->json(['success' => true]);
    }

    // Hotel Contacts Management
    public function contacts()
    {
        $contact = HotelContact::first();
        return view('content-management.contacts.index', compact('contact'));
    }

    public function updateContacts(Request $request)
    {
        $contact = HotelContact::firstOrNew();
        $contact->fill($request->all());
        $contact->save();

        return redirect()->back()->with('success', 'Hotel contacts updated successfully');
    }

    // About Us Management
    public function about()
    {
        $about = About::first();
        return view('content-management.about.index', compact('about'));
    }

    public function updateAbout(Request $request)
    {
        $about = About::firstOrNew();
        $about->fill($request->only(['title', 'subTitle', 'founderDescription', 'mission', 'vision', 'storyDescription', 'backImageText']));
        $about->user_id = auth()->id();
        
        // Handle image uploads
        if ($request->hasFile('image1')) {
            if ($about->image1) {
                \Storage::disk('public')->delete($about->image1);
            }
            $about->image1 = $request->file('image1')->store('abouts', 'public');
        }
        if ($request->hasFile('image2')) {
            if ($about->image2) {
                \Storage::disk('public')->delete($about->image2);
            }
            $about->image2 = $request->file('image2')->store('abouts', 'public');
        }
        if ($request->hasFile('image3')) {
            if ($about->image3) {
                \Storage::disk('public')->delete($about->image3);
            }
            $about->image3 = $request->file('image3')->store('abouts', 'public');
        }
        if ($request->hasFile('image4')) {
            if ($about->image4) {
                \Storage::disk('public')->delete($about->image4);
            }
            $about->image4 = $request->file('image4')->store('abouts', 'public');
        }
        if ($request->hasFile('storyImage')) {
            if ($about->storyImage) {
                \Storage::disk('public')->delete($about->storyImage);
            }
            $about->storyImage = $request->file('storyImage')->store('abouts', 'public');
        }
        
        $about->save();

        return redirect()->back()->with('success', 'About information updated successfully');
    }

    // Terms and Conditions
    public function termsConditions()
    {
        $terms = TermsCondition::first();
        return view('content-management.terms.index', compact('terms'));
    }

    public function updateTermsConditions(Request $request)
    {
        $terms = TermsCondition::firstOrNew();
        $terms->content = $request->content;
        $terms->status = $request->status ?? 'active';
        $terms->updated_by = auth()->id();
        $terms->save();

        return redirect()->back()->with('success', 'Terms and conditions updated successfully');
    }

    // SEO Data Management
    public function seoData()
    {
        $seoData = SeoData::all();
        return view('content-management.seo.index', compact('seoData'));
    }

    public function showSeoData($id)
    {
        $seo = SeoData::findOrFail($id);
        return response()->json($seo);
    }

    public function updateSeoData(Request $request)
    {
        $id = $request->input('id') ?? $request->query('id');
        
        if ($id) {
            $seo = SeoData::findOrFail($id);
        } else {
            $request->validate([
                'page_name' => 'required|unique:seo_data,page_name',
            ]);
            $seo = new SeoData();
        }
        
        $seo->fill($request->only(['page_name', 'meta_title', 'meta_description', 'meta_keywords', 'og_title', 'og_description']));
        $seo->updated_by = auth()->id();
        
        if ($request->hasFile('og_image')) {
            if ($seo->og_image) {
                \Storage::disk('public')->delete($seo->og_image);
            }
            $seo->og_image = $request->file('og_image')->store('seo', 'public');
        }
        
        $seo->save();

        if ($request->wantsJson()) {
            return response()->json(['success' => true, 'message' => 'SEO data saved successfully']);
        }

        return redirect()->back()->with('success', 'SEO data updated successfully');
    }

    // System Users Panel (Super Admin only)
    public function users()
    {
        $users = User::with('role')->latest()->get();
        $roles = Role::whereIn('slug', ['admin', 'guest'])->orderBy('name')->get();
        $superAdminRole = Role::where('slug', 'super-admin')->first();

        return view('content-management.users.index', compact('users', 'roles', 'superAdminRole'));
    }

    public function updateUserRole(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $allowedRoleIds = Role::whereIn('slug', ['admin', 'guest'])->pluck('id')->all();
        $superAdminRoleId = Role::where('slug', 'super-admin')->value('id');
        if ($superAdminRoleId && (int) $user->role_id === (int) $superAdminRoleId) {
            $allowedRoleIds[] = (int) $superAdminRoleId;
        }

        $request->validate([
            'role_id' => ['required', Rule::in($allowedRoleIds)],
        ]);

        $user->role_id = $request->role_id;
        $user->save();

        return redirect()->back()->with('success', 'User role updated successfully');
    }

    // Services Management
    public function services()
    {
        $services = Service::with('images')->latest()->get();
        return view('content-management.services.index', compact('services'));
    }

    public function storeService(Request $request)
    {
        $service = new Service();
        $service->fill($request->all());
        $service->slug = \Illuminate\Support\Str::slug($request->title);
        if ($request->hasFile('image')) {
            $service->image = $request->file('image')->store('services', 'public');
        }
        $service->save();

        // Handle multiple images
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $index => $image) {
                ServiceImage::create([
                    'service_id' => $service->id,
                    'image' => $image->store('services', 'public'),
                    'order' => $index,
                ]);
            }
        }

        return redirect()->back()->with('success', 'Service created successfully');
    }

    // Rooms Management
    public function rooms()
    {
        $rooms = Room::with(['amenities', 'images'])->latest()->get();
        $amenities = Amenity::all();
        return view('content-management.rooms.index', compact('rooms', 'amenities'));
    }

    public function storeRoom(Request $request)
    {
        $room = new Room();
        $room->fill($request->all());
        $room->slug = \Illuminate\Support\Str::slug($request->title);
        if ($request->hasFile('image')) {
            $room->image = $request->file('image')->store('rooms', 'public');
        }
        $room->user_id = auth()->id();
        $room->save();

        // Attach amenities
        if ($request->has('amenities')) {
            $room->amenities()->sync($request->amenities);
        }

        // Handle multiple images
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $index => $image) {
                Roomimage::create([
                    'room_id' => $room->id,
                    'image' => $image->store('rooms', 'public'),
                ]);
            }
        }

        return redirect()->back()->with('success', 'Room created successfully');
    }

    // Facilities Management
    public function facilities()
    {
        $facilities = Facility::with('images')->latest()->get();
        return view('content-management.facilities.index', compact('facilities'));
    }

    public function storeFacility(Request $request)
    {
        $facility = new Facility();
        $facility->fill($request->all());
        $facility->slug = \Illuminate\Support\Str::slug($request->title);
        if ($request->hasFile('image')) {
            $facility->image = $request->file('image')->store('facilities', 'public');
        }
        $facility->save();

        // Handle multiple images
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $index => $image) {
                Facilityimage::create([
                    'facility_id' => $facility->id,
                    'image' => $image->store('facilities', 'public'),
                ]);
            }
        }

        return redirect()->back()->with('success', 'Facility created successfully');
    }

    // Gallery Management
    public function gallery()
    {
        $gallery = Gallery::query()->with('mediaImage')->ordered()->get();
        $mediaImages = MediaImage::query()->latest()->get();

        return view('content-management.gallery.index', compact('gallery', 'mediaImages'));
    }

    public function storeGallery(Request $request)
    {
        $mediaLibrary = app(MediaLibrary::class);

        if ($request->media_type === 'image') {
            $files = $request->file('images');
            if (empty($files)) {
                $files = $request->hasFile('image') ? [$request->file('image')] : [];
            }
            if (! is_array($files)) {
                $files = [$files];
            }
            $count = 0;
            $caption = $request->input('caption');
            $category = $request->input('category');

            foreach ($files as $file) {
                if (! $file || ! $file->isValid()) {
                    continue;
                }
                $media = $mediaLibrary->ingestUploadedFile($file);
                $item = $mediaLibrary->attachToGallery($media, $caption, $category);
                if ($caption && ! $item->caption) {
                    $item->caption = $caption;
                    $item->category = $category;
                    $item->save();
                }
                $count++;
            }

            foreach ($mediaLibrary->findMany((array) $request->input('existing_media_ids', [])) as $media) {
                $mediaLibrary->attachToGallery($media, $caption, $category);
                $count++;
            }

            if ($count === 0) {
                return redirect()->back()->with('error', 'Upload new images or select existing ones from the media library.');
            }

            return redirect()->back()->with('success', 'Gallery images updated successfully.');
        }

        $gallery = new Gallery();
        $gallery->media_type = $request->media_type;
        $gallery->category = $request->category;
        $gallery->caption = $request->caption;

        if ($request->hasFile('video')) {
            $gallery->video_path = $request->file('video')->store('gallery/videos', 'public');
        }
        if ($request->youtube_link) {
            $gallery->youtube_link = $request->youtube_link;
        }
        if ($request->hasFile('thumbnail')) {
            $gallery->thumbnail = $request->file('thumbnail')->store('gallery', 'public');
        }

        $gallery->sort_order = ((int) Gallery::query()->max('sort_order')) + 1;
        $gallery->save();

        return redirect()->back()->with('success', 'Gallery item added successfully');
    }

    public function destroyGallery($id)
    {
        $item = Gallery::findOrFail($id);
        $item->delete();

        return redirect()->back()->with('warning', 'Item removed from the gallery page.');
    }

    public function reorderGallery(Request $request)
    {
        $ids = array_values(array_filter(array_map('intval', (array) $request->input('order', []))));
        $count = count($ids);
        foreach ($ids as $index => $id) {
            Gallery::query()->where('id', $id)->update(['sort_order' => $count - $index]);
        }

        return redirect()->back()->with('success', 'Gallery order saved.');
    }

    public function moveGallery(Request $request, $id)
    {
        $direction = $request->input('direction');
        $items = Gallery::query()->ordered()->get()->values();
        $index = $items->search(fn (Gallery $item) => (int) $item->id === (int) $id);
        if ($index === false) {
            return redirect()->back()->with('error', 'Gallery item not found.');
        }

        $swapWith = $direction === 'up' ? $index - 1 : $index + 1;
        if ($swapWith < 0 || $swapWith >= $items->count()) {
            return redirect()->back();
        }

        $temp = $items[$index];
        $items[$index] = $items[$swapWith];
        $items[$swapWith] = $temp;
        $count = $items->count();
        foreach ($items as $i => $item) {
            $item->sort_order = $count - $i;
            $item->save();
        }

        return redirect()->back()->with('success', 'Gallery order updated.');
    }

    // Slideshow Management
    public function slideshow()
    {
        $slides = Slide::latest()->get();
        return view('content-management.slideshow.index', compact('slides'));
    }

    public function storeSlide(Request $request)
    {
        $rules = [
            'heading' => 'nullable|string|max:255',
            'subheading' => 'nullable|string|max:255',
            'button' => 'nullable|string|max:255',
            'link' => 'nullable|url|max:255',
            'media_type' => 'required|in:image,video',
        ];

        if ($request->media_type === 'image') {
            $rules['image'] = 'required|image|max:2048';
        } else {
            // Video validation - at least one must be provided
            $rules['video_url'] = 'nullable|url|max:500';
            $rules['video_file'] = 'nullable|mimes:mp4,webm,ogg|max:10240'; // 10MB max for video
        }

        $request->validate($rules);

        // Additional validation for video: at least video_url or video_file must be provided
        if ($request->media_type === 'video') {
            if (empty($request->video_url) && !$request->hasFile('video_file')) {
                return redirect()->back()->with('error', 'Please provide either a video URL or upload a video file.');
            }
        }

        $slide = new Slide();
        $slide->heading = $request->heading;
        $slide->subheading = $request->subheading;
        $slide->button = $request->button;
        $slide->link = $request->link;
        $slide->media_type = $request->media_type;
        
        if ($request->media_type === 'image') {
            if ($request->hasFile('image')) {
                $slide->image = $request->file('image')->store('slides', 'public');
            }
        } else {
            // Video mode - prioritize URL over file
            if ($request->filled('video_url')) {
                $slide->video_url = $request->video_url;
            } elseif ($request->hasFile('video_file')) {
                $slide->video_file = $request->file('video_file')->store('slides/videos', 'public');
            }
        }
        
        $slide->save();

        return redirect()->back()->with('success', 'Slide added successfully');
    }

    public function updateSlide(Request $request, Slide $slide)
    {
        $rules = [
            'heading' => 'nullable|string|max:255',
            'subheading' => 'nullable|string|max:255',
            'button' => 'nullable|string|max:255',
            'link' => 'nullable|url|max:255',
            'media_type' => 'required|in:image,video',
        ];

        if ($request->media_type === 'image') {
            $rules['image'] = 'nullable|image|max:2048';
        } else {
            $rules['video_url'] = 'nullable|url|max:500';
            $rules['video_file'] = 'nullable|mimes:mp4,webm,ogg|max:10240';
        }

        $request->validate($rules);

        if ($request->media_type === 'video' && empty($request->video_url) && ! $request->hasFile('video_file')) {
            return redirect()->back()->with('error', 'Please provide either a video URL or upload a video file.');
        }

        $slide->heading = $request->heading;
        $slide->subheading = $request->subheading;
        $slide->button = $request->button;
        $slide->link = $request->link;
        $slide->media_type = $request->media_type;

        if ($request->media_type === 'image') {
            // Clear any previous video data
            if ($slide->video_file) {
                Storage::disk('public')->delete($slide->video_file);
            }
            $slide->video_url = null;
            $slide->video_file = null;

            if ($request->hasFile('image')) {
                if ($slide->image) {
                    Storage::disk('public')->delete($slide->image);
                }
                $slide->image = $request->file('image')->store('slides', 'public');
            }
        } else {
            // Clear any previous image
            if ($slide->image) {
                Storage::disk('public')->delete($slide->image);
            }
            $slide->image = null;

            if ($request->filled('video_url')) {
                $slide->video_url = $request->video_url;
                if ($slide->video_file) {
                    Storage::disk('public')->delete($slide->video_file);
                }
                $slide->video_file = null;
            } elseif ($request->hasFile('video_file')) {
                if ($slide->video_file) {
                    Storage::disk('public')->delete($slide->video_file);
                }
                $slide->video_url = null;
                $slide->video_file = $request->file('video_file')->store('slides/videos', 'public');
            }
        }

        $slide->save();

        return redirect()->back()->with('success', 'Slide updated successfully');
    }

    public function deleteSlide(Slide $slide)
    {
        if ($slide->image) {
            Storage::disk('public')->delete($slide->image);
        }
        if ($slide->video_file) {
            Storage::disk('public')->delete($slide->video_file);
        }

        $slide->delete();

        return redirect()->back()->with('success', 'Slide deleted successfully');
    }

    // Page Heroes Management (only pages linked on the public site)
    public function pageHeroes()
    {
        $definitions = config('page_heroes', []);

        foreach ($definitions as $slug => $meta) {
            $hero = PageHero::firstOrNew(['page_slug' => $slug]);
            if (! $hero->exists) {
                $hero->page_name = $meta['label'];
                $hero->is_active = true;
                $hero->save();
            } elseif ($hero->page_name !== $meta['label']) {
                $hero->page_name = $meta['label'];
                $hero->save();
            }
        }

        $order = array_keys($definitions);
        $pageHeroes = PageHero::query()
            ->whereIn('page_slug', $order)
            ->get()
            ->sortBy(function ($h) use ($order) {
                $i = array_search($h->page_slug, $order, true);

                return $i === false ? 1000 + $h->id : $i;
            })
            ->values();

        $defaultHero = $pageHeroes->firstWhere('page_slug', 'default');
        $heroPaths = collect($definitions)->map(fn ($m) => $m['path'])->all();

        return view('content-management.page-heroes.index', compact('pageHeroes', 'heroPaths', 'defaultHero'));
    }

    public function updatePageHero(Request $request, $id)
    {
        try {
            $request->validate([
                'background_image' => 'nullable|image|mimes:jpeg,jpg,png,gif,webp|max:10240',
                'caption' => 'nullable|string|max:255',
                'description' => 'nullable|string|max:500',
            ]);

            $pageHero = PageHero::findOrFail($id);

            if ($request->boolean('remove_background_image') && $pageHero->background_image) {
                Storage::disk('public')->delete($pageHero->background_image);
                $pageHero->background_image = null;
            }

            if ($request->hasFile('background_image')) {
                if ($pageHero->background_image) {
                    Storage::disk('public')->delete($pageHero->background_image);
                }
                $pageHero->background_image = app(ImageOptimizer::class)
                    ->store($request->file('background_image'), 'page-heroes');
            }

            $pageHero->caption = $request->input('caption', '');
            $pageHero->description = $request->input('description', '');
            $pageHero->is_active = true;
            $saved = $pageHero->save();

            if ($saved) {
                $message = $pageHero->page_slug === 'default'
                    ? 'Default header image saved. Pages without their own photo will use this one.'
                    : 'Page header updated successfully.';

                return redirect()->back()->with('success', $message);
            }

            return redirect()->back()->with('error', 'Failed to update page hero. Please try again.');
        } catch (\Illuminate\Validation\ValidationException $e) {
            return redirect()->back()
                ->withErrors($e->errors())
                ->withInput()
                ->with('error', 'Validation failed. Please check your input.');
        } catch (\Exception $e) {
            \Log::error('Page Hero Update Error: '.$e->getMessage());

            return redirect()->back()->with('error', 'An error occurred: '.$e->getMessage());
        }
    }
}
