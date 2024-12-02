@extends('dashboard.layouts.main')

@section('dashboard_content')
    <div class="row">    
        <div class="col-lg-12 d-flex grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex flex-wrap justify-content-between">
                        <h4 class="card-title mb-3">Carbon Emission</h4>
                    </div>
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="d-sm-flex justify-content-between">
                                <div id="floating-panel">
                                    <b>Mode of Travel: </b>
                                    <select id="travel_mode">
                                      <option value="DRIVING">Driving</option>
                                      <option value="WALKING">Walking</option>
                                      <option value="BICYCLING">Bicycling</option>
                                      <option value="TRANSIT">Transit</option>
                                    </select>
                                  </div>
                                <div id="map" style="width: 100%; height: 700px;"></div>                            
                            </div>                            
                        </div>              
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12 grid-margin">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Calculate Carbon Emission</h4>                  
                    <form id="carbon_form" method="POST" action="{{ route('emission.store') }}"> 
                        @csrf
                        <div class="row g-3">
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
                                    <input type="text" class="form-control" name="destination_address" id="destination_address" placeholder="1234 Main St" required>
                                    <input type="hidden" name="destination_latitude" value="">
                                    <input type="hidden" name="destination_longitude" value="">
                                </div>
                            </div>
                        </div>
                        <div class="row g-3">
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
                                    <label for="work_days" class="form-label">
                                        Work Days per week
                                        <span class="text-danger">*</span>
                                    </label>
                                    <input type="number" name="work_days" id="work_days" class="form-control" min="1" value="1" placeholder="Work Days" required>
                                </div>
                            </div>
                        </div> 
                        <div class="row g-3 mb-3">
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
                                        CO2e per year (kg)
                                    </label>
                                    <input type="text" id="emission_value" class="form-control" value="" placeholder="CO2e per year" readonly>                                    
                                </div>
                            </div> 
                        </div>             
                        <div class="col-md-12 mt-3 text-right">
                            <button type="submit" class="btn btn-info btn-rounded btn-fw">Calculate</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@stop
@section('dashboard-script')
    <script src="https://maps.google.com/maps/api/js?key={{ config('services.google.google_map_key')}}&libraries=places,geometry" type="text/javascript"></script>

    <script>
        var map,directionsRenderer;

        setTimeout(() => {
            drawMap();
        }, 1000);
        
        google.maps.event.addDomListener(window, 'load', initializeStartingAddress);
        google.maps.event.addDomListener(window, 'load', initializeDestinationAddress);
        
        $('#transport_method').select2();

        $(document).on('change', '#travel_mode', function() {
            drawLineOnMap();
        });

        $("#carbon_form").validate({
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
                work_days: {
                    required: true,
                },
                route_distance: {
                    required: true,
                }
            },
            submitHandler: function(form) {
                const transportMethod = $('#transport_method').val();
                const workDistance = parseFloat($('#route_distance').val());
                const workDays = parseFloat($('#work_days').val());
                const weeksPerYear = 48;

                if (workDays > 0 && workDistance > 0 && transportMethod >= 0) {
                    const co2eEmissions = (transportMethod * workDistance * 2 * workDays * weeksPerYear).toFixed(2);
                    $('#emission_value').val(co2eEmissions);  
                    
                    var formData = new FormData(form);
                    var formBtn = $("button");
                    formBtn.attr('disabled',true);
                    
                    $.ajax({
                        url: form.action,
                        type: form.method,
                        data: formData,
                        contentType: false,
                        processData: false,
                        success: function(response) {
                            formBtn.attr('disabled',false);
                            if (response.success == "1") {
                                drawMap();
                                form.reset();

                                swal({
                                    title: "Got It!",
                                    text: response.message || "You Have Successfully Calculated.",
                                    icon: "success",
                                    button: "Ok",
                                    timer: 1500,
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
                }
            }
        });

        function drawMap() {
            var zoomLatitude = 53.3498053;  // centered dublin
            var zoomLongitude = -6.2603097;  // centered dublin

            var mapOptions = {
                zoom: 14,
                center: new google.maps.LatLng(zoomLatitude, zoomLongitude), // centered Dublin
                mapTypeId: google.maps.MapTypeId.ROADMAP,
            };

            map = new google.maps.Map(document.getElementById('map'), mapOptions);

            var infowindow = new google.maps.InfoWindow();

            var marker = new google.maps.Marker({
                position: new google.maps.LatLng(zoomLatitude, zoomLongitude),
                map: map
            });
        }

        function initializeStartingAddress() {
            var input = document.getElementById('starting_address');
            var autocomplete = new google.maps.places.Autocomplete(input);

            autocomplete.addListener('place_changed', function() {
                var place = autocomplete.getPlace();

                $('input[name="starting_latitude"]').val(place.geometry['location'].lat());
                $('input[name="starting_longitude"]').val(place.geometry['location'].lng());

                drawLineOnMap();
            });
        }

        function initializeDestinationAddress() {
            var input = document.getElementById('destination_address');
            var autocomplete = new google.maps.places.Autocomplete(input);

            autocomplete.addListener('place_changed', function() {
                var place = autocomplete.getPlace();
              
                $('input[name="destination_latitude"]').val(place.geometry['location'].lat());
                $('input[name="destination_longitude"]').val(place.geometry['location'].lng());

                drawLineOnMap();
            });
        }

        function drawLineOnMap() {
            var startingLat = parseFloat($('input[name="starting_latitude"]').val());
            var startingLng = parseFloat($('input[name="starting_longitude"]').val());
            var destinationLat = parseFloat($('input[name="destination_latitude"]').val());
            var destinationLng = parseFloat($('input[name="destination_longitude"]').val());
            var selectedTravelMode = $('#travel_mode').val();

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

                if (directionsRenderer && google.maps.DirectionsStatus.OK) {
                    directionsRenderer.setDirections({ routes: [] }); // Clear previous route from the map                    
                }

                directionsRenderer = new google.maps.DirectionsRenderer({
                    map: map,
                    polylineOptions: {
                        strokeColor: '#FF0000',  // Red path color
                        strokeOpacity: 0.7,      // Path opacity
                        strokeWeight: 6          // Path thickness
                    }
                });
    
                // Set up the route options for the car route
                var request = {
                    origin: startingAddress,
                    destination: destinationAddress,
                    travelMode: google.maps.TravelMode[selectedTravelMode] // Driving mode for route
                };
    
                // Call the Directions API to calculate the route
                directionsService.route(request, function (result, status) {
                    if (status === google.maps.DirectionsStatus.OK) {
                        var mapRoute = result.routes[0];
                        var routeDistance = (mapRoute.legs[0].distance.value)/1000;
                        var routeDuration = (mapRoute.legs[0].duration.value)/1000;
                        $('#route_distance').val(routeDistance);
                        directionsRenderer.setDirections(result); // Display the route on the map
                    } else {
                        alert('Could not display directions: ' + status);
                    }
                });
                var service = new google.maps.DistanceMatrixService();

                // Calculate distance
                // service.getDistanceMatrix({
                //     origins: [startingAddress],
                //     destinations: [destinationAddress],
                //     travelMode: google.maps.TravelMode[selectedTravelMode],
                // }, function(response, status) {
                //     if (status === google.maps.DistanceMatrixStatus.OK) {
                //         var distance = response.rows[0].elements[0].distance.text;
                //         var duration = response.rows[0].elements[0].duration.text;

                //         console.log(distance, duration);
                //         $('#result').html(`Distance: ${distance}, Duration: ${duration}`);
                //     } else {
                //         $('#result').html('Error: ' + status);
                //     }
                // });             
            }
        }
    </script>
@stop