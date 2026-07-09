<?php

namespace App\Http\Controllers;

use App\Models\Home;
use App\Models\Term;
use App\Models\About;
use App\Models\Aboutus;
use App\Models\Setting;
use App\Models\TermsCondition;
use App\Models\Getinvolved;
use App\Support\HotelChannels;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;

class SettingsController extends Controller
{
    public function setting(){
        $data = Setting::first();
        $setting = Setting::first();
        if($data===null)
        {
            $data = new Setting();
            $data->title = 'Company Name';
            $data->user_id = Auth()->user()->id;
            $data->company = 'Company Name';
            $data->keywords = 'Community development in Rwanda';
            $data->save();
            $data = Setting::first();
        }

        $about = About::first();
        $terms = TermsCondition::first();

        $canEditDelivery = Auth::check()
            && strtolower((string) Auth::user()->email) === 'admin@iremetech.com';

        return view('admin.setting', compact('data', 'setting', 'about', 'terms', 'canEditDelivery'));
    }



    public function saveSetting(Request $request){
        $request->merge([
            'star_rating' => $request->filled('star_rating') ? (int) $request->input('star_rating') : null,
        ]);
        $request->validate([
            'star_rating' => 'nullable|integer|min:1|max:5',
            'ga4_measurement_id' => 'nullable|string|max:32',
            'ga4_reports_url' => 'nullable|url|max:4000',
            'price_currency' => 'nullable|in:usd,rwf',
        ]);

        $data = Setting::first();
        $data->company = $request->input('company');
        $data->address = $request->input('address');
        $data->phone = $request->input('phone');
        $data->reception_phone = $request->input('reception_phone');
        $data->manager_phone = $request->input('manager_phone');
        $data->restaurant_phone = $request->input('restaurant_phone');
        $data->email = $request->input('email');
        $data->facebook = $request->input('facebook');
        $data->instagram = $request->input('instagram');
        $data->youtube = $request->input('youtube');
        $data->linkedin = $request->input('linkedin');
        $data->linktree = $request->input('linktree');
        $data->keywords = $request->input('keywords');
        $data->quote = $request->input('quote');
        $data->google_map_embed = $request->input('google_map_embed');
        $data->star_rating = $request->input('star_rating');
        $ga4MeasurementId = strtoupper(trim((string) $request->input('ga4_measurement_id', '')));
        $data->ga4_measurement_id = $ga4MeasurementId !== '' ? $ga4MeasurementId : null;
        $data->ga4_reports_url = $request->filled('ga4_reports_url') ? trim((string) $request->input('ga4_reports_url')) : null;
        $data->price_currency = $request->input('price_currency', 'usd');
        $data->user_id = Auth()->user()->id;


        if ($request->hasFile('logo') && request('logo') != '') {
            $dir = 'public/images';

            if (File::exists($dir)) {
                unlink($dir);
            }
            $path = $request->file('logo')->store($dir);
            $fileName = str_replace($dir, '', $path);

            $data->logo = $fileName;
        }


        if ($request->hasFile('donate') && request('donate') != '') {
            $dir = 'public/images';

            if (File::exists($dir)) {
                unlink($dir);
            }
            $path = $request->file('donate')->store($dir);
            $fileNameLogo2 = str_replace($dir, '', $path);

            $data->donate = $fileNameLogo2;
        }

        $saved = $data->update();

        if($saved){
            return redirect()->back()->with('success', 'Setting has been updated successfully');
        }
        else{
            abort(404);
        }
    }

    /**
     * Footer "Delivered by" line (company + URL, show/hide) — only editable by admin@iremetech.com.
     */
    public function updateFooterDeliveredBy(Request $request)
    {
        if (! Auth::check() || strtolower((string) Auth::user()->email) !== 'admin@iremetech.com') {
            abort(403);
        }

        $validated = $request->validate([
            'footer_delivered_by_company' => 'nullable|string|max:255',
            'footer_delivered_by_url' => 'nullable|string|max:500',
        ]);

        $url = trim((string) ($validated['footer_delivered_by_url'] ?? ''));
        if ($url !== '' && ! filter_var($url, FILTER_VALIDATE_URL)) {
            return redirect()->back()
                ->withErrors(['footer_delivered_by_url' => 'Enter a valid URL (including https://) or leave empty.'])
                ->withInput();
        }

        $setting = Setting::first();
        if (! $setting) {
            return redirect()->back()->with('error', 'No settings record found.');
        }

        $setting->footer_delivered_by_enabled = $request->boolean('footer_delivered_by_enabled');
        $setting->footer_delivered_by_company = trim((string) ($validated['footer_delivered_by_company'] ?? ''));
        $setting->footer_delivered_by_url = $url;
        $setting->save();

        return redirect()->back()->with('success', 'Footer “Delivered by” settings updated successfully.');
    }

    /**
     * Booking.com, TripAdvisor, Google, WhatsApp — overrides config/hotel_channels.php (.env defaults).
     */
    public function saveChannelLinks(Request $request)
    {
        $validated = $request->validate([
            'booking_com_url' => 'nullable|string|max:4000',
            'booking_com_review_score' => 'nullable|numeric|min:0|max:10',
            'booking_com_review_count' => 'nullable|integer|min:0|max:99999999',
            'booking_com_review_summary' => 'nullable|string|max:2000',
            'booking_com_write_review_url' => 'nullable|string|max:4000',
            'tripadvisor_location_id' => 'nullable|string|max:32',
            'tripadvisor_hotel_url' => 'nullable|string|max:4000',
            'tripadvisor_write_review_url' => 'nullable|string|max:4000',
            'tripadvisor_review_score' => 'nullable|numeric|min:0|max:5',
            'tripadvisor_review_count' => 'nullable|integer|min:0|max:99999999',
            'tripadvisor_review_summary' => 'nullable|string|max:2000',
            'google_place_url' => 'nullable|string|max:4000',
            'google_maps_embed_url' => 'nullable|string|max:4000',
            'google_review_score' => 'nullable|numeric|min:0|max:5',
            'google_review_count' => 'nullable|integer|min:0|max:99999999',
            'google_review_summary' => 'nullable|string|max:2000',
            'google_write_review_url' => 'nullable|string|max:4000',
            'whatsapp_e164' => 'nullable|string|max:32',
            'whatsapp_default_message' => 'nullable|string|max:2000',
            'channel_contact_email' => 'nullable|email|max:255',
        ]);

        $setting = Setting::first();
        if (! $setting) {
            return redirect()->back()->with('error', 'No settings record found.');
        }

        foreach ([
            'booking_com_url',
            'booking_com_review_score',
            'booking_com_review_count',
            'booking_com_review_summary',
            'booking_com_write_review_url',
            'tripadvisor_location_id',
            'tripadvisor_hotel_url',
            'tripadvisor_write_review_url',
            'tripadvisor_review_score',
            'tripadvisor_review_count',
            'tripadvisor_review_summary',
            'google_place_url',
            'google_maps_embed_url',
            'google_review_score',
            'google_review_count',
            'google_review_summary',
            'google_write_review_url',
            'whatsapp_e164',
            'whatsapp_default_message',
            'channel_contact_email',
        ] as $key) {
            $v = $validated[$key] ?? null;
            if ($v === null || (is_string($v) && trim($v) === '')) {
                $setting->{$key} = null;
            } elseif (in_array($key, ['booking_com_review_count', 'tripadvisor_review_count', 'google_review_count'], true)) {
                $setting->{$key} = (int) $v;
            } else {
                $setting->{$key} = $v;
            }
        }

        $setting->save();
        HotelChannels::forgetCache();

        return redirect()->back()->with('success', 'Booking & review links updated successfully.');
    }

    /**
     * Update only the header SEO keywords (used in meta name="keywords").
     */
    public function updateKeywords(Request $request)
    {
        $request->validate(['keywords' => 'nullable|string']);
        $setting = Setting::first();
        if (!$setting) {
            return redirect()->back()->with('error', 'No settings record found.');
        }
        $setting->keywords = $request->input('keywords', '');
        $setting->save();
        return redirect()->back()->with('success', 'Header keywords updated successfully.');
    }

