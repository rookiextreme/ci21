@extends('segment.layouts.main')

@section('customCSS')
    @include('segment.layouts.asset_include_links.datatable.css.datatable_css')
    @include('segment.layouts.asset_include_links.select2.css.select2_css')
    @include('segment.layouts.asset_include_links.sweetAlert.css.sweet_alert_css')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.4.0/chart.min.js"></script>
    <style>
        table, th, td {
            border: 1px solid;
        }

        canvas{
            /* width:1000px !important;
            height:600px !important; */
            /* display:block;margin:0 auto; */
        }
    </style>
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
                                    <li class="breadcrumb-item active"><a href="#">Graf {{ $trigger == 0 ? 'Standard' : 'Actual'}} Analisis Jurang</a>
                                    </li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="content-body">
                <div class="card">
                    <form method="POST" action="">
                        @csrf
                    <div class="card-body">
                        <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label class="form-label" for="title">Tahun</label>
                                        <select class="select2 form-control search-tahun" data-placeholder="Sila Pilih" name="search_tahun">
                                            <option value="">Sila Pilih Tahun</option>
                                            @foreach ($year as $y)
                                                <option value="{{$y->id}}">{{$y->year}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label class="form-label" for="title">Penilaian</label>
                                        <select class="select2 form-control search-penilaian" data-placeholder="Sila Pilih" name="search_penilaian">
                                            <option value="">Sila Pilih Penilaian</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label class="form-label" for="title">Kumpulan</label>
                                        <select class="select2 form-control search-kumpulan" data-placeholder="Sila Pilih" name="search_kumpulan">
                                            <option value="">Sila Pilih Penilaian</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label class="form-label" for="title">Gred</label>
                                        <select class="select2 form-control search-gred" data-placeholder="Sila Pilih" name="search_gred">
                                            <option value="">Sila Pilih Gred</option>
                                            @foreach ($gred as $g)
                                                <option value="{{$g->id}}">{{$g->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label class="form-label" for="title2">Jurusan</label>
                                        <select class="select2 form-control search-jurusan" data-placeholder="Sila Pilih" name="search_jurusan">
                                            <option value="">Sila Pilih Jurusan</option>
                                            @foreach ($jurusan as $j)
                                                <option value="{{$j->kod_jurusan}}">{{$j->jurusan}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label class="form-label" for="title">Job Group</label>
                                        <select class="select2 form-control search-job-group" data-placeholder="Sila Pilih" name="search_job_group">
                                            <option value="">Sila Pilih Job Group</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label class="form-label" for="title">Kompetensi</label>
                                        <select class="select2 form-control search-kompetensi" data-placeholder="Sila Pilih" name="search_kompetensi">
                                            <option value="">Sila Pilih Kompetensi</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group" style="padding-top: 23px">
                                        <input type="submit" class="btn btn-success search-papar" value="Papar Laporan">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
                <div class="row" id="table-responsive">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="row">
                                    @if(empty($data))
                                        <div style="text-align: center;width:100%">Sila Pilih Penilaian</div>
                                    @else
                                    <div class="col-md-12">
                                        <canvas id="canvas" width="200" height="200"></canvas>
                                    </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    <input type="hidden" class="search_tahun_id" value="{{$search_tahun}}">
                    <input type="hidden" class="search_penilaian_id" value="{{$search_penilaian}}">
                    <input type="hidden" class="search_kumpulan_id" value="{{$search_kumpulan}}">
                    <input type="hidden" class="search_gred_id" value="{{$search_gred}}">
                    <input type="hidden" class="search_jurusan_id" value="{{$search_jurusan}}">
                    <input type="hidden" class="search_group_id" value="{{$search_group}}">
                    <input type="hidden" class="search_kompetensi_id" value="{{$search_kompetensi}}">
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
    <script src="{{ asset('js_helper/segment/pelaporan/analisis_jurang_standard/swal.js') }}"></script>
    <script src="{{ asset('js_helper/segment/pelaporan/analisis_jurang_standard/ajax.js') }}"></script>
    <script src="{{ asset('js_helper/segment/pelaporan/analisis_jurang_standard/page_settings.js') }}"></script>
    <script src="{{ asset('js_helper/segment/pelaporan/analisis_jurang_standard/datatable.js') }}"></script>
    <script src="{{ asset('js_helper/segment/pelaporan/analisis_jurang_standard/index.js') }}"></script>

    @if(!empty($data))
        <script>
            const DATA_COUNT = 7;
            const NUMBER_CFG = {count: DATA_COUNT, min: 0, max: 100};
            var canvas = document.getElementById('canvas');
            var ctx = canvas.getContext('2d');

            var myChart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: @json(array_values($data['label'])),
                    datasets: [{
                        label: 'Jumlah Pegawai (+ve)',
                        data: @json($data['positive']),
                        borderColor: 'rgb(0,0,255, 0.5)',
                        backgroundColor: [
                        'rgb(0,0,255, 0.5)',
                        ]
                    },
                    {
                        label: 'Jumlah Pegawai (-ve)',
                        data: @json($data['negative']),
                        borderColor: 'rgb(255,0,0, 0.5)',
                        backgroundColor: [
                        'rgb(255,0,0, 0.5)',
                        ]
                    }]
                },
                options: {
                    // maintainAspectRatio: false,
                    responsive: true,
                    scales: {
                        r: {
                            pointLabels: {
                                display: true,
                                centerPointLabels: true,
                                font: {
                                    size: 18
                                }
                            }
                        }
                    },
                    indexAxis: 'y',
                    plugins: {
                        legend: {
                            position: 'right',
                        },
                        title: {
                            display: true,
                            text: 'Jumlah Keseluruhan Projek: 0'
                        }
                    },

                }
            });
        </script>
    @endif
@endsection
