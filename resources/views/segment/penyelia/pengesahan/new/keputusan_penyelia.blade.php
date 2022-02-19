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
            <div class="row" id="table-bordered">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title" style="text-decoration: underline">Keputusan Penilaian {{$name}}</h4>
                            <div class="row">
                                <div class="col-md-6">
                                    <button href="#" class="btn btn-success submit-updated-score">Pengesahan</button>
                                </div>
                                <div class="col-md-6">
                                    <a href="{{url('/penyelia/pengesahan/new/with-penyelia/'.$penilaian_id)}}" class="btn btn-warning">Kembali</a>
                                </div>
                            </div>
                        </div>
                        <br>
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                <tr style="background-color: deepskyblue;color: white">
                                    <td rowspan="3">Competency Type</td>
                                    <td colspan="3" style="text-align: center">Standard Position ({{$data['standard_gred']}})</td>
                                </tr>
                                <tr style="background-color: deepskyblue;color: white">
                                    <td style="background-color: red;color: white">Score Peserta</td>
                                    <td style="background-color: orange;color: black">Penyelia Score</td>
                                    <td>Expected Score</td>
                                </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $int = 1;
                                    @endphp
                                    @foreach($data['penilaian'] as $pID => $p)
                                        <tr style="background-color: grey;color: white">
                                            <td>{{$p['name']}}</td>
                                            <td style="text-align: center"></td>
                                            <td style="text-align: center"></td>
                                            <td style="text-align: center"></td>
                                        </tr>

                                        @foreach($p['competencies'] as $cName => $cScore)
                                            <tr data-item-id="{{$data_p['penilaian'][$pID]['competencies'][$cName]['id']}}">
                                                <td>{{ $cName }}</td>
                                                <td style="background-color: deepskyblue;color: yellow;text-align: center">{{ $cScore['score'] }}</td>
                                                <td><input type="text" class="form-control item-penyelia-jawapan" data-count="{{$int}}" value="{{$data_p['penilaian'][$pID]['competencies'][$cName]['score']}}"></td>
                                                <td style="text-align: center">{{ $cScore['expected'] }}</td>
                                            </tr>
                                            @php
                                                $int++;
                                            @endphp
                                        @endforeach
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
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
    <script src="{{ asset('js_helper/segment/penyelia/pengesahan/new/kemaskini_keputusan/swal.js') }}"></script>
    <script src="{{ asset('js_helper/segment/penyelia/pengesahan/new/kemaskini_keputusan/page_settings.js') }}"></script>
    <script src="{{ asset('js_helper/segment/penyelia/pengesahan/new/kemaskini_keputusan/datatable.js') }}"></script>
    <script src="{{ asset('js_helper/segment/penyelia/pengesahan/new/kemaskini_keputusan/ajax.js') }}"></script>
    <script src="{{ asset('js_helper/segment/penyelia/pengesahan/new/kemaskini_keputusan/index.js') }}"></script>
@endsection
