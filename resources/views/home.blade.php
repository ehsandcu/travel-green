@extends('layouts.main')
@section('css')
    <link rel="stylesheet" href="{{ asset('css/bootstrap/alpha_bootstrap.min.css') }}">

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

        .form-group {
            margin-bottom: 1.5rem;
        }

        .select2-container .select2-selection--single .select2-selection__rendered {
            padding-left: 0px;
        }

        .select2-container--default .select2-selection--single .select2-selection__rendered {
            line-height: 0;
            overflow: unset;
        }

        .select2-container--default .select2-selection--single .select2-selection__arrow {
            top: 10px;
        }

        .select2-container--default .select2-selection--single, .select2-container--default .select2-selection--single .select2-search__field {
            display: block;
            width: 100%;
            padding: 1.315rem .75rem;
            font-size: 1rem;
            font-weight: 400;
            line-height: 1.5;
            color: var(--bs-body-color);
            background-color: var(--bs-form-control-bg);
            background-clip: padding-box;
            border: var(--bs-border-width) solid var(--bs-border-color);
            -webkit-appearance: none;
            -moz-appearance: none;
            appearance: none;
            border-radius: .375rem;
            transition: border-color .15s ease-in-out, box-shadow .15s ease-in-out;
        }

        .banner-text {
            color: #f0f0f0;
            font-size: 1rem;
            font-weight: 500;
            line-height: 1.5;
            text-align: left;
            letter-spacing: normal;
            width: 80%;
        }
    </style>
