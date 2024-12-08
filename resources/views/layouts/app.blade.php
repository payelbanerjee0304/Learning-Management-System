<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    {{-- <title>{{ env('APP_NAME') }}</title> --}}
    <title>Project</title>
    <meta name="description" content="" />
    <meta name="author" content="admin" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="shortcut icon" href="images/favicon.ico" alt="" />
    <!-- <link rel="stylesheet" href="{{ asset('css/font-awesome.css') }}" /> -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css"
        integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/css/bootstrap-select.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.1/css/all.min.css">
    <link
        href="https://fonts.googleapis.com/css2?family=Noto+Sans:ital,wght@0,100..900;1,100..900&family=Nunito+Sans:ital,opsz,wght@0,6..12,200..1000;1,6..12,200..1000&display=swap"
        rel="stylesheet">

    <link rel="stylesheet" href="{{ asset('css/aos.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/jquery.fancybox.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/easy-responsive-tabs.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/swiper.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/custom.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/responsive.css') }}" />
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Popper.js and Bootstrap JS (necessary for dropdowns) -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js"></script>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js"></script>
</head>
<!--Header End-->

<body>
    <main>
      <section class="total_parent_element dash1">
        @include('layouts.sidebar')
        <div class="right_parent_element">
          <div class="outr_parent_nav dashb">
            <div class="lft_p_nav">
              <div class="sidebar">
                <img src="{{asset('images/mnu_icn.png')}}" alt="menu_icon" />
              </div>
              <a href="javascript:void(0);">
                <div class="top_logo">
                  {{-- <img src="{{asset('images/mob_logo.png')}}" alt="mob_logo" /> --}}
                </div>
              </a>
              <h6>Project</h6>
              <div class="all_r_btn use">
                <a href="javascript:void(0)">
                  <span class="user_icn">
                    <i class="fa-regular fa-user"></i> </span></a>
              </div>
            </div>
            <div class="rgt_p_nav prfl">
              <div class="all_r_btn">
                <a href="javascript:void(0)">
                  <span class="user_icn">
                    <i class="fa-regular fa-user"></i> </span></a>
                <a href="javascript:void(0)">
                  <span class="mail_icn">
                    <i class="fa-regular fa-envelope"></i>
                  </span>
                </a>
                <a href="javascript:void(0)">
                  <span class="notifi_icn">
                    <i class="fa-regular fa-bell"></i>
                  </span>
                </a>
              </div>
            </div>
          </div>
          <div class="outr-right-content jst_event">
            @yield('content')
          </div>
          {{-- <div class="mob_ftr">
            <div class="ftr_lnks">
              <div class="ftr_lnk">
                <a href="#" class="nav-link">
                  <div class="icon_box">
                    <!-- <img src="{{asset('images/s_i1.png')}}" alt="nav_icon1" /> -->
                     <span><i class="fa-solid fa-location-dot"></i></span>
                  </div>
                  <span class="icon_text"> My Area </span>
                </a>
                <a href="javascript:void(0);" class="nav-link">
                  <div class="icon_box">
                    <!-- <img src="{{asset('images/ldr.png')}}" alt="nav_icon1" /> -->
                    <span><i class="fa-solid fa-square-poll-vertical"></i></span>
                  </div>
                  <span class="icon_text"> Points </span>
                </a>
                <a href="javascript:void(0);" class="nav-link">
                  <div class="icon_box">
                    <!-- <img src="{{asset('images/ldr.png')}}" alt="nav_icon1" /> -->
                    <span><i class="fa-solid fa-location-crosshairs"></i></span>
                  </div>
                  <span class="icon_text"> Home </span>
                </a>
                <a href="javascript:void(0);" class="nav-link">
                  <div class="icon_box">
                    <!-- <img src="{{asset('images/s_i3.png')}}" alt="nav_icon1" /> -->
                    <span><i class="fa-regular fa-message"></i></span>
                  </div>
                  <span class="icon_text"> Chats </span>
                </a>
                <a href="javascript:void(0);" class="nav-link">
                  <div class="icon_box">
                    <!-- <img src="{{asset('images/s_i4.png')}}" alt="nav_icon1" /> -->
                    <span><i class="fa-solid fa-phone"></i></span>
                  </div>
                  <span class="icon_text"> Contacts </span>
                </a>
              </div>
            </div>
  
            <div class="ftr_img_logo">
              <img src="{{asset('images/ftr_logo.png')}}" alt="ftr_logo" />
            </div>
          </div> --}}
        </div>
        </div>
      </section>
    </main>
  
    @yield('customJs')

</body>

<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js"></script>


<script src="{{ asset('js/bootstrap.min.js') }}"></script>
<script src="{{ asset('js/font-awesome-all.min.js') }}"></script>
<script src="{{ asset('js/jquery.fancybox.pack.js') }}"></script>
<script src="{{ asset('js/easy-responsive-tabs.js') }}"></script>
<script src="{{ asset('js/swiper.js') }}"></script>
<script src="{{ asset('js/aos.js') }}"></script>
<script>
    AOS.init();
</script>
<script src="{{ asset('js/custom.js') }}"></script>

<!-- Push Notification -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
<script src="https://js.pusher.com/8.2.0/pusher.min.js"></script>
<script>
    Pusher.logToConsole = false;
    var pusher = new Pusher('85e5d5c81fe6572d30d7', {
        cluster: 'ap2'
    });
    var channel = pusher.subscribe('my-channel');
    channel.bind('my-event', function(data) {
        if (data) {
            toastr.success('New Task Created', {
                timeOut: 0,
                extendedTimeOut: 0,
            });
        } else {
            console.error('Invalid data structure received:', data);
        }
    });
</script>
<!-- Push Notification -->

<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>

<script>
    if ('serviceWorker' in navigator) {
        navigator.serviceWorker.register('/service-worker.js').then(function(registration) {
            console.log('Service Worker registered with scope:', registration.scope);

            // Ask for permission to send notifications
            Notification.requestPermission().then(function(permission) {
                if (permission === 'granted') {
                    console.log('Notification permission granted.');
                    // Subscribe the user to push notifications
                    subscribeUserToPush();
                }
            });
        }).catch(function(error) {
            console.log('Service Worker registration failed:', error);
        });
    }

    function subscribeUserToPush() {
        navigator.serviceWorker.ready.then(function(registration) {
            const options = {
                userVisibleOnly: true,
                applicationServerKey: "{{ env('VAPID_PUBLIC_KEY') }}"
            };
            registration.pushManager.subscribe(options).then(function(subscription) {
                console.log('Push Subscription:', subscription);
                // Send subscription to the server
                axios.post('/subscribe', subscription).then(response => {
                    console.log('User subscribed to push notifications:', response.data);
                });
            }).catch(function(error) {
                console.error('Failed to subscribe to push notifications:', error);
            });
        });
    }
</script>


</html>