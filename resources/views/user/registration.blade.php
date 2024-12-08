<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <title>Project</title>
    <meta name="description" content="" />
    <meta name="author" content="admin" />
    <meta name="viewport" content="width=device-width; initial-scale=1.0" />
    <link rel="shortcut icon" href="images/favicon.ico" alt="" />
    <link rel="stylesheet" href="css/font-awesome.css" />
    <link
        href="https://fonts.googleapis.com/css2?family=Noto+Sans:ital,wght@0,100..900;1,100..900&family=Nunito+Sans:ital,opsz,wght@0,6..12,200..1000;1,6..12,200..1000&display=swap"
        rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('css/aos.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/jquery.fancybox.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/easy-responsive-tabs.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/swiper.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/custom.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/responsive.css') }}" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css"
        integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css"
        integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <style>
        /* Hide the up/down arrows */
        input[type=number]::-webkit-inner-spin-button,
        input[type=number]::-webkit-outer-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }

        /* Hide the side scrollbar */
        input[type=number] {
            -moz-appearance: textfield;
        }
    </style>
</head>

<body>
    <main class="jst_login">
        <header class="login_logo lft_p_nav">
            <a href="javascript:void(0);">
                <div class="top_logo">
                    {{-- <img src="{{ asset('/images/mob_logo.png') }}" alt="mob_logo" /> --}}
                </div>
            </a>
            <h6>ProjectName</h6>
        </header>
        <section class="login-part">
            <div class="d_brd_tp" style="margin-bottom: 20px;">
                <h3>Register to the Project</h3>
                <!-- <p>
                This is a secure site. Please enter your login information<br />
                to enter or <a href="javascript:void(0)">click here</a> to register
                </p> -->
            </div>
            <div class="login-form lgn_frm_two">
                <form method="post" action="{{ route('userRegistration.register') }}" enctype="multipart/form-data" name="registration" id="registration">
                    @csrf
                    <div class="form_control">
                        <input type="text" id="name" name="name" placeholder="Enter your Name" />
                        <div id="name_error" class="error"></div>
                        @error('name')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="form_control">
                        <input type="text" id="email" name="email" placeholder="Enter your Email" />
                        <div id="email_error" class="error"></div>
                        @error('email')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="form_control">
                        <input type="number" id="mobile" name="mobile" placeholder="Enter your Mobile No." maxlength="10" 
                        oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 10);"  />
                        <div id="mobile_error" class="error"></div>
                        @error('mobile')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <div id="" class="sbmt_btn text-center">
                        <input type="submit" name="submit" value="Register" class="mainsb_btn">
                    </div>
                    {{-- <div  id="forgot">
                        <a href="{{route('forget.password')}}">Forgot Password</a>
                        </div> --}}
                    <div id="unableToLogin" style="font-size: 14px;">
                        <a href="javascript:void(0);" id="loginErrorLink">Unable to Register?</a>
                    </div>
                    </div>
                </form>
            </div>
        </section>
        <footer class="lgin_ftr">
            <p>© 2024 <a href="javascript:void(0);"></a></p>
        </footer>
    </main>
    <!--Header End-->

    <!-- Back to top button -->

    <a href="javascript:void(0);" id="backToTop">
        <i class="fa fa-solid fa-arrow-up"></i>
    </a>

    <!-- Back to top button -->

    <!-- Jquery  -->
    <script src="{{ asset('/js/jquery.min.js') }}"></script>
    <!-- Bootstrap JS -->
    <script src="{{ asset('/js/bootstrap.min.js') }}"></script>
    <!-- Font Awesome JS -->
    <script src="{{ asset('/js/font-awesome-all.min.js') }}"></script>
    <!-- Fancy Box -->
    <script src="{{ asset('/js/jquery.fancybox.pack.js') }}"></script>
    <!-- Easy Responsive Tab -->
    <script src="{{ asset('/js/easy-responsive-tabs.js') }}"></script>
    <!-- Swiper -->
    <script src="{{ asset('/js/swiper.js') }}"></script>
    <!-- AOS JS -->
    <script src="{{ asset('/js/aos.js') }}"></script>
    <script>
        AOS.init();
    </script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.js"></script>

    <script>
        document.getElementById('loginErrorLink').onclick = function() {
            Swal.fire({
                title: 'Contact Details',
                html: 'Please contact at: <br><b>+91 1234567890</b>',
                icon: 'info',
                confirmButtonText: 'OK',
            });
        };

        $(document).ready(function () {
            $("#registration").on("submit", function (e) {
                e.preventDefault();

                // Clear previous errors
                $(".error").html("");

                let name = $("#name").val().trim();
                let email = $("#email").val().trim();
                let mobile = $("#mobile").val().trim();
                let hasError = false;

                // Validate Name
                if (!name) {
                    $("#name_error").html("Name is required.");
                    hasError = true;
                }

                // Validate Email
                if (!email) {
                    $("#email_error").html("Email is required.");
                    hasError = true;
                } 

                // Validate Mobile
                if (!mobile) {
                    $("#mobile_error").html("Mobile number is required.");
                    hasError = true;
                } else if (mobile.length !== 10) {
                    $("#mobile_error").html("Mobile number must be exactly 10 digits.");
                    hasError = true;
                }

                if (hasError) {
                    return false;
                }

                // Submit form via AJAX
                $.ajax({
                    url: "{{ route('userRegistration.register') }}",
                    type: "POST",
                    data: $(this).serialize(),
                    success: function (response) {
                        if (response.status === "exists") {
                            Swal.fire({
                                icon: "warning",
                                title: "Already Registered",
                                text: "You are already registered. Please login.",
                            }).then(() => {
                                window.location.href = "{{ url('login') }}";
                            });
                        } else if (response.status === "success") {
                            Swal.fire({
                                icon: "success",
                                title: "Registration Successful",
                                text: "You are successfully registered. Please login.",
                            }).then(() => {
                                window.location.href = "{{ url('login') }}";
                            });
                        }
                    },
                    error: function () {
                        Swal.fire({
                            icon: "error",
                            title: "Error",
                            text: "An error occurred. Please try again.",
                        });
                    },
                });
            });

        });

    </script>
</body>

</html>
