<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Images Gallery</title>
        <link href="https://cdn.jsdelivr.net/npm/simple-datatables@latest/dist/style.css" rel="stylesheet" />
        <link href="{{asset('assets')}}/admin/css/styles.css" rel="stylesheet" />
        <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/js/all.min.js" crossorigin="anonymous"></script>

        {{-- summernote --}}
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" >
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.3/font/bootstrap-icons.css">

        <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.css" rel="stylesheet">

        @yield('head')
    </head>
    <body class="sb-nav-fixed">



    <div class="container-fluid">
        {{-- @show --}}
        @yield('content')
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <script src="{{asset('assets')}}/admin/js/scripts.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
    <script src="{{asset('assets')}}/admin/assets/demo/chart-area-demo.js"></script>
    <script src="{{asset('assets')}}/admin/assets/demo/chart-bar-demo.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/simple-datatables@latest" crossorigin="anonymous"></script>
    <script src="{{asset('assets')}}/admin/js/datatables-simple-demo.js"></script>

    {{-- summernote --}}
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.js"></script>

    <script src="{{asset('assets')}}/js/summernote.js"></script>

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
            var backdrop = document.querySelector('.modal-backdrop');
            if (backdrop) backdrop.remove();
        }

        document.addEventListener('click', function(e) {
            var trigger = e.target.closest(
                '[data-bs-dismiss="modal"], [data-dismiss="modal"], .modal .btn-close, .modal .close'
            );
            if (!trigger) return;
            var modalEl = trigger.closest ? trigger.closest('.modal') : null;
            if (!modalEl) return;
            forceCloseModal(modalEl);
        });
    })();
    </script>

    @yield('scripts')


</body>
</html>