@stop
@section('content')
    @php
        $currentYear = \Carbon\Carbon::now()->year;   
    @endphp
    <div class="hero">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-7">
                    <div class="intro-wrap">
                        <h1 class="mb-4"><span class="d-block">Calculate your commuting </span> carbon <span class="typed-words"></span></h1>
                        <p class="banner-text">
                            <span class="d-block">Commuting is a daily routine, but the way you travel has a big impact on the environment. Driving, public transport, biking, or walking all contribute differently to carbon emissions.</span><span> Our calculator helps you measure your commute’s environmental impact and discover ways to reduce it. Make a difference with every journey you take!</span>
                            <span class="d-block mt-3">Would you like to <button class="btn btn-primary btn_carbon_calculator">Calculate</button> now?</span>
                        </p>
                        {{-- <div class="row">
                            <div class="col-12">
                                <form class="form" id="carbon_form">
                                    <div class="row mb-2">
                                        <div class="col-sm-12 col-md-6 mb-3 mb-lg-0 col-lg-4">
                                            <label for="transport_method">Transport Method</label>                                            
                                            <select id="transport_method" class="form-control custom-select">
                                                @foreach (\App\Lib\TransportMode::MODES as $modeVal => $mode)
                                                    <option value="{{ $modeVal }}">{{ $mode }}</option>                                                    
                                                @endforeach                                                
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
                        </div> --}}
                    </div>
                </div>
                <div class="col-lg-5">
                    <div class="slides">
                        <img src="{{ asset('images/helix.jpg') }}" alt="Image" class="img-fluid active">
                        <img src="{{ asset('images/hero-slider-2.jpg') }}" alt="Image" class="img-fluid">
                        <img src="{{ asset('images/hero-slider-3.jpg') }}" alt="Image" class="img-fluid">
                        <img src="{{ asset('images/hero-slider-4.jpg') }}" alt="Image" class="img-fluid">
                        <img src="{{ asset('images/hero-slider-5.jpg') }}" alt="Image" class="img-fluid">
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="untree_co-section py-5 carbon_calculator" style="display: none;">
		<div class="container">
			<div class="row">
                <div class="card" style="background-color: #f8f9fa;">
                    <div class="card-body">
                        <h4 class="card-title mt-2">Calculate Carbon Emission</h4>                  
                        <form id="carbon_calculate_form" method="POST" action="{{ route('calculate_carbon.home') }}">                         
                            @csrf
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="form-label">
                                            Trip Journey
                                            <span class="text-danger">*</span>
                                        </label>
                                        <div class="mt-2">
                                            @foreach(\App\Lib\TripJourney::JOURNEYS as $journeyKey => $journey)
                                                <input type="radio" class="btn-check form-control" name="trip_journey" id="{{ $journeyKey }}-outlined" value="{{ $journeyKey }}" autocomplete="off" @if ($loop->first) checked @endif>
                                                <label class="btn btn-outline-{{ $journey['color'] }}" for="{{ $journeyKey }}-outlined">{{ $journey['label'] }}</label>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 weekDays" style="display: none;">
                                    <div class="form-group">
                                        <label class="form-label">
                                            Week
                                            <span class="text-danger">*</span>
                                        </label>
                                        <input type="text" name="custom_week" id="camp-week" min="{{ $currentYear }}-W01" max="{{ $currentYear }}-W52" class="form-control" />
                                    </div>
                                </div>
                                <div class="col-md-6 customMonth" style="display: none;">
                                    <div class="form-group">
                                        <label class="form-label">
                                            Month
                                            <span class="text-danger">*</span>
                                        </label>
                                        <input type="month" name="custom_month" class="form-control" value="{{ date('Y-m') }}"/>
                                    </div>
                                </div>
                                <div class="col-md-6 customSemester" style="display: none;">                                
                                    <div class="form-group">
                                        <label class="form-label" for="semester_year">
                                            Semester Year
                                            <span class="text-danger">*</span>
                                        </label>
                                        <select class="w-100" name="semester_year" id="semester_year" required>
                                            @foreach ( listOfYears('2022') as $year)
                                                @php
                                                    $semesterYear = $year .'-'. $year + 1
                                                @endphp
                                                <option value="{{ $semesterYear }}">{{ $semesterYear }}</option>                                                    
                                            @endforeach    
                                        </select>          
                                    </div>                                
                                </div>
                                <div class="col-md-6 customSemester" style="display: none;">
                                    <div class="form-group">
                                        <label class="form-label">
                                            Semester
                                            <span class="text-danger">*</span>
                                        </label>
                                        <div class="d-flex">                                             
                                            @foreach(\App\Lib\SemesterType::TYPES as $semesterKey => $semesterType)
                                                <div class="form-check form-check-inline">
                                                    <label class="form-check-label" for="{{ $semesterKey }}">
                                                        <input class="form-check-input" name="semester_type" type="radio" id="{{ $semesterKey }}" value="{{ $semesterKey }}">
                                                        {{ $semesterType['label'] }}
                                                    </label>
                                                </div>
                                            @endforeach                       
                                        </div>                     
                                    </div>
                                </div>
                                <div class="col-md-6 customYear" style="display: none;">
                                    <div class="form-group">
                                        <label class="form-label">
                                            Year
                                            <span class="text-danger">*</span>
                                        </label>
                                        <input type="text" name="custom_year" class="form-control" />
                                    </div>
                                </div>
                                <div class="col-md-6 customDates" style="display: none;">
                                    <div class="form-group"> 
                                        <label class="form-label">
                                            Custom
                                            <span class="text-danger">*</span>
                                        </label>   
                                        <input type="text" class="form-control" name="custom_date" value="" />
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="starting_address" class="form-label">
                                            Starting Address
                                            <span class="text-danger">*</span>
                                        </label>
                                        <input type="text" class="form-control" name="starting_address" id="starting_address" placeholder="1234 Main St" required>
                                        <input type="hidden" name="starting_latitude" value="">
                                        <input type="hidden" name="starting_longitude" value="">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="destination_address" class="form-label">
                                            Destination Address
                                            <span class="text-danger">*</span>
                                        </label>
                                        <select class="destination_campus w-100" name="destination_address" id="destination_address" required>  
                                            <option value="">Select Campus</option>                                              
                                            @foreach (\App\Lib\DcuCampus::CAMPUSES as $campus)
                                                @php
                                                    $campus_name = $campus['label'] ?? '';
                                                @endphp
                                                <option value="{{ $campus_name }}" data-lat="{{ $campus['latitude'] ?? '' }}" data-lng="{{ $campus['longitude'] ?? '' }}">{{ $campus_name }}</option>                                                    
                                            @endforeach    
                                        </select>                                        
                                    </div>
                                    <input type="hidden" name="destination_latitude" value="">
                                    <input type="hidden" name="destination_longitude" value="">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">                        
                                        <label for="transport_method" class="form-label">
                                            Transport Mode
                                            <span class="text-danger">*</span>
                                        </label>
                                        <select class="transport_method w-100" name="transport_method" id="transport_method" required>
                                            @foreach (\App\Lib\TransportMode::MODES as $modeVal => $mode)
                                                <option value="{{ $modeVal }}">{{ $mode }}</option>                                                    
                                            @endforeach    
                                        </select>
                                    </div>                        
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="route_type" class="form-label">
                                            Route Type
                                            <span class="text-danger">*</span>
                                        </label>
                                        <select class="w-100" name="route_type" id="route_type" required>
                                            @foreach (\App\Lib\RouteType::TYPES as $routeKey => $routeType)
                                                <option value="{{ $routeKey }}">{{ $routeType }}</option>                                                    
                                            @endforeach    
                                        </select>
                                    </div>
                                </div> 
                            </div>
                            <div class="row workDays" style="display: none;">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="work_days" class="form-label">
                                            Work Days per week
                                            <span class="text-danger">*</span>
                                        </label>
                                        <input type="number" name="work_days" id="work_days" class="form-control" min="1" value="1" placeholder="Work Days">
                                    </div>
                                </div>
                            </div> 
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="route_distance" class="form-label">
                                            Distance (km)
                                            <span class="text-danger">*</span>
                                        </label>
                                        <input type="text" name="route_distance" id="route_distance" class="form-control" value="" placeholder="Distance" required readonly>
                                    </div>
                                </div>  
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="emission_value" class="form-label">
                                            CO2 (g)
                                        </label>
                                        <input type="text" id="carbon_emission_value" class="form-control" value="" placeholder="CO2" readonly>                                    
                                    </div>
                                </div> 
                            </div>             
                            <div class="col-md-12 text-right">
                                <button type="submit" class="btn btn-primary btn-block">Calculate</button>
                            </div>
                            <div class="text-secondary">
                                <strong>Note:</strong> Weekdays are not currently included in the carbon emission calculation.
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- <div class="untree_co-section count-numbers py-5"> --}}
    <div class="untree_co-section py-5">
        <div class="container">
            <h2 class="mb-3">Today Campuses Emission</h2>
            @if(count($todayCampusEmissionResult))
                @foreach($todayCampusEmissionResult as $campusEmission)
                    <div class="row shadow p-3 mb-5 bg-white rounded">
                        <div class="col-6 col-sm-6 col-md-6 col-lg-3 m-auto">
                            <div class="counter-wrap">
                                <div class="">
                                    <span class="fs-2" data-number="">{{ $campusEmission->campus_name }}</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-6 col-sm-6 col-md-6 col-lg-3">
                            <div class="counter-wrap">
                                <div class="counter">
                                    <span class="" data-number="">{{ convertInInteger($campusEmission->total_records) ?? 0 }}</span>
                                </div>
                                <span class="caption">No. of Vehicles</span>
                            </div>
                        </div>
                        <div class="col-6 col-sm-6 col-md-6 col-lg-3">
                            <div class="counter-wrap">
                                <div class="counter">
                                    <span class="" data-number="">{{ convertInInteger($campusEmission->total_distance) ?? 0}}</span>
                                </div>
                                <span class="caption">Total Distance(km)</span>
                            </div>
                        </div>
                        <div class="col-6 col-sm-6 col-md-6 col-lg-3">
                            <div class="counter-wrap">
                                <div class="counter">
                                    <span class="" data-number="">{{ convertInInteger($campusEmission->total_carbon_emission) ?? 0 }}</span>
                                </div>
                                <span class="caption">Quantity of Carbon Emissions(g)</span>
                            </div>
                        </div>				
                    </div>
                @endforeach
            @else
                <p class="text-secondary shadow p-3 mb-5 bg-white rounded">Sorry, No record found</p>
            @endif
        </div>
    </div>
