@extends('frontend.master.master')

@section('keyTitle','Home')

@section('contents')

@include('frontend.contents.mobile-nav')
@include('frontend.contents.slider')
@include('frontend.contents.best_selling_products')
@include('frontend.contents.sbann')
@include('frontend.contents.new_arrivals')
@include('frontend.contents.amenities')
@include('frontend.contents.special_banner')





@endsection