@extends('segment.layouts.main')

@section('customCSS')
    @include('segment.layouts.asset_include_links.datatable.css.datatable_css')
    @include('segment.layouts.asset_include_links.select2.css.select2_css')
    @include('segment.layouts.asset_include_links.sweetAlert.css.sweet_alert_css')
    {{-- @include('segment.layouts.asset_include_links.form_wizard.css.form-wizard-css') --}}
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
                                <li class="breadcrumb-item active">Senarai Soalan
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
                            <table class="item-bank-table table">
                                <thead>
                                    <tr>
                                        <th>Tahap Pengukuran</th>
                                        <th>Jenis Kecekapan</th>
                                        <th>Kategori Gred</th>
                                        <th>Jurusan</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                            </table>
                            <input type="hidden" id="hdn_dict_bank_id" value="{{$dict_bank_id}}">
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>
   {{--  @include('segment.admin.dictionary.bank.modals.question') --}}
    @include('segment.admin.dictionary.bank.modals.items')
@endsection

@section('customJS')
    {{--  Vendor files  --}}
    @include('segment.layouts.asset_include_links.datatable.js.datatable_js')
    @include('segment.layouts.asset_include_links.common.js.common_js')
    @include('segment.layouts.asset_include_links.select2.js.select2_js')
    @include('segment.layouts.asset_include_links.sweetAlert.js.sweet_alert_js')
    {{-- @include('segment.layouts.asset_include_links.form_wizard.js.form-wizard-js') --}}
    @include('segment.layouts.asset_include_links.date_time.js.datetime_js')


    {{--  Custom files  --}}
    <script src="{{ asset('js_helper/segment/admin/dictionary/item/swal.js') }}"></script>
    <script src="{{ asset('js_helper/segment/admin/dictionary/item/page_settings.js') }}"></script>
    <script src="{{ asset('js_helper/segment/admin/dictionary/item/datatable.js') }}"></script>
    <script src="{{ asset('js_helper/segment/admin/dictionary/item/ajax.js') }}"></script>
    <script src="{{ asset('js_helper/segment/admin/dictionary/item/index.js') }}"></script>
@endsection