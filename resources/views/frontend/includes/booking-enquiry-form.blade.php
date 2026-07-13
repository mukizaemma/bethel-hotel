@props([
    'rooms' => null,
    'setting' => null,
    'formId' => 'booking-enquiry-form',
    'formAction' => null,
    'defaultEnquiryType' => null,
])

@php
    $formAction = $formAction ?? route('contact.enquiry');
    $setting = $setting ?? \App\Models\Setting::first();
    $rooms = collect($rooms ?? []);
    if ($rooms->isEmpty()) {
        $rooms = \App\Models\Room::where('status', 'Active')->latest()->get();
    }
    $hasRooms = $rooms->isNotEmpty();
    $enquiryTypes = [
        'general' => 'General enquiry',
        'room' => 'Book a Room',
        'meetings' => 'Workshop / meeting',
        'dining' => 'Restaurant / dining',
    ];
    $selectedType = old('enquiry_type', $defaultEnquiryType ?? 'general');
    if (! array_key_exists($selectedType, $enquiryTypes) || ($selectedType === 'room' && ! $hasRooms)) {
        $selectedType = 'general';
    }
@endphp

<form
    id="{{ $formId }}"
    class="bethel-enquiry-form"
    method="POST"
    action="{{ $formAction }}"
    novalidate
    data-bethel-enquiry-form
