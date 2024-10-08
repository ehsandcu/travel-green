@extends('layouts.main')
@section('css')
    <style>
        .hero .slides img{
            width: 100%;
            height: inherit;
        }

        #carbon-result {
            font-size: 14px;
            font-weight: normal;
            color: #333;
            margin-bottom: 6px;
            text-align: center;
            background-color: #f0f0f0;
            padding: 10px;
            border-radius: 30px;
        }
    </style>
@stop
@section('content')
    <div class="hero">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-7">
                    <div class="intro-wrap">
                        <h1 class="mb-5"><span class="d-block">Calculate your commuting </span> carbon <span class="typed-words"></span></h1>
                        <div class="row">
                            <div class="col-12">
                                <form class="form" id="carbon_form">
                                    <div class="row mb-2">
                                        <div class="col-sm-12 col-md-6 mb-3 mb-lg-0 col-lg-4">
                                            <label for="transport_method">Transport Method</label>                                            
                                            <select id="transport_method" class="form-control custom-select">
                                                <option value="0.1645">Petrol Car</option>
                                                <option value="0.16984">Diesel Car</option>
                                                <option value="0.0514">Electric Car</option>
                                                <option value="0.11367">Motorbike</option>
                                                <option value="0.02861">Train</option>
                                                <option value="0">Bicycle</option>
                                                <option value="0.10846">Bus</option>
                                                <option value="0">Walking</option>
                                              </select>
                                        </div>
                                        <div class="col-sm-12 col-md-6 mb-3 mb-lg-0 col-lg-5">
                                            <label for="work_distance">Distance to Work(km)</label>
                                            <input type="number" id="work_distance" class="form-control" min="1" value="1" placeholder="Distance to Work">
                                        </div>
                                        <div class="col-sm-12 col-md-6 mb-3 mb-lg-0 col-lg-3">                                            
                                            <label for="work_days">Work Days per Week</label>
                                            <input type="number" id="work_days" class="form-control" min="1" value="1" placeholder="Work Days">
                                        </div>
                                    </div>    
                                    <div class="row align-items-center">
                                        <div class="col-sm-12 col-md-6 mb-3 mb-lg-0 col-lg-4">
                                            <input type="submit" class="btn btn-primary btn-block calculate_carbon" value="Calculate">
                                        </div>    
                                        <div class="col-sm-12 col-md-6 mb-3 mb-lg-0 col-lg-4">
                                            <p id="carbon-result">CO2e per year <span id="emission_value"></span></p>                          
                                        </div>          
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-5">
                    <div class="slides">
                        <img src="{{ asset('images/hero-slider-1.jpg') }}" alt="Image" class="img-fluid active">
                        <img src="{{ asset('images/hero-slider-2.jpg') }}" alt="Image" class="img-fluid">
                        <img src="{{ asset('images/hero-slider-3.jpg') }}" alt="Image" class="img-fluid">
                        <img src="{{ asset('images/hero-slider-4.jpg') }}" alt="Image" class="img-fluid">
                        <img src="{{ asset('images/hero-slider-5.jpg') }}" alt="Image" class="img-fluid">
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="untree_co-section count-numbers py-5">
		<div class="container">
			<div class="row">
				<div class="col-6 col-sm-6 col-md-6 col-lg-4">
					<div class="counter-wrap">
						<div class="counter">
							<span class="" data-number="9313">0</span>
						</div>
						<span class="caption">No. of Vehicles</span>
					</div>
				</div>
				<div class="col-6 col-sm-6 col-md-6 col-lg-4">
					<div class="counter-wrap">
						<div class="counter">
							<span class="" data-number="8492">0</span>
						</div>
						<span class="caption">No. of People</span>
					</div>
				</div>
				<div class="col-6 col-sm-6 col-md-6 col-lg-4">
					<div class="counter-wrap">
						<div class="counter">
							<span class="" data-number="100">0</span>
						</div>
						<span class="caption">Quantity of Carbon Emissions</span>
					</div>
				</div>
				{{-- <div class="col-6 col-sm-6 col-md-6 col-lg-3">
					<div class="counter-wrap">
						<div class="counter">
							<span class="" data-number="120">0</span>
						</div>
						<span class="caption">No. of Countries</span>
					</div>
				</div> --}}
			</div>
		</div>
	</div>
@stop

@section('script')
    <script>
        $(function() {
            var slides = $('.slides'),
            images = slides.find('img');

            images.each(function(i) {
                $(this).attr('data-id', i + 1);
            })

            var typed = new Typed('.typed-words', {
                strings: ["footprint."],
                typeSpeed: 80,
                backSpeed: 80,
                backDelay: 3000,
                startDelay: 1000,
                loop: true,
                showCursor: true,
                preStringTyped: (arrayPos, self) => {
                    arrayPos++;
                    $('.slides img').removeClass('active');
                    $('.slides img[data-id="'+arrayPos+'"]').addClass('active');
                }

            });
        });

        $(document).on('submit', '#carbon_form', function(e){
            e.preventDefault();

            const transportMethod = $('#transport_method').val();
            const workDistance = parseFloat($('#work_distance').val());
            const workDays = parseFloat($('#work_days').val());
            const weeksPerYear = 48;

            if (workDays > 0 && workDistance > 0 && transportMethod >= 0) {
                const co2eEmissions = (transportMethod * workDistance * 2 * workDays * weeksPerYear).toFixed(2);
                $('#emission_value').text(co2eEmissions + 'kg');                
            }
        });
   </script>
@endsection