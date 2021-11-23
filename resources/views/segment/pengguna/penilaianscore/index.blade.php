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
            <div class="row" id="basic-table">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">{{$data['penilaian_info']['title']}}</h4>
                        </div>
                        <div class="card-body">
                            <p class="card-text">
                                Sila baca dan fahami setiap perkara terlebih dahulu sebelum menentukan tahap anda yang sepatutnya. Anda juga boleh menyimpan setiap jawapan yang diberikan dan membuat penilaian pada waktu lain tanpa perlu menghabiskan semua penilaian dalam satu masa
                            </p>
                        </div>
                        @if($data['competencies']['info']['type'] == 'multiple')
                            @if(!empty($data['competencies']['info']['scoreList']['scale_desc']))
                                <div class="table-responsive ">
                                    <table class="table table-bordered">
                                        <thead>
                                        <tr>
                                            <th>Skor</th>
                                            <th>Penerangan</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($data['competencies']['info']['scoreList']['scale_desc'] as $sd)
                                            <tr>
                                                <td>
                                                    <span class="font-weight-bold">{{$sd['skillset']}}</span>
                                                </td>
                                                <td>{{$sd['description']}}</td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @endif
                        @endif
                    </div>
                </div>
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">Kompetensi: {{$data['competencies']['info']['title']}}</h4>
                        </div>
                        <div class="table-responsive ">
                            <table class="table table-bordered">
                                <thead>
                                <tr style="text-align: center">
                                    <th rowspan="2">Kompetensi Item</th>
                                    <th colspan="{{$data['competencies']['info']['scoreList']['score_header']}}">SKOR</th>
                                </tr>
                                <tr style="">
                                    @if($data['competencies']['info']['type'] == 'multiple')
                                        @foreach($data['competencies']['info']['scoreList']['scale_desc'] as $sdk => $sdv)
                                            <th class="centerCell">{{$sdk + 1}}</th>
                                        @endforeach
                                    @else
                                        <th class="centerCell">Yes/No</th>
                                    @endif
                                </tr>
                                </thead>
                                <tbody>
                                @if(!empty($data['competencies']['question']))
                                    @foreach($data['competencies']['question'] as $q)
                                        <tr class="question-ans" data-ques-id="{{$q['id']}}">
                                            <td>
                                                <span class="font-weight-bold">{{$q['name']}}</span>
                                            </td>
                                            @if($data['competencies']['info']['type'] == 'multiple')
                                                <?php echo $q['scoreList']['score_html'] ?>
                                            @else
                                                <td><?php echo $q['scoreList']['score_html'] ?></td>
                                            @endif
                                        </tr>
                                    @endforeach
                                @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="col-12">
                    <button class="btn btn-success" id="simpan-skor" style="width: 100%;">Simpan Jawapan</button>
                </div>
            </div>
        </div>
    </div>
    <input type="hidden" class="skor-type" value="{{$data['competencies']['info']['type']}}">
    <input type="hidden" class="penilaian-id" value="{{$penilaian_id}}">
    <input type="hidden" class="competency-id" value="{{$data['competencies']['info']['id']}}">
@endsection

@section('customJS')
    {{--  Vendor files  --}}
    @include('segment.layouts.asset_include_links.datatable.js.datatable_js')
    @include('segment.layouts.asset_include_links.common.js.common_js')
    @include('segment.layouts.asset_include_links.select2.js.select2_js')
    @include('segment.layouts.asset_include_links.sweetAlert.js.sweet_alert_js')
    @include('segment.layouts.asset_include_links.date_time.js.datetime_js')

    {{--  Custom files  --}}
    <script src="{{ asset('js_helper/segment/pengguna/penilaianscore/swal.js') }}"></script>
    <script src="{{ asset('js_helper/segment/pengguna/penilaianscore/page_settings.js') }}"></script>
    <script src="{{ asset('js_helper/segment/pengguna/penilaianscore/datatable.js') }}"></script>
    <script src="{{ asset('js_helper/segment/pengguna/penilaianscore/ajax.js') }}"></script>
    <script src="{{ asset('js_helper/segment/pengguna/penilaianscore/index.js') }}"></script>
@endsection