>
    @csrf

    @if($errors->any())
    <div class="home-cta__alert home-cta__alert--error bethel-enquiry-form__alert" role="alert">
        <ul class="home-cta__alert-list mb-0">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <div class="row g-3">
        <div class="col-12">
            <label class="home-cta__label" for="{{ $formId }}-enquiry-type">
                What would you like to enquire about? <span class="home-cta__req">*</span>
            </label>
            <select
                class="home-cta__input home-cta__input--select bethel-enquiry-form__type-select"
                id="{{ $formId }}-enquiry-type"
                name="enquiry_type"
                required
                data-enquiry-type-select
            >
                @foreach($enquiryTypes as $value => $label)
                    @if($value !== 'room' || $hasRooms)
                        <option value="{{ $value }}" @selected($selectedType === $value)>{{ $label }}</option>
                    @endif
                @endforeach
            </select>
        </div>

        <div class="col-md-6">
            <label class="home-cta__label" for="{{ $formId }}-names">Full name <span class="home-cta__req">*</span></label>
            <input type="text" class="home-cta__input" id="{{ $formId }}-names" name="names" value="{{ old('names') }}" required autocomplete="name">
        </div>
        <div class="col-md-6">
            <label class="home-cta__label" for="{{ $formId }}-phone">Phone <span class="home-cta__req">*</span></label>
            <input type="tel" class="home-cta__input" id="{{ $formId }}-phone" name="phone" value="{{ old('phone') }}" required autocomplete="tel">
        </div>

        <div class="col-md-6">
            <label class="home-cta__label" for="{{ $formId }}-email">Email <span class="home-cta__req">*</span></label>
            <input type="email" class="home-cta__input" id="{{ $formId }}-email" name="email" value="{{ old('email') }}" required autocomplete="email">
        </div>
        <div class="col-md-6">
            <label class="home-cta__label" for="{{ $formId }}-subject" data-subject-label>
                Subject <span class="home-cta__req" data-subject-required>*</span>
                <span class="home-cta__label-opt" data-subject-optional hidden>(optional)</span>
            </label>
            <input
                type="text"
                class="home-cta__input"
                id="{{ $formId }}-subject"
                name="subject"
                value="{{ old('subject') }}"
                data-subject-input
                placeholder="Brief summary of your request"
            >
        </div>

        <div class="col-md-6" data-enquiry-panel="room" @if($selectedType !== 'room') hidden @endif>
            <label class="home-cta__label" for="{{ $formId }}-checkin">Check-in <span class="home-cta__req">*</span></label>
            <input type="date" class="home-cta__input" id="{{ $formId }}-checkin" name="checkin_date" value="{{ old('checkin_date') }}" data-room-required min="{{ date('Y-m-d') }}">
        </div>
        <div class="col-md-6" data-enquiry-panel="room" @if($selectedType !== 'room') hidden @endif>
            <label class="home-cta__label" for="{{ $formId }}-checkout">Check-out <span class="home-cta__req">*</span></label>
            <input type="date" class="home-cta__input" id="{{ $formId }}-checkout" name="checkout_date" value="{{ old('checkout_date') }}" data-room-required min="{{ date('Y-m-d', strtotime('+1 day')) }}">
        </div>
        <div class="col-md-6" data-enquiry-panel="room" @if($selectedType !== 'room') hidden @endif>
            <label class="home-cta__label" for="{{ $formId }}-adults">Number of guests <span class="home-cta__req">*</span></label>
            <input type="number" class="home-cta__input" id="{{ $formId }}-adults" name="adults" value="{{ old('adults', 1) }}" min="1" max="20" data-room-required>
        </div>
        <div class="col-md-6" data-enquiry-panel="room" @if($selectedType !== 'room') hidden @endif>
            <label class="home-cta__label" for="{{ $formId }}-children">Children <span class="home-cta__label-opt">(optional)</span></label>
            <input type="number" class="home-cta__input" id="{{ $formId }}-children" name="children" value="{{ old('children', 0) }}" min="0" max="20">
        </div>

        <div class="col-12" data-enquiry-panel="room" @if($selectedType !== 'room') hidden @endif>
            <label class="home-cta__label" for="{{ $formId }}-room">Select a room <span class="home-cta__req">*</span></label>
            <select class="home-cta__input home-cta__input--select" id="{{ $formId }}-room" name="room_id" data-room-required>
                <option value="" disabled @selected(! old('room_id'))>Choose a room and nightly rate</option>
                @foreach($rooms as $room)
                    <option value="{{ $room->id }}" @selected((int) old('room_id') === (int) $room->id)>
                        {{ $room->title }} — {{ hotel_price($room->price ?? 0, $setting) }} / night
                    </option>
                @endforeach
            </select>
        </div>

        <div class="col-md-6" data-enquiry-panel="meetings" @if($selectedType !== 'meetings') hidden @endif>
            <label class="home-cta__label" for="{{ $formId }}-meeting-date">Preferred date <span class="home-cta__req">*</span></label>
            <input type="date" class="home-cta__input" id="{{ $formId }}-meeting-date" name="preferred_date" value="{{ old('preferred_date') }}" data-meetings-required min="{{ date('Y-m-d') }}">
        </div>
        <div class="col-md-6" data-enquiry-panel="meetings" @if($selectedType !== 'meetings') hidden @endif>
            <label class="home-cta__label" for="{{ $formId }}-meeting-guests">Expected guests <span class="home-cta__req">*</span></label>
            <input type="number" class="home-cta__input" id="{{ $formId }}-meeting-guests" name="expected_guests" value="{{ old('expected_guests') }}" min="1" max="500" data-meetings-required>
        </div>
        <div class="col-md-6" data-enquiry-panel="meetings" @if($selectedType !== 'meetings') hidden @endif>
            <label class="home-cta__label" for="{{ $formId }}-meeting-days">Number of days <span class="home-cta__req">*</span></label>
            <input type="number" class="home-cta__input" id="{{ $formId }}-meeting-days" name="number_of_days" value="{{ old('number_of_days', 1) }}" min="1" max="365" data-meetings-required>
        </div>
        <div class="col-md-6" data-enquiry-panel="meetings" @if($selectedType !== 'meetings') hidden @endif>
            <label class="home-cta__label" for="{{ $formId }}-event-type">Event type <span class="home-cta__label-opt">(optional)</span></label>
            <input type="text" class="home-cta__input" id="{{ $formId }}-event-type" name="event_type" value="{{ old('event_type') }}" placeholder="Workshop, conference, training…">
        </div>

        <div class="col-md-6" data-enquiry-panel="dining" @if($selectedType !== 'dining') hidden @endif>
            <label class="home-cta__label" for="{{ $formId }}-dining-date">Preferred date <span class="home-cta__req">*</span></label>
            <input type="date" class="home-cta__input" id="{{ $formId }}-dining-date" name="preferred_date" value="{{ old('preferred_date') }}" data-dining-required min="{{ date('Y-m-d') }}">
        </div>
        <div class="col-md-6" data-enquiry-panel="dining" @if($selectedType !== 'dining') hidden @endif>
            <label class="home-cta__label" for="{{ $formId }}-party-size">Party size <span class="home-cta__req">*</span></label>
            <input type="number" class="home-cta__input" id="{{ $formId }}-party-size" name="party_size" value="{{ old('party_size') }}" min="1" max="500" data-dining-required>
        </div>

        <div class="col-12">
            <label class="home-cta__label" for="{{ $formId }}-message">
                Message
                <span class="home-cta__req" data-message-required>*</span>
                <span class="home-cta__label-opt" data-message-optional hidden>(optional)</span>
            </label>
            <textarea
                class="home-cta__input home-cta__input--textarea"
                id="{{ $formId }}-message"
                name="message"
                rows="4"
                data-message-input
                placeholder="Tell us about your dates, group size, or special requirements…"
            >{{ old('message') }}</textarea>
        </div>

        <div class="col-12">
            <button type="submit" class="theme-btn btn-style fill home-cta__submit bethel-enquiry-form__submit w-100" data-enquiry-submit>
                <i class="fa-solid fa-paper-plane home-cta__submit-icon" aria-hidden="true" data-enquiry-submit-icon></i>
                <span data-enquiry-submit-label>Send enquiry</span>
            </button>
            <p class="home-cta__form-note bethel-enquiry-form__note mb-0" data-enquiry-note>
                We reply within one business day. Your details are only used to respond to this request.
            </p>
        </div>
    </div>
