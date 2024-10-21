<!-- Header Satart-->
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta http-equiv="x-ua-compatible" content="ie=edge" />
    <title>Green Travel | Login</title>
    <link rel="shortcut icon" href="{{ asset('favicon.png') }}">
    <link rel="stylesheet" href="{{ asset('assets/login/css/core.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/login/css/backend.css?v=1.0.0') }}" />
    <link rel="stylesheet" href="{{ asset('assets/login/css/googlebutton.css') }}" />
    
    <script src="{{ asset('assets/login/js/app.js') }}"></script>

    <style>
        body {
            font-family: 'Inter' !important;
        }
        .form-control:focus {
            color: #01041b;
            border-color: #FF642F;
            box-shadow: none;
        }

        .divider-wrapper {
            display: flex;
            flex-direction: row;
            text-transform: uppercase;
            border: none;
            font-size: 12px;
            font-weight: 400;
            margin: 0;
            /* padding: 24px 0 0; */
            align-items: center;
            justify-content: center;
            width: 380px;
            vertical-align: baseline;
        }

        .divider-wrapper::before, .divider-wrapper::after {
            content: "";
            border-bottom: 1px solid #c2c8d0;
            flex: 1 0 auto;
            height: .5em;
            margin: 0;
        }

        .divider {
            text-align: center;
            flex: .2 0 auto;
            margin: 0;
            height: 12px;
        }
    </style>
</head>

