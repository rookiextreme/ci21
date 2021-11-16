@extends('segment.layouts.main')

@section('customCSS')
    @include('segment.layouts.asset_include_links.datatable.css.datatable_css')
    @include('segment.layouts.asset_include_links.select2.css.select2_css')
    @include('segment.layouts.asset_include_links.sweetAlert.css.sweet_alert_css')
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
                                    <li class="breadcrumb-item active"><a href="#">Konfigurasi Penilaian</a>
                                    </li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="content-body">
                <section id="page-account-settings">
                    <div class="row">
                        <!-- left menu section -->
                        <div class="col-md-3 mb-2 mb-md-0">
                            <ul class="nav nav-pills flex-column nav-left">
                                <li class="nav-item">
                                    <a class="nav-link" id="account-pill-competency-type-set" data-toggle="pill" href="#account-vertical-competency-type-set" aria-expanded="false">
                                        <i data-feather="type" class="font-medium-3 mr-1"></i>
                                        <span class="font-weight-bold">Competency Type Set</span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="account-pill-scale-level" data-toggle="pill" href="#account-vertical-scale-level" aria-expanded="false">
                                        <i data-feather="box" class="font-medium-3 mr-1"></i>
                                        <span class="font-weight-bold">Scale Level</span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="account-pill-grade-category" data-toggle="pill" href="#account-vertical-grade-category" aria-expanded="false">
                                        <i data-feather="command" class="font-medium-3 mr-1"></i>
                                        <span class="font-weight-bold">Grade Category</span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="account-pill-measuring-lvl" data-toggle="pill" href="#account-vertical-measuring-lvl" aria-expanded="false">
                                        <i data-feather="tool" class="font-medium-3 mr-1"></i>
                                        <span class="font-weight-bold">Measuring Level</span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link active" id="account-pill-setting" data-toggle="pill" href="#account-vertical-setting" aria-expanded="false">
                                        <i data-feather="zap" class="font-medium-3 mr-1"></i>
                                        <span class="font-weight-bold">Setting</span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ Request::root() }}/admin/dictionary/bank/penilaian/job-group/{{$penilaian_id}}">
                                        <i data-feather="zap" class="font-medium-3 mr-1"></i>
                                        <span class="font-weight-bold">Job Group</span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                        <!--/ left menu section -->

                        <!-- right content section -->
                        <div class="col-md-9">
                            <div class="card">
                                <div class="card-body">
                                    <div class="tab-content">

                                        <!-- Competency Type Set tab -->
                                        <div role="tabpanel" class="tab-pane" id="account-vertical-competency-type-set" aria-labelledby="account-pill-competency-type-set" aria-expanded="true">
                                            <section id="basic-datatable">
                                                <div class="row">
                                                    <div class="col-12">
                                                        <div class="card">
                                                            <table class="competency-type-set-table table">
                                                                <thead>
                                                                <tr>
                                                                    <th>Competency</th>
                                                                    <th>Scale Level</th>
                                                                    <th>Aktif</th>
                                                                    <th>Aksi</th>
                                                                </tr>
                                                                </thead>
                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>
                                            </section>
                                            <!-- header media -->
                                        </div>
                                        <!--/ Measuring Level tab -->
                                        <div role="tabpanel" class="tab-pane" id="account-vertical-measuring-lvl" aria-labelledby="account-pill-measuring-lvl" aria-expanded="true">
                                            <section id="basic-datatable">
                                                <div class="row">
                                                    <div class="col-12">
                                                        <div class="card">
                                                            <table class="measuring-lvl-table table">
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
                                            <!-- header media -->
                                        </div>
                                        <div role="tabpanel" class="tab-pane" id="account-vertical-grade-category" aria-labelledby="account-pill-grade-category" aria-expanded="true">
                                            <section id="basic-datatable">
                                                <div class="row">
                                                    <div class="col-12">
                                                        <div class="card">
                                                            <table class="grade-category-table table">
                                                                <thead>
                                                                <tr>
                                                                    <th>Nama</th>
                                                                    <th>Jumlah Gred</th>
                                                                    <th>Aktif</th>
                                                                    <th>Aksi</th>
                                                                </tr>
                                                                </thead>
                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>
                                            </section>
                                            <!-- header media -->
                                        </div>
                                        <div role="tabpanel" class="tab-pane" id="account-vertical-scale-level" aria-labelledby="account-pill-scale-level" aria-expanded="true">
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
                                            <!-- header media -->
                                        </div>
                                        <div role="tabpanel" class="tab-pane active" id="account-vertical-setting" aria-labelledby="account-pill-setting" aria-expanded="true">
                                            <h4>Competency Type</h4>
                                            <section id="basic-datatable">
                                                <div class="row">
                                                    <div class="col-12">
                                                        <div class="card">
                                                            <table class="competency-type-table table">
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
                                            <hr>
                                            <h4>Scale Level Skillsets</h4>
                                            <section id="basic-datatable">
                                                <div class="row">
                                                    <div class="col-12">
                                                        <div class="card">
                                                            <table class="scale-skill-set-table table">
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
                                            <!-- header media -->
                                        </div>
                                        <!--/ Competency Type Set tab -->
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--/ right content section -->
                    </div>
                </section>
            </div>
        </div>
    </div>
    @include('segment.admin.dictionarybank.penilaianconfig.modals.index')
    <input type="hidden" class="penilaian_id" value="{{$penilaian_id}}">
@endsection

@section('customJS')
    {{--  Vendor files  --}}
    @include('segment.layouts.asset_include_links.datatable.js.datatable_js')
    @include('segment.layouts.asset_include_links.common.js.common_js')
    @include('segment.layouts.asset_include_links.select2.js.select2_js')
    @include('segment.layouts.asset_include_links.sweetAlert.js.sweet_alert_js')
    @include('segment.layouts.asset_include_links.date_time.js.datetime_js')


    {{--  Custom files  --}}
    <script src="{{ asset('js_helper/segment/admin/dictionarybank/penilaianconfig/swal.js') }}"></script>
    <script src="{{ asset('js_helper/segment/admin/dictionarybank/penilaianconfig/page_settings.js') }}"></script>
    <script src="{{ asset('js_helper/segment/admin/dictionarybank/penilaianconfig/datatable.js') }}"></script>
    <script src="{{ asset('js_helper/segment/admin/dictionarybank/penilaianconfig/ajax.js') }}"></script>
    <script src="{{ asset('js_helper/segment/admin/dictionarybank/penilaianconfig/index.js') }}"></script>
@endsection

