@extends('segment.layouts.main')

@section('customCSS')
    @include('segment.layouts.asset_include_links.datatable.css.datatable_css')
    @include('segment.layouts.asset_include_links.select2.css.select2_css')
    @include('segment.layouts.asset_include_links.sweetAlert.css.sweet_alert_css')
    @include('segment.layouts.asset_include_links.form_wizard.css.form-wizard-css')
    @include('segment.layouts.asset_include_links.date_time.css.datetime_css')

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
                        <h2 class="content-header-title float-left mb-0">Penilaian</h2>
                        <div class="breadcrumb-wrapper">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="#">Penilaian</a>
                                </li>
                                <li class="breadcrumb-item active">Senarai
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
                            <!--
                            <div class="card-header border-bottom p-1">
                                <div class="head-label">
                                   
                                </div>
                                <div class="dt-action-buttons text-right">
                                    <div class="dt-buttons">
                                        <button type="button" class="create-new btn btn-warning"><i class="mr-50" data-feather='plus'></i><span>Tambah Baru</span></button>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                
                            </div>
                            -->
                            <table class="dictionary-bank-table table">
                                <thead>
                                    <tr>
                                        <th>Tajuk</th>
                                        <th>Tarikh Mula</th>
                                        <th>Tarikh Akhir</th>
                                        <th>Status</th>
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
    @include('segment.admin.dictionary.bank.modals.index')
@endsection

@section('customJS')
    {{--  Vendor files  --}}
    @include('segment.layouts.asset_include_links.datatable.js.datatable_js')
    @include('segment.layouts.asset_include_links.common.js.common_js')
    @include('segment.layouts.asset_include_links.select2.js.select2_js')
    @include('segment.layouts.asset_include_links.sweetAlert.js.sweet_alert_js')
    @include('segment.layouts.asset_include_links.form_wizard.js.form-wizard-js')
    @include('segment.layouts.asset_include_links.date_time.js.datetime_js')


    {{--  Custom files  --}}
    <script src="{{ asset('js_helper/segment/admin/dictionary/bank/swal.js') }}"></script>
    <script src="{{ asset('js_helper/segment/admin/dictionary/bank/page_settings.js') }}"></script>
    <script src="{{ asset('js_helper/segment/admin/dictionary/bank/datatable.js') }}"></script>
    <script src="{{ asset('js_helper/segment/admin/dictionary/bank/ajax.js') }}"></script>
    <script src="{{ asset('js_helper/segment/admin/dictionary/bank/index.js') }}"></script>
@endsection