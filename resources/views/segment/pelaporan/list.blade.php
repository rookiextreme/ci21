@extends('segment.layouts.main')

@section('customCSS')
    @include('segment.layouts.asset_include_links.datatable.css.datatable_css')
    @include('segment.layouts.asset_include_links.select2.css.select2_css')
    @include('segment.layouts.asset_include_links.sweetAlert.css.sweet_alert_css')
@endsection

@section('content')
    <div class="app-content content ">
        <div class="content-overlay"></div>
        <div class="header-navbar-shadow"></div>
        <div class="content-wrapper container-xxl p-0">
            <div class="content-header row">
                <div class="content-header-left col-md-9 col-12 mb-2">
                    <div class="row breadcrumbs-top">
                        <div class="col-12">
                            <h2 class="content-header-title float-left mb-0">Pelaporan</h2>
                            <div class="breadcrumb-wrapper">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item active"><a href="#">Pelaporan</a>
                                    </li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="content-body">
                <div class="row">
                    <div class="col-md-3">
                        <div class="card">
                            <img class="card-img-top" src="../../../app-assets/images/slider/05.jpg" alt="Card image cap" />
                            <div class="card-body">
                                <h4 class="card-title" style="text-align: center"><a href="{{url('/pelaporan/analisis-jurang-standard/0')}}">Laporan Analisis Jurang<br> (Standard Position)</a></h4>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card">
                            <img class="card-img-top" src="../../../app-assets/images/slider/05.jpg" alt="Card image cap" />
                            <div class="card-body">
                                <h4 class="card-title" style="text-align: center"><a href="{{url('/pelaporan/analisis-jurang-standard/1')}}">Laporan Analisis Jurang<br> (Actual Position)</a></h4>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card">
                            <img class="card-img-top" src="../../../app-assets/images/slider/05.jpg" alt="Card image cap" />
                            <div class="card-body">
                                <h4 class="card-title" style="text-align: center">Graf Laporan Analisis Jurang<br> (Standard Position)</h4>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card">
                            <img class="card-img-top" src="../../../app-assets/images/slider/05.jpg" alt="Card image cap" />
                            <div class="card-body">
                                <h4 class="card-title" style="text-align: center">Graf Laporan Analisis Jurang<br> (Actual Position)</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('segment.admin.setting.grade.modals.index')
@endsection

@section('customJS')
    {{--  Vendor files  --}}
    @include('segment.layouts.asset_include_links.datatable.js.datatable_js')
    @include('segment.layouts.asset_include_links.common.js.common_js')
    @include('segment.layouts.asset_include_links.select2.js.select2_js')
    @include('segment.layouts.asset_include_links.sweetAlert.js.sweet_alert_js')

    {{--  Custom files  --}}
    <script src="{{ asset('js_helper/segment/admin/setting/grade/swal.js') }}"></script>
    <script src="{{ asset('js_helper/segment/admin/setting/grade/page_settings.js') }}"></script>
    <script src="{{ asset('js_helper/segment/admin/setting/grade/datatable.js') }}"></script>
    <script src="{{ asset('js_helper/segment/admin/setting/grade/ajax.js') }}"></script>
    <script src="{{ asset('js_helper/segment/admin/setting/grade/index.js') }}"></script>
@endsection
