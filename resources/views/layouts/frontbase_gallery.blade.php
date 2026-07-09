<!doctype html>
<html lang="en">
<head>
    @php
    $data = App\Models\Setting::first();
    @endphp
    <base href="/public">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>{{ $data?->company ?? '' }}</title>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- Use Minified Plugins Version For Fast Page Load -->
        <link rel="stylesheet" type="text/css" media="screen" href="css/plugins.css" />
        <link rel="stylesheet" type="text/css" media="screen" href="css/main.css" />
        <link rel="shortcut icon" type="image/x-icon" href="image/favicon.ico">


        {{-- Gallery assests --}}
        <link href='assets/plugins/fontawesome-5.15.2/css/all.min.css' rel='stylesheet'>
        <link href='assets/plugins/fontawesome-5.15.2/css/fontawesome.min.css' rel='stylesheet'>
        <link href='assets/plugins/animate/animate.css' rel='stylesheet'>

        <link href='assets/plugins/fancybox/jquery.fancybox.min.css' rel='stylesheet'>
        <link href='assets/plugins/isotope/isotope.min.css' rel='stylesheet'>


        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Dosis:300,400,600,700|Open+Sans:300,400,600,700" rel="stylesheet">

        <!-- Custom css -->
        <link href="assets/css/kidz.css" id="option_style" rel="stylesheet">

        <!-- Favicon -->
        <link href="assets/img/favicon.png" rel="shortcut icon">


    </head>
    
    <body>



<div class="container-fluid">
    {{-- @show --}}
    @yield('content')
