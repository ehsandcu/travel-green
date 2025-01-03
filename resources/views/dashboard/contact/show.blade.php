@extends('dashboard.layouts.main')
@section('dashboard_content')
    <div class="row">
        <div class="col-12 grid-margin">
            <div class="card">
                <div class="card-body">
                    <div class="mb-3">
                        <a href="{{ route('dashboard.contact.us') }}">
                            <button class="btn btn-info btn-sm"><i class="typcn typcn-arrow-left"></i>Back</button>
                        </a>
                    </div>
                    <h4 class="card-title">Contact Us</h4>
                    <div class="row g-3">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="form-label">Name</label>
                                <input type="text" class="form-control" value="{{ $getContact->name ?? '' }}" readonly>                                    
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="form-label">Email</label>                                    
                                <input type="text" class="form-control" value="{{ $getContact->email ?? '' }}" readonly>
                            </div>                               
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="form-label">Received At</label>                                    
                                <input type="text" class="form-control" value="{{ $getContact->received_at }}" readonly>
                            </div>                               
                        </div>
                    </div>
                    <div class="row g-3">
                        <div class="col-md-12">
                            <div class="form-group">                        
                                <label for="transport_method" class="form-label">Message</label>
                                <textarea class="form-control" cols="30" rows="10" readonly>{{ $getContact->message ?? '' }}</textarea>
                            </div>                        
                        </div>
                    </div> 
                </div>
            </div>
        </div>
    </div>
@stop
@section('dashboard-script')
    <script>
        $(document).ready(function(){
            $('.nav .nav-item').removeClass('active');
        })
    </script>
@stop