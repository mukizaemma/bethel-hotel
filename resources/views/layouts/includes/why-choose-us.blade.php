{{-- Bethel Hotel: left-aligned header + 2-column horizontal feature list (no hover-reveal grid).
     Optional $whyChooseUsLayout: 'full' (default) | 'meetings' — single column beside proposal form. --}}
@if(isset($whyChooseUsItems) && $whyChooseUsItems->isNotEmpty())
@php
    $wcuLayout = $whyChooseUsLayout ?? 'full';
    $wcuIcons = [
        'fa-location-dot',
        'fa-chalkboard-user',
        'fa-bed',
        'fa-hands-praying',
        'fa-utensils',
        'fa-user-group',
        'fa-wifi',
        'fa-shield-heart',
    ];
@endphp

@if($wcuLayout === 'meetings')
<div class="site-why-choose-wrap site-why-choose-wrap--meetings">
@else
<div class="site-why-choose-wrap site-why-choose-wrap--full">
@endif
    <section
        class="site-why-choose site-why-choose--bethel {{ $wcuLayout === 'meetings' ? 'site-why-choose--meetings' : '' }} rts__section {{ $wcuLayout === 'meetings' ? 'py-4' : 'section__padding' }}"
        aria-labelledby="site-why-choose-heading"
    >
        <div class="{{ $wcuLayout === 'meetings' ? 'w-100' : 'container' }}">
            <header class="site-why-choose__header {{ $wcuLayout === 'meetings' ? 'site-why-choose__header--meetings' : '' }}">
                <p class="site-why-choose__eyebrow">Why stay with us</p>
                <h2 id="site-why-choose-heading" class="site-why-choose__heading section__title">Why Choose Us</h2>
                <p class="site-why-choose__lead font-sm">
                    Practical reasons guests and event organisers pick Bethel Hotel in Rubengera.
                </p>
            </header>

            <div class="site-why-choose__grid" role="list">
                @foreach($whyChooseUsItems as $item)
                <article
                    class="site-why-choose__item {{ $loop->even ? 'site-why-choose__item--even' : 'site-why-choose__item--odd' }}"
                    role="listitem"
                >
                    <span class="site-why-choose__index" aria-hidden="true">{{ str_pad((string) $loop->iteration, 2, '0', STR_PAD_LEFT) }}</span>
                    <div class="site-why-choose__icon" aria-hidden="true">
                        <i class="fa-solid {{ $wcuIcons[$loop->index % count($wcuIcons)] }}"></i>
                    </div>
                    <div class="site-why-choose__body">
                        <h3 class="site-why-choose__title">{{ $item->title }}</h3>
                        @if(filled($item->description))
                            <p class="site-why-choose__text">{!! nl2br(e($item->description)) !!}</p>
                        @endif
                    </div>
                </article>
                @endforeach
            </div>
        </div>
    </section>
</div>
@endif
