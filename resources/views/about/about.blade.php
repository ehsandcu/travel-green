@extends('layouts.main')
@section('content')
    <div class="hero hero-inner">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6 mx-auto text-center">
                    <div class="intro-wrap">
                        <h1 class="mb-0">About Us</h1>
                        <p class="text-white">Welcome to Travel Green! Our mission is to help you understand and reduce your carbon footprint. With our easy-to-use tool, you can calculate the carbon emissions from your daily commute and discover greener alternatives. We believe that by making small changes in how we travel, we can make a big difference for the planet. Join us in creating a cleaner, healthier world, one step at a time.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- <div class="untree_co-section">
        <div class="container">
            <div class="row">
                <div class="col-lg-7">
                    <div class="owl-single dots-absolute owl-carousel">
                        <img src="{{ asset('images/slider-2.jpg') }}" alt="images" class="img-fluid rounded-20">
                        <img src="{{ asset('images/slider-3.jpg') }}" alt="images" class="img-fluid rounded-20">
                        <img src="{{ asset('images/slider-4.jpg') }}" alt="images" class="img-fluid rounded-20">
                        <img src="{{ asset('images/slider-5.jpg') }}" alt="images" class="img-fluid rounded-20">
                    </div>
                </div>
                <div class="col-lg-5 pl-lg-5 ml-auto">
                    <h2 class="section-title mb-4">About Green Travel</h2>
                    <p>Lorem ipsum, dolor sit amet consectetur adipisicing elit. Laboriosam, repellendus iure quae eaque optio ad repellat quos. Vitae ex facere quaerat ratione, totam deserunt laudantium esse obcaecati voluptas nostrum earum.</p>
                    <ul class="list-unstyled two-col clearfix">
                        <li>Lorem ipsum</li>
                        <li>Lorem ipsum</li>
                        <li>Lorem ipsum</li>
                        <li>Lorem ipsum</li>
                    </ul>
                </div>
            </div>
        </div>
    </div> --}}
    <div class="untree_co-section">
        <div class="container">
            <div class="row justify-content-center mb-5">
                <div class="col-md-6 text-center">
                    <h2 class="section-title mb-3 text-center">Team</h2>
                    <p>Meet the team behind Travel Green! Our team, including our supportive supervisor, is made up of people who care about the environment. Each of us uses our skills to create a platform that helps people make greener travel choices. Together, we’re working towards a cleaner and healthier future for everyone.</p>
                </div>
            </div>    
            <div class="row d-flex justify-content-center">
                @foreach($team as $member)
                    <div class="col-lg-3 mb-4">
                        <a href="{{ $member->link }}" target="_blank" class="text-decoration-none">
                            <div class="team">
                                <img src="{{ asset( $member->image ) }}" alt="Image" class="img-fluid mb-4 rounded-20 h-250 w-100">
                                <div class="px-3">
                                    <h3 class="mb-0">{{ $member->name }}</h3>
                                    <p>{{ $member->position }}</p>
                                </div>
                            </div>
                        </a>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
	<div class="py-5 cta-section">
		<div class="container">
			<div class="row text-center">
				<div class="col-md-12">
					<h2 class="mb-2 text-white">Lets you Explore the Best. Contact Us Now</h2>
					<p class="mb-4 lead text-white text-white-opacity"></p>
					<p class="mb-0">
						<a href="{{ route('contact.us') }}" class="btn btn-outline-white text-white btn-md font-weight-bold">Get in touch</a>
					</p>
				</div>
			</div>
		</div>
	</div>
@stop