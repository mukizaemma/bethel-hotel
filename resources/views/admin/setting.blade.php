@extends('layouts.adminBase')

@section('content')
@include('content-management.includes.sidebar')
<div class="content">
    @include('admin.includes.navbar')

    <div class="container-fluid pt-4 px-4">
        @if (session()->has('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session()->get('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        @if (session()->has('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session()->get('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <h5 class="mb-3">Settings</h5>

        <style>
            /* Terms editor: full-width, comfortable height (Summernote sets .note-editable height) */
            .settings-terms-editor-wrap .note-editor {
                border-radius: 0.375rem;
                margin-bottom: 0;
            }
            .settings-terms-editor-wrap .note-statusbar {
                display: none;
            }
            /* Pin save actions while scrolling long tabs */
            .admin-settings-tab-content .card-footer.bg-light {
                position: sticky;
                bottom: 0;
                z-index: 5;
            }
        </style>
        <ul class="nav nav-tabs mb-4">
            <li class="nav-item">
                <a class="nav-link active" data-bs-toggle="tab" href="#contacts">Contacts & Logo</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-bs-toggle="tab" href="#channel-links">Booking &amp; review links</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-bs-toggle="tab" href="#about">About Hotel</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-bs-toggle="tab" href="#tab-terms">Terms &amp; Conditions</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-bs-toggle="tab" href="#seo">SEO Keywords</a>
            </li>
            @if(!empty($canEditDelivery))
            <li class="nav-item">
                <a class="nav-link" data-bs-toggle="tab" href="#footer-delivered-by">Delivered by (footer)</a>
            </li>
            @endif
        </ul>

        <div class="tab-content admin-settings-tab-content">
            {{-- Tab 1: Contacts & Logo — one card, one form --}}
            <div id="contacts" class="tab-pane fade show active">
                <div class="card shadow-sm border-0">
                    <div class="card-header bg-white py-3">
                        <h5 class="mb-1">Contacts & Logo</h5>
                        <p class="text-muted small mb-0">Contact details and logos used across the site.</p>
                    </div>
                        <form action="{{ route('saveSetting', $data->id) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                    <div class="card-body border-bottom-0 pb-4">
                            <fieldset class="mb-4">
                                <legend class="h6 text-secondary border-bottom pb-2 mb-3">Contact details</legend>
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label for="company" class="form-label">Website title</label>
                                        <input type="text" class="form-control" id="company" name="company" value="{{ $data->company }}">
                                    </div>
                                    <div class="col-md-6">
                                        <label for="address" class="form-label">Address</label>
                                        <input type="text" class="form-control" id="address" name="address" value="{{ $data->address }}">
                                    </div>
                                    <div class="col-md-6">
                                        <label for="phone" class="form-label">Phone</label>
                                        <input type="text" class="form-control" id="phone" name="phone" value="{{ $data->phone }}">
                                    </div>
                                    <div class="col-md-6">
                                        <label for="email" class="form-label">Email</label>
                                        <input type="email" class="form-control" id="email" name="email" value="{{ $data->email }}">
                                    </div>
                                </div>
                                <div class="row g-3 mt-1">
                                    <div class="col-md-4">
                                        <label for="reception_phone" class="form-label">Reception phone</label>
                                        <input
                                            type="text"
                                            class="form-control"
                                            id="reception_phone"
                                            name="reception_phone"
                                            value="{{ old('reception_phone', $data->reception_phone ?? '') }}">
                                    </div>
                                    <div class="col-md-4">
                                        <label for="manager_phone" class="form-label">Manager phone</label>
                                        <input
                                            type="text"
                                            class="form-control"
                                            id="manager_phone"
                                            name="manager_phone"
                                            value="{{ old('manager_phone', $data->manager_phone ?? '') }}">
                                    </div>
                                    <div class="col-md-4">
                                        <label for="restaurant_phone" class="form-label">Restaurant phone</label>
                                        <input
                                            type="text"
                                            class="form-control"
                                            id="restaurant_phone"
                                            name="restaurant_phone"
                                            value="{{ old('restaurant_phone', $data->restaurant_phone ?? '') }}">
                                    </div>
                                </div>
                            </fieldset>
                            <fieldset class="mb-4">
                                <legend class="h6 text-secondary border-bottom pb-2 mb-3">Google Map</legend>
                                <p class="text-muted small mb-2">Paste the embed code from Google Maps (Share → Embed a map). Used on Home, Contact, and About pages.</p>
                                <div class="mb-0">
                                    <label for="google_map_embed" class="form-label">Embed code (iframe)</label>
                                    <textarea class="form-control font-monospace" id="google_map_embed" name="google_map_embed" rows="6" placeholder="<iframe src=&quot;https://www.google.com/maps/embed?pb=...&quot; ...></iframe>">{{ $data->google_map_embed ?? '' }}</textarea>
                                </div>
                            </fieldset>
                            <fieldset class="mb-4">
                                <legend class="h6 text-secondary border-bottom pb-2 mb-3">Social media</legend>
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label for="facebook" class="form-label">Facebook</label>
                                        <input type="text" class="form-control" id="facebook" name="facebook" value="{{ $data->facebook }}">
                                    </div>
                                    <div class="col-md-6">
                                        <label for="instagram" class="form-label">Instagram</label>
                                        <input type="text" class="form-control" id="instagram" name="instagram" value="{{ $data->instagram }}">
                                    </div>
                                    <div class="col-md-6">
                                        <label for="youtube" class="form-label">YouTube</label>
                                        <input type="text" class="form-control" id="youtube" name="youtube" value="{{ $data->youtube }}">
                                    </div>
                                    <div class="col-md-6">
                                        <label for="linkedin" class="form-label">LinkedIn</label>
                                        <input type="text" class="form-control" id="linkedin" name="linkedin" value="{{ $data->linkedin }}">
                                    </div>
                                    <div class="col-12">
                                        <label for="linktree" class="form-label">Booking link</label>
                                        <input type="text" class="form-control" id="linktree" name="linktree" value="{{ $data->linktree ?? '' }}">
                                    </div>
                                </div>
                            </fieldset>
                            <fieldset class="mb-4">
                                <legend class="h6 text-secondary border-bottom pb-2 mb-3">Analytics (Google GA4)</legend>
                                <div class="row g-3">
                                    <div class="col-md-4">
                                        <label for="ga4_measurement_id" class="form-label">Measurement ID</label>
                                        <input
                                            type="text"
                                            class="form-control font-monospace"
                                            id="ga4_measurement_id"
                                            name="ga4_measurement_id"
                                            value="{{ old('ga4_measurement_id', $data->ga4_measurement_id ?? '') }}"
                                            placeholder="G-XXXXXXXXXX"
                                            maxlength="32">
                                        <p class="text-muted small mb-0 mt-1">Used to load GA4 tracking on public pages.</p>
                                    </div>
                                    <div class="col-md-8">
                                        <label for="ga4_reports_url" class="form-label">Google Analytics reports URL</label>
                                        <input
                                            type="url"
                                            class="form-control font-monospace small"
                                            id="ga4_reports_url"
                                            name="ga4_reports_url"
                                            value="{{ old('ga4_reports_url', $data->ga4_reports_url ?? '') }}"
                                            placeholder="https://analytics.google.com/analytics/web/#/...">
                                        <p class="text-muted small mb-0 mt-1">Optional shortcut shown on the admin dashboard.</p>
                                    </div>
                                </div>
                            </fieldset>
                            <fieldset class="mb-0">
                                <legend class="h6 text-secondary border-bottom pb-2 mb-3">Logos</legend>
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label class="form-label">Header logo</label>
                                        <div class="mb-2">
                                            <img src="{{ asset('storage/images') . $data->logo }}" alt="Header logo" class="img-thumbnail" style="max-height: 80px;">
                                        </div>
                                        <input type="file" class="form-control" name="logo" accept="image/*">
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Footer logo</label>
                                        <div class="mb-2">
                                            <img src="{{ asset('storage/images') . $data->donate }}" alt="Footer logo" class="img-thumbnail" style="max-height: 80px;">
                                        </div>
                                        <input type="file" class="form-control" name="donate" accept="image/*">
                                    </div>
                                    <div class="col-12 col-md-6">
                                        <label for="star_rating" class="form-label">Star rating (footer)</label>
                                        <select class="form-select" id="star_rating" name="star_rating">
                                            <option value="">— Not shown —</option>
                                            @for ($s = 1; $s <= 5; $s++)
                                                <option value="{{ $s }}" @selected((int) ($data->star_rating ?? 0) === $s)>{{ $s }} star{{ $s > 1 ? 's' : '' }}</option>
                                            @endfor
                                        </select>
                                        <p class="text-muted small mb-0 mt-1">Shown below the footer logo on the public site (out of 5).</p>
                                    </div>
                                    <div class="col-12 col-md-6">
                                        <label for="price_currency" class="form-label">Website price currency display</label>
                                        <select class="form-select" id="price_currency" name="price_currency">
                                            <option value="usd" @selected(($data->price_currency ?? 'usd') === 'usd')>USD ($)</option>
                                            <option value="rwf" @selected(($data->price_currency ?? 'usd') === 'rwf')>RWF (RWF)</option>
                                        </select>
                                        <p class="text-muted small mb-0 mt-1">Controls how room prices are shown on public pages.</p>
                                    </div>
                                </div>
                            </fieldset>
                    </div>
                    <div class="card-footer bg-light border-top py-3 d-flex justify-content-end gap-2 flex-wrap">
                        <button type="submit" class="btn btn-primary">Save Contacts &amp; Logo</button>
                    </div>
                        </form>
                </div>
            </div>

            {{-- Tab: Booking.com, TripAdvisor, Google, WhatsApp (overrides .env defaults when filled) --}}
            <div id="channel-links" class="tab-pane fade">
                <div class="card shadow-sm border-0">
                    <div class="card-header bg-white py-3">
                        <h5 class="mb-1">Booking &amp; review links</h5>
                        <p class="text-muted small mb-0">
                            Values saved here override <code>config/hotel_channels.php</code> (from <code>.env</code>) on the public site.
                            Leave a field empty to use the default from the server environment.
                        </p>
                    </div>
                        <form action="{{ route('setting.channel-links.update') }}" method="POST">
                            @csrf
                    <div class="card-body border-bottom-0 pb-4">
                            <fieldset class="mb-4">
                                <legend class="h6 text-secondary border-bottom pb-2 mb-3">Booking.com</legend>
                                <label class="form-label" for="booking_com_url">Booking.com property URL</label>
                                <input type="url" class="form-control font-monospace small" id="booking_com_url" name="booking_com_url" value="{{ old('booking_com_url', $data->booking_com_url ?? '') }}" placeholder="https://www.booking.com/hotel/...">
                                <p class="text-muted small mt-1 mb-3">Used for the public site — book / read guest scores shown on the property page.</p>
                                <div class="row g-3">
                                    <div class="col-md-4">
                                        <label class="form-label" for="booking_com_review_score">Review score (display)</label>
                                        <input type="number" step="0.1" min="0" max="10" class="form-control" id="booking_com_review_score" name="booking_com_review_score" value="{{ old('booking_com_review_score', $data->booking_com_review_score ?? '') }}" placeholder="e.g. 9.2">
                                        <p class="text-muted small mb-0 mt-1">Booking.com uses 1–10 (e.g. “Exceptional 9.2”).</p>
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label" for="booking_com_review_count">Number of reviews (display)</label>
                                        <input type="number" min="0" class="form-control" id="booking_com_review_count" name="booking_com_review_count" value="{{ old('booking_com_review_count', $data->booking_com_review_count ?? '') }}" placeholder="e.g. 127">
                                    </div>
                                    <div class="col-12">
                                        <label class="form-label" for="booking_com_review_summary">Short summary (optional)</label>
                                        <textarea class="form-control" id="booking_com_review_summary" name="booking_com_review_summary" rows="2" maxlength="2000" placeholder="One line shown on the reviews page — update when you refresh stats.">{{ old('booking_com_review_summary', $data->booking_com_review_summary ?? '') }}</textarea>
                                    </div>
                                    <div class="col-12">
                                        <label class="form-label" for="booking_com_write_review_url">Write-review link (optional)</label>
                                        <input type="url" class="form-control font-monospace small" id="booking_com_write_review_url" name="booking_com_write_review_url" value="{{ old('booking_com_write_review_url', $data->booking_com_write_review_url ?? '') }}" placeholder="Often from Booking’s post-stay email, or leave empty">
                                        <p class="text-muted small mb-0 mt-1">Booking.com normally invites verified guests by email. If you don’t have a direct URL, leave empty — the reviews page will only show “View on Booking.com”.</p>
                                    </div>
                                </div>
                            </fieldset>
                            <fieldset class="mb-4">
                                <legend class="h6 text-secondary border-bottom pb-2 mb-3">TripAdvisor</legend>
                                <div class="row g-3">
                                    <div class="col-md-4">
                                        <label class="form-label" for="tripadvisor_location_id">Location ID (widget)</label>
                                        <input type="text" class="form-control" id="tripadvisor_location_id" name="tripadvisor_location_id" value="{{ old('tripadvisor_location_id', $data->tripadvisor_location_id ?? '') }}" placeholder="28135123" maxlength="32">
                                    </div>
                                    <div class="col-md-8">
                                        <label class="form-label" for="tripadvisor_hotel_url">Hotel reviews page URL</label>
                                        <input type="url" class="form-control font-monospace small" id="tripadvisor_hotel_url" name="tripadvisor_hotel_url" value="{{ old('tripadvisor_hotel_url', $data->tripadvisor_hotel_url ?? '') }}">
                                    </div>
                                    <div class="col-12">
                                        <label class="form-label" for="tripadvisor_write_review_url">Write review URL</label>
                                        <input type="url" class="form-control font-monospace small" id="tripadvisor_write_review_url" name="tripadvisor_write_review_url" value="{{ old('tripadvisor_write_review_url', $data->tripadvisor_write_review_url ?? '') }}">
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label" for="tripadvisor_review_score">Review score (display)</label>
                                        <input type="number" step="0.1" min="0" max="5" class="form-control" id="tripadvisor_review_score" name="tripadvisor_review_score" value="{{ old('tripadvisor_review_score', $data->tripadvisor_review_score ?? '') }}" placeholder="e.g. 4.5">
                                        <p class="text-muted small mb-0 mt-1">TripAdvisor bubble rating out of 5.</p>
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label" for="tripadvisor_review_count">Number of reviews (display)</label>
                                        <input type="number" min="0" class="form-control" id="tripadvisor_review_count" name="tripadvisor_review_count" value="{{ old('tripadvisor_review_count', $data->tripadvisor_review_count ?? '') }}">
                                    </div>
                                    <div class="col-12">
                                        <label class="form-label" for="tripadvisor_review_summary">Short summary (optional)</label>
                                        <textarea class="form-control" id="tripadvisor_review_summary" name="tripadvisor_review_summary" rows="2" maxlength="2000" placeholder="Optional line for the reviews page.">{{ old('tripadvisor_review_summary', $data->tripadvisor_review_summary ?? '') }}</textarea>
                                    </div>
                                </div>
                            </fieldset>
                            <fieldset class="mb-4">
                                <legend class="h6 text-secondary border-bottom pb-2 mb-3">Google</legend>
                                <div class="mb-3">
                                    <label class="form-label" for="google_place_url">Google Maps / Business place URL</label>
                                    <input type="url" class="form-control font-monospace small" id="google_place_url" name="google_place_url" value="{{ old('google_place_url', $data->google_place_url ?? '') }}">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label" for="google_maps_embed_url">Map embed URL (reviews page)</label>
                                    <input type="url" class="form-control font-monospace small" id="google_maps_embed_url" name="google_maps_embed_url" value="{{ old('google_maps_embed_url', $data->google_maps_embed_url ?? '') }}" placeholder="https://maps.google.com/maps?q=...&amp;output=embed">
                                    <p class="text-muted small mb-0 mt-1">Simple embed without API key, e.g. <code>https://maps.google.com/maps?q=lat,lng&amp;z=16&amp;output=embed</code></p>
                                </div>
                                <div class="row g-3">
                                    <div class="col-md-4">
                                        <label class="form-label" for="google_review_score">Review score (display)</label>
                                        <input type="number" step="0.1" min="0" max="5" class="form-control" id="google_review_score" name="google_review_score" value="{{ old('google_review_score', $data->google_review_score ?? '') }}" placeholder="e.g. 4.8">
                                        <p class="text-muted small mb-0 mt-1">Google Maps rating out of 5.</p>
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label" for="google_review_count">Number of reviews (display)</label>
                                        <input type="number" min="0" class="form-control" id="google_review_count" name="google_review_count" value="{{ old('google_review_count', $data->google_review_count ?? '') }}">
                                    </div>
                                    <div class="col-12">
                                        <label class="form-label" for="google_review_summary">Short summary (optional)</label>
                                        <textarea class="form-control" id="google_review_summary" name="google_review_summary" rows="2" maxlength="2000" placeholder="Optional line for the reviews page.">{{ old('google_review_summary', $data->google_review_summary ?? '') }}</textarea>
                                    </div>
                                    <div class="col-12">
                                        <label class="form-label" for="google_write_review_url">Write-review URL (optional)</label>
                                        <input type="url" class="form-control font-monospace small" id="google_write_review_url" name="google_write_review_url" value="{{ old('google_write_review_url', $data->google_write_review_url ?? '') }}" placeholder="Leave empty to use the place URL above">
                                        <p class="text-muted small mb-0 mt-1">If empty, the site uses the Google Maps / Business place URL for the “Write a review” button.</p>
                                    </div>
                                </div>
                            </fieldset>
                            <fieldset class="mb-0">
                                <legend class="h6 text-secondary border-bottom pb-2 mb-3">WhatsApp &amp; email (CTAs)</legend>
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label class="form-label" for="whatsapp_e164">WhatsApp number</label>
                                        <input type="text" class="form-control" id="whatsapp_e164" name="whatsapp_e164" value="{{ old('whatsapp_e164', $data->whatsapp_e164 ?? '') }}" placeholder="250794191115" maxlength="32">
                                        <p class="text-muted small mb-0 mt-1">Digits only, with country code (no +).</p>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label" for="channel_contact_email">Contact email for mailto links</label>
                                        <input type="email" class="form-control" id="channel_contact_email" name="channel_contact_email" value="{{ old('channel_contact_email', $data->channel_contact_email ?? '') }}" placeholder="Leave empty to use main Email above">
                                    </div>
                                    <div class="col-12">
                                        <label class="form-label" for="whatsapp_default_message">Default WhatsApp message prefix</label>
                                        <textarea class="form-control" id="whatsapp_default_message" name="whatsapp_default_message" rows="2" maxlength="2000">{{ old('whatsapp_default_message', $data->whatsapp_default_message ?? '') }}</textarea>
                                    </div>
                                </div>
                            </fieldset>
                    </div>
                    <div class="card-footer bg-light border-top py-3 d-flex justify-content-end gap-2 flex-wrap">
                            <button type="submit" class="btn btn-primary">Save booking &amp; review links</button>
                    </div>
                        </form>
                </div>
            </div>

            {{-- Tab 2: About Hotel — one card, one form --}}
            <div id="about" class="tab-pane fade">
                <div class="card shadow-sm border-0">
                    <div class="card-header bg-white py-3">
                        <h5 class="mb-1">About Hotel</h5>
                        <p class="text-muted small mb-0">About-us content and images for the public site.</p>
                    </div>
                        <form action="{{ route('content-management.about.update') }}" method="POST" enctype="multipart/form-data" class="settings-about-form">
                            @csrf
                    <div class="card-body border-bottom-0 pb-4">
                            <fieldset class="mb-4">
                                <legend class="h6 text-secondary border-bottom pb-2 mb-3">Main content</legend>
                                <div class="mb-3">
                                    <label class="form-label">Title</label>
                                    <input type="text" class="form-control" name="title" value="{{ optional($about)->title ?? '' }}">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Sub title</label>
                                    <input type="text" class="form-control" name="subTitle" value="{{ optional($about)->subTitle ?? '' }}">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label" for="founderDescription">About page narrative</label>
                                    <p class="text-muted small mb-2">Story text for the public About / home sections. Legal policies belong under <strong>Terms &amp; Conditions</strong>.</p>
                                    <textarea class="form-control" name="founderDescription" rows="6" id="founderDescription">{{ optional($about)->founderDescription ?? '' }}</textarea>
                                </div>
                            </fieldset>
                            <fieldset class="mb-0">
                                <legend class="h6 text-secondary border-bottom pb-2 mb-3">Images</legend>
                                <div class="row g-3">
                                    <div class="col-md-6 col-lg-3">
                                        <label class="form-label">About image</label>
                                        @if($about && $about->image1)
                                            <div class="mb-2"><img src="{{ asset('storage/' . $about->image1) }}" alt="" class="img-thumbnail" style="max-height: 60px;"></div>
                                        @endif
                                        <input type="file" class="form-control" name="image1" accept="image/*">
                                    </div>
                                    <div class="col-md-6 col-lg-3">
                                        <label class="form-label">Home middle image</label>
                                        @if($about && $about->image2)
                                            <div class="mb-2"><img src="{{ asset('storage/' . $about->image2) }}" alt="" class="img-thumbnail" style="max-height: 60px;"></div>
                                        @endif
                                        <input type="file" class="form-control" name="image2" accept="image/*">
                                    </div>
                                    <div class="col-md-6 col-lg-3">
                                        <label class="form-label">Image 3</label>
                                        @if($about && $about->image3)
                                            <div class="mb-2"><img src="{{ asset('storage/' . $about->image3) }}" alt="" class="img-thumbnail" style="max-height: 60px;"></div>
                                        @endif
                                        <input type="file" class="form-control" name="image3" accept="image/*">
                                    </div>
                                    <div class="col-md-6 col-lg-3">
                                        <label class="form-label">Image 4</label>
                                        @if($about && $about->image4)
                                            <div class="mb-2"><img src="{{ asset('storage/' . $about->image4) }}" alt="" class="img-thumbnail" style="max-height: 60px;"></div>
                                        @endif
                                        <input type="file" class="form-control" name="image4" accept="image/*">
                                    </div>
                                    <div class="col-12">
                                        <label class="form-label">Story image</label>
                                        @if($about && $about->storyImage)
                                            <div class="mb-2"><img src="{{ asset('storage/' . $about->storyImage) }}" alt="" class="img-thumbnail" style="max-height: 80px;"></div>
                                        @endif
                                        <input type="file" class="form-control" name="storyImage" accept="image/*">
                                    </div>
                                </div>
                            </fieldset>
                    </div>
                    <div class="card-footer bg-light border-top py-3 d-flex justify-content-end gap-2 flex-wrap">
                                <button type="submit" class="btn btn-primary">Update About Hotel</button>
                    </div>
                        </form>
                </div>
            </div>

            {{-- Tab id must NOT be "terms": global admin/js/summernote.js binds $('#terms') to a textarea on legacy pages --}}
            <div id="tab-terms" class="tab-pane fade">
                <div class="card shadow-sm border-0">
                    <div class="card-header bg-white py-3">
                        <h5 class="mb-1">Terms &amp; Conditions</h5>
                        <p class="text-muted small mb-0">Legal and policy content shown on the Terms page.</p>
                    </div>
                        {{-- Single form; save action is pinned in card-footer so it cannot be scrolled off-screen --}}
                        <form action="{{ route('content-management.terms.update') }}" method="POST" class="settings-terms-form">
                            @csrf
                    <div class="card-body border-bottom-0 pb-2">
                            <div class="mb-0 settings-terms-editor-wrap">
                                <label class="form-label" for="termsContent">Terms content</label>
                                <p class="text-muted small mb-2">Use the editor for headings, lists, and links; saved HTML is shown on the public Terms page.</p>
                                <textarea class="form-control" name="content" rows="16" id="termsContent">{{ $terms->content ?? '' }}</textarea>
                            </div>
                    </div>
                    <div class="card-footer bg-light border-top py-3 d-flex justify-content-end gap-2 flex-wrap">
                                <button type="submit" class="btn btn-primary px-4">Save Terms &amp; Conditions</button>
                    </div>
                        </form>
                </div>
            </div>

            @if(!empty($canEditDelivery))
            {{-- Tab: Footer “Delivered by” — only for admin@iremetech.com --}}
            <div id="footer-delivered-by" class="tab-pane fade">
                <div class="card shadow-sm border-0 border-start border-primary border-3">
                    <div class="card-header bg-white py-3">
                        <h5 class="mb-1">Delivered by (footer)</h5>
                        <p class="text-muted small mb-0">Controls the credit line in the site footer. Only visible to the designated administrator account.</p>
                    </div>
                        <form action="{{ route('setting.footer-delivered-by.update') }}" method="POST">
                            @csrf
                    <div class="card-body border-bottom-0 pb-4">
                            <div class="form-check form-switch mb-4">
                                <input type="hidden" name="footer_delivered_by_enabled" value="0">
                                <input
                                    class="form-check-input"
                                    type="checkbox"
                                    name="footer_delivered_by_enabled"
                                    id="footer_delivered_by_enabled"
                                    value="1"
                                    @checked(old('footer_delivered_by_enabled', $data->footer_delivered_by_enabled ?? false))
                                >
                                <label class="form-check-label" for="footer_delivered_by_enabled">Show “Delivered by” in the footer</label>
                            </div>
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label" for="footer_delivered_by_company">Company / credit name</label>
                                    <input
                                        type="text"
                                        class="form-control"
                                        id="footer_delivered_by_company"
                                        name="footer_delivered_by_company"
                                        value="{{ old('footer_delivered_by_company', $data->footer_delivered_by_company ?? '') }}"
                                        placeholder="e.g. Ireme Technologies"
                                        maxlength="255"
                                    >
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label" for="footer_delivered_by_url">URL</label>
                                    <input
                                        type="url"
                                        class="form-control"
                                        id="footer_delivered_by_url"
                                        name="footer_delivered_by_url"
                                        value="{{ old('footer_delivered_by_url', $data->footer_delivered_by_url ?? '') }}"
                                        placeholder="https://example.com"
                                        maxlength="500"
                                    >
                                    <p class="text-muted small mb-0 mt-1">If empty, the name is shown without a link.</p>
                                </div>
                            </div>
                    </div>
                    <div class="card-footer bg-light border-top py-3 d-flex justify-content-end gap-2 flex-wrap">
                                <button type="submit" class="btn btn-primary">Save footer credit</button>
                    </div>
                        </form>
                </div>
            </div>
            @endif

            {{-- Tab 3: SEO Keywords — one card, one form (only keywords textarea) --}}
            <div id="seo" class="tab-pane fade">
                <div class="card shadow-sm border-0">
                    <div class="card-header bg-white py-3">
                        <h5 class="mb-1">SEO Keywords</h5>
                        <p class="text-muted small mb-0">Keywords used in the site header meta tag. Separate with commas.</p>
                    </div>
                        <form action="{{ route('setting.keywords.update') }}" method="POST">
                            @csrf
                    <div class="card-body border-bottom-0 pb-4">
                            <label class="form-label" for="seoKeywords">Header keywords</label>
                            <textarea class="form-control" name="keywords" rows="8" id="seoKeywords" placeholder="keyword1, keyword2, keyword3">{{ $data->keywords ?? '' }}</textarea>
                    </div>
                    <div class="card-footer bg-light border-top py-3 d-flex justify-content-end gap-2 flex-wrap">
                                <button type="submit" class="btn btn-primary">Save keywords</button>
                    </div>
                        </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
jQuery(function ($) {
    var settingsTermsToolbar = [
        ['style', ['style']],
        ['font', ['bold', 'underline', 'clear']],
        ['color', ['color']],
        ['para', ['ul', 'ol', 'paragraph']],
        ['table', ['table']],
        ['insert', ['link', 'picture', 'video']],
        ['view', ['fullscreen', 'codeview', 'help']]
    ];

    function initAboutEditor() {
        var $el = $('#founderDescription');
        if (!$el.length || $el.next('.note-editor').length) {
            return;
        }
        $el.summernote({
            placeholder: 'Intro and story shown on About / Home…',
            tabsize: 2,
            height: 300,
            disableResizeEditor: true,
            toolbar: settingsTermsToolbar
        });
    }

    function initTermsEditor() {
        var $tc = $('#termsContent');
        if (!$tc.length || $tc.next('.note-editor').length) {
            return;
        }
        $tc.summernote({
            placeholder: 'Hotel policies and terms…',
            tabsize: 2,
            height: 420,
            disableResizeEditor: true,
            toolbar: settingsTermsToolbar
        });
    }

    // Bootstrap 5
    $(document).on('shown.bs.tab', 'a[data-bs-toggle="tab"][href="#about"]', function () {
        initAboutEditor();
    });
    $(document).on('shown.bs.tab', 'a[data-bs-toggle="tab"][href="#tab-terms"]', function () {
        initTermsEditor();
    });
    // Bootstrap 4 (some admin JS still uses data-toggle)
    $(document).on('shown.bs.tab', 'a[data-toggle="tab"][href="#about"]', function () {
        initAboutEditor();
    });
    $(document).on('shown.bs.tab', 'a[data-toggle="tab"][href="#tab-terms"]', function () {
        initTermsEditor();
    });

    if (window.location.hash === '#about' || document.querySelector('.nav-link.active[href="#about"]')) {
        initAboutEditor();
    }
    if (window.location.hash === '#tab-terms' || window.location.hash === '#terms' || document.querySelector('.nav-link.active[href="#tab-terms"]')) {
        initTermsEditor();
    }
    if ($('#about').hasClass('active') || $('#about').hasClass('show')) {
        initAboutEditor();
    }
    if ($('#tab-terms').hasClass('active') || $('#tab-terms').hasClass('show')) {
        initTermsEditor();
    }

    $(document).on('submit', '.settings-terms-form', function () {
        var $t = $('#termsContent');
        if ($t.length && $t.next('.note-editor').length) {
            $t.val($t.summernote('code'));
        }
    });

    $(document).on('submit', '.settings-about-form', function () {
        var $el = $('#founderDescription');
        if ($el.length && $el.next('.note-editor').length) {
            $el.val($el.summernote('code'));
        }
    });
});
</script>
@endpush