<body>

    <div class="pageloader"></div>
    <div class="infraloader is-active"></div>
    <!-- Header End-->
    <!-- Wrapper -->
    <div class="row login-wrapper columns is-gapless">
        <!-- Form section -->
        <div class="col-md-7">
            <div class="hero is-fullheight">
                <div class="hero-heading">
                    <div class="d-flex justify-content-center">
                        {{-- <a href="/">
                            <img class="top-logo switcher-logo" src="assets/login/img/logos/LOGO 1.svg" alt="" />
                        </a> --}}
                    </div>
                </div>
                <div class="hero-body">
                    <div class="container">
                        <div class="columns justify-content-md-center">
                            <!-- <div class="column"></div> -->
                            <div id="login-view-colunm" class="column is-5">
                                <!-- Login Form -->
                                <form method="post" action="{{ route('check.login') }}" id="signin-form" class="needs-validation login-form-view" novalidate>
                                    @csrf
                                    <div class="auth-content text-center">
                                        <h2 class="mb-2">Welcome</h2>
                                        <p>Please sign in to your account</p>
                                    </div>
                                    <div id="login-error" class="text-danger"></div>

                                    <div class="animated preFadeInLeft fadeInLeft">
                                        <!-- Input -->
                                        <div class="form-group">
                                            <label for="uname">Email</label>
                                            <input type="email" class="form-control" id="email"
                                                placeholder="Please enter email" name="login_email" required />
                                            <div class="invalid-feedback">
                                                Please enter valid email.
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="pwd">Password</label>
                                            <input type="password" class="form-control" id="password"
                                                placeholder="Please enter password" minlength="6" name="login_password"
                                                required />
                                            <div class="invalid-feedback">
                                                Please enter correct password.
                                            </div>
                                        </div>
                                        <p class="control login">
                                            <button type="submit"
                                                class="button button-cta primary-btn btn-align-lg w-100 rounded raised no-lh" id="login">
                                                Log in
                                                <span class="action-load-btn spinner-border spinner-border-sm ml-2"
                                                    role="status" aria-hidden="true"></span>
                                            </button>
                                        </p>
                                    </div>
                                </form>
                                <!-- OTP Form -->
                                <form class="otp-form-view">
                                    <div class="auth-content text-center">
                                        <h2 class="mb-2">Let's Verify</h2>
                                        <p>Please check your email for verification code</p>
                                    </div>
                                    <div class="animated preFadeInLeft fadeInLeft">
                                        <!-- Input -->
                                        <div class="field pb-10">
                                            <div class="`e">
                                                <div class="d-flex justify-content-center align-items-center container">
                                                    <div class="verifyCode"
                                                        style="background-color: #f9fbfe !important ;">
                                                        <h5 class="ml-1 control-label text-center">Verification Code
                                                        </h5>
                                                        <div class="d-flex flex-row mt-5 verification-code--inputs">
                                                            <input id="otp-input1" type="text" maxlength="1"
                                                                class="form-control" autofocus="">
                                                            <input id="otp-input2" type="text" maxlength="1"
                                                                class="form-control">
                                                            <input id="otp-input3" type="text" maxlength="1"
                                                                class="form-control">
                                                            <input id="otp-input4" type="text" maxlength="1"
                                                                class="form-control">
                                                            <input id="otp-input5" type="text" maxlength="1"
                                                                class="form-control">
                                                            <input id="otp-input6" type="text" maxlength="1"
                                                                class="form-control">
                                                        </div>
                                                    </div>
                                                </div>


                                                <input type="hidden" id="verificationCode" />
                                            </div>
                                        </div>
                                        <div class="col-lg-12" style="margin-bottom: 15px; text-align: center">
                                            <input type="checkbox" id="remember_me" name="remember_me" value="1" />
                                            <label for="remember_me">Remember me on this Browser
                                            </label>
                                        </div>
                                        <div id="otp-error" class="alert alert-danger" style="display: none"></div>
                                        <!-- Submit -->
                                        <p class="control login">
                                            <button type="button" id="submit-otp-value"
                                                class="button button-cta primary-btn btn-align-lg is-bold w-100 rounded raised no-lh form-otp-btn">
                                                Submit
                                                <span class="action-load-btn spinner-border spinner-border-sm ml-2"
                                                    role="status" aria-hidden="true"></span>
                                            </button>
                                        </p>
                                    </div>
                                </form>
                                <!-- Reset Form -->
                                <form id="reset-form" class="reset-form-view">
                                    <div class="auth-content text-center">
                                        <h2 class="mb-2">Forgot Password?</h2>
                                        <p>
                                            Please provide your account's email for which you want to
                                            reset your password
                                        </p>
                                        <a class="" href="/signup">I do not have an account yet </a>
                                    </div>
                                    <div class="animated preFadeInLeft fadeInLeft">
                                        <!-- Input -->
                                        <div class="field pb-10">
                                            <div class="control has-icons-right">
                                                <input name="reset-email" id="reset-email"
                                                    class="input is-medium has-shadow" type="email" required
                                                    placeholder="Please enter registered email" />
                                                <span class="icon is-medium is-right">
                                                    <i class="sl sl-icon-envelope-open"></i>
                                                </span>
                                            </div>
                                        </div>
                                        <div id="forgot-error" class="alert alert-danger" style="display: none"></div>
                                        <!-- Submit -->
                                        <p class="control">
                                            <button type="submit" id="reset_btn"
                                                class="button button-cta primary-btn btn-align-lg is-bold w-100 rounded raised no-lh form-reset-btn">
                                                Reset password
                                                <span class="action-load-btn spinner-border spinner-border-sm ml-2"
                                                    role="status" aria-hidden="true"></span>
                                            </button>
                                        </p>
                                    </div>
                                </form>
                                <!-- Reset Password Form -->
                                <form id="new-password-form" class="new-pswd-form-view reset-pwd-needs-validation"
                                    novalidate>
                                    <div class="auth-content text-center">
                                        <h2 class="mb-2">Reset New Password</h2>
                                    </div>

                                    <div class="animated preFadeInLeft fadeInLeft">
                                        <!-- Input -->
                                        <div class="field pb-10">
                                            <!-- <div class="control has-icons-right">
                                                <input name="reset_token" id="reset_token" class="input is-medium has-shadow" type="text" required
                                                    placeholder="Please enter OTP" />
                                                <span class="icon is-medium is-right">
                                                   <i class="sl sl-icon-lock"></i>
                                                </span>
                                            </div> -->
                                            <div class="field pb-10">
                                                <div class="verification-code">
                                                    <label class="control-label">Verification Code</label>
                                                    <div class="verification-code--inputs">
                                                        <input id="otp-pwd-input1" type="text" maxlength="1" />
                                                        <input id="otp-pwd-input2" type="text" maxlength="1" />
                                                        <input id="otp-pwd-input3" type="text" maxlength="1" />
                                                        <input id="otp-pwd-input4" type="text" maxlength="1" />
                                                        <input id="otp-pwd-input5" type="text" maxlength="1" />
                                                        <input id="otp-pwd-input6" type="text" maxlength="1" />
                                                    </div>
                                                    <input type="hidden" id="verificationCode" />
                                                    <span id="empety-otp" class="text-center text-danger mt-3">Please
                                                        Enter Verification Code</span>
                                                </div>
                                            </div>

                                            <!-- <div class="control has-icons-right mt-3">
                                                <input name="reset_password" id="reset_password" class="input is-medium has-shadow" type="password" required min="6"
                                                    placeholder="Please enter new password" />
                                                <span class="icon is-medium is-right">
                                                   <i class="sl sl-icon-lock"></i>
                                                </span>
                                            </div> -->
                                            <div class="form-group">
                                                <label for="pwd">New Password</label>
                                                <input type="password" class="form-control" name="reset_password"
                                                    name="reset_password_confirmation" id="reset_password_confirmation"
                                                    placeholder="Please enter new password" minlength="6" name="pswd"
                                                    required />
                                                <div class="invalid-feedback">Please enter password.</div>
                                            </div>
                                            <div class="form-group">
                                                <label for="pwd">Re-Type New Password</label>
                                                <input type="password" class="form-control" name="reset_password"
                                                    id="reset_password" placeholder="Please enter new password"
                                                    minlength="6" name="pswd" required />
                                                <div class="invalid-feedback">Please enter password.</div>
                                            </div>
                                            <!-- <div class="control has-icons-right mt-3">
                                                <input name="reset_password_confirmation" id="reset_password_confirmation" class="input is-medium has-shadow" type="password" required min="6"
                                                    placeholder="Please re-type new password" />
                                                <span class="icon is-medium is-right">
                                                   <i class="sl sl-icon-lock"></i>
                                                </span>
                                            </div> -->
                                        </div>
                                        <div id="reset-password-error" class="alert alert-danger" style="display: none">
                                        </div>
                                        <!-- Submit -->
                                        <p class="control">
                                            <button type="submit"
                                                class="button button-cta primary-btn btn-align-lg is-bold w-100 rounded raised no-lh form-new-pswd-btn">
                                                Reset password
                                                <span class="action-load-btn spinner-border spinner-border-sm ml-2"
                                                    role="status" aria-hidden="true"></span>
                                            </button>
                                        </p>
                                    </div>
                                </form>
                                <!-- Sign up Form -->
                                <form method="POST" action="{{ route('register') }}" id="signup-form" class="register-form-view register-form-needs-validation" novalidate>
                                    @csrf
                                    <div class="auth-content text-center">
                                        <h2 class="mb-2">Sign up</h2>
                                        <p>
                                            Please fill the form and register your account
                                        </p>
                                    </div>
                                    <div id="register-error" class="text-danger"></div>
                                    <div class="animated preFadeInLeft fadeInLeft">
                                        <!-- Input -->
                                        <div class="form-group">
                                            <label for="uname">Name</label>
                                            <input type="text" class="form-control" id="email"
                                                placeholder="Please enter your name" name="register_name" required />
                                            <div class="invalid-feedback">
                                                Please enter your name.
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="uname">Email</label>
                                            <input type="email" class="form-control" id="email"
                                                placeholder="Please enter your email" name="register_email" required />
                                            <div class="invalid-feedback">
                                                Please enter valid email.
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="pwd">Password</label>
                                            <input type="password" class="form-control" id="password"
                                                placeholder="Please enter your password" minlength="6" name="new_password"
                                                required />
                                            <div class="invalid-feedback">
                                                Please enter correct password.
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="pwd">Confirm Password</label>
                                            <input type="password" class="form-control" id="confirm-password"
                                                placeholder="Please enter confirm password" minlength="6" name="confirm_password"
                                                required />
                                            <div class="invalid-feedback">
                                                Please enter correct password.
                                            </div>
                                        </div>
                                        <p class="control register">
                                            <button type="submit"
                                                class="button button-cta primary-btn btn-align-lg w-100 rounded raised no-lh"
                                                id="register">
                                                Sign Up
                                                <span class="action-load-btn spinner-border spinner-border-sm ml-2"
                                                    role="status" aria-hidden="true"></span>
                                            </button>
                                        </p>
                                    </div>
                                </form>
                                <!-- Toggles -->
                                <div>
                                    <div class="forgot-password animated preFadeInLeft fadeInLeft forget-pswd-btn">
                                        <p class="has-text-right">
                                            <a href="javascript:void(0)">Forgot password?</a>
                                        </p>                                    
                                    </div>                                    
                                </div>
                            </div>
                        </div>
                        <div class="divider-wrapper m-auto pb-2">
                            <span class="divider">OR</span>
                        </div>
                        <div class="columns justify-content-md-center pt-10 has-text-centered pb-2">
                            <div class="column is-5">
                                <a href="{{ route('google.redirect') }}" class="btn login-with-google-btn" >
                                    Sign in with Google
                                </a>
                            </div>
                        </div>
                        
                        <div class="register-account columns animated preFadeInLeft fadeInLeft justify-content-md-center pt-10 has-text-centered">
                            <p class="has-text-right">
                                <span class="">Don't have an account? <a href="javascript:void(0)">Register </a></span>
                            </p>                                    
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Image section (hidden on mobile) -->
        <div class="col-md-5 login-column is-hidden-mobile hero-banner px-0 d-flex align-items-stretch">
            <div class="hero login-hero is-fullheight is-theme-primary is-relative">
                <div class="text-center">
                    <p class="text-white font-size-28 " style="padding-left: 30px; padding-right: 30px;">
                        Lorem ipsum dolor sit amet consectetur adipisicing elit. Est ipsa alias, cum aperiam enim quisquam.<br>
                        <small>Lorem ipsum dolor sit amet consectetur adipisicing elit.</small>
                    </p>
                </div>
                <ul class="circles">
                    <li></li>
                    <li></li>
                    <li></li>
                    <li></li>
                    <li></li>
                    <li></li>
                    <li></li>
                    <li></li>
                    <li></li>
                    <li></li>
                </ul>
            </div>
        </div>
        <!-- /Image section -->
    </div>
   
    <!-- /Wrapper -->

    <!-- /Side navigation -->
    <!-- Back To Top Button -->

    <script>
        function getRememberMeCookie(cname) {
            var cookies = ` ${document.cookie}`.split(";");
            var val = "";
            for (var i = 0; i < cookies.length; i++) {
                var cookie = cookies[i].split("=");
                if (cookie[0] == ` ${cname}`) {
                    return cookie[1];
                }
            }
            return "";
        }

        function setRememberMeCookie() {
            const d = new Date();
            d.setTime(d.getTime() + 30 * 24 * 60 * 60 * 1000);
            let expires = "expires=" + d.toUTCString();
            document.cookie = "remember_me=true; " + expires + "; path=/;";
        }

        function unsetRememberMeCookie() {
            document.cookie =
                "remember_me=false; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/";
        }

        // $(document).ready(function () {
        //     $("#remember_me").click(function () {
        //         if ($(this).prop("checked") === true) {
        //             setRememberMeCookie();
        //         } else if ($(this).prop("checked") === false) {
        //             unsetRememberMeCookie();
        //         }
        //     });
        // });

        $(document).on("submit", "#reset-form", function (form) {
            form.preventDefault();

            $.ajax({
                url: adminApiUrl + "/api/v3/auth/forgot-password",
                type: "POST",
                data: JSON.stringify({
                    email: $("#reset-email").val(),
                }),
                timeout: 0,
                headers: {
                    "Content-Type": "application/json",
                },
                success: function (response) {
                    if (response.success == "1") {
                        $(".reset-form-view").hide();
                        $(".new-pswd-form-view").show();
                    } else {
                        $("#forgot-error").css("display", "block").html(response.message);
                    }
                },
                error: function (response) {
                    $("#forgot-error")
                        .css("display", "block")
                        .html("Something went wrong, please try again!");
                },
            });
        });

        $(document).on("submit", "#new-password-form", function (form) {
            form.preventDefault();
        });

        // Get the input field
        var input = document.getElementById("otp-input6");

        // Execute a function when the user presses a key on the keyboard
        input.addEventListener("keypress", function (event) {
            // If the user presses the "Enter" key on the keyboard
            if (event.key === "Enter") {
                // Cancel the default action, if needed
                event.preventDefault();
                console.log("ddd")
                // Trigger the button element with a click
                document.getElementById("submit-otp-value").click();
            }
        });

        //Code Verification
        $("#submit-otp-value").click(function () {
            var str1 = $("#otp-input1").val();
            var str2 = $("#otp-input2").val();
            var str3 = $("#otp-input3").val();
            var str4 = $("#otp-input4").val();
            var str5 = $("#otp-input5").val();
            var str6 = $("#otp-input6").val();
            var otpvalue = str1 + str2 + str3 + str4 + str5 + str6;
            //alert(otpvalue);
            var email = $("#email").val();
            var password = $("#password").val();

            window.location = "index.html";
        });

        var verificationCode = [];
        $(".verification-code input[type=text]").keyup(function (e) {
            // Get Input for Hidden Field
            $(".verification-code input[type=text]").each(function (i) {
                verificationCode[i] = $(".verification-code input[type=text]")[i].value;
                $("#verificationCode").val(Number(verificationCode.join("")));
                //console.log( $('#verificationCode').val() );
            });
            //console.log(event.key, event.which);
            if ($(this).val() > 0) {
                if (
                    event.key == 1 ||
                    event.key == 2 ||
                    event.key == 3 ||
                    event.key == 4 ||
                    event.key == 5 ||
                    event.key == 6 ||
                    event.key == 7 ||
                    event.key == 8 ||
                    event.key == 9 ||
                    event.key == 0
                ) {
                    $(this).next().focus();
                }
            } else {
                if (event.key == "Backspace") {
                    $(this).prev().focus();
                }
            }
        });

        $(document).ready(function () {
            $(".otp-form-view").hide();
            // $("#signin-form").hide();
            $(".new-pswd-form-view").hide();
            $(".reset-form-view").hide();
            $("#empety-otp").hide();
            $(".action-load-btn").hide();
            $('.register-form-view').hide();

            $(".forget-pswd-btn").click(function () {
                $(".forget-pswd-btn").hide();
                $(".login-form-view").hide();
                $(".otp-form-view").hide();
                $(".new-pswd-form-view").hide();
                $(".reset-form-view").show();
            });

            $('.register-account').click(function () {
                $(".forget-pswd-btn").hide();
                $(".login-form-view").hide();
                $(".otp-form-view").hide();
                $(".new-pswd-form-view").hide();
                $('.register-account').hide();
                $(".register-form-view").show();
            });

            var container = document.getElementsByClassName("verification-code--inputs")[0];
            container.onkeyup = function (e) {
                var target = e.srcElement || e.target;
                var maxLength = parseInt(target.attributes["maxlength"].value, 10);
                var myLength = target.value.length;
                if (myLength >= maxLength) {
                    var next = target;
                    while (next = next.nextElementSibling) {
                        if (next == null)
                            break;
                        if (next.tagName.toLowerCase() === "input") {
                            next.focus();
                            break;
                        }
                    }
                }
                // Move to previous field if empty (user pressed backspace)
                else if (myLength === 0) {
                    var previous = target;
                    while (previous = previous.previousElementSibling) {
                        if (previous == null)
                            break;
                        if (previous.tagName.toLowerCase() === "input") {
                            previous.focus();
                            break;
                        }
                    }
                }
            }
        });
        
        (function () {
            "use strict";
            window.addEventListener(
                "load",
                function () {
                    // Get the forms we want to add validation styles to
                    var forms = document.getElementsByClassName(
                        "register-form-needs-validation"
                    );
                    // Loop over them and prevent submission
                    var validation = Array.prototype.filter.call(forms, function (form) {
                        form.addEventListener(
                            "submit",
                            function (event) {                                
                                event.preventDefault();
                                event.stopPropagation();
                                
                                var errorSelector = $('#register-error');
                                errorSelector.text('');

                                if (form.checkValidity() === true) {
                                    var formData = new FormData(form);
                                    var formBtn = $("button");
                                    formBtn.attr('disabled',true);

                                    $.ajax({
                                        url: form.action,
                                        type: form.method,
                                        data: formData,
                                        processData: false,
                                        contentType: false,
                                        cache: false,
                                        headers: {
                                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                                        },
                                        success: function (response) {
                                            formBtn.attr('disabled',false);

                                            if (response.success == "1") {
                                                $(".forget-pswd-btn").show();
                                                $(".login-form-view").show();
                                                $("#signup-form").hide();
                                                $(".new-pswd-form-view").hide();
                                                $(".reset-form-view").hide();
                                                swal({
                                                    title: "Got It!",
                                                    text: response.message || "Account successfully created!",
                                                    icon: "success",
                                                    button: "Ok",
                                                    timer: 1500,
                                                });
                                            } else {
                                                errorSelector.text(response.message || 'Something went wrong!');
                                            }
                                        },
                                        error: function (response) {
                                            formBtn.attr('disabled',false);
                                            errorSelector.text(response.message || 'Something went wrong!');
                                        },
                                    });
                                }
                                form.classList.add("was-validated");
                            },
                            false
                        );
                    });
                },
                false
            );
        })();

        (function () {
            "use strict";
            window.addEventListener(
                "load",
                function () {
                    // Get the forms we want to add validation styles to
                    var forms = document.getElementsByClassName("needs-validation");
                    // Loop over them and prevent submission
                    var validation = Array.prototype.filter.call(forms, function (form) {
                        form.addEventListener(
                            "submit",
                            function (event) {
                                event.preventDefault();
                                event.stopPropagation();

                                var errorSelector = $('#login-error');
                                errorSelector.text('');

                                if (form.checkValidity() === true) {
                                    console.log('here');
                                    var formData = new FormData(form);
                                    var formBtn = $("button");
                                    formBtn.attr('disabled',true);

                                    $.ajax({
                                        url: form.action,
                                        type: form.method,
                                        data: formData,
                                        processData: false,
                                        contentType: false,
                                        cache: false,
                                        headers: {
                                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                                        },
                                        success: function (response) {
                                            formBtn.attr('disabled',false);

                                            if (response.success == "1") {
                                                location.reload();
                                            } else {
                                                errorSelector.text(response.message || 'Something went wrong!');
                                            }
                                        },
                                        error: function (response) {
                                            formBtn.attr('disabled',false);
                                            errorSelector.text(response.message || 'Something went wrong!');
                                        },
                                    });
                                }
                                form.classList.add("was-validated");
                            },
                            false
                        );
                    });
                },
                false
            );
        })();

        (function () {
            "use strict";
            window.addEventListener(
                "load",
                function () {
                    // Get the forms we want to add validation styles to
                    var forms = document.getElementsByClassName(
                        "reset-pwd-needs-validation"
                    );
                    // Loop over them and prevent submission
                    var validation = Array.prototype.filter.call(forms, function (form) {
                        form.addEventListener(
                            "submit",
                            function (event) {
                                var string1 = $("#otp-pwd-input1").val();
                                var string2 = $("#otp-pwd-input2").val();
                                var string3 = $("#otp-pwd-input3").val();
                                var string4 = $("#otp-pwd-input4").val();
                                var string5 = $("#otp-pwd-input5").val();
                                var string6 = $("#otp-pwd-input6").val();
                                var reset_token =
                                    string1 + string2 + string3 + string4 + string5 + string6;

                                if (reset_token.length != 6) {
                                    $("#empety-otp").show();
                                }
                                event.preventDefault();
                                event.stopPropagation();
                                if (form.checkValidity() === true) {
                                    $.ajax({
                                        url: adminApiUrl + "/api/v3/auth/reset-password",
                                        type: "POST",
                                        data: JSON.stringify({
                                            email: $("#reset-email").val(),
                                            password: $("#reset_password").val(),
                                            password_confirmation: $(
                                                "#reset_password_confirmation"
                                            ).val(),
                                            token: reset_token,
                                        }),
                                        timeout: 0,
                                        headers: {
                                            "Content-Type": "application/json",
                                        },
                                        success: function (response) {
                                            if (response.success == "1") {
                                                $(".forget-pswd-btn").show();
                                                $(".login-form-view").show();
                                                $(".otp-form-view").hide();
                                                $(".new-pswd-form-view").hide();
                                                $(".reset-form-view").hide();
                                            } else {
                                                $("#reset-password-error")
                                                    .css("display", "block")
                                                    .html(response.message);
                                            }
                                        },
                                        error: function (response) {
                                            $("#forgot-error")
                                                .css("display", "block")
                                                .html("Something went wrong, please try again!");
                                        },
                                    });
                                }
                                form.classList.add("was-validated");
                            },
                            false
                        );
                    });
                },
                false
            );
        })();

        function responsiveFunct(x) {
            if (x.matches) {
                // If media query matches
                $("#login-view-colunm").removeClass("is-5").addClass("is-12");
            } else {
                $("#login-view-colunm").removeClass("is-12").addClass("is-5");
            }
        }

        var x = window.matchMedia("(max-width: 1100px)");
        responsiveFunct(x); // Call listener function at run time
        x.addListener(responsiveFunct);

        function removeclassfunct(y) {
            if (y.matches) {
                // If media query matches
                $(".is-hidden-mobile").removeClass("d-flex");
                $(".is-hidden-mobile").removeClass("align-items-stretch");
            } else {
                $(".is-hidden-mobile").addClass("d-flex");
                $(".is-hidden-mobile").addClass("align-items-stretch");
            }
        }

        var y = window.matchMedia("(max-width: 770px)");
        removeclassfunct(y); // Call listener function at run time
        y.addListener(removeclassfunct);

        $(document).on({
            ajaxStart: function () {
                $(".action-load-btn").show();
            },
            ajaxStop: function () {
                $(".action-load-btn").hide();
            },
        });
        
    </script>
    <div id="backtotop"><a href="#"></a></div>
    <script src="assets/login/js/core.js"></script>
    <script src="{{ asset('assets/dashboard/js/sweetalert.min.js') }}"></script>
</body>
</html>