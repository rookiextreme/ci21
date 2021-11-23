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
            <div class="misc-wrapper">
                <div class="misc-inner p-2 p-sm-3">
                    <div class="w-100 text-center">
                        <h2 class="mb-1">Anda Telah Berjaya Menjawab Penilaian Ini 🚀</h2>
                        <p class="mb-3">Anda Boleh Menghantar Atau Kemaskini Jawapan</p>
                        <div class="row">
                            <div class="col-md-6">
                                <button class="btn btn-warning kemaskini-score" style="width: 50%;float:right">Kemaskini</button>
                            </div>
                            <div class="col-md-6">
                                <button class="btn btn-success hantar-score" style="width: 50%;float:left">Hantar</button>
                            </div>
                        </div>
                        <img class="img-fluid" src="{{ asset('templates/app-assets/images/pages/coming-soon.svg') }}" alt="Coming soon page" />
                    </div>
                </div>
            </div>
        </div>
    </div>
    <input type="hidden" class="penilaian-id" value="{{$penilaian_id}}">
@endsection

@section('customJS')
    {{--  Vendor files  --}}
    @include('segment.layouts.asset_include_links.datatable.js.datatable_js')
    @include('segment.layouts.asset_include_links.common.js.common_js')
    @include('segment.layouts.asset_include_links.select2.js.select2_js')
    @include('segment.layouts.asset_include_links.sweetAlert.js.sweet_alert_js')
    @include('segment.layouts.asset_include_links.date_time.js.datetime_js')

    {{--  Custom files  --}}
    <script src="{{ asset('js_helper/segment/pengguna/penilaianscore/penilaiancomplete/swal.js') }}"></script>
    <script src="{{ asset('js_helper/segment/pengguna/penilaianscore/penilaiancomplete/page_settings.js') }}"></script>
    <script src="{{ asset('js_helper/segment/pengguna/penilaianscore/penilaiancomplete/datatable.js') }}"></script>
    <script src="{{ asset('js_helper/segment/pengguna/penilaianscore/penilaiancomplete/ajax.js') }}"></script>
    <script src="{{ asset('js_helper/segment/pengguna/penilaianscore/penilaiancomplete/index.js') }}"></script>
@endsection