@stop

@section('script')
    <script src="https://maps.google.com/maps/api/js?key={{ config('services.google.google_map_key')}}&libraries=places,geometry" type="text/javascript"></script>

    <script>
        google.maps.event.addDomListener(window, 'load', initializeStartingAddress); //initialize starting address

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
        
        let isCalculatorOpen = false;
        $(document).on('click', '.btn_carbon_calculator', function() {
            $(".carbon_calculator").slideToggle("slow", function() {
                isCalculatorOpen = !isCalculatorOpen;

                if (isCalculatorOpen) {
                    $("html, body").animate({
                        scrollTop: $(".carbon_calculator").offset().top
                    }, 300, "swing");                    
                }
            });
        });

        $('.destination_campus, #transport_method, #semester_year, #route_type').select2({
            width: '100%',
        });

        $(document).on('submit', '#carbon_form', function(e){
            e.preventDefault();

            const transportMethod = $('#transport_method').val();
            const workDistance = parseFloat($('#work_distance').val());
            const workDays = parseFloat($('#work_days').val());
            const weeksPerYear = 48;

            if (workDays > 0 && workDistance > 0 && transportMethod >= 0) {
                const co2eEmissions = (transportMethod * workDistance * 2 * workDays * weeksPerYear).toFixed(2);
                $('#emission_value').text(co2eEmissions + 'g');                
            }
        });

        $('#carbon_calculate_form').validate({
            rules: {
                starting_address: {
                    required: true,
                },
                starting_latitude: {
                    required: true,
                },
                starting_longitude: {
                    required: true,
                },
                destination_address: {
                    required: true,
                },
                destination_latitude: {
                    required: true,
                },
                destination_longitude: {
                    required: true,
                },
                transport_method: {
                    required: true,
                },
                route_type: {
                    required: true,
                },
                // work_days: {
                //     required: true,
                // },
                route_distance: {
                    required: true,
                }
            },
            submitHandler: function(form) {
                const transportMethod = $('#transport_method').val();
                const workDistance = parseFloat($('#route_distance').val());
                const routeType = parseFloat($('#route_type').val());
                const workDays = parseFloat($('#work_days').val());

                // if (workDays > 0 && workDistance > 0 && transportMethod >= 0) {
                if (workDistance > 0 && transportMethod >= 0) {
                    var formData = new FormData(form);
                    formData.append('get_emission', 1);
                    
                    var formBtn = $("#carbon_form button");
                    formBtn.attr('disabled',true); 

                    //get emission from ajax call 
                    $.ajax({
                        url: form.action,
                        type: form.method,
                        data: formData,
                        contentType: false,
                        processData: false,
                        success: function(response) {
                            formBtn.attr('disabled',false);
                            
                            if (response.success == "1") {
                                var emissionVal = response.data;
                                $('#carbon_emission_value').val(emissionVal); 
                                formData.delete('get_emission');

                                swal({
                                    title: "Carbon Emission Estimate: "+ emissionVal +"(g)",
                                    icon: "success",
                                    text: "Great job on your calculation! Want to save your results and explore more features? Log in to your account now and unlock personalized insights, history tracking, and more!",
                                    buttons: {
                                        cancel: true,
                                        confirm:  {
                                            text: "Login",
                                            value: true,
                                            visible: true
                                        },
                                    },
                                }).then(function(result){
                                    if(result){ 
                                        window.location.href = '{{ route('emission.index') }}';                               
                                    }
                                });
                            } else {
                                swal({
                                    title: "Got It!",
                                    text: response.message,
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
                    //end get emission from ajax call                  
                }
            }
        });

        $(document).on('change', '.destination_campus', function(){
            var campusVal = $(this).find(":selected");
            var campusLat = campusVal.attr('data-lat');
            var campusLng = campusVal.attr('data-lng');
            
            if (campusLat) {                    
                $('input[name="destination_latitude"]').val(campusLat);
                $('input[name="destination_longitude"]').val(campusLng);
                
                calculateDistance();                  
            }
        });

        function initializeStartingAddress() {
            var input = document.getElementById('starting_address');
            var autocomplete = new google.maps.places.Autocomplete(input);

            autocomplete.addListener('place_changed', function() {
                var place = autocomplete.getPlace();

                $('input[name="starting_latitude"]').val(place.geometry['location'].lat());
                $('input[name="starting_longitude"]').val(place.geometry['location'].lng());
                
                calculateDistance();                  
            });
        }

        function calculateDistance() {
            var startingLat = parseFloat($('input[name="starting_latitude"]').val());
            var startingLng = parseFloat($('input[name="starting_longitude"]').val());
            var destinationLat = parseFloat($('input[name="destination_latitude"]').val());
            var destinationLng = parseFloat($('input[name="destination_longitude"]').val());

            if (startingLat && startingLng && destinationLat && destinationLng) { 
                 // Define the start and end points of the route
                 var startingAddress = { 
                    lat: startingLat, 
                    lng: startingLng 
                };
    
                var destinationAddress = { 
                    lat: destinationLat, 
                    lng: destinationLng
                };

                // Create the DirectionsService and DirectionsRenderer objects
                var directionsService = new google.maps.DirectionsService();

                // Set up the route options for the car route
                var request = {
                    origin: startingAddress,
                    destination: destinationAddress,
                    travelMode: google.maps.TravelMode['DRIVING'] // Car Driving mode for route
                };
    
                // Call the Directions API to calculate the route
                directionsService.route(request, function (result, status) {
                    if (status === google.maps.DirectionsStatus.OK) {
                        var mapRoute = result.routes[0];
                        var routeDistance = (mapRoute.legs[0].distance.value)/1000;
                        var routeDuration = (mapRoute.legs[0].duration.value)/1000;
                        $('#route_distance').val(routeDistance);
                    } else {
                        alert('Could not display directions: ' + status);
                    }
                });
            }
        }
   </script>
@endsection