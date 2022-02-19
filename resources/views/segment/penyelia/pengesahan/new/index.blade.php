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
                            <h2 class="content-header-title float-left mb-0">Penyelia</h2>
                            <div class="breadcrumb-wrapper">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="#">Pengesahan Baru</a>
                                    </li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="content-body">
                <div class="row" id="table-bordered">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">Pengesahan Baru Dihantar</h4>
                            </div>

                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>Name</th>
                                            <th>Nokp</th>
                                            <th>Standard Gred/ Actual Gred</th>
                                            <th>Tarikh Selesai</th>
                                            <th>Tindakan</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if(count($penilaian) > 0)
                                            @foreach($penilaian as $p)
                                                <tr style="text-align: center">
                                                    <td>{{$p->profile_Users->profile_Users->name}}</td>
                                                    <td>{{$p->profile_Users->profile_Users->nokp}}</td>
                                                    <td>{{$p->standard_gred}} / {{$p->actual_gred}}</td>
                                                    <td>{{$p->updated_at}}</td>
                                                    <td>
                                                        <a href="{{ url('/penyelia/pengesahan/result/'.$p->profiles_id.'/'.$p->id.'')}}" style="text-decoration: underline">Pengesahan</a>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @else
                                            <tr>
                                                <td colspan="5" style="text-align: center">
                                                    Tiada Penilaian Untuk Dinilai
                                                </td>
                                            </tr>
                                        @endif

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
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
