@extends('layouts.main')
@section('content')
    <div class="hero hero-inner">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6 mx-auto text-center">
                    <div class="intro-wrap">
                        <h1 class="mb-0">Contact Us</h1>
                        <p class="text-white">Got a question or need help? We’re here for you! Whether you have feedback, need assistance with using the Travel Green tool, or just want to learn more about how we can help you reduce your carbon footprint, feel free to reach out to us. Our team is happy to assist and connect with you. Just fill out the form below, and we'll get back to you as soon as possible!</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="untree_co-section">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 mb-5 mb-lg-0">
                    <form class="contact-form" action="{{ route('contact.us.store') }}" method="post" data-aos="fade-up" data-aos-delay="200">
                        @csrf
                        <div class="row mb-3">
                            <div class="col-6">
                                <div class="form-group">
                                <label class="text-black mb-1" for="first_name">First name</label>
                                <input type="text" name="first_name" class="form-control" id="first_name">
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                <label class="text-black mb-1" for="last_name">Last name</label>
                                <input type="text" name="last_name" class="form-control" id="last_name">
                                </div>
                            </div>
                        </div>
                        <div class="form-group mb-3">
                            <label class="text-black mb-1" for="email">Email address</label>
                            <input type="email" name="email" class="form-control" id="email">
                        </div>
            
                        <div class="form-group mb-3">
                            <label class="text-black mb-1" for="message">Message</label>
                            <textarea name="message" class="form-control h-auto" id="message" cols="30" rows="5"></textarea>
                        </div>
            
                        <button type="submit" class="btn btn-primary">Send Message</button>
                    </form>
                </div>
                <div class="col-lg-5 ml-auto">
                    <div class="quick-contact-item d-flex align-items-center mb-4">
                        <span class="flaticon-house"></span>
                        <address class="text">
                            Dublin City University, Collins Ave Ext, Whitehall, Dublin 9
                        </address>
                    </div>
                    <div class="quick-contact-item d-flex align-items-center mb-4">
                        <span class="flaticon-phone-call"></span>
                        <address class="text">
                            +353 (1) 700 5000
                        </address>
                    </div>
                    {{-- <div class="quick-contact-item d-flex align-items-center mb-4">
                        <span class="flaticon-mail"></span>
                        <address class="text">
                            mail@example.com
                        </address>
                    </div> --}}
                </div>
            </div>
        </div>
    </div>
@stop
@section('script')
    <script>
        $(document).ready(function(){
            $(".contact-form").validate({
                rules: {
                    first_name: {
                        required: true,
                    },
                    last_name: {
                        required: true,
                    },
                    email: {
                        required: true,
                        email: true,
                    },
                    message: {
                        required: true,
                    }
                },
                submitHandler: function(form) {
                    var formData = new FormData(form);

                    var formBtn = $(".contact-form button");
                    formBtn.attr('disabled',true);

                    $.ajax({
                        url: form.action,
                        type: form.method,
                        data: formData,
                        contentType: false,
                        processData: false,
                        success: function(res) {
                            formBtn.attr('disabled',false);
                            if (res.success == "1") {
                                form.reset();

                                swal({
                                    title: "Got It!",
                                    text: res.message || "You Have Successfully Calculated.",
                                    icon: "success",
                                    button: "Ok",
                                });
                            } else {
                                swal({
                                    title: "Got It!",
                                    text: res.message,
                                    icon: "error",
                                    button: "Ok",
                                });
                            }
                        },
                        error: function(jqXHR, textStatus, errorThrown) {
                            formBtn.attr('disabled',false);
                            swal({
                                title: "Got It!",
                                text: jqXHR.responseJSON.message||'Something went wrong please try again',
                                icon: "error",
                                button: "Ok",
                            });
                        }
                    }); 
                }
            });
        });
    </script>
@stop