    public function aboutPage(){
        $data = About::first();
        $setting = Setting::first();
        if($data===null)
        {
            $data = new About();
            $data->title = 'About Us';
            $data->founderDescription = 'About Us';
            $data->mission = 'Value 1';
            $data->vision = 'Value 1';
            $data->user_id = 1;
            $data->save();
            $data = About::first();
        }

        return view('admin.pages.about', ['data'=>$data,'setting'=>$setting]);
    }

    public function saveAbout(Request $request){
        $data = About::first();
        $title = [];
        $subTitle = [];
        $founderDescription = [];
        $mission = [];
        $vision = [];
        $image1 = [];
        $image2 = [];
        $image3 = [];
        $image4 = [];
        $storyImage = [];
        $backImageText = [];
    
        if ($data->founderDescription != $request->input('founderDescription')) {
            $data->founderDescription = $request->input('founderDescription');
            $founderDescription[] = 'founderDescription';
        }
    
        if ($data->storyDescription != $request->input('storyDescription')) {
            $data->storyDescription = $request->input('storyDescription');
            $storyDescription[] = 'storyDescription';
        }
    
        if ($data->mission != $request->input('mission')) {
            $data->mission = $request->input('mission');
            $mission[] = 'mission';
        }
    
        if ($data->vision != $request->input('vision')) {
            $data->vision = $request->input('vision');
            $vision[] = 'mission';
        }
    
        if ($data->subTitle != $request->input('subTitle')) {
            $data->subTitle = $request->input('subTitle');
            $subTitle[] = 'subTitle';
        }
        // Handle file uploads
        $dir = 'public/images/about/';
    
        if ($request->hasFile('image1') && request('image1') != '') {
            // Delete old file
            File::delete($dir . $data->image1);
            // Store new file
            $fileName = $request->file('image1')->store($dir);
            $data->image1 = str_replace($dir, '', $fileName);
            $image1[] = 'image1';
        }

        if ($request->hasFile('image2') && request('image2') != '') {
            // Delete old file
            File::delete($dir . $data->image2);
            // Store new file
            $fileName2 = $request->file('image2')->store($dir);
            $data->image2 = str_replace($dir, '', $fileName2);
            $image2[] = 'image2';
        }

        if ($request->hasFile('image3') && request('image3') != '') {
            // Delete old file
            File::delete($dir . $data->image3);
            // Store new file
            $fileName3 = $request->file('image3')->store($dir);
            $data->image3 = str_replace($dir, '', $fileName3);
            $image3[] = 'image3';
        }

        if ($request->hasFile('image4') && request('image4') != '') {
            // Delete old file
            File::delete($dir . $data->image4);
            // Store new file
            $fileName4 = $request->file('image4')->store($dir);
            $data->image4 = str_replace($dir, '', $fileName4);
            $image4[] = 'image4';
        }

        if ($request->hasFile('storyImage') && request('storyImage') != '') {
            // Delete old file
            File::delete($dir . $data->storyImage);
            // Store new file
            $fileName5 = $request->file('storyImage')->store($dir);
            $data->storyImage = str_replace($dir, '', $fileName5);
            $storyImage[] = 'storyImage';
        }

    
        $saved = $data->update();
    
        if($saved){
            return redirect()->back()->with('success', 'About us Page fields have been updated successfully');

        }

        return redirect()->back()->with('error', 'No fields were updated');
    }



    // Terms and policies

    public function getTerms(){
        $data = Term::first();
        if($data===null)
        {
            $data = new Term();
            $data->terms = 'Our Terms and conditions';
            $data->privacy = 'Our Privacy policies';
            $data->return = 'Our Return policies';
            $data->support = 'Our Support policies';
            $data->added_by = Auth()->user()->id;
            $data->save();
            $data = Term::first();
        }

        return view('admin.terms', ['data'=>$data]);
    }

    
    public function saveTerms(Request $request){
        $data = Term::first();
        $data->privacy = $request->input('privacy');
        $data->return = $request->input('return');
        $data->terms = $request->input('terms');
        $data->support = $request->input('support');


        $data->update();

        return redirect()->back()->with('success', 'Terms and policies has been updated successfully');
    }
}
