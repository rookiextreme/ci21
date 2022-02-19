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
                                @if($penyelia_update == 0)
                                    <div class="col-md-6">
                                        <a href="#" class="btn btn-success">Pengesahan</a>
                                    </div>
                                    <div class="col-md-6">
                                        <a href="{{url('/penyelia/pengesahan/new/with-penyelia/'.$penilaian_id)}}" class="btn btn-warning">Kemaskini</a>
                                    </div>
                                @else
                                    <div class="col-md-12" style="color:green;font-weight:bold">
                                        PENILAIAN SUDAH DISAHKAN
                                    </div>
                                @endif
                            </div>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-bordered" border="1">
                                <tr>
                                    <td>Nama</td>
                                    <td>{{$user['name']}}</td>
                                </tr>
                                <tr>
                                    <td>Standard Gred</td>
                                    <td>{{$user['s_gred']}}</td>
                                </tr>
                                <tr>
                                    <td>Actual Gred</td>
                                    <td>{{$user['a_gred']}}</td>
                                </tr>
                            </table>
                        </div>
                        <br>
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                <tr style="background-color: deepskyblue;color: white">
                                    <td rowspan="2">Competency Type</td>
                                    <td colspan="4" style="text-align: center">Standard Position ({{$data['standard_gred']}})</td>
                                    <td colspan="4" style="text-align: center">Actual Position ({{$data['actual_gred']}})</td>
                                </tr>
                                <tr style="background-color: deepskyblue;color: white">
                                    <td style="background-color: red;color: white">Your Score</td>
                                    <td>Expected Score</td>
                                    <td>Development Gap</td>
                                    <td>Development Advisor</td>
                                    <td style="background-color: red;color: white">Your Score</td>
                                    <td>Expected Score</td>
                                    <td>Development Gap</td>
                                    <td>Training Required</td>
                                </tr>
                                </thead>
                                <tbody>
                                    @foreach($data['penilaian'] as $p)
                                        <tr style="background-color: grey;color: white">
                                            <td>{{$p['name']}}</td>
                                            <td style="text-align: center">{{$p['avg_com_score']}}</td>
                                            <td style="text-align: center">{{$p['avg_com_expected']}}</td>
                                            <td style="text-align: center">{{$p['avg_com_gap']}}</td>
                                            <td style="text-align: center"></td>
                                            <td style="text-align: center">{{$p['actual_avg_com_score']}}</td>
                                            <td style="text-align: center">{{$p['actual_avg_com_expected']}}</td>
                                            <td style="text-align: center">{{$p['actual_avg_com_gap']}}</td>
                                            <td style="text-align: center"></td>
                                        </tr>
                                        @foreach($p['competencies'] as $cName => $cScore)
                                            <tr>
                                                <td>{{ $cName }}</td>
                                                <td style="background-color: deepskyblue;color: yellow;text-align: center">{{ $cScore['score'] }}</td>
                                                <td style="text-align: center">{{ $cScore['expected'] }}</td>
                                                <td style="text-align: center">{{ $cScore['gap'] }}</td>
                                                <td style="{{$cScore['training'] == 'Required' ? 'color:red' : 'text-align:center'}}">{{ $cScore['training'] }}</td>
                                                <td style="background-color: deepskyblue;color: yellow;text-align: center">{{ $cScore['score'] }}</td>
                                                <td style="text-align: center">{{ $cScore['actual_expected'] }}</td>
                                                <td style="text-align: center">{{ $cScore['actual_gap'] }}</td>
                                                <td style="{{$cScore['actual_training'] == 'Required' ? 'color:red' : 'text-align:center'}}">{{ $cScore['actual_training'] }}</td>
                                            </tr>
                                        @endforeach
                                    @endforeach
                                    <tr style="background-color: yellow;color:black">
                                        <td style="text-align: right">JUMLAH</td>
                                        <td style="text-align: center">{{ $data['jumlah']['avg_com_score'] }}</td>
                                        <td style="text-align: center">{{ $data['jumlah']['avg_com_expected'] }}</td>
                                        <td style="text-align: center">{{ $data['jumlah']['avg_com_gap'] }}</td>
                                        <td></td>
                                        <td style="text-align: center">{{ $data['jumlah']['actual_avg_com_expected'] }}</td>
                                        <td style="text-align: center">{{ $data['jumlah']['actual_avg_com_expected'] }}</td>
                                        <td style="text-align: center">{{ $data['jumlah']['actual_avg_com_gap'] }}</td>
                                        <td></td>
                                    </tr>
                                </tbody>
                            </table>
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
    @include('segment.layouts.asset_include_links.date_time.js.datetime_js')

    {{--  Custom files  --}}
    <script src="{{ asset('js_helper/segment/pengguna/penilaianscore/penilaiancomplete/swal.js') }}"></script>
    <script src="{{ asset('js_helper/segment/pengguna/penilaianscore/penilaiancomplete/page_settings.js') }}"></script>
    <script src="{{ asset('js_helper/segment/pengguna/penilaianscore/penilaiancomplete/datatable.js') }}"></script>
    <script src="{{ asset('js_helper/segment/pengguna/penilaianscore/penilaiancomplete/ajax.js') }}"></script>
    <script src="{{ asset('js_helper/segment/pengguna/penilaianscore/penilaiancomplete/index.js') }}"></script>
@endsection
