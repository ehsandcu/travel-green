@extends('layouts.main')
@section('content')
    <div class="hero hero-inner">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6 mx-auto text-center">
                    <div class="intro-wrap">
                        <h1 class="mb-0">Contact Us</h1>
                        <p class="text-white">Lorem ipsum dolor, sit amet consectetur adipisicing elit. Est cum molestiae accusantium reiciendis commodi ab hic maxime sequi, accusamus provident, nulla iure! Rem reprehenderit reiciendis porro incidunt veritatis similique illo. </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="untree_co-section">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 mb-5 mb-lg-0">
                    <form class="contact-form" data-aos="fade-up" data-aos-delay="200">
                        <div class="row mb-3">
                            <div class="col-6">
                                <div class="form-group">
                                <label class="text-black mb-1" for="fname">First name</label>
                                <input type="text" class="form-control" id="fname">
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                <label class="text-black mb-1" for="lname">Last name</label>
                                <input type="text" class="form-control" id="lname">
                                </div>
                            </div>
                        </div>
                        <div class="form-group mb-3">
                            <label class="text-black mb-1" for="email">Email address</label>
                            <input type="email" class="form-control" id="email">
                        </div>
            
                        <div class="form-group mb-3">
                            <label class="text-black mb-1" for="message">Message</label>
                            <textarea name="" class="form-control h-auto" id="message" cols="30" rows="5"></textarea>
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
                            +353 22 333 4444
                        </address>
                    </div>
                    <div class="quick-contact-item d-flex align-items-center mb-4">
                        <span class="flaticon-mail"></span>
                        <address class="text">
                            mail@example.com
                        </address>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop