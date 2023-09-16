@section('title',$title)
@section('description',$description)
@extends('layouts.app')
@section('content')
    <div class="dm-page-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <div class="breadcrumb-main">
                        <h4 class="text-capitalize breadcrumb-title">{{ trans('menu.map-vector') }}</h4>
                        <div class="breadcrumb-action justify-content-center flex-wrap">
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="#"><i class="las la-home"></i>Home</a></li>
                                    <li class="breadcrumb-item active"
                                        aria-current="page">{{ trans('menu.map-vector') }}</li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                </div>
                <div class="col-12">
                    <div class="card card-default card-md mb-4">
                        <div class="card-header">
                            <h6>World Map</h6>
                        </div>
                        <div class="card-body">
                            <div id="world-map"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
