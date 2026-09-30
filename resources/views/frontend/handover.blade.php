@extends('layouts.frontbase')

@section('meta_robots', 'noindex, nofollow')

@section('document_title', 'Client handover & user guide — Bethel Hotel')

@push('head')
<script>document.documentElement.classList.add('handover-doc-page');</script>
<style>
    html.handover-doc-page .header__top,
    html.handover-doc-page header.main__header,
    html.handover-doc-page .offcanvas,
    html.handover-doc-page footer.rts__footer,
    html.handover-doc-page .rts__back__top,
    html.handover-doc-page #site-preloader,
    html.handover-doc-page .gdprcookie {
        display: none !important;
    }
    html.handover-doc-page body {
        background: #eef2f6;
        color: #1c2430;
    }
    html.handover-doc-page .container-fluid {
        padding: 0;
        max-width: none;
    }

    .ho {
        --ink: #1c2430;
        --muted: #5c6b7a;
        --line: #d9e1ea;
        --brand: #0048ff;
        --brand-dark: #0036c9;
        --green: #1a6b1a;
        --paper: #ffffff;
        --soft: #f5f8fb;
        max-width: 980px;
        margin: 0 auto;
        padding: 1.25rem 1rem 6.5rem;
        font-family: Inter, "Segoe UI", sans-serif;
        color: var(--ink);
    }
    .ho * { box-sizing: border-box; }
    .ho h1, .ho h2, .ho h3 {
        font-family: "Playfair Display", Georgia, serif;
        color: var(--ink);
        letter-spacing: -0.02em;
    }
    .ho p, .ho li { line-height: 1.65; }
    .ho a { color: var(--brand-dark); }
    .ho code {
        font-size: 0.86em;
        background: #eef3f8;
        padding: 0.1em 0.35em;
        border-radius: 4px;
    }

    .ho-top {
        display: flex;
        justify-content: space-between;
        align-items: flex-end;
        gap: 1rem;
        margin-bottom: 1rem;
    }
    .ho-brand {
        font-size: 0.75rem;
        letter-spacing: 0.14em;
        text-transform: uppercase;
        color: var(--muted);
        margin: 0 0 0.2rem;
    }
    .ho-brand strong { color: var(--ink); font-weight: 700; }
    .ho-actions { display: flex; gap: 0.5rem; flex-wrap: wrap; }
    .ho-btn {
        appearance: none;
        border: 1px solid var(--brand);
        background: var(--brand);
        color: #fff;
        border-radius: 999px;
        padding: 0.55rem 1rem;
        font-size: 0.92rem;
        font-weight: 600;
        cursor: pointer;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 0.4rem;
        line-height: 1.2;
    }
    .ho-btn:hover { background: var(--brand-dark); color: #fff; }
    .ho-btn.ghost {
        background: #fff;
        color: var(--brand-dark);
    }
    .ho-btn:disabled {
        opacity: 0.45;
        cursor: not-allowed;
    }

    .ho-sections {
        display: flex;
        gap: 0.4rem;
        overflow-x: auto;
        padding-bottom: 0.35rem;
        margin-bottom: 0.85rem;
        scrollbar-width: thin;
    }
    .ho-sections button {
        flex: 0 0 auto;
        border: 1px solid var(--line);
        background: #fff;
        color: var(--ink);
        border-radius: 999px;
        padding: 0.4rem 0.8rem;
        font-size: 0.84rem;
        font-weight: 600;
        cursor: pointer;
    }
    .ho-sections button[aria-selected="true"] {
        background: var(--ink);
        border-color: var(--ink);
        color: #fff;
    }
    .ho-progress {
        font-size: 0.8rem;
        color: var(--muted);
        margin: 0 0 0.75rem;
    }

    .ho-card {
        background: var(--paper);
        border: 1px solid var(--line);
        border-radius: 16px;
        padding: 1.5rem 1.35rem 1.35rem;
        box-shadow: 0 10px 30px rgba(22, 36, 56, 0.05);
    }
    .ho-kicker {
        margin: 0 0 0.35rem;
        font-size: 0.75rem;
        letter-spacing: 0.12em;
        text-transform: uppercase;
        color: var(--brand);
        font-weight: 700;
    }
    .ho-card h2 { font-size: 1.85rem; margin: 0 0 0.6rem; }
    .ho-lead { font-size: 1.05rem; color: #334155; }

    .ho-section { display: none; }
    .ho-section.is-active { display: block; }
    .ho-feature { display: none; }
    .ho-section.is-active .ho-feature.is-active { display: block; }

    .ho-meta {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 0.75rem;
        margin: 1.25rem 0;
    }
    .ho-meta div, .ho-callout, .ho-note {
        background: var(--soft);
        border-radius: 12px;
        padding: 0.85rem 1rem;
    }
    .ho-meta span {
        display: block;
        font-size: 0.72rem;
        letter-spacing: 0.08em;
        text-transform: uppercase;
        color: var(--muted);
        margin-bottom: 0.2rem;
    }
    .ho-callout {
        border-left: 4px solid var(--brand);
        margin: 1rem 0;
    }
    .ho-callout strong { display: block; margin-bottom: 0.25rem; }
    .ho-note { border-left: 4px solid var(--green); margin: 1rem 0; }

    .ho-steps { margin: 0.5rem 0 0; padding-left: 1.2rem; }
    .ho-steps li { margin-bottom: 0.55rem; }
    .ho-cta { margin-top: 1rem; }

    .ho-tabs {
        display: flex;
        gap: 0.35rem;
        overflow-x: auto;
        padding: 0.15rem 0 0.7rem;
        margin: 0.4rem 0 1rem;
        scrollbar-width: thin;
    }
    .ho-tabs button {
        flex: 0 0 auto;
        border: 1px solid var(--line);
        background: #fff;
        border-radius: 8px;
        padding: 0.4rem 0.7rem;
        font-size: 0.82rem;
        font-weight: 600;
        cursor: pointer;
        color: var(--ink);
    }
    .ho-tabs button[aria-selected="true"] {
        background: #e8f0ff;
        border-color: var(--brand);
        color: var(--brand-dark);
    }

    .ho-where {
        margin: 0 0 0.8rem;
        color: var(--muted);
        font-size: 0.92rem;
    }
    .ho-crud {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 0.65rem;
        margin: 0.8rem 0 1rem;
    }
    .ho-crud article {
        border: 1px solid var(--line);
        border-radius: 12px;
        padding: 0.75rem 0.85rem;
        background: #fff;
    }
    .ho-crud header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 0.5rem;
        margin-bottom: 0.35rem;
    }
    .ho-crud h3 { margin: 0; font-family: Inter, sans-serif; font-size: 0.95rem; }
    .ho-pill {
        font-size: 0.7rem;
        font-weight: 700;
        letter-spacing: 0.04em;
        text-transform: uppercase;
        border-radius: 999px;
        padding: 0.15rem 0.45rem;
    }
    .ho-pill.yes { background: #e7f6ea; color: var(--green); }
    .ho-pill.no { background: #f3f4f6; color: #6b7280; }
    .ho-crud p { margin: 0; font-size: 0.9rem; color: #334155; }

    .ho-table { width: 100%; border-collapse: collapse; font-size: 0.92rem; margin-top: 0.5rem; }
    .ho-table th, .ho-table td {
        border: 1px solid var(--line);
        padding: 0.55rem 0.65rem;
        text-align: left;
        vertical-align: top;
    }
    .ho-table th { background: var(--soft); font-size: 0.78rem; letter-spacing: 0.04em; text-transform: uppercase; }
    .ho-dl { display: grid; gap: 0.65rem; margin-top: 0.75rem; }
    .ho-dl div {
        display: grid;
        grid-template-columns: 180px 1fr;
        gap: 0.75rem;
        padding-bottom: 0.65rem;
        border-bottom: 1px solid var(--line);
    }
    .ho-dl dt { font-weight: 700; }
    .ho-dl dd { margin: 0; color: #334155; }

    .ho-pager {
        position: sticky;
        bottom: 0.75rem;
        margin-top: 1rem;
        display: flex;
        justify-content: space-between;
        gap: 0.75rem;
        background: rgba(255,255,255,0.94);
        border: 1px solid var(--line);
        border-radius: 14px;
        padding: 0.7rem;
        backdrop-filter: blur(8px);
    }
    .ho-pager .ho-btn { min-width: 9.5rem; max-width: 48%; justify-content: center; text-align: center; white-space: normal; }
    .ho-pager small { display: block; font-weight: 500; font-size: 0.72rem; opacity: 0.85; }

    .ho-print-only { display: none; }
    .ho-jump { display: flex; flex-wrap: wrap; gap: 0.45rem; margin-top: 1rem; }
    .ho-jump button {
        border: 1px solid var(--line);
        background: #fff;
        border-radius: 8px;
        padding: 0.45rem 0.7rem;
        cursor: pointer;
        font-weight: 600;
        font-size: 0.85rem;
    }

    @media (max-width: 720px) {
        .ho-meta, .ho-crud, .ho-dl div { grid-template-columns: 1fr; }
        .ho-card h2 { font-size: 1.5rem; }
        .ho-top { flex-direction: column; align-items: flex-start; }
        .ho-pager { flex-direction: column; }
        .ho-pager .ho-btn { width: 100%; max-width: none; }
    }

    @media print {
        html.handover-doc-page body { background: #fff; }
        .ho { max-width: none; padding: 0; }
        .ho-no-print { display: none !important; }
        .ho-print-only { display: block; }
        .ho-section, .ho-feature { display: block !important; }
        .ho-section + .ho-section,
        .ho-feature {
            break-before: page;
            page-break-before: always;
        }
        .ho-card {
            border: 0;
            box-shadow: none;
            padding: 0;
            border-radius: 0;
        }
        .ho-crud article, .ho-callout, .ho-note, .ho-table, .ho-meta div {
            break-inside: avoid;
            page-break-inside: avoid;
        }
        .ho-doc-running {
            display: block;
            font-size: 10pt;
            color: #5c6b7a;
            border-bottom: 1px solid #d9e1ea;
            margin: 0 0 12pt;
            padding-bottom: 6pt;
        }
        a { text-decoration: none; }
        @page { size: A4; margin: 16mm 14mm 18mm; }
    }
</style>
@endpush

@php
    $registerUrl = url('/register');
    $loginUrl = url('/login');
    $dashboardUrl = url('/content-management/dashboard');
    $domain = 'www.bethelhotel.rw';
    $live = 'https://www.bethelhotel.rw';

    $features = [
        [
            'id' => 'dashboard',
            'name' => 'Dashboard',
            'where' => 'Sidebar → Dashboard',
            'path' => '/content-management/dashboard',
            'summary' => 'The home screen after an admin signs in. It shows how many rooms, services, facilities, and users are on the site, and offers shortcuts into the main editors.',
            'crud' => [
                ['Create', 'no', 'Nothing is created here. Use the shortcut buttons to open Rooms, Services, Facilities, or Amenities.'],
                ['Read', 'yes', 'Review the counts and confirm you are signed in as Super Admin or Content Manager.'],
                ['Update', 'no', 'Content is changed inside each feature, not on the dashboard itself.'],
                ['Delete', 'no', 'Records are removed from their own screens.'],
            ],
            'steps' => [
                'Sign in, then confirm the address ends with /content-management/dashboard.',
                'Use a quick-action button when you already know which area you want to change.',
                'Use the left sidebar when you need a feature that is not in the shortcut row, such as Dining, Meetings, or Gallery.',
            ],
        ],
        [
            'id' => 'contacts',
            'name' => 'Contacts',
            'where' => 'Sidebar → Contacts',
            'path' => '/content-management/contacts',
            'summary' => 'The hotel’s phone, email, and address shown to guests. There is one contact record, so you edit it in place.',
            'crud' => [
                ['Create', 'no', 'The contact record already exists. Do not try to add a second one.'],
                ['Read', 'yes', 'Open Contacts to see the details currently published.'],
                ['Update', 'yes', 'Change phone, email, address, city, country, or postal code, then save the form.'],
                ['Delete', 'no', 'Clearing the hotel contact would remove details guests rely on. Ask the developer if a field must be retired.'],
            ],
            'steps' => [
                'Open Contacts from the sidebar.',
                'Edit the fields that should appear on the public site.',
                'Save, then open the Contact page in a private window to confirm the new details.',
            ],
        ],
        [
            'id' => 'about',
            'name' => 'About',
            'where' => 'Sidebar → About',
            'path' => '/content-management/about',
            'summary' => 'The hotel story used on the Home and About pages: heading, welcome text, mission, community values, and the two main photos.',
            'crud' => [
                ['Create', 'no', 'This is a single About record. You update it rather than adding another page.'],
                ['Read', 'yes', 'The form is already filled with the text and photos currently on the site.'],
                ['Update', 'yes', 'Change the heading, welcome text, quote, mission, or photos, then choose Update About.'],
                ['Delete', 'no', 'There is no delete action. Replace text or a photo instead of removing the page.'],
            ],
            'steps' => [
                'Open About and edit only the fields that appear on the public Home and About pages.',
                'For a photo, upload a new file or pick one already in Media Images so the same picture is not stored twice.',
                'Save and check /about-us.',
            ],
        ],
        [
            'id' => 'reservations',
            'name' => 'Reservations',
            'where' => 'Sidebar → Reservations',
            'path' => '/content-management/reservations',
            'summary' => 'Guest enquiries for rooms and facilities. Guests create these from the website. Staff read them and send a reply by email.',
            'crud' => [
                ['Create', 'no', 'Reservations are submitted by guests. Staff do not add them from this screen.'],
                ['Read', 'yes', 'Use the Room Reservations and Facility Reservations tabs. Open a row to see the guest, dates, and request.'],
                ['Update', 'yes', 'Write a reply and send it. The message is emailed to the guest.'],
                ['Delete', 'no', 'This screen does not remove a reservation. Ask the developer if one must be taken off the list.'],
            ],
            'steps' => [
                'Open Reservations and choose the Room or Facility tab.',
                'Open the enquiry you want to handle.',
                'Write a clear reply and send it. The guest receives that text by email.',
            ],
        ],
        [
            'id' => 'rooms',
            'name' => 'Rooms',
            'where' => 'Sidebar → Rooms',
            'path' => '/content-management/rooms',
            'summary' => 'Room types on Our rooms and room detail pages: title, how many identical rooms exist, nightly price, included guests, status, amenities, and photos.',
            'crud' => [
                ['Create', 'yes', 'Choose Add New Room. Enter the title, number of rooms, description, base price, guests included, extra-guest prices, and photos.'],
                ['Read', 'yes', 'The table lists every room. The eye icon opens the full record.'],
                ['Update', 'yes', 'The pencil icon opens the same form with the current values. Save when the changes are complete.'],
                ['Delete', 'yes', 'The trash icon removes that room after you confirm. Removing a photo uses the × on that image and does not delete the room.'],
            ],
            'steps' => [
                'Add or edit the room, including status (Active or not) and room status such as available.',
                'Attach amenities so they appear with the room.',
                'Add a cover and gallery photos. Large files are compressed, but smaller originals upload faster.',
                'Save, then open the public room page and confirm the price and photos.',
            ],
        ],
        [
            'id' => 'facilities',
            'name' => 'Facilities',
            'where' => 'Sidebar → Facilities',
            'path' => '/content-management/facilities',
            'summary' => 'Facility pages such as spaces guests can read about and, where enabled, enquire about.',
            'crud' => [
                ['Create', 'yes', 'Choose Add New Facility and complete the title, description, and images.'],
                ['Read', 'yes', 'The table lists facilities. The eye icon opens one record.'],
                ['Update', 'yes', 'The pencil icon edits the facility. Save to publish the change.'],
                ['Delete', 'yes', 'The trash icon removes the facility after confirmation. A photo can be removed on its own with the × on that image.'],
            ],
            'steps' => [
                'Open Facilities and add a new record or edit an existing one.',
                'Keep the title clear, because it becomes the public page name.',
                'Save and review /facilities.',
            ],
        ],
        [
            'id' => 'dining',
            'name' => 'Dining page',
            'where' => 'Sidebar → Dining page',
            'path' => '/resto',
            'summary' => 'The Bar & Restaurant page: introductory text, kitchen specializations, and the photo gallery.',
            'crud' => [
                ['Create', 'yes', 'Add a kitchen specialization or add images. The dining page itself already exists.'],
                ['Read', 'yes', 'Open Dining page to see the current text, specializations, and photos.'],
                ['Update', 'yes', 'Edit the page text, a specialization, or a photo caption, then save that form.'],
                ['Delete', 'yes', 'Delete removes one specialization or one photo. It does not remove the dining page.'],
            ],
            'steps' => [
                'Update the main description so it matches the current restaurant and bar offer.',
                'Add at least one kitchen specialization if the public page should highlight the kitchens.',
                'Add photos, set captions, and use the order controls so the best image leads.',
                'Check /dining after saving.',
            ],
        ],
        [
            'id' => 'meetings',
            'name' => 'Meetings',
            'where' => 'Sidebar → Meetings',
            'path' => '/eventsPage',
            'summary' => 'The Meetings & Events page and each meeting room: description, logistics, room details, and room photos.',
            'crud' => [
                ['Create', 'yes', 'Use Add room for a new meeting space, and Add images for that room’s gallery.'],
                ['Read', 'yes', 'The page lists the events introduction and every meeting room.'],
                ['Update', 'yes', 'Save the events description, or open a room and choose Save room. Captions are saved on each photo.'],
                ['Delete', 'yes', 'Remove room deletes that meeting space. Delete on a photo removes only that image.'],
            ],
            'steps' => [
                'Edit the events introduction and the details guests need for enquiries.',
                'Add or update each meeting room, including its name and description.',
                'Add room photos and save captions.',
                'Confirm the result on /meetings-events and on the individual room page.',
            ],
        ],
        [
            'id' => 'amenities',
            'name' => 'Amenities',
            'where' => 'Sidebar → Amenities',
            'path' => '/content-management/amenities',
            'summary' => 'The amenity list attached to rooms and repeated in hotel content, such as Wi-Fi or parking.',
            'crud' => [
                ['Create', 'yes', 'Choose Add New Amenity, name it, and save.'],
                ['Read', 'yes', 'The table shows every amenity currently available to attach to rooms.'],
                ['Update', 'yes', 'Edit an amenity when the name or details should change, then save.'],
                ['Delete', 'yes', 'Delete removes that amenity from the list. Update any room that was using it if the public text should change.'],
            ],
            'steps' => [
                'Add amenities before you assign them on a room.',
                'Edit a name here if it should change everywhere it is reused.',
                'Open Rooms afterwards and confirm the right amenities are ticked.',
            ],
        ],
        [
            'id' => 'activities',
            'name' => 'Activities',
            'where' => 'Sidebar → Activities',
            'path' => '/content-management/tour-activities',
            'summary' => 'Tours and activities shown under the experiences area of the website.',
            'crud' => [
                ['Create', 'yes', 'Choose Add New Tour Activity and complete the title, description, and image.'],
                ['Read', 'yes', 'The list shows each activity currently available to guests.'],
                ['Update', 'yes', 'Edit the activity and save. The public page uses the saved title and text.'],
                ['Delete', 'yes', 'Delete removes that activity after you confirm.'],
            ],
            'steps' => [
                'Add an activity only when the hotel is ready for guests to read about it.',
                'Keep the description practical: what the guest does, and how to ask the hotel about it.',
                'Save and review the activities pages on the public site.',
            ],
        ],
        [
            'id' => 'why-choose-us',
            'name' => 'Why Choose Us',
            'where' => 'Sidebar → Why Choose Us',
            'path' => '/content-management/why-choose-us',
            'summary' => 'Short reasons shown on the website, such as location, values, or service. Each reason is one item with a title and description.',
            'crud' => [
                ['Create', 'yes', 'Choose Add item, enter the title and description, and save.'],
                ['Read', 'yes', 'The table lists items in their display order.'],
                ['Update', 'yes', 'Edit an item to change its title, description, or order.'],
                ['Delete', 'yes', 'Delete removes that reason from the website after you confirm.'],
            ],
            'steps' => [
                'Keep each item short enough to scan.',
                'Set the order so the strongest reason appears first.',
                'Save and review the block on the public pages that include it.',
            ],
        ],
        [
            'id' => 'attractions',
            'name' => 'Attractions',
            'where' => 'Sidebar → Attractions',
            'path' => '/content-management/attractions',
            'summary' => 'Nearby points of interest the hotel wants guests to know about.',
            'crud' => [
                ['Create', 'yes', 'Add an attraction with its name and description.'],
                ['Read', 'yes', 'The list shows every attraction currently stored.'],
                ['Update', 'yes', 'Edit an attraction when the description or details change.'],
                ['Delete', 'yes', 'Delete removes that attraction from the site.'],
            ],
            'steps' => [
                'Add places guests can realistically visit from the hotel.',
                'Update a description when opening hours or the offer changes.',
                'Remove an attraction that should no longer be recommended.',
            ],
        ],
        [
            'id' => 'updates',
            'name' => 'Updates',
            'where' => 'Sidebar → Updates',
            'path' => '/getBlogs',
            'summary' => 'News-style articles published on Our updates. Each article can be drafted and then published.',
            'crud' => [
                ['Create', 'yes', 'Choose Add New Update, write the title and article, add an image if you have one, and save.'],
                ['Read', 'yes', 'The list shows existing articles. Open one to read it before it goes public.'],
                ['Update', 'yes', 'Edit the article and save. Use Publish when it should appear on the public updates page.'],
                ['Delete', 'yes', 'Delete removes the article. Confirm first, because the public link will stop working.'],
            ],
            'steps' => [
                'Write the update and save it.',
                'Publish it only when the wording is final.',
                'Open /our-updates and the article link to confirm it reads correctly.',
            ],
        ],
        [
            'id' => 'team',
            'name' => 'Team Members',
            'where' => 'Sidebar → Team Members',
            'path' => '/staff',
            'summary' => 'People shown as the hotel team: name, position, and photo.',
            'crud' => [
                ['Create', 'yes', 'Choose Add New Team Member and enter the name, position, and photo.'],
                ['Read', 'yes', 'The table lists current team members.'],
                ['Update', 'yes', 'Edit a member when a name, role, or photo changes.'],
                ['Delete', 'yes', 'Delete removes that person from the team list.'],
            ],
            'steps' => [
                'Add a member only with permission to publish their name and photo.',
                'Update the position when a role changes, rather than creating a duplicate.',
                'Remove a member who should no longer appear.',
            ],
        ],
        [
            'id' => 'media',
            'name' => 'Media Images',
            'where' => 'Sidebar → Media Images',
            'path' => '/content-management/media',
            'summary' => 'The shared photo library. Other screens can reuse a picture from here so the same file is not uploaded again.',
            'crud' => [
                ['Create', 'yes', 'Upload a new image into the library.'],
                ['Read', 'yes', 'Browse the library before uploading, in case the photo is already there.'],
                ['Update', 'no', 'There is no separate edit form. Upload a replacement and remove the old file if it should no longer be used.'],
                ['Delete', 'yes', 'The trash icon removes that library file. Check it is not still needed on a room, page, or gallery first.'],
            ],
            'steps' => [
                'Upload clear, reasonably sized photos.',
                'When editing a room, About, or page header, choose an existing library image if you already have the right one.',
                'Delete a file only when you are sure no public page still depends on it.',
            ],
        ],
        [
            'id' => 'gallery',
            'name' => 'Gallery',
            'where' => 'Sidebar → Gallery',
            'path' => '/content-management/gallery',
            'summary' => 'The public photo gallery at /gallery.',
            'crud' => [
                ['Create', 'yes', 'Add photos to the gallery.'],
                ['Read', 'yes', 'The screen shows the photos currently in the gallery and their order.'],
                ['Update', 'yes', 'Reorder photos so the strongest images appear first. Move a photo when its position should change.'],
                ['Delete', 'yes', 'Remove a photo that should no longer be public.'],
            ],
            'steps' => [
                'Add new property photos after an event, renovation, or photo visit.',
                'Put the best image first.',
                'Remove anything outdated, then refresh /gallery in a private window.',
            ],
        ],
        [
            'id' => 'slideshow',
            'name' => 'Home Slide',
            'where' => 'Sidebar → Home Slide',
            'path' => '/content-management/slideshow',
            'summary' => 'The large photos and captions at the top of the homepage.',
            'crud' => [
                ['Create', 'yes', 'Add a slide with an image and the caption guests should read.'],
                ['Read', 'yes', 'The list shows every slide currently available to the homepage.'],
                ['Update', 'yes', 'Edit a slide to change its photo, caption, or link.'],
                ['Delete', 'yes', 'Delete removes that slide from the homepage after you confirm.'],
            ],
            'steps' => [
                'Keep a small set of strong images rather than many similar ones.',
                'Write short captions.',
                'Save, then open the homepage and confirm the slideshow still moves through every slide.',
            ],
        ],
        [
            'id' => 'heroes',
            'name' => 'Page header images',
            'where' => 'Sidebar → Page header images',
            'path' => '/content-management/page-heroes',
            'summary' => 'The banner photograph at the top of public pages. Set one default, then replace a single page when it needs its own photo.',
            'crud' => [
                ['Create', 'no', 'You do not add new pages here. The public pages already exist.'],
                ['Read', 'yes', 'The list shows each public page and the header it is using.'],
                ['Update', 'yes', 'Upload a new photo or pick one from the media library, then save that page.'],
                ['Delete', 'no', 'Clearing a page header falls back toward the default. Ask the developer if a banner must be removed entirely.'],
            ],
            'steps' => [
                'Set the default header first so every page has a consistent photo.',
                'Change an individual page only when its subject needs a different picture.',
                'Prefer a library image you already uploaded, so duplicates are not stored.',
            ],
        ],
        [
            'id' => 'partners',
            'name' => 'Partners',
            'where' => 'Sidebar → Partners',
            'path' => '/getPartners',
            'summary' => 'Logos and names of partner organisations shown on the site.',
            'crud' => [
                ['Create', 'yes', 'Choose Add New Partner and enter the name and logo.'],
                ['Read', 'yes', 'The list shows partners currently stored.'],
                ['Update', 'yes', 'Edit a partner when the logo or name changes.'],
                ['Delete', 'yes', 'Delete removes that partner from the website.'],
            ],
            'steps' => [
                'Use a clear logo on a simple background.',
                'Update the logo in place when a partner rebrands.',
                'Remove a partner that should no longer be displayed.',
            ],
        ],
        [
            'id' => 'services',
            'name' => 'Services',
            'where' => 'Dashboard → Manage Services',
            'path' => '/content-management/services',
            'summary' => 'Service entries used on Our services. Open this from the dashboard shortcut. It uses the same list pattern as Rooms.',
            'crud' => [
                ['Create', 'yes', 'Choose Add New Service and complete the title, description, and image.'],
                ['Read', 'yes', 'The table lists every service.'],
                ['Update', 'yes', 'The pencil icon edits the service. Save to publish.'],
                ['Delete', 'yes', 'The trash icon removes that service after you confirm.'],
            ],
            'steps' => [
                'From the dashboard, choose Manage Services.',
                'Add or edit the service so the public name matches what the hotel offers.',
                'Check /our-services after saving.',
            ],
        ],
        [
            'id' => 'terms',
            'name' => 'Terms',
            'where' => 'Sidebar → Terms',
            'path' => '/content-management/terms',
            'summary' => 'The Terms & Conditions page. The text is edited in one document and can be marked active or inactive.',
            'crud' => [
                ['Create', 'no', 'There is one terms document. You update that document.'],
                ['Read', 'yes', 'Open Terms to read the current policy.'],
                ['Update', 'yes', 'Edit the content, set the status to Active, and choose Update Terms & Conditions.'],
                ['Delete', 'no', 'Do not remove the policy. Replace wording, or set it inactive only with the hotel’s approval.'],
            ],
            'steps' => [
                'Edit the policy in the editor.',
                'Leave the status Active when the page should be public.',
                'Read /terms-and-conditions after saving, before you share the change.',
            ],
        ],
        [
            'id' => 'seo',
            'name' => 'SEO Data',
            'where' => 'Sidebar → SEO Data',
            'path' => '/content-management/seo-data',
            'summary' => 'The search title and description for public pages. This is what search engines and link previews can show.',
            'crud' => [
                ['Create', 'yes', 'Choose Add SEO Data for a page that does not have an entry yet. Set the page name, meta title, and meta description.'],
                ['Read', 'yes', 'The table lists each page with its current title and description.'],
                ['Update', 'yes', 'Use the pencil icon to revise a title or description, then save.'],
                ['Delete', 'no', 'This screen does not delete an SEO entry. Ask the developer if one was created for the wrong page.'],
            ],
            'steps' => [
                'Write a title that names the page and Bethel Hotel.',
                'Write a short description a guest would understand in a search result.',
                'Update an existing row instead of adding a second entry for the same page.',
            ],
        ],
        [
            'id' => 'settings',
            'name' => 'Settings',
            'where' => 'Sidebar → Settings',
            'path' => '/setting',
            'summary' => 'Hotel-wide settings. Work in one tab at a time and save that tab before moving on.',
            'crud' => [
                ['Create', 'no', 'These settings already exist. You update them.'],
                ['Read', 'yes', 'Each tab shows the values currently in use.'],
                ['Update', 'yes', 'Contacts & Logo, Booking & review links, About Hotel, Terms & Conditions, and SEO Keywords each have their own save action.'],
                ['Delete', 'no', 'Replace a value rather than deleting the setting. An empty booking or review link will weaken the public Book and Reviews buttons.'],
            ],
            'steps' => [
                'Contacts & Logo: website title, logo, phones, email, address, map, and social links.',
                'Booking & review links: Booking.com, TripAdvisor, Google, WhatsApp, and the contact email used on buttons. Optional scores and review counts appear on the Reviews page.',
                'Save the tab you edited, then test Book now and Reviews on the public site.',
            ],
        ],
        [
            'id' => 'hosting',
            'name' => 'Hosting',
            'where' => 'Sidebar → Hosting',
            'path' => '/content-management/hosting',
            'summary' => 'Domain registration, the hosting server, the annual hosting and support fees, and each year’s renewal invoice. The renewal date is 1 August.',
            'crud' => [
                ['Create', 'no', 'The next annual invoice is opened automatically when the previous period reaches 1 August.'],
                ['Read', 'yes', 'Open Hosting to see afriregister.com, digitalocean.com, the fee totals, and the list of annual invoices. Open an invoice to print or download it as a PDF.'],
                ['Update', 'yes', 'Enter the current dollar rate. Hosting of $80 is converted to RWF and added to the 500,000 RWF support fee on the active invoice. A super admin marks an invoice paid after payment is confirmed.'],
                ['Delete', 'no', 'Invoices stay on file. An unpaid invoice changes from active to expired on 1 August until it is marked paid.'],
            ],
            'steps' => [
                'Open Hosting and check the domain registrar, hosting server, and the email that receives renewal reminders.',
                'Enter today’s USD to RWF rate and save. The active invoice total updates immediately.',
                'Open View / print on an invoice, then use Print or Download PDF and choose Save as PDF.',
                'After the hotel pays, a super admin confirms that invoice as paid. Reminders go out 30 days before, 15 days before, and on 1 August.',
            ],
        ],
        [
            'id' => 'users',
            'name' => 'System Users',
            'where' => 'Developer only',
            'path' => '/content-management/users',
            'summary' => 'Accounts and roles. This menu is available to the developer, not to a newly registered hotel user. The hotel creates the account, then asks the developer to make that person the admin.',
            'crud' => [
                ['Create', 'yes', 'The new staff member creates their own account at the registration page. The developer then assigns the admin role.'],
                ['Read', 'yes', 'The developer can see registered users and their roles.'],
                ['Update', 'yes', 'The developer sets the role to Super Admin, verifies the email if needed, or resets a password.'],
                ['Delete', 'yes', 'The developer can remove an account that should no longer have access. Ask before anyone is deleted.'],
            ],
            'steps' => [
                'The person opens Create an account and registers with the email they will use for admin work.',
                'They tell the developer the exact name and email on that account.',
                'The developer makes that user the admin. Until that is done, signing in will not open content management.',
            ],
        ],
    ];

    $sections = [
        ['id' => 'overview', 'label' => 'Overview'],
        ['id' => 'access', 'label' => 'Admin access'],
        ['id' => 'guide', 'label' => 'Admin guide'],
        ['id' => 'website', 'label' => 'Public website'],
        ['id' => 'maintenance', 'label' => 'Maintenance'],
        ['id' => 'close', 'label' => 'Support'],
    ];
@endphp

@section('content')
<div class="ho" id="handover-app">
    <header class="ho-top ho-no-print">
        <div>
            <p class="ho-brand">KURRE Consultancy · Prepared for <strong>Bethel Hotel</strong></p>
            <p class="ho-brand" style="letter-spacing:0;text-transform:none;font-size:0.95rem;">Client handover &amp; user guide · September 2026</p>
        </div>
        <div class="ho-actions">
            <button type="button" class="ho-btn" id="ho-download">
                <i class="fa-solid fa-file-arrow-down" aria-hidden="true"></i> Download PDF
            </button>
        </div>
    </header>

    <nav class="ho-sections ho-no-print" aria-label="Handover sections">
        @foreach($sections as $section)
            <button type="button" data-section="{{ $section['id'] }}" aria-selected="false">{{ $section['label'] }}</button>
        @endforeach
    </nav>
    <p class="ho-progress ho-no-print" id="ho-progress"></p>

    <div class="ho-card">
        <section class="ho-section" id="overview" data-label="Overview">
            <p class="ho-print-only ho-doc-running">Bethel Hotel · Client handover · KURRE Consultancy</p>
            <p class="ho-kicker">Document</p>
            <h2>Client handover &amp; user guide</h2>
            <p class="ho-lead">This guide is how Bethel Hotel takes over the website: who may edit it, how each admin feature is created, read, updated, and removed, and how the live site is maintained.</p>
            <div class="ho-meta">
                <div><span>Prepared for</span><strong>Bethel Hotel</strong></div>
                <div><span>Prepared by</span><strong>KURRE Consultancy</strong></div>
                <div><span>Live domain</span><strong>{{ $domain }}</strong></div>
            </div>
            <p>The website is the hotel’s public presence. It presents rooms, dining, facilities, meetings, activities, and news, and it sends guests to trusted places to book and leave reviews. Day-to-day edits are made after an admin signs in. Server passwords are not printed in this document.</p>
            <div class="ho-callout">
                <strong>How to use this guide</strong>
                Move with the section buttons, or with Previous and Next. The admin guide then opens one feature at a time. Download PDF saves the full document, with each section and each feature starting on its own page. In the print window, choose <strong>Save as PDF</strong>.
            </div>
            <div class="ho-jump ho-no-print">
                <button type="button" data-goto="access">Get an admin account</button>
                <button type="button" data-goto="guide">Open the admin guide</button>
                <button type="button" data-goto="maintenance">Maintenance &amp; domain</button>
            </div>
        </section>

        <section class="ho-section" id="access" data-label="Admin access">
            <p class="ho-print-only ho-doc-running">Bethel Hotel · Client handover · KURRE Consultancy</p>
            <p class="ho-kicker">Access</p>
            <h2>Create an account, then ask for admin</h2>
            <p class="ho-lead">Registration creates a normal account. It does not make someone an administrator. After the account exists, ask the developer to make that user the admin.</p>
            <ol class="ho-steps">
                <li>Open <a href="{{ $registerUrl }}">Create an account</a> and register with the name and email that should manage the website. On the live site this page is <strong>{{ $live }}/register</strong>.</li>
                <li>Use an email the person can access. They will need it to sign in and to receive a password reset if one is required.</li>
                <li>Contact the developer at <strong>KURRE Consultancy</strong> on the same channel used for this project. Send the <strong>full name and email</strong> on the new account and ask them to make that user the admin.</li>
                <li>Wait for confirmation. Until the role is assigned, that person cannot open content management.</li>
                <li>Sign in at <a href="{{ $loginUrl }}">{{ $loginUrl }}</a>. An admin is taken to <a href="{{ $dashboardUrl }}">{{ $dashboardUrl }}</a>.</li>
            </ol>
            <p class="ho-cta ho-no-print">
                <a class="ho-btn" href="{{ $registerUrl }}">Create an account</a>
            </p>
            <div class="ho-note">
                <strong>What “admin” means here</strong>
                <p style="margin:0.35rem 0 0;">The developer assigns <strong>Super Admin</strong>. That role can manage the website content described in the next section. A second person can later be given <strong>Content Manager</strong> if they should edit content without user administration. New registrations stay ordinary accounts until the developer changes the role. The System Users screen itself stays with the developer.</p>
            </div>
            <p>There is one staff sign-in address: <strong>/login</strong>. Guest accounts under <strong>/account</strong> are for travellers and do not open the admin sidebar.</p>
        </section>

        <section class="ho-section" id="guide" data-label="Admin guide">
            <p class="ho-print-only ho-doc-running">Bethel Hotel · Client handover · KURRE Consultancy</p>
            <p class="ho-kicker">Admin user guide</p>
            <h2>Features, one at a time</h2>
            <p>After you are an admin, the left sidebar is the menu. Most content screens use the same four actions. <strong>Create</strong> is usually an Add button. <strong>Read</strong> is the list or the eye icon. <strong>Update</strong> is the pencil icon or a Save button. <strong>Delete</strong> is the trash icon and always asks you to confirm. Save, then check the public page in a private window so you are not looking at an old copy.</p>
            <div class="ho-tabs ho-no-print" id="ho-feature-tabs" role="tablist" aria-label="Admin features">
                @foreach($features as $feature)
                    <button type="button" role="tab" data-feature="{{ $feature['id'] }}" aria-selected="false">{{ $feature['name'] }}</button>
                @endforeach
            </div>

            @foreach($features as $feature)
                <article class="ho-feature" id="feature-{{ $feature['id'] }}" data-name="{{ $feature['name'] }}">
                    <p class="ho-print-only ho-doc-running">Bethel Hotel · Client handover · {{ $feature['name'] }} · {{ $loop->iteration }} of {{ $loop->count }}</p>
                    <h2 style="font-size:1.55rem;">{{ $feature['name'] }}</h2>
                    <p class="ho-where">{{ $feature['where'] }} · <code>{{ $feature['path'] }}</code></p>
                    <p>{{ $feature['summary'] }}</p>
                    <div class="ho-crud">
                        @foreach($feature['crud'] as [$label, $state, $text])
                            <article>
                                <header>
                                    <h3>{{ $label }}</h3>
                                    <span class="ho-pill {{ $state }}">{{ $state === 'yes' ? 'Available' : 'Not on this screen' }}</span>
                                </header>
                                <p>{{ $text }}</p>
                            </article>
                        @endforeach
                    </div>
                    <h3 style="font-family:Inter,sans-serif;font-size:1rem;margin:0 0 0.35rem;">How to do it</h3>
                    <ol class="ho-steps">
                        @foreach($feature['steps'] as $step)
                            <li>{{ $step }}</li>
                        @endforeach
                    </ol>
                </article>
            @endforeach
        </section>

        <section class="ho-section" id="website" data-label="Public website">
            <p class="ho-print-only ho-doc-running">Bethel Hotel · Client handover · KURRE Consultancy</p>
            <p class="ho-kicker">Public website</p>
            <h2>What guests see</h2>
            <p class="ho-lead">The public site introduces the hotel and points guests outward to book and review. It does not take card payments and it does not replace Booking.com.</p>
            <div style="overflow-x:auto;">
            <table class="ho-table">
                <thead>
                    <tr><th>Page</th><th>Address</th><th>Edited from</th></tr>
                </thead>
                <tbody>
                    <tr><td>Home</td><td><code>/</code></td><td>Home Slide, About, Settings</td></tr>
                    <tr><td>About us</td><td><code>/about-us</code></td><td>About</td></tr>
                    <tr><td>Our services</td><td><code>/our-services</code></td><td>Services</td></tr>
                    <tr><td>Rooms &amp; apartments</td><td><code>/our-rooms</code></td><td>Rooms</td></tr>
                    <tr><td>Dining</td><td><code>/dining</code></td><td>Dining page</td></tr>
                    <tr><td>Facilities</td><td><code>/facilities</code></td><td>Facilities</td></tr>
                    <tr><td>Activities &amp; tours</td><td><code>/activities</code>, <code>/tours</code></td><td>Activities</td></tr>
                    <tr><td>Meetings &amp; events</td><td><code>/meetings-events</code></td><td>Meetings</td></tr>
                    <tr><td>Updates</td><td><code>/our-updates</code></td><td>Updates</td></tr>
                    <tr><td>Gallery</td><td><code>/gallery</code></td><td>Gallery</td></tr>
                    <tr><td>Contact</td><td><code>/contact</code></td><td>Contacts and Settings</td></tr>
                    <tr><td>Book now</td><td><code>/book-now</code></td><td>Settings → Booking &amp; review links</td></tr>
                    <tr><td>Reviews</td><td><code>/reviews</code></td><td>Settings → Booking &amp; review links</td></tr>
                    <tr><td>Terms</td><td><code>/terms-and-conditions</code></td><td>Terms</td></tr>
                </tbody>
            </table>
            </div>
            <div class="ho-callout">
                <strong>Booking and reviews stay on trusted platforms</strong>
                <p style="margin:0.35rem 0 0;">Book now sends guests to Booking.com, WhatsApp, or email. Reviews links go to TripAdvisor, Google, and Booking.com. Those services already handle availability, payment, and public feedback. The hotel website’s job is to present the property and send a ready guest to the right place. Keep those links current in Settings.</p>
            </div>
        </section>

        <section class="ho-section" id="maintenance" data-label="Maintenance">
            <p class="ho-print-only ho-doc-running">Bethel Hotel · Client handover · KURRE Consultancy</p>
            <p class="ho-kicker">Maintenance</p>
            <h2>Domain, server, and hosting</h2>
            <p class="ho-lead">The live website is published at <strong>{{ $domain }}</strong>. Content changes are made by an admin in the browser. Server and hosting passwords are shared separately, and only if the hotel wants to follow the hosting up on its own.</p>
            <dl class="ho-dl">
                <div>
                    <dt>Domain</dt>
                    <dd><strong>{{ $domain }}</strong><br>Public address: <a href="{{ $live }}">{{ $live }}</a></dd>
                </div>
                <div>
                    <dt>Admin sign-in</dt>
                    <dd><a href="{{ $live }}/login">{{ $live }}/login</a><br>Content management: <a href="{{ $live }}/content-management/dashboard">{{ $live }}/content-management/dashboard</a></dd>
                </div>
                <div>
                    <dt>Application</dt>
                    <dd>Laravel 10 on PHP 8.1 or newer, with a MySQL database. Public pages use Livewire. The site is served over HTTPS on the domain above.</dd>
                </div>
                <div>
                    <dt>Email delivery</dt>
                    <dd>Guest messages, reservation replies, and account mail are sent through the hotel’s mail service (Resend) from the hotel’s configured address. Changing the sending domain is a developer task.</dd>
                </div>
                <div>
                    <dt>Domain registration</dt>
                    <dd><strong>afriregister.com</strong></dd>
                </div>
                <div>
                    <dt>Hosting server</dt>
                    <dd><strong>digitalocean.com</strong>. Annual hosting is <strong>$80</strong>. Annual support is <strong>500,000 RWF</strong>. The renewal date is <strong>1 August</strong>.</dd>
                </div>
                <div>
                    <dt>Renewal invoices</dt>
                    <dd>Signed-in admins open <a href="{{ $live }}/content-management/hosting">Hosting</a>, enter the current dollar rate, and print or download each annual invoice. The invoice already paid was <strong>130,000 RWF</strong> with support included free. The next invoice is active and adds the support fee. It becomes expired on 1 August if it is still unpaid, until a super admin confirms payment.</dd>
                </div>
                <div>
                    <dt>Hosting credentials</dt>
                    <dd>The hosting control panel, file access, and database passwords are <strong>not included in this guide</strong>. KURRE Consultancy will share them once they are needed, if the hotel wants to follow the server up independently. Until then, do not request or store those passwords in a general staff channel.</dd>
                </div>
            </dl>
            <div class="ho-note">
                <strong>What the hotel can maintain without the server</strong>
                <p style="margin:0.35rem 0 0;">Text, photos, rooms, prices shown on the site, dining, meetings, gallery, updates, contact details, and the booking and review links. Ask the developer before a domain change, a hosting move, a database export, or a change to how email is sent.</p>
            </div>
        </section>

        <section class="ho-section" id="close" data-label="Support">
            <p class="ho-print-only ho-doc-running">Bethel Hotel · Client handover · KURRE Consultancy</p>
            <p class="ho-kicker">Support</p>
            <h2>Training and further help</h2>
            <p class="ho-lead">KURRE Consultancy remains available so the hotel can keep the site current as content, channels, and guest expectations change.</p>
            <div class="ho-callout">
                <strong>When to ask for a training session</strong>
                <p style="margin:0.35rem 0 0;">If several staff members need to edit the site, or if this guide is not enough on its own, arrange a walkthrough with KURRE Consultancy. A short session is the reliable way to confirm that more than one person can update rooms, photos, and booking links.</p>
            </div>
            <ul class="ho-steps">
                <li>For a new administrator: send the registered name and email and ask the developer to make that user the admin.</li>
                <li>For content that will not save or does not appear: say which sidebar item you used and what you expected to see on the public page.</li>
                <li>For hosting, the domain, or email delivery: ask through the project channel. Credentials are shared only when the hotel wants to follow that up itself.</li>
            </ul>
            <p>Thank you to Bethel Hotel for trusting KURRE Consultancy with this project. Share this guide inside the hotel at <a href="{{ url('/handover') }}">{{ url('/handover') }}</a>. It is marked so search engines are not asked to list it.</p>
        </section>
    </div>

    <div class="ho-pager ho-no-print">
        <button type="button" class="ho-btn ghost" id="ho-prev"><span></span></button>
        <button type="button" class="ho-btn" id="ho-next"><span></span></button>
    </div>
</div>
@endsection

@push('scripts')
<script>
(function () {
    var root = document.getElementById('handover-app');
    if (!root) return;

    var sections = Array.prototype.slice.call(root.querySelectorAll('.ho-section'));
    var features = Array.prototype.slice.call(root.querySelectorAll('.ho-feature'));
    var sectionButtons = Array.prototype.slice.call(root.querySelectorAll('.ho-sections button'));
    var featureButtons = Array.prototype.slice.call(root.querySelectorAll('#ho-feature-tabs button'));
    var progress = document.getElementById('ho-progress');
    var prevBtn = document.getElementById('ho-prev');
    var nextBtn = document.getElementById('ho-next');
    var sectionIndex = 0;
    var featureIndex = 0;

    function guideIndex() {
        return sections.findIndex(function (section) { return section.id === 'guide'; });
    }

    function isGuide() {
        return sectionIndex === guideIndex();
    }

    function show() {
        sections.forEach(function (section, index) {
            var active = index === sectionIndex;
            section.classList.toggle('is-active', active);
        });
        sectionButtons.forEach(function (button, index) {
            button.setAttribute('aria-selected', index === sectionIndex ? 'true' : 'false');
        });
        features.forEach(function (feature, index) {
            feature.classList.toggle('is-active', index === featureIndex);
        });
        featureButtons.forEach(function (button, index) {
            button.setAttribute('aria-selected', index === featureIndex ? 'true' : 'false');
        });

        var section = sections[sectionIndex];
        var label = section.getAttribute('data-label');
        if (isGuide()) {
            progress.textContent = 'Section ' + (sectionIndex + 1) + ' of ' + sections.length
                + ' · ' + label + ' · Feature ' + (featureIndex + 1) + ' of ' + features.length
                + ' — ' + features[featureIndex].getAttribute('data-name');
        } else {
            progress.textContent = 'Section ' + (sectionIndex + 1) + ' of ' + sections.length + ' · ' + label;
        }

        var prev = previousTarget();
        var next = nextTarget();
        prevBtn.disabled = !prev;
        nextBtn.disabled = !next;
        prevBtn.querySelector('span').innerHTML = prev
            ? '<small>Previous</small>' + prev.label
            : '<small>Previous</small>Start';
        nextBtn.querySelector('span').innerHTML = next
            ? '<small>Next</small>' + next.label
            : '<small>Next</small>End';

        var hash = isGuide()
            ? '#guide-' + features[featureIndex].id.replace('feature-', '')
            : '#' + section.id;
        if (location.hash !== hash) {
            history.replaceState(null, '', hash);
        }

        var activeSectionBtn = sectionButtons[sectionIndex];
        if (activeSectionBtn) {
            activeSectionBtn.scrollIntoView({ inline: 'center', block: 'nearest' });
        }
        if (isGuide() && featureButtons[featureIndex]) {
            featureButtons[featureIndex].scrollIntoView({ inline: 'center', block: 'nearest' });
        }
    }

    function previousTarget() {
        if (isGuide() && featureIndex > 0) {
            return { label: features[featureIndex - 1].getAttribute('data-name') };
        }
        if (sectionIndex > 0) {
            return { label: sections[sectionIndex - 1].getAttribute('data-label') };
        }
        return null;
    }

    function nextTarget() {
        if (isGuide() && featureIndex < features.length - 1) {
            return { label: features[featureIndex + 1].getAttribute('data-name') };
        }
        if (sectionIndex < sections.length - 1) {
            return { label: sections[sectionIndex + 1].getAttribute('data-label') };
        }
        return null;
    }

    function goNext() {
        if (isGuide() && featureIndex < features.length - 1) {
            featureIndex += 1;
        } else if (sectionIndex < sections.length - 1) {
            sectionIndex += 1;
            if (isGuide()) featureIndex = 0;
        }
        show();
        root.scrollIntoView({ behavior: 'smooth', block: 'start' });
    }

    function goPrev() {
        if (isGuide() && featureIndex > 0) {
            featureIndex -= 1;
        } else if (sectionIndex > 0) {
            sectionIndex -= 1;
            if (isGuide()) featureIndex = features.length - 1;
        }
        show();
        root.scrollIntoView({ behavior: 'smooth', block: 'start' });
    }

    function openSection(id) {
        var index = sections.findIndex(function (section) { return section.id === id; });
        if (index < 0) return;
        sectionIndex = index;
        if (!isGuide()) {
            featureIndex = 0;
        }
        show();
    }

    sectionButtons.forEach(function (button) {
        button.addEventListener('click', function () {
            openSection(button.getAttribute('data-section'));
            root.scrollIntoView({ behavior: 'smooth', block: 'start' });
        });
    });
    featureButtons.forEach(function (button, index) {
        button.addEventListener('click', function () {
            sectionIndex = guideIndex();
            featureIndex = index;
            show();
        });
    });
    root.querySelectorAll('[data-goto]').forEach(function (button) {
        button.addEventListener('click', function () {
            openSection(button.getAttribute('data-goto'));
            root.scrollIntoView({ behavior: 'smooth', block: 'start' });
        });
    });
    prevBtn.addEventListener('click', goPrev);
    nextBtn.addEventListener('click', goNext);

    document.getElementById('ho-download').addEventListener('click', function () {
        window.print();
    });

    document.addEventListener('keydown', function (event) {
        if (event.altKey || event.metaKey || event.ctrlKey) return;
        var tag = (event.target && event.target.tagName) || '';
        if (tag === 'INPUT' || tag === 'TEXTAREA' || tag === 'SELECT') return;
        if (event.key === 'ArrowRight') {
            event.preventDefault();
            goNext();
        } else if (event.key === 'ArrowLeft') {
            event.preventDefault();
            goPrev();
        }
    });

    var hash = (location.hash || '').replace('#', '');
    if (hash.indexOf('guide-') === 0) {
        var featureId = hash.slice('guide-'.length);
        var found = features.findIndex(function (feature) {
            return feature.id === 'feature-' + featureId;
        });
        sectionIndex = guideIndex();
        featureIndex = found >= 0 ? found : 0;
    } else if (hash) {
        var fromHash = sections.findIndex(function (section) { return section.id === hash; });
        if (fromHash >= 0) sectionIndex = fromHash;
    }

    show();
})();
</script>
@endpush
