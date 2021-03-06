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
                            <h2 class="content-header-title float-left mb-0">Dictionary</h2>
                            <div class="breadcrumb-wrapper">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="#">Collection</a>
                                    </li>
                                    <li class="breadcrumb-item active">Scale Level
                                    </li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="content-body">
                <section id="basic-datatable">
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <table class="scale-level-table table">
                                    <thead>
                                    <tr>
                                        <th>Nama</th>
                                        <th>Aktif</th>
                                        <th>Aksi</th>
                                    </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </div>
    @include('segment.admin.dictionary.scalelvl.modals.index')
@endsection

@section('customJS')
    {{--  Vendor files  --}}
    @include('segment.layouts.asset_include_links.datatable.js.datatable_js')
    @include('segment.layouts.asset_include_links.common.js.common_js')
    @include('segment.layouts.asset_include_links.select2.js.select2_js')
    @include('segment.layouts.asset_include_links.sweetAlert.js.sweet_alert_js')

    {{--  Custom files  --}}
    <script src="{{ asset('js_helper/segment/admin/dictionary/scalelvl/swal.js') }}"></script>
    <script src="{{ asset('js_helper/segment/admin/dictionary/scalelvl/page_settings.js') }}"></script>
    <script src="{{ asset('js_helper/segment/admin/dictionary/scalelvl/datatable.js') }}"></script>
    <script src="{{ asset('js_helper/segment/admin/dictionary/scalelvl/ajax.js') }}"></script>
    <script src="{{ asset('js_helper/segment/admin/dictionary/scalelvl/index.js') }}"></script>

@endsection
