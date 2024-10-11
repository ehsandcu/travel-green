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
                                <div id="map" style="width: 100%; height: 900px;"></div>                            
                            </div>                            
                        </div>              
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop
@section('dashboard-script')
    <script src="https://maps.google.com/maps/api/js?key={{ config('services.google.google_map_key')}}&libraries=places" type="text/javascript"></script>

    <script>
        setTimeout(() => {
            drawMap()
        }, 1000);

        function drawMap() {
            var zoomLatitude = 36.778259;  // centered California US
            var zoomLongitude = -119.417931;  // centered California US

            var mapOptions = {
                zoom: 14,
                center: new google.maps.LatLng(zoomLatitude, zoomLongitude), // centered US
                mapTypeId: google.maps.MapTypeId.ROADMAP,
            };

            var map = new google.maps.Map(document.getElementById('map'), mapOptions);

            var infowindow = new google.maps.InfoWindow();

            var marker = new google.maps.Marker({
                position: new google.maps.LatLng(zoomLatitude, zoomLongitude),
                map: map
            });
        }
    </script>
@stop