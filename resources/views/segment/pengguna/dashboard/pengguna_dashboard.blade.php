@extends('segment.layouts.main')

@section('customCSS')
    @include('segment.layouts.asset_include_links.datatable.css.datatable_css')
    @include('segment.layouts.asset_include_links.select2.css.select2_css')
    @include('segment.layouts.asset_include_links.sweetAlert.css.sweet_alert_css')
    @include('segment.layouts.asset_include_links.date_time.css.datetime_css')
    <link rel="stylesheet" type="text/css" href="{{ asset('css/timeline_custom.css') }}">
@endsection

@section('content')
    <div class="app-content content ">
        <div class="content-overlay"></div>
        <div class="header-navbar-shadow"></div>
        <div class="content-wrapper container-xxl p-0">
            @if(!empty($data))
            <div class="row">
                <div class="col-md-6 col-xl-6">
                    <div class="card plan-card border-primary">
                        <div class="card-header d-flex justify-content-between align-items-center pt-75 pb-1">
                            <h5 class="mb-0">Maklumat Pegawai</h5>
                        </div>
                        <div class="card-body">
                            <ul class="list-unstyled my-1">
                                <li>
                                    <span class="align-middle" style="font-weight: bold">{{$data['user']['user_info']['name']}}</span>
                                </li>
                                <li>
                                    <span class="align-middle" style="font-weight: bold">{{$data['user']['user_info']['nric']}}</span>
                                </li>
                                <li class="my-25">
                                    <span class="align-middle">{{$data['user']['user_info']['penempatan']}}</span>
                                </li>
                                <li>
                                    <span class="align-middle">Gred Jawatan: {{$data['user']['user_info']['gred']}}</span>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-xl-6">
                    <div class="card bg-primary text-white pt-75 pb-1" style="height: 86% !important;">
                        <div class="card-body">
                            <h4 class="card-title text-white" style="text-align: center">Jumlah Penilaian</h4>
                            <p class="card-text" style="text-align: center;font-size: xx-large"> {{$data['completed']}} / {{count($data['penilaian_list'])}}</p>
                        </div>
                    </div>
                </div>
            </div>
            <section class="basic-timeline">
                @if(!empty($data))
                    @foreach($data['penilaian_list'] as $dk => $d)
                        {{-- <span>Tarikh Semasa : {{ $d['penilaian']['current_tkh'] }}</span><br/>
                        <span>Tarikh Mula : {{ $d['penilaian']['tkh_mula'] }}</span><br/>
                        <span>Tarikh Akhir : {{ $d['penilaian']['tkh_tutup'] }}</span><br/> --}}
                        @if($d['penilaian']['current_tkh'] >= $d['penilaian']['tkh_mula'] && $d['penilaian']['current_tkh'] <= $d['penilaian']['tkh_tutup'])
                            <div class="row main-penilaian-id" data-id="{{$d['penilaian']['id']}}">
                                <div class="col-lg-12">
                                    <div class="row">
                                        @if($d['penilaian']['status'] == 0)
                                            <div class="col-md-6 col-xl-6">
                                                <div class="card bg-info text-white">
                                                    <div class="card-body" style="height: 141px">
                                                        <h4 class="card-title text-white" style="text-align: center">Status Penilaian</h4>
                                                        <p class="card-text" style="text-align: center;font-size: xx-large">DRAF</p>
                                                    </div>
                                                </div>
                                            </div>
                                        @elseif($d['penilaian']['status'] == 1)
                                            <div class="col-md-6 col-xl-6">
                                                <div class="card bg-warning text-white">
                                                    <div class="card-body" style="height: 141px">
                                                        <h4 class="card-title text-white" style="text-align: center">Status Penilaian</h4>
                                                        <p class="card-text" style="text-align: center;font-size: xx-large">MENUNGGU PENGHANTARAN</p>
                                                    </div>
                                                </div>
                                            </div>
                                        @elseif($d['penilaian']['status'] == 2)
                                            <div class="col-md-6 col-xl-6">
                                                <div class="card bg-success text-white">
                                                    <div class="card-body" style="height: 141px">
                                                        <h4 class="card-title text-white" style="text-align: center">Status Penilaian</h4>
                                                        <p class="card-text" style="text-align: center;font-size: xx-large">SELESAI</p>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                        <div class="col-md-6 col-xl-6">
                                            <div class="card bg-warning text-white">
                                                <div class="card-body">
                                                    <h4 class="card-title text-white" style="text-align: center">Tarikh Tamat Penilaian</h4>
                                                    <p class="card-text" style="text-align: center;font-size: xx-large">
                                                        {{$d['penilaian']['tkh_tutup']}}<br>
                                                    </p>
                                                    <p class="card-text" style="text-align: center;font-size: xx-large">
                                                        {{$d['penilaian']['tkh_remain']}}
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="card">
                                        <div class="card-header">
                                            <h4 class="card-title">Penilaian ({{$d['penilaian']['year']}}) : {{$d['penilaian']['name']}}</h4>
                                        </div>
                                        <div class="card-body">
                                            <!-- old timeline penilaian -->
                                            {{--
                                            <ul class="timeline">
                                                <li class="timeline-item">
                                                <span class="timeline-point timeline-point-info">
                                                    <i data-feather="user"></i>
                                                </span>
                                                    <div class="row">
                                                        <div class="col-md-7">
                                                            <div class="d-flex justify-content-between flex-sm-row flex-column mb-sm-0 mb-1">
                                                                <h6>STEP 1 : PENYELIA</h6>
                                                            </div>
                                                            @if(!empty($d['penilaian']['penyelia']))
                                                                <p>Penyelia Anda Adalah: </p>
                                                                <p><b>{{$d['penilaian']['penyelia']['name']}}</b></p>
                                                            @else
                                                                <p>Anda Belum Memilih Penyelia</p>
                                                            @endif
                                                            <p><a class="penyelia-choose" style="color:darkgreen;font-weight: bolder">Tukar Penyelia</a></p>
                                                        </div>
                                                        @if(!empty($d['penilaian']['penyelia']))
                                                            <div class="col-md-5">
                                                                <img src="{{Request::root()}}/basicImg/tick.jpg" alt="" width="70px" height="70px" style="float: right">
                                                            </div>
                                                        @else
                                                            <div class="col-md-5">
                                                                <img src="{{Request::root()}}/basicImg/wrong.png" alt="" width="75px" height="75px" style="float: right">
                                                            </div>
                                                        @endif
                                                    </div>
                                                </li>
                                                <li class="timeline-item">
                                                <span class="timeline-point timeline-point-warning">
                                                    <i data-feather="layers"></i>
                                                </span>
                                                    <div class="row">
                                                        <div class="col-md-7">
                                                            <div class="d-flex justify-content-between flex-sm-row flex-column mb-sm-0 mb-1">
                                                                <h6>STEP 2 : JOB GROUP</h6>
                                                            </div>
                                                            @if(!empty($d['penilaian']['jobgroup']))
                                                                <p>Job Group Anda Adalah: </p>
                                                                <p><b>{{$d['penilaian']['jobgroup']['name']}}</b></p>
                                                            @else
                                                                <p>Anda Belum Memilih Job Group </p>
                                                            @endif

                                                            <p><a class="job-group-choose" style="color:darkgreen;font-weight: bolder">Tukar Job Group</a></p>
                                                        </div>
                                                        @if(!empty($d['penilaian']['jobgroup']))
                                                            <div class="col-md-5">
                                                                <img src="{{Request::root()}}/basicImg/tick.jpg" alt="" width="70px" height="70px" style="float: right">
                                                            </div>
                                                        @else
                                                            <div class="col-md-5">
                                                                <img src="{{Request::root()}}/basicImg/wrong.png" alt="" width="75px" height="75px" style="float: right">
                                                            </div>
                                                        @endif
                                                    </div>
                                                </li>
                                                <li class="timeline-item">
                                                <span class="timeline-point timeline-point-primary">
                                                    <i data-feather="file-text"></i>
                                                </span>
                                                    <div class="row">
                                                        <div class="col-md-7">
                                                            <div class="d-flex justify-content-between flex-sm-row flex-column mb-sm-0 mb-1">
                                                                <h6>STEP 3: PENILAIAN</h6>
                                                            </div>
                                                            <?php
                                                            $pass = 0;
                                                            foreach($d['penilaian']['competencies'] as $c){
                                                                if($c['status'] == 0){
                                                                    $pass = 1;
                                                                }
                                                            }
                                                            ?>
                                                            @if(!empty($d['penilaian']['penyelia']) && !empty($d['penilaian']['jobgroup']) && $pass == 0)
                                                                <p>Anda Telah Berjaya Melengkapkan Penilaian Kompetensi Ini.
                                                                    <br>
                                                                    <a href="{{Request::root()}}/pengguna/penilaian/keputusan/{{$dk}}" style="color:darkgreen;font-weight: bolder">Lihat Keputusan</a>
                                                                </p>
                                                            @elseif(!empty($d['penilaian']['penyelia']) && !empty($d['penilaian']['jobgroup']) && $pass == 1)
                                                                <p>Anda Boleh Menjawab Penilaian Sekarang</p>
                                                                <p><a class="penilaian-choose" style="color:darkgreen;font-weight: bolder">Jawab Penilaian</a></p>
                                                            @else
                                                                <p>Sila Pilih Penyelia Dan Job Group Anda</p>
                                                            @endif

                                                        </div>
                                                        @if(!empty($d['penilaian']['penyelia']) && !empty($d['penilaian']['jobgroup']) && $pass == 0)
                                                            <div class="col-md-5">
                                                                <img src="{{Request::root()}}/basicImg/tick.jpg" alt="" width="70px" height="70px" style="float: right">
                                                            </div>
                                                        @else
                                                            <div class="col-md-5">
                                                                <img src="{{Request::root()}}/basicImg/wrong.png" alt="" width="75px" height="75px" style="float: right">
                                                            </div>
                                                        @endif
                                                    </div>
                                                </li>
                                                <li class="timeline-item">
                                                <span class="timeline-point timeline-point-warning">
                                                    <i data-feather="fast-forward"></i>
                                                </span>
                                                    <div class="row">
                                                        <div class="col-md-7">
                                                            <div class="d-flex justify-content-between flex-sm-row flex-column mb-sm-0 mb-1">
                                                                <h6>STEP 4: HANTAR</h6>
                                                            </div>
                                                            @if($d['penilaian']['status'] != 0 && ($d['penilaian']['status'] == 1))
                                                                <p>Penilaian Selesai. Sila Hantar Kepada Penyelia Bagi Pengesahan</p>
                                                                <p><a class="penilaian-hantar" style="color:darkgreen;font-weight: bolder">Hantar</a></p>
                                                            @elseif($d['penilaian']['status'] != 0 && ($d['penilaian']['status'] == 2))
                                                                <p>Penilaian Dihantar Ke Penyelia</p>
                                                            @else
                                                                <p>Sila Jawab Penilaian Anda Dahulu</p>
                                                            @endif

                                                        </div>
                                                        @if($d['penilaian']['status'] != 0 && $d['penilaian']['status'] == 1)
                                                            <div class="col-md-5">
                                                                <img src="{{Request::root()}}/basicImg/tick.jpg" alt="" width="70px" height="70px" style="float: right">
                                                            </div>
                                                        @elseif($d['penilaian']['status'] != 0 && ($d['penilaian']['status'] == 2))
                                                            <div class="col-md-5">
                                                                <img src="{{Request::root()}}/basicImg/tick.jpg" alt="" width="70px" height="70px" style="float: right">
                                                            </div>
                                                        @else
                                                            <div class="col-md-5">
                                                                <img src="{{Request::root()}}/basicImg/wrong.png" alt="" width="75px" height="75px" style="float: right">
                                                            </div>
                                                        @endif
                                                    </div>
                                                </li>
                                                <li class="timeline-item">
                                                <span class="timeline-point timeline-point-success">
                                                    <i data-feather="flag"></i>
                                                </span>
                                                    <div class="row">
                                                        <div class="col-md-7">
                                                            <div class="d-flex justify-content-between flex-sm-row flex-column mb-sm-0 mb-1">
                                                                @if($d['penilaian']['status'] == 2)
                                                                    <h6>PENILAIAN SELESAI SEPENUHNYA</h6>
                                                                @else
                                                                    <h6>BELUM SELESAI</h6>
                                                                @endif
                                                            </div>
                                                        </div>
                                                        @if($d['penilaian']['status'] == 2)
                                                            <div class="col-md-5">
                                                                <img src="{{Request::root()}}/basicImg/tick.jpg" alt="" width="70px" height="70px" style="float: right">
                                                            </div>
                                                        @else
                                                            <div class="col-md-5">
                                                                <img src="{{Request::root()}}/basicImg/wrong.png" alt="" width="75px" height="75px" style="float: right">
                                                            </div>
                                                        @endif
                                                    </div>
                                                </li>
                                            </ul>
                                             --}}
                                            <!-- new timeline penilaian -->
                                            <div style="display:inline-block;width:100%;overflow-y:auto; height:600px;">
                                            <ul class="timeline-custom timeline-horizontal" style="top:50px;">
                                                <li class="timeline-item">
                                                    <div class="timeline-badge info"><i data-feather="user"></i></div>
                                                    <div class="timeline-panel">
                                                        <div class="timeline-heading">
                                                            <h4 class="timeline-title">LANGKAH 1 : PENYELIA</h4>
                                                        </div>
                                                        <div class="timeline-body">
                                                            @if(!empty($d['penilaian']['penyelia']))
                                                                <p>Penyelia Anda Adalah: </p>
                                                                <p><b>{{$d['penilaian']['penyelia']['name']}}</b></p>
                                                            @else
                                                                <p>Anda Belum Memilih Penyelia</p>
                                                            @endif
                                                            <p><a class="penyelia-choose" style="color:darkgreen;font-weight: bolder">Tukar Penyelia</a></p>
                                                            @if(!empty($d['penilaian']['penyelia']))
                                                            <div class="col-md-12">
                                                                <img src="{{Request::root()}}/basicImg/tick.jpg" alt="" width="70px" height="70px" style="float: right">
                                                            </div>
                                                            @else
                                                            <div class="col-md-12">
                                                                <img src="{{Request::root()}}/basicImg/wrong.png" alt="" width="75px" height="75px" style="float: right">
                                                            </div>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </li>
                                                <li class="timeline-item">
                                                    <div class="timeline-badge primary"><i data-feather="layers"></i></div>
                                                    <div class="timeline-panel">
                                                        <div class="timeline-heading">
                                                            <h4 class="timeline-title">LANGKAH 2 : JOB GROUP</h4>
                                                        </div>
                                                        <div class="timeline-body">
                                                            @if(!empty($d['penilaian']['jobgroup']))
                                                                <p>Job Group Anda Adalah: </p>
                                                                <p><b>{{$d['penilaian']['jobgroup']['name']}}</b></p>
                                                            @else
                                                                <p>Anda Belum Memilih Job Group </p>
                                                            @endif

                                                            <p><a class="job-group-choose" style="color:darkgreen;font-weight: bolder">Tukar Job Group</a></p>

                                                        @if(!empty($d['penilaian']['jobgroup']))
                                                            <div class="col-md-12">
                                                                <img src="{{Request::root()}}/basicImg/tick.jpg" alt="" width="70px" height="70px" style="float: right">
                                                            </div>
                                                        @else
                                                            <div class="col-md-12">
                                                                <img src="{{Request::root()}}/basicImg/wrong.png" alt="" width="75px" height="75px" style="float: right">
                                                            </div>
                                                        @endif
                                                        </div>
                                                    </div>
                                                </li>
                                                <li class="timeline-item">
                                                    <div class="timeline-badge warning"><i data-feather="file-text"></i></div>
                                                    <div class="timeline-panel">
                                                        <div class="timeline-heading">
                                                            <h4 class="timeline-title">LANGKAH 3: PENILAIAN</h4>
                                                        </div>
                                                        <div class="timeline-body">
                                                            <?php
                                                            $pass = 0;
                                                            foreach($d['penilaian']['competencies'] as $c){
                                                                if($c['status'] == 0){
                                                                    $pass = 1;
                                                                }
                                                            }
                                                            ?>
                                                            @if(!empty($d['penilaian']['penyelia']) && !empty($d['penilaian']['jobgroup']) && $pass == 0)
                                                                <p>Anda Telah Berjaya Melengkapkan Penilaian Kompetensi Ini</p>
                                                            @elseif(!empty($d['penilaian']['penyelia']) && !empty($d['penilaian']['jobgroup']) && $pass == 1)
                                                                <p>Anda Boleh Menjawab Penilaian Sekarang</p>
                                                                <p><a class="penilaian-choose" style="color:darkgreen;font-weight: bolder">Jawab Penilaian</a></p>
                                                            @else
                                                                <p>Sila Pilih Penyelia Dan Job Group Anda</p>
                                                            @endif
                                                        @if(!empty($d['penilaian']['penyelia']) && !empty($d['penilaian']['jobgroup']) && $pass == 0)
                                                            <div class="col-md-12">
                                                                <img src="{{Request::root()}}/basicImg/tick.jpg" alt="" width="70px" height="70px" style="float: right">
                                                            </div>
                                                        @else
                                                            <div class="col-md-12">
                                                                <img src="{{Request::root()}}/basicImg/wrong.png" alt="" width="75px" height="75px" style="float: right">
                                                            </div>
                                                        @endif
                                                        </div>
                                                    </div>
                                                </li>
                                                <li class="timeline-item">
                                                    <div class="timeline-badge danger"><i data-feather="fast-forward"></i></div>
                                                    <div class="timeline-panel">
                                                        <div class="timeline-heading">
                                                            <h4 class="timeline-title">LANGKAH 4: HANTAR</h4>
                                                        </div>
                                                        <div class="timeline-body">
                                                            @if($d['penilaian']['status'] != 0 && ($d['penilaian']['status'] == 1))
                                                                <p>Penilaian Selesai. Sila Hantar Kepada Penyelia Bagi Pengesahan</p>
                                                                <p><a class="penilaian-hantar" style="color:darkgreen;font-weight: bolder">Hantar</a></p>
                                                            @elseif($d['penilaian']['status'] != 0 && ($d['penilaian']['status'] == 2))
                                                                <p>Penilaian Dihantar Ke Penyelia</p>
                                                            @else
                                                                <p>Sila Jawab Penilaian Anda Dahulu</p>
                                                            @endif
                                                        @if($d['penilaian']['status'] != 0 && $d['penilaian']['status'] == 1)
                                                            <div class="col-md-12">
                                                                <img src="{{Request::root()}}/basicImg/tick.jpg" alt="" width="70px" height="70px" style="float: right">
                                                            </div>
                                                        @elseif($d['penilaian']['status'] != 0 && ($d['penilaian']['status'] == 2))
                                                            <div class="col-md-12">
                                                                <img src="{{Request::root()}}/basicImg/tick.jpg" alt="" width="70px" height="70px" style="float: right">
                                                            </div>
                                                        @else
                                                            <div class="col-md-12">
                                                                <img src="{{Request::root()}}/basicImg/wrong.png" alt="" width="75px" height="75px" style="float: right">
                                                            </div>
                                                        @endif
                                                        </div>
                                                    </div>
                                                </li>
                                                <li class="timeline-item">
                                                    <div class="timeline-badge success"><i data-feather="fast-forward"></i></div>
                                                    <div class="timeline-panel">
                                                        <div class="timeline-heading">
                                                            @if($d['penilaian']['status'] == 2)
                                                            <h4 class="timeline-title">PENILAIAN SELESAI SEPENUHNYA</4>
                                                        @else
                                                            <h4 class="timeline-title">BELUM SELESAI</h4>
                                                        @endif
                                                        </div>
                                                        <div class="timeline-body">
                                                            @if($d['penilaian']['status'] == 2)
                                                            <div class="col-md-12">
                                                                <img src="{{Request::root()}}/basicImg/tick.jpg" alt="" width="70px" height="70px" style="float: right">
                                                            </div>
                                                        @else
                                                            <div class="col-md-12">
                                                                <img src="{{Request::root()}}/basicImg/wrong.png" alt="" width="75px" height="75px" style="float: right">
                                                            </div>
                                                        @endif
                                                        </div>
                                                    </div>
                                                </li>
                                            </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12 col-xl-12">
                                    <div class="card">
                                        <div class="card-header">
                                            <h4 class="card-title">Ringkasan Kompetensi</h4>
                                        </div>
                                        <div class="table-responsive">
                                            <table class="table table-bordered">
                                                <thead>
                                                <tr style="text-align: center">
                                                    <th class="centerCell" rowspan="2">Kompetensi</th>
                                                    <th colspan="5">Soalan</th>
                                                </tr>
                                                <tr style="">
                                                    <th class="centerCell">Jumlah</th>
                                                    <th class="centerCell">Selesai</th>
                                                    <th class="centerCell">Baki</th>
                                                    <th class="centerCell">Lengkap(%)</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                @if(!empty($d['penilaian']['competencies']))
                                                    @foreach($d['penilaian']['competencies'] as $c)
                                                        <tr data-penilaian-competency-id="{{$c['id']}}">
                                                            <td>
                                                                {{$c['name']}}
                                                            </td>
                                                            <td>{{$c['total']}}</td>
                                                            <td>{{$c['ans']}}</td>
                                                            <td>{{$c['notAns']}}</td>
                                                            <td>{{$c['percentageLengkap']}}</td>
                                                        </tr>
                                                    @endforeach
                                                @else
                                                    <tr>
                                                        <td colspan="6" style="text-align: center">TIADA COMPETENCY</td>
                                                    </tr>
                                                @endif
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @elseif($d['penilaian']['current_tkh'] < $d['penilaian']['tkh_mula'])
                            <div class="row">
                                <div class="col-md-12 col-xl-12">
                                    <div class="card bg-warning text-white">
                                        <div class="card-body">
                                            <h4 class="card-title text-white" style="text-align: center">Penilaian ({{$d['penilaian']['year']}}) : {{$d['penilaian']['name']}}</h4>
                                            <p class="card-text" style="text-align: center;font-size: xx-large">Penilaian Belum Mula</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @elseif($d['penilaian']['current_tkh'] > $d['penilaian']['tkh_tutup'])
                            <div class="row">
                                <div class="col-md-12 col-xl-12">
                                    <div class="card bg-danger text-white">
                                        <div class="card-body">
                                            <h4 class="card-title text-white" style="text-align: center">Penilaian ({{$d['penilaian']['year']}}) : {{$d['penilaian']['name']}}</h4>
                                            <p class="card-text" style="text-align: center;font-size: xx-large">Penilaian Ditutup</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                    @endforeach
                @else

                @endif
            </section>
            @else
                <div class="row">
                    <div class="col-md-12 col-xl-12">
                        <div class="card plan-card border-primary">
                            <div class="card-header d-flex justify-content-between align-items-center pt-75 pb-1">
                                <h5 class="mb-0">Penilaian</h5>
                            </div>
                            <div class="card-body">
                                <span>Tiada Penilaian Buat Masa Sekarang</span>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
    <input type="hidden" class="penilaian-id" value="">
    @include('segment.pengguna.dashboard.modals.index')
@endsection

@section('customJS')
    {{--  Vendor files  --}}
    @include('segment.layouts.asset_include_links.datatable.js.datatable_js')
    @include('segment.layouts.asset_include_links.common.js.common_js')
    @include('segment.layouts.asset_include_links.select2.js.select2_js')
    @include('segment.layouts.asset_include_links.sweetAlert.js.sweet_alert_js')
    @include('segment.layouts.asset_include_links.date_time.js.datetime_js')

    {{--  Custom files  --}}
    <script src="{{ asset('js_helper/segment/pengguna/dashboard/swal.js') }}"></script>
    <script src="{{ asset('js_helper/segment/pengguna/dashboard/page_settings.js') }}"></script>
    <script src="{{ asset('js_helper/segment/pengguna/dashboard/datatable.js') }}"></script>
    <script src="{{ asset('js_helper/segment/pengguna/dashboard/ajax.js') }}"></script>
    <script src="{{ asset('js_helper/segment/pengguna/dashboard/index.js') }}"></script>
@endsection
