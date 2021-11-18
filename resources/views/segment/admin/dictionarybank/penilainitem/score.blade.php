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
                                    <li class="breadcrumb-item"><a href="#">Koleksi Soalan</a>
                                    </li>
                                    <li class="breadcrumb-item active"><a href="#">Score Set</a>
                                    </li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="content-body">
                <section id="basic-input">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-8"></div>
                                        <div class="col-md-4">
                                            <a href="{{Request::root()}}/admin/dictionary/bank/penilaian/job-group/{{$penilaian_id}}" class="btn btn-warning" style="float: right"><i data-feather='settings' style="padding-right: 2px"></i>Senarai Job Jobgroup</a>
                                        </div>
                                        <br><br>
                                        <br><br>
                                        <div class="col-xl-12 col-md-6 col-12 mb-1">
                                            <div class="table-responsive">
                                                <table class="table table-bordered">
                                                    <thead>
                                                    <tr style="text-align: center">
                                                        <th class="centerCell" rowspan="2">Items</th>
                                                        <th colspan="{{count($data['grade_categories'])}}">Senarai Grade</th>
                                                    </tr>
                                                    <tr>
                                                        @foreach($data['grade_categories'] as $gc)
                                                            <th style="bcolor:black">{{$gc['name']}}</th>
                                                        @endforeach
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    @foreach($data['item']['main']['list'] as $itemlist)
                                                        <tr data-item-id="{{$itemlist['id']}}">
                                                            <td>
                                                                {{$itemlist['name']}}
                                                            </td>
                                                            @foreach($itemlist['scoreset'] as $score)
                                                                <td data-grade-id="{{$score['grade_id']}}" data-score-id="{{$score['id']}}">
                                                                    <input style="width: 20%" type="text" class="job-group-score" value="{{$score['score']}}">
                                                                </td>
                                                            @endforeach
                                                        </tr>
                                                    @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
                <div class="row">
                    <div class="col-xl-12 col-md-6 col-12 mb-1">
                        <button type="button" style="width: 100%" class="btn btn-success post-add-job-group-score">Simpan</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <input type="hidden" class="job_group_sets_id" value="{{$job_group_sets_id ?? ''}}">
@endsection

@section('customJS')
    {{--  Vendor files  --}}
    @include('segment.layouts.asset_include_links.datatable.js.datatable_js')
    @include('segment.layouts.asset_include_links.common.js.common_js')
    @include('segment.layouts.asset_include_links.select2.js.select2_js')
    @include('segment.layouts.asset_include_links.sweetAlert.js.sweet_alert_js')
    @include('segment.layouts.asset_include_links.date_time.js.datetime_js')

    {{--  Custom files  --}}
    <script src="{{ asset('js_helper/segment/admin/dictionarybank/jobgroupscore/swal.js') }}"></script>
    <script src="{{ asset('js_helper/segment/admin/dictionarybank/jobgroupscore/ajax.js') }}"></script>
    <script src="{{ asset('js_helper/segment/admin/dictionarybank/jobgroupscore/page_settings.js') }}"></script>
    <script src="{{ asset('js_helper/segment/admin/dictionarybank/jobgroupscore/datatable.js') }}"></script>
    <script src="{{ asset('js_helper/segment/admin/dictionarybank/jobgroupscore/index.js') }}"></script>
@endsection