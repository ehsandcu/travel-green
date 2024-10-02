@extends('layouts.main')
@section('css')
    <style>
        .hero .slides img{
            width: 100%;
            height: inherit;
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
                                <form class="form">
                                    <div class="row mb-2">
                                        <div class="col-sm-12 col-md-6 mb-3 mb-lg-0 col-lg-4">
                                            <select name="" id="" class="form-control custom-select">
                                                <option value="">DCU</option>
                                                <option value="">DCU</option>
                                                <option value="">DCU</option>
                                                <option value="">DCU</option>                                                
                                            </select>
                                        </div>
                                        <div class="col-sm-12 col-md-6 mb-3 mb-lg-0 col-lg-5">
                                            <input type="text" class="form-control" name="daterange">
                                        </div>
                                        <div class="col-sm-12 col-md-6 mb-3 mb-lg-0 col-lg-3">
                                            <input type="text" class="form-control" placeholder="# of People">
                                        </div>

                                    </div>    
                                    <div class="row align-items-center">
                                        <div class="col-sm-12 col-md-6 mb-3 mb-lg-0 col-lg-4">
                                            <input type="submit" class="btn btn-primary btn-block" value="Calculate">
                                        </div>
                                        {{-- <div class="col-lg-8">
                                            <label class="control control--checkbox mt-3">
                                                <span class="caption">Save this search</span>
                                                <input type="checkbox" checked="checked" />
                                                <div class="control__indicator"></div>
                                            </label>
                                        </div> --}}
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
@endsection