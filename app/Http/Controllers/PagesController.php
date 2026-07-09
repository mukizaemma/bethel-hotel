<?php

namespace App\Http\Controllers;

use App\Models\Eventimage;
use App\Models\Eventpage;
use App\Models\MeetingRoom;
use App\Models\MeetingRoomImage;
use App\Models\Restaurant;
use App\Models\RestaurantCuisine;
use App\Models\Restoimage;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PagesController extends Controller
{
    public function eventsPage()
    {
        $data = Eventpage::first();

        if ($data) {
            $data->load(['meetingRooms.images']);
            MeetingRoom::ensureDefaultsForEventpage($data);
            $data->load(['meetingRooms.images']);
        } else {
            Eventpage::create([
                'title' => 'Meetings & Events',
                'description' => 'Host your meetings and events with us.',
                'details' => '',
            ]);
            $data = Eventpage::first();
            MeetingRoom::ensureDefaultsForEventpage($data);
            $data->load(['meetingRooms.images']);
        }

        return view('admin.pages.events', [
            'data' => $data,
            'meetingRooms' => $data->meetingRooms ?? collect(),
        ]);
    }

    public function saveEvent(Request $request)
    {
        $data = Eventpage::firstOrFail();
        $data->title = $request->input('title');
        $data->description = $request->input('description');
        $data->details = $request->input('details');

        $data->save();

        return redirect()->back()->with('success', 'Page has been updated successfully');
    }

    public function addEventImage(Request $request)
    {
        $request->validate([
            'image.*' => 'image|mimes:jpeg,png,jpg,gif,webp,svg|max:5120',
            'eventpage_id' => 'required|exists:eventpages,id',
        ]);

        if (! $request->hasFile('image')) {
            return redirect()->back()->with('error', 'No images were uploaded.');
        }

        $maxOrder = (int) Eventimage::where('eventpage_id', $request->eventpage_id)->max('sort_order');

        foreach ($request->file('image') as $image) {
            $path = $image->store('public/images/events');
            $fileName = str_replace('public/images/events/', '', $path);

            $maxOrder++;
            Eventimage::create([
                'image' => $fileName,
                'eventpage_id' => $request->eventpage_id,
                'user_id' => $request->user()?->id,
                'sort_order' => $maxOrder,
            ]);
        }

        return redirect()->back()->with('success', 'Images uploaded successfully!');
    }

    public function updateEventImage(Request $request, $id)
    {
        $request->validate([
            'caption' => 'nullable|string|max:500',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp,svg|max:5120',
        ]);

        $row = Eventimage::findOrFail($id);

        if ($request->exists('caption')) {
            $row->caption = $request->input('caption');
        }

        if ($request->hasFile('image')) {
            $diskPath = 'images/events/'.$row->image;
            if (Storage::disk('public')->exists($diskPath)) {
                Storage::disk('public')->delete($diskPath);
            }
            $path = $request->file('image')->store('public/images/events');
            $fileName = str_replace('public/images/events/', '', $path);
            $row->image = $fileName;
        }

        $row->save();

        return redirect()->back()->with('success', 'Image updated.');
    }

    public function reorderEventImage(Request $request, $id)
    {
        $request->validate(['direction' => 'required|in:up,down']);

        $img = Eventimage::findOrFail($id);
        $rows = Eventimage::where('eventpage_id', $img->eventpage_id)
            ->orderBy('sort_order')
            ->orderBy('id')
            ->get();

        $idx = $rows->search(fn ($r) => (int) $r->id === (int) $img->id);
        if ($idx === false) {
            return redirect()->back();
        }

        $swapIdx = $request->input('direction') === 'up' ? $idx - 1 : $idx + 1;
        if ($swapIdx < 0 || $swapIdx >= $rows->count()) {
            return redirect()->back();
        }

        $a = $rows[$idx];
        $b = $rows[$swapIdx];
        $tmp = $a->sort_order;
        $a->sort_order = $b->sort_order;
        $b->sort_order = $tmp;
        $a->save();
        $b->save();

        return redirect()->back()->with('success', 'Order updated.');
    }

    public function deleteEventImage($id)
    {
        $image = Eventimage::findOrFail($id);
        $diskPath = 'images/events/'.$image->image;
        if (Storage::disk('public')->exists($diskPath)) {
            Storage::disk('public')->delete($diskPath);
        }
        $image->delete();

        return redirect()->back()->with('warning', 'Image has been deleted');
    }

    public function saveMeetingRoom(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'max_persons' => 'required|integer|min:1|max:10000',
            'description' => 'nullable|string',
            'cover_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:5120',
        ]);

        $room = MeetingRoom::findOrFail($id);
        $newTitle = $request->input('title');
        if ($room->title !== $newTitle) {
            $room->slug = MeetingRoom::uniqueSlugForEventpage((int) $room->eventpage_id, $newTitle, (int) $room->id);
        }
        $room->title = $newTitle;
        $room->max_persons = (int) $request->input('max_persons');
        $room->description = $request->input('description');

        if ($request->hasFile('cover_image')) {
            if ($room->image) {
                $diskPath = 'images/meeting-rooms/covers/'.$room->image;
                if (Storage::disk('public')->exists($diskPath)) {
                    Storage::disk('public')->delete($diskPath);
                }
            }
            $path = $request->file('cover_image')->store('public/images/meeting-rooms/covers');
            $room->image = str_replace('public/images/meeting-rooms/covers/', '', $path);
        }

        $room->save();

        return redirect()->back()->with('success', 'Meeting room updated.');
    }

    public function addMeetingRoom(Request $request)
    {
        $request->validate([
            'eventpage_id' => 'required|exists:eventpages,id',
            'title' => 'required|string|max:255',
            'max_persons' => 'required|integer|min:1|max:10000',
        ]);

        $maxOrder = (int) MeetingRoom::where('eventpage_id', $request->eventpage_id)->max('sort_order');

        $eventpageId = (int) $request->eventpage_id;
        $title = $request->title;
        MeetingRoom::create([
            'eventpage_id' => $eventpageId,
            'title' => $title,
            'slug' => MeetingRoom::uniqueSlugForEventpage($eventpageId, $title),
            'max_persons' => (int) $request->max_persons,
            'sort_order' => $maxOrder + 1,
        ]);

        return redirect()->back()->with('success', 'Meeting room added.');
    }

    public function deleteMeetingRoom($id)
    {
        $room = MeetingRoom::with('images')->findOrFail($id);
        if ($room->image) {
            $diskPath = 'images/meeting-rooms/covers/'.$room->image;
            if (Storage::disk('public')->exists($diskPath)) {
                Storage::disk('public')->delete($diskPath);
            }
        }
        foreach ($room->images as $img) {
            $p = 'images/meeting-rooms/gallery/'.$img->image;
            if (Storage::disk('public')->exists($p)) {
                Storage::disk('public')->delete($p);
            }
        }
        $room->delete();

        return redirect()->back()->with('warning', 'Meeting room removed.');
    }

    public function addMeetingRoomImage(Request $request)
    {
        $request->validate([
            'meeting_room_id' => 'required|exists:meeting_rooms,id',
            'image.*' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:5120',
        ]);

        if (! $request->hasFile('image')) {
            return redirect()->back()->with('error', 'No images were uploaded.');
        }

        $maxOrder = (int) MeetingRoomImage::where('meeting_room_id', $request->meeting_room_id)->max('sort_order');

        foreach ($request->file('image') as $image) {
            $path = $image->store('public/images/meeting-rooms/gallery');
            $fileName = str_replace('public/images/meeting-rooms/gallery/', '', $path);
            $maxOrder++;
            MeetingRoomImage::create([
                'meeting_room_id' => (int) $request->meeting_room_id,
                'image' => $fileName,
                'sort_order' => $maxOrder,
            ]);
        }

        return redirect()->back()->with('success', 'Gallery images uploaded.');
    }

    public function updateMeetingRoomImage(Request $request, $id)
    {
        $request->validate([
            'caption' => 'nullable|string|max:500',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:5120',
        ]);

        $row = MeetingRoomImage::findOrFail($id);

        if ($request->exists('caption')) {
            $row->caption = $request->input('caption');
        }

        if ($request->hasFile('image')) {
            $diskPath = 'images/meeting-rooms/gallery/'.$row->image;
            if (Storage::disk('public')->exists($diskPath)) {
                Storage::disk('public')->delete($diskPath);
            }
            $path = $request->file('image')->store('public/images/meeting-rooms/gallery');
            $row->image = str_replace('public/images/meeting-rooms/gallery/', '', $path);
        }

        $row->save();

        return redirect()->back()->with('success', 'Image updated.');
    }

    public function reorderMeetingRoomImage(Request $request, $id)
    {
        $request->validate(['direction' => 'required|in:up,down']);

        $img = MeetingRoomImage::findOrFail($id);
        $rows = MeetingRoomImage::where('meeting_room_id', $img->meeting_room_id)
            ->orderBy('sort_order')
            ->orderBy('id')
            ->get();

        $idx = $rows->search(fn ($r) => (int) $r->id === (int) $img->id);
        if ($idx === false) {
            return redirect()->back();
        }

        $swapIdx = $request->input('direction') === 'up' ? $idx - 1 : $idx + 1;
        if ($swapIdx < 0 || $swapIdx >= $rows->count()) {
            return redirect()->back();
        }

        $a = $rows[$idx];
        $b = $rows[$swapIdx];
        $tmp = $a->sort_order;
        $a->sort_order = $b->sort_order;
        $b->sort_order = $tmp;
        $a->save();
        $b->save();

        return redirect()->back()->with('success', 'Order updated.');
    }

    public function deleteMeetingRoomImage($id)
    {
        $image = MeetingRoomImage::findOrFail($id);
        $diskPath = 'images/meeting-rooms/gallery/'.$image->image;
        if (Storage::disk('public')->exists($diskPath)) {
            Storage::disk('public')->delete($diskPath);
        }
        $image->delete();

        return redirect()->back()->with('warning', 'Image deleted.');
    }

    public function resto()
    {
        $data = Restaurant::with('images')->first();
        $images = collect();
        $totalImages = 0;

        if ($data) {
            $data->load(['images', 'cuisines']);
            $images = $data->images ?? collect();
            $totalImages = $images->count();
            $cuisines = $data->cuisines ?? collect();
        } else {
            Restaurant::create([
                'title' => 'Dining',
                'description' => 'Discover our restaurant and bar.',
            ]);
            $data = Restaurant::with(['images', 'cuisines'])->first();
            $images = $data->images ?? collect();
            $totalImages = $images->count();
            $cuisines = $data->cuisines ?? collect();
        }

        return view('admin.pages.restaurant', [
            'data' => $data,
            'images' => $images,
            'totalImages' => $totalImages,
            'cuisines' => $cuisines,
            'totalCuisines' => $cuisines->count(),
        ]);
    }

    public function saveResto(Request $request, $id)
    {
        $request->validate([
            'title' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'cuisine_section_title' => 'nullable|string|max:255',
            'cuisine_section_lead' => 'nullable|string|max:2000',
        ]);

        $data = Restaurant::findOrFail($id);
        $data->title = $request->input('title');
        $data->description = $request->input('description');
        $data->cuisine_section_title = $request->input('cuisine_section_title');
        $data->cuisine_section_lead = $request->input('cuisine_section_lead');
        $data->save();

        return redirect()->back()->with('success', 'Page has been updated successfully');
    }

    public function addRestoCuisine(Request $request)
    {
        $request->validate([
            'restaurant_id' => 'required|exists:restaurants,id',
            'title' => 'required|string|max:255',
            'summary' => 'nullable|string|max:500',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:5120',
        ]);

        $maxOrder = (int) RestaurantCuisine::where('restaurant_id', $request->restaurant_id)->max('sort_order');
        $path = $request->file('image')->store('public/images/restaurant/cuisines');
        $fileName = str_replace('public/images/restaurant/cuisines/', '', $path);

        RestaurantCuisine::create([
            'restaurant_id' => (int) $request->restaurant_id,
            'title' => $request->input('title'),
            'summary' => $request->input('summary'),
            'image' => $fileName,
            'sort_order' => $maxOrder + 1,
        ]);

        return redirect()->back()->with('success', 'Kitchen specialization added.');
    }

    public function updateRestoCuisine(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'summary' => 'nullable|string|max:500',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:5120',
        ]);

        $row = RestaurantCuisine::findOrFail($id);
        $row->title = $request->input('title');
        $row->summary = $request->input('summary');

        if ($request->hasFile('image')) {
            $diskPath = 'images/restaurant/cuisines/'.$row->image;
            if ($row->image && Storage::disk('public')->exists($diskPath)) {
                Storage::disk('public')->delete($diskPath);
            }
            $path = $request->file('image')->store('public/images/restaurant/cuisines');
            $row->image = str_replace('public/images/restaurant/cuisines/', '', $path);
        }

        $row->save();

        return redirect()->back()->with('success', 'Specialization updated.');
    }

    public function reorderRestoCuisine(Request $request, $id)
    {
        $request->validate(['direction' => 'required|in:up,down']);

        $item = RestaurantCuisine::findOrFail($id);
        $rows = RestaurantCuisine::where('restaurant_id', $item->restaurant_id)
            ->orderBy('sort_order')
            ->orderBy('id')
            ->get();

        $idx = $rows->search(fn ($r) => (int) $r->id === (int) $item->id);
        if ($idx === false) {
            return redirect()->back();
        }

        $swapIdx = $request->input('direction') === 'up' ? $idx - 1 : $idx + 1;
        if ($swapIdx < 0 || $swapIdx >= $rows->count()) {
            return redirect()->back();
        }

        $a = $rows[$idx];
        $b = $rows[$swapIdx];
        $tmp = $a->sort_order;
        $a->sort_order = $b->sort_order;
        $b->sort_order = $tmp;
        $a->save();
        $b->save();

        return redirect()->back()->with('success', 'Order updated.');
    }

    public function deleteRestoCuisine($id)
    {
        $row = RestaurantCuisine::findOrFail($id);
        $diskPath = 'images/restaurant/cuisines/'.$row->image;
        if ($row->image && Storage::disk('public')->exists($diskPath)) {
            Storage::disk('public')->delete($diskPath);
        }
        $row->delete();

        return redirect()->back()->with('warning', 'Specialization removed.');
    }

    public function addRestoImage(Request $request)
    {
        $request->validate([
            'image.*' => 'image|mimes:jpeg,png,jpg,gif,webp,svg|max:5120',
            'restaurant_id' => 'required|exists:restaurants,id',
        ]);

        if (! $request->hasFile('image')) {
            return redirect()->back()->with('error', 'No images were uploaded.');
        }

        $maxOrder = (int) Restoimage::where('restaurant_id', $request->restaurant_id)->max('sort_order');

        foreach ($request->file('image') as $image) {
            $path = $image->store('public/images/restaurant');
            $fileName = str_replace('public/images/restaurant/', '', $path);

            $maxOrder++;
            Restoimage::create([
                'image' => $fileName,
                'restaurant_id' => $request->restaurant_id,
                'user_id' => $request->user()?->id,
                'sort_order' => $maxOrder,
            ]);
        }

        return redirect()->back()->with('success', 'Images uploaded successfully!');
    }

    public function updateRestoImage(Request $request, $id)
    {
        $request->validate([
            'caption' => 'nullable|string|max:500',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp,svg|max:5120',
        ]);

        $row = Restoimage::findOrFail($id);

        if ($request->exists('caption')) {
            $row->caption = $request->input('caption');
        }

        if ($request->hasFile('image')) {
            $diskPath = 'images/restaurant/'.$row->image;
            if (Storage::disk('public')->exists($diskPath)) {
                Storage::disk('public')->delete($diskPath);
            }
            $path = $request->file('image')->store('public/images/restaurant');
            $fileName = str_replace('public/images/restaurant/', '', $path);
            $row->image = $fileName;
        }

        $row->save();

        return redirect()->back()->with('success', 'Image updated.');
    }

    public function reorderRestoImage(Request $request, $id)
    {
        $request->validate(['direction' => 'required|in:up,down']);

        $img = Restoimage::findOrFail($id);
        $rows = Restoimage::where('restaurant_id', $img->restaurant_id)
            ->orderBy('sort_order')
            ->orderBy('id')
            ->get();

        $idx = $rows->search(fn ($r) => (int) $r->id === (int) $img->id);
        if ($idx === false) {
            return redirect()->back();
        }

        $swapIdx = $request->input('direction') === 'up' ? $idx - 1 : $idx + 1;
        if ($swapIdx < 0 || $swapIdx >= $rows->count()) {
            return redirect()->back();
        }

        $a = $rows[$idx];
        $b = $rows[$swapIdx];
        $tmp = $a->sort_order;
        $a->sort_order = $b->sort_order;
        $b->sort_order = $tmp;
        $a->save();
        $b->save();

        return redirect()->back()->with('success', 'Order updated.');
    }

    public function deleteRestoImage($id)
    {
        $image = Restoimage::findOrFail($id);
        $diskPath = 'images/restaurant/'.$image->image;
        if (Storage::disk('public')->exists($diskPath)) {
            Storage::disk('public')->delete($diskPath);
        }
        $image->delete();

        return redirect()->back()->with('warning', 'Image has been deleted');
    }
}
