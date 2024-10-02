@extends('layouts.main')
@section('content')
    <div class="hero hero-inner">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6 mx-auto text-center">
                    <div class="intro-wrap">
                        <h1 class="mb-0">About Us</h1>
                        <p class="text-white">Lorem ipsum dolor, sit amet consectetur adipisicing elit. Est cum molestiae accusantium reiciendis commodi ab hic maxime sequi, accusamus provident, nulla iure! Rem reprehenderit reiciendis porro incidunt veritatis similique illo. </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="untree_co-section">
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
    </div>
    <div class="untree_co-section">
        <div class="container">
            <div class="row justify-content-center mb-5">
                <div class="col-md-6 text-center">
                    <h2 class="section-title mb-3 text-center">Team</h2>
                    <p>Lorem ipsum, dolor sit amet consectetur adipisicing elit. Laboriosam, repellendus iure quae eaque optio ad repellat quos. Vitae ex facere quaerat ratione, totam deserunt laudantium esse obcaecati voluptas nostrum earum.</p>
                </div>
            </div>    
            <div class="row">
                <div class="col-lg-3 mb-4">
                    <div class="team">
                        <img src="{{ asset('images/dummy-image.jpg') }}" alt="Image" class="img-fluid mb-4 rounded-20">
                        <div class="px-3">
                            <h3 class="mb-0">Member 1</h3>
                            <p>Co-Founder &amp; CEO</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 mb-4">
					<div class="team">
						<img src="{{ asset('images/dummy-image.jpg') }}" alt="Image" class="img-fluid mb-4 rounded-20">
						<div class="px-3">
							<h3 class="mb-0">Member 2</h3>
							<p>Co-Founder &amp; CEO</p>
						</div>
					</div>
                </div> 
				<div class="col-lg-3 mb-4">
                    <div class="team">
                        <img src="{{ asset('images/dummy-image.jpg') }}" alt="Image" class="img-fluid mb-4 rounded-20">
                        <div class="px-3">
                            <h3 class="mb-0">Member 4</h3>
                            <p>Co-Founder &amp; CEO</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 mb-4">
					<div class="team">
						<img src="{{ asset('images/dummy-image.jpg') }}" alt="Image" class="img-fluid mb-4 rounded-20">
						<div class="px-3">
							<h3 class="mb-0">Member 5</h3>
							<p>Co-Founder &amp; CEO</p>
						</div>
					</div>
                </div> 
            </div>
        </div>
    </div>
	<div class="py-5 cta-section">
		<div class="container">
			<div class="row text-center">
				<div class="col-md-12">
					<h2 class="mb-2 text-white">Lets you Explore the Best. Contact Us Now</h2>
					<p class="mb-4 lead text-white text-white-opacity">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Excepturi, fugit?</p>
					<p class="mb-0">
						<a href="#" class="btn btn-outline-white text-white btn-md font-weight-bold">Get in touch</a>
					</p>
				</div>
			</div>
		</div>
	</div>
@stop