@extends('dashboard.layouts.main')
@section('dashboard-css')
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
    <link rel="stylesheet" href="{{ asset('assets/dashboard/leaflet/leaflet.css') }}"/>
@stop
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
    <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.min.js"></script>
    <script src="{{ asset('assets/dashboard/leaflet/leaflet.js') }}"></script>

    <script> 
        var map,polyline;       
        $('#transport_method').select2();

        $(document).on('change', '#travel_mode', function() {
            drawLineOnMap();
        });


        function drawMap() {
            var zoomLatitude = 53.3498053;  // centered dublin
            var zoomLongitude = -6.2603097;  // centered dublin

            if (map) {
                map.remove(); // Destroys the existing map instance
            }

            map = L.map('map', {
                center: [zoomLatitude, zoomLongitude],
                zoom: 13
            });

            L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
            }).addTo(map);

            L.marker([zoomLatitude, zoomLongitude]).addTo(map)
                // .bindPopup('Dublin')
                .openPopup();
                
        }

        function drawLineOnMap() {
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
                
                var latlngs = [
                    [startingLat, startingLng],
                    [destinationLat, destinationLng]
                ];

                // Define two points
                var startRouteDistance = L.latLng(startingLat, startingLng);
                var endRouteDistance = L.latLng(destinationLat, destinationLng);

                var routeDistance = (startRouteDistance.distanceTo(endRouteDistance))/1000; //in kilometers

                if (polyline) {
                    polyline.remove();      //remove lines if exists              
                }

                polyline = L.polyline(latlngs, {color: 'red'}).addTo(map);
                
                // zoom the map to the polyline
                map.fitBounds(polyline.getBounds());
                $('#route_distance').val(routeDistance.toFixed(2));
            }
        }

        async function getAddress(serachText) {
            const res = [];
            
            try {
                const response = await fetch(`https://api.geoapify.com/v1/geocode/autocomplete?text=${serachText}&apiKey={{ config('services.geoapify.api_key')}}`);
                const result = await response.json();

                const features = result.features || [];
                features.forEach(feature => {
                    const feature_prop = feature.properties;
                    const full_address = feature_prop.formatted;
                    const latitude = feature_prop.lat;
                    const longitude = feature_prop.lon;

                    if (full_address) {
                        res.push({ label: full_address, latitude: latitude, longitude: longitude });
                    }
                });
            } catch (error) {
                console.error("Error fetching data:", error);
            }

            return res; 
        }
        
        $(document).ready(function(){
            setTimeout(() => {
                drawMap();
            }, 1000);

            $("#starting_address").autocomplete({
                source: function(request, response) {
                    getAddress(request.term).then(getAddresses => {
                        response(getAddresses);
                    }).catch(error => {
                        console.error("Error:", error);
                    });
                },
                minLength: 2, // Start searching after 2 characters

                select: function (e, selected) {
                    var selectedItem = selected.item;
                    $('input[name="starting_latitude"]').val(selectedItem.latitude);
                    $('input[name="starting_longitude"]').val(selectedItem.longitude);

                    drawLineOnMap();
                },
                // ,

                // change: function (e, ui) {

                //     alert("changed!");
                // }
            });

            $("#destination_address").autocomplete({
                source: function(request, response) {
                    getAddress(request.term).then(getAddresses => {
                        response(getAddresses);
                    }).catch(error => {
                        console.error("Error:", error);
                    });
                },
                minLength: 2, // Start searching after 2 characters

                select: function (e, selected) {
                    var selectedItem = selected.item;
                    $('input[name="destination_latitude"]').val(selectedItem.latitude);
                    $('input[name="destination_longitude"]').val(selectedItem.longitude);

                    drawLineOnMap();
                }
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

                                    swal({
                                        title: "Got It!",
                                        text: response.message || "You Have Successfully Calculated.",
                                        icon: "success",
                                        button: "Ok",
                                    }).then(                                        
                                        function() {
                                            form.reset();
                                        }
                                    );
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
        });
    </script>
@stop