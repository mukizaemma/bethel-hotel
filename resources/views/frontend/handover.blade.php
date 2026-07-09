@extends('layouts.frontbase')

@section('meta_robots', 'noindex, nofollow')

@section('document_title', 'Client handover & user guide — Bethel Hotel')

@push('head')
<style>
    .handover-doc { max-width: 900px; margin-left: auto; margin-right: auto; }
    .handover-doc h2 { margin-top: 2rem; font-size: clamp(1.35rem, 2.5vw, 1.6rem); }
    .handover-doc h3 { margin-top: 1.5rem; font-size: 1.1rem; font-weight: 600; }
    .handover-doc .handover-lead { font-size: 1.05rem; line-height: 1.65; }
    .handover-doc table { font-size: 0.95rem; }
    .handover-doc .callout-training {
        border-left: 4px solid #0048ff;
        background: #f0f6fc;
        padding: 1rem 1.25rem;
        border-radius: 0 8px 8px 0;
    }
    .handover-doc code { font-size: 0.88em; }
    @media print {
        .handover-no-print { display: none !important; }
        .handover-doc { font-size: 11pt; max-width: 100%; }
        .rts__section { padding-top: 0.5rem !important; padding-bottom: 0.5rem !important; }
    }
</style>
@endpush

@section('content')
<div class="rts__section section__padding handover-doc text-start">
    <div class="container py-3 py-lg-4">
        <div class="handover-no-print d-flex flex-wrap gap-2 justify-content-between align-items-center mb-4 pb-3 border-bottom">
            <div>
                <p class="small text-muted mb-0">Bethel Hotel · Client handover</p>
                <p class="small mb-0"><strong>KURRE Consultancy</strong></p>
            </div>
            <div class="d-flex gap-2">
                <button type="button" class="theme-btn btn-style sm-btn fill handover-no-print" onclick="window.print()">
                    <span><i class="fa-solid fa-print me-1" aria-hidden="true"></i> Print / Save as PDF</span>
                </button>
            </div>
        </div>

        <header class="mb-4">
            <h1 class="mb-3" style="font-size: clamp(1.5rem, 3vw, 2rem);">Client handover &amp; user guide</h1>
            <p class="handover-lead text-muted mb-2">Your website — how to get access, manage content, and where booking and reviews fit in.</p>
            <p class="small text-muted mb-0">Prepared for <strong>Bethel Hotel</strong> · Document version for web &amp; print</p>
        </header>

        <section class="mb-4 p-3 p-lg-4 rounded-3 border bg-light">
            <h2 class="h5 mb-2">About this project</h2>
            <p class="mb-2"><strong>KURRE Consultancy</strong> partnered with Bethel Hotel on a <strong>full-package online presence revamp</strong>: we helped build the website, develop professional content, and support photography at the property — including sharing <strong>quality images</strong> for use across the site. The goal was a credible, modern digital presence that reflects the hotel’s standards.</p>
            <p class="mb-0">We remain available for <strong>future support</strong> so the hotel can stay ahead in the digital space as channels, content, and guest expectations evolve.</p>
        </section>

        <div class="callout-training mb-4">
            <p class="mb-2"><strong>Training &amp; further support</strong></p>
            <p class="mb-0 small">Hotel <strong>management should plan a training session</strong> with KURRE Consultancy if this document is not sufficient on its own, or if the team needs <strong>more in-person walkthroughs</strong> and clarification beyond what is written here. A structured session helps ensure several staff members can confidently update content and understand booking and review workflows.</p>
        </div>

        <h2>1. Introduction</h2>
        <p>This guide explains what your Bethel Hotel website is for, how your team can obtain a <strong>content-management</strong> account, where to sign in, how to update content, and why booking and guest reviews use trusted external platforms. Use the <strong>Print / Save as PDF</strong> button at the top (or your browser’s print function) to save a copy for your records.</p>
        <p><strong>Share this page:</strong> <a href="{{ url('/handover') }}" target="_blank" rel="noopener noreferrer">{{ url('/handover') }}</a> — anyone with the link can read it; it is intended for your hotel team. The page is marked <strong>noindex</strong> so it is not meant to appear in search results.</p>

        <h2>2. What this website does (public site)</h2>
        <p>The site is your <strong>marketing and discovery</strong> presence: it showcases the hotel (rooms, dining, facilities, meetings &amp; events, tours, activities, updates, gallery), provides contact options, and directs guests to <strong>book</strong> and <strong>review</strong> through established channels (e.g. Booking.com, WhatsApp, TripAdvisor, Google). It works <strong>alongside</strong> your operations and OTAs — it does not replace a channel manager.</p>

        <h3>Main public pages</h3>
        <div class="table-responsive">
            <table class="table table-bordered align-middle bg-white">
                <thead class="table-light">
                    <tr>
                        <th scope="col">Area</th>
                        <th scope="col">URL path</th>
                        <th scope="col">Purpose</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Home</td>
                        <td><code>/</code></td>
                        <td>First impression, slideshow, highlights.</td>
                    </tr>
                    <tr>
                        <td>About us</td>
                        <td><code>/about-us</code></td>
                        <td>Story and background content.</td>
                    </tr>
                    <tr>
                        <td>Our services</td>
                        <td><code>/our-services</code></td>
                        <td>Services overview.</td>
                    </tr>
                    <tr>
                        <td>Rooms &amp; apartments</td>
                        <td><code>/our-rooms</code>, <code>/our-apartments</code>, <code>/our-rooms/{slug}</code></td>
                        <td>Room types, detail pages, booking CTAs to external channels.</td>
                    </tr>
                    <tr>
                        <td>Dining</td>
                        <td><code>/dining</code></td>
                        <td>Restaurant &amp; bar content.</td>
                    </tr>
                    <tr>
                        <td>Facilities</td>
                        <td><code>/facilities</code>, <code>/facilities/{slug}</code></td>
                        <td>Hotel facilities and detail pages.</td>
                    </tr>
                    <tr>
                        <td>Tours &amp; activities</td>
                        <td><code>/tours</code>, <code>/tour/{slug}</code>, <code>/activities</code>, <code>/activities/{slug}</code></td>
                        <td>Experiences and local activities.</td>
                    </tr>
                    <tr>
                        <td>Meetings &amp; events</td>
                        <td><code>/meetings-events</code>, <code>/meetings-events/{slug}</code></td>
                        <td>Events overview and individual meeting spaces.</td>
                    </tr>
                    <tr>
                        <td>SPA &amp; wellness</td>
                        <td><code>/spa-wellness</code></td>
                        <td>Wellness content (if enabled in navigation).</td>
                    </tr>
                    <tr>
                        <td>Guesthouse / apartment landing</td>
                        <td><code>/guesthouse</code>, <code>/apartment</code></td>
                        <td>Targeted landing content where used.</td>
                    </tr>
                    <tr>
                        <td>Promotions</td>
                        <td><code>/promotions</code></td>
                        <td>Offers or campaigns.</td>
                    </tr>
                    <tr>
                        <td>Our updates (articles)</td>
                        <td><code>/our-updates</code>, <code>/our-updates/{slug}</code></td>
                        <td>News-style posts.</td>
                    </tr>
                    <tr>
                        <td>Gallery</td>
                        <td><code>/gallery</code></td>
                        <td>Image gallery.</td>
                    </tr>
                    <tr>
                        <td>Contact</td>
                        <td><code>/contact</code></td>
                        <td>Contact details and enquiry behaviour as configured.</td>
                    </tr>
                    <tr>
                        <td>Book now</td>
                        <td><code>/book-now</code></td>
                        <td>Booking.com, WhatsApp, email — no on-site payment form.</td>
                    </tr>
                    <tr>
                        <td>Reviews</td>
                        <td><code>/reviews</code></td>
                        <td>Summary plus links to TripAdvisor, Google, Booking.com context — not an on-site review form.</td>
                    </tr>
                    <tr>
                        <td>Terms &amp; conditions</td>
                        <td><code>/terms-and-conditions</code></td>
                        <td>Legal text, maintained from admin where applicable.</td>
                    </tr>
                </tbody>
            </table>
        </div>
        <p class="small text-muted mb-0"><strong>Guest accounts:</strong> Travellers who register as guests use <code>/account</code> (dashboard, bookings, profile) after signing in — this is separate from staff content-management access.</p>

        <h2>3. Access &amp; sign-in</h2>

        <h3>3.1 Roles</h3>
        <p>Editing website content requires an account with the <strong>Super Admin</strong> or <strong>Content Manager</strong> role (or equivalent approved for your project). Public self-registration does <strong>not</strong> grant access to the content-management screens.</p>

        <h3>3.2 Requesting access</h3>
        <ol>
            <li class="mb-2">Coordinate with <strong>KURRE Consultancy</strong> through the <strong>same communication channel used during this project</strong>, and provide the <strong>name and email</strong> of each person who should manage the site.</li>
            <li class="mb-2">That person may register a basic account at <a href="{{ url('/register') }}" target="_blank" rel="noopener noreferrer">{{ url('/register') }}</a> (or start from <a href="{{ url('/login') }}" target="_blank" rel="noopener noreferrer">{{ url('/login') }}</a> and use Register). Use the email that should receive admin access.</li>
            <li class="mb-2"><strong>KURRE Consultancy</strong> (or your Super Admin) assigns the correct role. Until then, content-management areas will not be available.</li>
        </ol>

        <h3>3.3 Where to sign in (single login for staff)</h3>
        <p>Staff use <strong>one</strong> login URL for the whole application:</p>
        <ul>
            <li class="mb-2"><strong>Sign in:</strong> <a href="{{ url('/login') }}" target="_blank" rel="noopener noreferrer">{{ url('/login') }}</a></li>
        </ul>
        <p>After a successful login, <strong>Super Admins</strong> and <strong>Content Managers</strong> are taken to the <strong>content-management dashboard</strong>:</p>
        <ul>
            <li class="mb-0"><a href="{{ url('/content-management/dashboard') }}" target="_blank" rel="noopener noreferrer">{{ url('/content-management/dashboard') }}</a></li>
        </ul>
        <p class="small text-muted mt-2 mb-0">Do not rely on any other “admin login” URL — your workflow is <strong>/login</strong> → dashboard and sidebar as described below.</p>

        <h2>4. Managing content — content-management &amp; related tools</h2>
        <p>Day-to-day editing is centred on <strong>Content management</strong> (sidebar after you open the dashboard). Some tools open related screens (e.g. Settings, dining, meetings) that use the same staff login.</p>

        <h3>4.1 Sidebar (typical items)</h3>
        <p>From <code>/content-management/dashboard</code>, the left menu commonly includes:</p>
        <ul>
            <li class="mb-1"><strong>Dashboard</strong> — overview and quick actions.</li>
            <li class="mb-1"><strong>Reservations</strong> — view/reply to reservation-related items where used.</li>
            <li class="mb-1"><strong>Rooms</strong> — room types, photos, prices, status.</li>
            <li class="mb-1"><strong>Facilities</strong> — facility pages and images.</li>
            <li class="mb-1"><strong>Dining page</strong> — restaurant / bar content (opens the dining editor).</li>
            <li class="mb-1"><strong>Meetings</strong> — meetings &amp; events / meeting-room content (opens the meetings editor).</li>
            <li class="mb-1"><strong>Amenities</strong> — amenity lists used across the site.</li>
            <li class="mb-1"><strong>Activities</strong> — tour &amp; activity content.</li>
            <li class="mb-1"><strong>Attractions</strong> — nearby points of interest.</li>
            <li class="mb-1"><strong>Gallery</strong> — gallery images.</li>
            <li class="mb-1"><strong>Slideshow</strong> — home (and related) carousel slides.</li>
            <li class="mb-1"><strong>Page heroes</strong> — hero banners for major sections.</li>
            <li class="mb-1"><strong>System Users</strong> — <em>Super Admin only</em> — user accounts.</li>
            <li class="mb-1"><strong>Settings</strong> — opens the full settings area (logo, contacts, booking &amp; review links, about text, keywords, etc.).</li>
        </ul>
        <p>The dashboard also offers <strong>quick actions</strong> (e.g. rooms, services, facilities, amenities). <strong>Services</strong> live under <code>/content-management/services</code> even if not every item appears in the short sidebar list.</p>
        <p>Additional CMS screens reachable when logged in include (paths under <code>/content-management/</code>): <strong>About</strong> (<code>…/about</code>), <strong>Contacts</strong> (<code>…/contacts</code>), <strong>Terms &amp; conditions</strong> (<code>…/terms-conditions</code>), and <strong>SEO data</strong> (<code>…/seo-data</code>) — use these for structured page content and SEO where your role allows.</p>

        <h3>4.2 Settings (critical)</h3>
        <p>Open <strong>Settings</strong> from the sidebar — this loads the settings area (e.g. <code>{{ url('/setting') }}</code>). Tabs include:</p>
        <ul>
            <li class="mb-2"><strong>Contacts &amp; logo</strong> — company name, logo, phones, email, address, map embed, social links, footer “delivered by” line (where enabled).</li>
            <li class="mb-2"><strong>Booking &amp; review links</strong> — Booking.com URL, TripAdvisor and Google links, WhatsApp, contact email for CTAs, optional <strong>display scores / review counts</strong> for the Reviews page.</li>
            <li class="mb-2"><strong>About Hotel</strong> — long-form story and images.</li>
            <li class="mb-2"><strong>Header keywords</strong> — SEO keywords where used in the layout.</li>
        </ul>
        <p>Always save and verify on the public site (preferably in a private/incognito window).</p>

        <h3>4.3 Updates (articles) &amp; messages (legacy admin screens)</h3>
        <p>Depending on your workflow, article-style <strong>Our updates</strong> posts may still be maintained from the legacy blog list (e.g. <code>{{ url('/getBlogs') }}</code> when logged in with the same staff account). Contact-form <strong>enquiries</strong> may appear under <code>{{ url('/getMessages') }}</code> (or equivalent) for staff who handle messages. If you cannot see an item, confirm your role with KURRE Consultancy.</p>

        <h3>4.4 Tips</h3>
        <ul>
            <li class="mb-2">Keep <strong>Booking.com</strong> and <strong>review</strong> URLs in Settings accurate — they power primary Book and Reviews behaviour.</li>
            <li class="mb-2">Optimise large images before upload where possible.</li>
            <li class="mb-0">If changes do not show, try an incognito/private window to avoid cache.</li>
        </ul>

        <h2>5. Why external booking and review links</h2>
        <p>The site points guests to <strong>Booking.com</strong>, <strong>WhatsApp</strong>, <strong>email</strong>, <strong>TripAdvisor</strong>, and <strong>Google</strong> rather than hosting full booking or anonymous on-site reviews. That matches how travellers book and trust feedback, and avoids fake/spam review boxes.</p>
        <ul>
            <li class="mb-2"><strong>Booking:</strong> OTAs handle availability, confirmations, and payments in systems guests already trust.</li>
            <li class="mb-2"><strong>Reviews:</strong> Established platforms improve credibility and discovery.</li>
            <li class="mb-0"><strong>Your site:</strong> Presents the brand, answers via phone/WhatsApp/email, and sends ready guests to the right place to book and review.</li>
        </ul>

        <h2>6. Thank you</h2>
        <p>We are grateful to <strong>Bethel Hotel</strong> for trusting <strong>KURRE Consultancy</strong> with this project. We hope this website serves you and your guests well. If you need adjustments or a walkthrough, reach out through the <strong>same project channel used with KURRE Consultancy</strong> — including optional training if needed.</p>

        <hr class="my-4">
        <p class="small text-muted mb-0">This document is part of your project handover. Save or print it from your browser for your internal records.</p>
    </div>
</div>
@endsection
