@extends('layouts.main')
@section('title')
    User Info
@stop
@section('content')
    <div class="hero hero-inner">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6 mx-auto text-center">
                    <div class="intro-wrap">
                        <h1 class="mb-0">User Info</h1>
                        <p class="text-white">Lorem ipsum dolor, sit amet consectetur adipisicing elit. Est cum molestiae accusantium reiciendis commodi ab hic maxime sequi, accusamus provident, nulla iure! Rem reprehenderit reiciendis porro incidunt veritatis similique illo. </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="untree_co-section">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <form class="row g-3">                        
                        <div class="col-12">
                            <label for="userType" class="form-label">Type</label>
                            <select id="userType" class="form-select form-control">
                                <option value="#" selected>Choose...</option>
                                <option>...</option>
                            </select>
                        </div>                        
                        
                        <div class="col-12">
                          <button type="submit" class="btn btn-primary">Update</button>
                        </div>
                    </form>                    
                </div>
            </div>
        </div>
    </div>
@stop