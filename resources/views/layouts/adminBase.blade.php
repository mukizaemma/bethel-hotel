
<!DOCTYPE html>
<html lang="en">
<base href="/">
<head>
    @php
    $data = App\Models\Setting::first();
    @endphp
    <meta charset="utf-8">
    <title>{{ $data?->company ?? '' }} - Admin</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta content="" name="keywords">
    <meta content="" name="description">

    <!-- Favicon -->
    <link href="admin/img/favicon.ico" rel="icon">

    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Heebo:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Icon Font Stylesheet -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Libraries Stylesheet -->
    <link href="admin/lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">
    <link href="admin/lib/tempusdominus/css/tempusdominus-bootstrap-4.min.css" rel="stylesheet" />

    {{-- summernote --}}
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.css" rel="stylesheet">

    <!-- Customized Bootstrap Stylesheet -->
    <link href="{{ asset('admin/css/bootstrap.min.css') }}" rel="stylesheet">
    <!-- Include Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">


    <!-- Template Stylesheet -->
    <link href="{{ asset('admin/css/style.css') }}" rel="stylesheet">
    {{-- <link rel="stylesheet" href="{{ asset('css/app.css') }}"> --}}

    @livewireStyles
</head>

<body>
    <div class="container-xxl position-relative bg-white d-flex p-0">
        <!-- Spinner Start -->
        <div id="spinner" class="show bg-white position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center">
            <div class="spinner-border text-primary" style="width: 3rem; height: 3rem;" role="status">
                <span class="sr-only">Loading...</span>
            </div>
        </div>
        <!-- Spinner End -->

    <div class="container-fluid">
        @isset($slot)
            {{ $slot }}
        @else
            @yield('content')
        @endisset
    </div>


        <!-- Back to Top -->
        <a href="#" class="btn btn-lg btn-primary btn-lg-square back-to-top"><i class="bi bi-arrow-up"></i></a>
    </div>

    <!-- JavaScript Libraries -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="admin/lib/chart/chart.min.js"></script>
    <script src="admin/lib/easing/easing.min.js"></script>
    <script src="admin/lib/waypoints/waypoints.min.js"></script>
    <script src="admin/lib/owlcarousel/owl.carousel.min.js"></script>
    <script src="admin/lib/tempusdominus/js/moment.min.js"></script>
    <script src="admin/lib/tempusdominus/js/moment-timezone.min.js"></script>
    <script src="admin/lib/tempusdominus/js/tempusdominus-bootstrap-4.min.js"></script>

    <!-- Template Javascript -->
    <script src="admin/js/main.js"></script>

            {{-- summernote --}}
    {{-- <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js"></script> --}}
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <script src="/admin/js/summernote.js"></script>
    @stack('scripts')

    {{-- System Users (content-management/users): inline scripts in Livewire slots do not run reliably after SPA navigation --}}
    <script src="{{ asset('admin/js/user-management-actions.js') }}"></script>

    {{-- Ensure admin modals can be closed via close button (BS4 loads last; close uses jQuery or BS5 API) --}}
    <script>
    (function() {
        function forceCloseModal(modalEl) {
            if (!modalEl) return;

            if (typeof bootstrap !== 'undefined' && bootstrap.Modal) {
                var bsInstance = bootstrap.Modal.getOrCreateInstance(modalEl);
                if (bsInstance) {
                    bsInstance.hide();
                    return;
                }
            }

            if (typeof jQuery !== 'undefined' && jQuery(modalEl).modal) {
                jQuery(modalEl).modal('hide');
                return;
            }

            modalEl.classList.remove('show');
            modalEl.style.display = 'none';
            modalEl.setAttribute('aria-hidden', 'true');
            document.body.classList.remove('modal-open');
            document.body.style.removeProperty('overflow');
            document.body.style.removeProperty('padding-right');
            var backdrops = document.querySelectorAll('.modal-backdrop');
            backdrops.forEach(function(b) { b.remove(); });
        }

        document.addEventListener('click', function(e) {
            var trigger = e.target.closest(
                '[data-bs-dismiss="modal"], [data-dismiss="modal"], .modal .btn-close, .modal .close'
            );
            if (!trigger) return;

            var modalEl = trigger.closest ? trigger.closest('.modal') : null;
            if (!modalEl) return;

            if (
                !trigger.hasAttribute('data-bs-dismiss')
                && !trigger.hasAttribute('data-dismiss')
                && !trigger.classList.contains('btn-close')
                && !trigger.classList.contains('close')
            ) {
                return;
            }

            forceCloseModal(modalEl);
        });
    })();
    </script>

    @livewireScriptConfig
    @livewireScripts
    <script>
        document.addEventListener('click', function (e) {
            var link = e.target.closest('a[href]');
            if (!link || link.target === '_blank' || link.hasAttribute('download')) return;
            if (link.closest('[data-no-spa-navigate]')) return;
            var href = link.getAttribute('href');
            if (!href || href.startsWith('#') || href.startsWith('javascript:')) return;
            if (href.startsWith('mailto:') || href.startsWith('tel:')) return;
            try {
                var url = new URL(link.href, window.location.origin);
                if (url.origin !== window.location.origin) return;
                if (url.pathname.startsWith('/livewire/')) return;
            } catch (err) {
                return;
            }
            if (typeof Livewire === 'undefined' || typeof Livewire.navigate !== 'function') return;
            e.preventDefault();
            Livewire.navigate(link.href);
        });
        document.addEventListener('livewire:navigated', function () {
            if (typeof jQuery !== 'undefined' && jQuery('#spinner').length) {
                setTimeout(function () {
                    jQuery('#spinner').removeClass('show');
                }, 1);
            }
        });
    </script>
</body>

</html>