</div>


    <!--=================================
    Footer Area
    ===================================== -->
    <footer class="site-footer" style="background-color: rgb(56, 54, 54); color:#fff">
        <div class="container">
            <div class="row justify-content-between  section-padding">
                <div class=" col-xl-4 col-lg-4 col-sm-6">
                    <div class="single-footer pb-10">
                        <div class="brand-footer footer-title mt-3">
                            <img src="{{ asset('storage/images') . ($data?->logo ?? '') }} " alt="" height="200px">
                        </div>
                        <div class="footer-contact">
                            <p><span class="label" style="color:#fff">Address:</span><span class="text"><a href="https://maps.app.goo.gl/7Ysg5n8ZjhYsdkVN7" target="_blank">{{ $data?->address ?? ''  }}</a>
                                    </span></p>
                            <p><span class="label" style="color:#fff">Phone:</span><span class="text"><a href="tel: {{ $data?->phone ?? '' }}">{{ $data?->phone ?? '' }}</a></span></p>
                            <p><span class="label" style="color:#fff">Email:</span><span class="text"><a href="mailto: {{ $data?->email ?? '' }}">{{ $data?->email ?? '' }}</a></span></p>
                        </div>
                    </div>
                </div>
                <div class=" col-xl-4 col-lg-4 col-sm-6">
                    <div class="single-footer pb--40">
                        <div class="container" style="max-width: 600px; margin: 0 auto; padding: 20px; text-align: center;">
                            <h1 style="font-size: 24px; margin-bottom: 20px;">Weekly Working Hours</h1>
                            <table style="width: 100%; border-collapse: collapse;">
                                <thead>
                                    <tr>
                                        <th style="background-color: #333; color: #fff; padding: 10px;">Day</th>
                                        <th style="background-color: #333; color: #fff; padding: 10px;">Working Hours</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td style="padding: 10px;">Monday</td>
                                        <td style="padding: 10px;">9:00 AM - 5:00 PM</td>
                                    </tr>
                                    <tr>
                                        <td style="padding: 10px;">Tuesday</td>
                                        <td style="padding: 10px;">9:00 AM - 5:00 PM</td>
                                    </tr>
                                    <tr>
                                        <td style="padding: 10px;">Wednesday</td>
                                        <td style="padding: 10px;">9:00 AM - 5:00 PM</td>
                                    </tr>
                                    <tr>
                                        <td style="padding: 10px;">Thursday</td>
                                        <td style="padding: 10px;">9:00 AM - 5:00 PM</td>
                                    </tr>
                                    <tr>
                                        <td style="padding: 10px;">Friday</td>
                                        <td style="padding: 10px;">9:00 AM - 5:00 PM</td>
                                    </tr>
                                    <tr>
                                        <td style="padding: 10px;">Saturday</td>
                                        <td style="padding: 10px;">10:00 AM - 4:00 PM</td>
                                    </tr>
                                    <tr>
                                        <td style="padding: 10px;">Sunday</td>
                                        <td style="padding: 10px; color: red;">Closed</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class=" col-xl-4 col-lg-4 col-sm-6">
                    <div class="footer-title">
                        <h3>Newsletter Subscribe</h3>
                    </div>
                    <div class="newsletter-form mb--30">
                        @php
                            $hc = \App\Support\HotelChannels::all();
                            $wad = preg_replace('/\D+/', '', (string) ($hc['whatsapp_e164'] ?? ''));
                            $wau = $wad !== '' ? 'https://wa.me/'.$wad.'?text='.rawurlencode('Hello Bethel Hotel') : '#';
                            $em = $hc['public_email'] ?? '';
                        @endphp
                        <p class="small mb-2">Contact us on WhatsApp or email — no newsletter form.</p>
                        <a href="{{ $wau }}" class="btn btn--primary w-100 mb-2" target="_blank" rel="noopener noreferrer">WhatsApp</a>
                        <a href="mailto:{{ $em }}" class="btn btn-outline-primary w-100">{{ $em }}</a>
                    </div>
                    <div class="social-block">
                        <h3 class="title">STAY CONNECTED</h3>
                        <ul class="social-list list-inline">
                            <li class="single-social facebook"><a href="{{ $data?->facebook }}" target="_blank"><i class="ion ion-social-facebook"></i></a>
                            </li>
                            <li class="single-social twitter"><a href="{{ $data?->twitter }}" target="_blank"><i class="ion ion-social-twitter"></i></a></li>
                            <li class="single-social youtube"><a href="{{ $data?->youtube }}" target="_blank"><i class="ion ion-social-youtube"></i></a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="footer-bottom">
            <div class="container">
                {{-- <a href="#" class="payment-block">
                    <img src="image/icon/payment.png" alt="">
                </a> --}}
                <p class="copyright-text">© <script>document.write(new Date().getFullYear()) </script>, All Right Reserved. <a href="https://iremetech.com" class="author">Delivered By Iremetechnologies</a>.
                    </p>
            </div>
        </div>
    </footer>
    <!-- Use Minified Plugins Version For Fast Page Load -->
    <script src="js/plugins.js"></script>
    <script src="js/ajax-mail.js"></script>
    <script src="js/custom.js"></script>

    {{-- Gallery Scripts --}}

    <script src='assets/plugins/jquery/jquery.min.js'></script>
    <script src='assets/plugins/bootstrap/js/bootstrap.bundle.min.js'></script>

    <script src='assets/plugins/fancybox/jquery.fancybox.min.js'></script>
    <script src='assets/plugins/isotope/isotope.min.js'></script>
    <script src='assets/plugins/images-loaded/js/imagesloaded.pkgd.min.js'></script>

    <script src='assets/plugins/lazyestload/lazyestload.js'></script>
    <script src='assets/plugins/velocity/velocity.min.js'></script>
    <script src='assets/plugins/smoothscroll/SmoothScroll.js'></script>

    <script type="text/javascript">
        (function () {
            var options = {
                whatsapp: "+250788300787", // WhatsApp number
                call_to_action: "Message us", // Call to action
                position: "right", // Position may be 'right' or 'left'
            };
            var proto = document.location.protocol, host = "getbutton.io", url = proto + "//static." + host;
            var s = document.createElement('script'); s.type = 'text/javascript'; s.async = true; s.src = url + '/widget-send-button/js/init.js';
            s.onload = function () { WhWidgetSendButton.init(host, proto, options); };
            var x = document.getElementsByTagName('script')[0]; x.parentNode.insertBefore(s, x);
        })();
    </script>
</body>

</html>