</form>

@once
@push('scripts')
<script>
(function () {
    function setRequired(fields, required) {
        fields.forEach(function (field) {
            if (required) {
                field.setAttribute('required', 'required');
            } else {
                field.removeAttribute('required');
            }
        });
    }

    function initBethelEnquiryForm(form) {
        if (!form || form.dataset.bethelEnquiryReady === '1') {
            return;
        }
        form.dataset.bethelEnquiryReady = '1';

        var typeSelect = form.querySelector('[data-enquiry-type-select]');
        if (!typeSelect) {
            return;
        }

        var panels = form.querySelectorAll('[data-enquiry-panel]');
        var subjectInput = form.querySelector('[data-subject-input]');
        var subjectRequired = form.querySelector('[data-subject-required]');
        var subjectOptional = form.querySelector('[data-subject-optional]');
        var messageInput = form.querySelector('[data-message-input]');
        var messageRequired = form.querySelector('[data-message-required]');
        var messageOptional = form.querySelector('[data-message-optional]');
        var roomFields = form.querySelectorAll('[data-room-required]');
        var meetingFields = form.querySelectorAll('[data-meetings-required]');
        var diningFields = form.querySelectorAll('[data-dining-required]');
        var submitLabel = form.querySelector('[data-enquiry-submit-label]');
        var submitIcon = form.querySelector('[data-enquiry-submit-icon]');
        var formNote = form.querySelector('[data-enquiry-note]');
        var checkinInput = form.querySelector('#' + form.id + '-checkin');
        var checkoutInput = form.querySelector('#' + form.id + '-checkout');

        function syncCheckoutMin() {
            if (!checkinInput || !checkoutInput) {
                return;
            }
            var checkinValue = checkinInput.value;
            if (!checkinValue) {
                return;
            }
            var nextDay = new Date(checkinValue + 'T00:00:00');
            nextDay.setDate(nextDay.getDate() + 1);
            var minCheckout = nextDay.toISOString().slice(0, 10);
            checkoutInput.min = minCheckout;
            if (checkoutInput.value && checkoutInput.value <= checkinValue) {
                checkoutInput.value = minCheckout;
            }
        }

        function syncForm() {
            var type = typeSelect.value;

            panels.forEach(function (panel) {
                var isActive = panel.getAttribute('data-enquiry-panel') === type;
                panel.hidden = !isActive;
                panel.querySelectorAll('input, select, textarea').forEach(function (field) {
                    field.disabled = !isActive;
                });
            });

            setRequired(roomFields, type === 'room');
            setRequired(meetingFields, type === 'meetings');
            setRequired(diningFields, type === 'dining');

            var subjectIsRequired = type === 'general' || type === 'meetings' || type === 'dining';
            if (subjectInput) {
                if (subjectIsRequired) {
                    subjectInput.setAttribute('required', 'required');
                    subjectInput.placeholder = 'Brief summary of your request';
                } else {
                    subjectInput.removeAttribute('required');
                    subjectInput.placeholder = 'Group name or reference (optional)';
                }
            }
            if (subjectRequired) {
                subjectRequired.hidden = !subjectIsRequired;
            }
            if (subjectOptional) {
                subjectOptional.hidden = subjectIsRequired;
            }

            var messageIsRequired = type === 'general' || type === 'meetings' || type === 'dining';
            if (messageInput) {
                if (messageIsRequired) {
                    messageInput.setAttribute('required', 'required');
                } else {
                    messageInput.removeAttribute('required');
                }
            }
            if (messageRequired) {
                messageRequired.hidden = !messageIsRequired;
            }
            if (messageOptional) {
                messageOptional.hidden = messageIsRequired;
            }

            if (submitLabel) {
                submitLabel.textContent = type === 'room' ? 'Book room' : 'Send enquiry';
            }
            if (submitIcon) {
                submitIcon.className = type === 'room'
                    ? 'fa-solid fa-bed home-cta__submit-icon'
                    : 'fa-solid fa-paper-plane home-cta__submit-icon';
            }
            if (formNote) {
                formNote.textContent = type === 'room'
                    ? 'Your booking request is pending confirmation. We will confirm availability shortly.'
                    : 'We reply within one business day. Your details are only used to respond to this request.';
            }

            if (type === 'room') {
                syncCheckoutMin();
            }
        }

        if (checkinInput) {
            checkinInput.addEventListener('change', syncCheckoutMin);
        }

        typeSelect.addEventListener('change', syncForm);
        syncForm();
    }

    function initAllBethelEnquiryForms() {
        document.querySelectorAll('[data-bethel-enquiry-form]').forEach(function (form) {
            delete form.dataset.bethelEnquiryReady;
            initBethelEnquiryForm(form);
        });
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initAllBethelEnquiryForms);
    } else {
        initAllBethelEnquiryForms();
    }

    document.addEventListener('livewire:navigated', initAllBethelEnquiryForms);
})();
</script>
@endpush
@endonce
