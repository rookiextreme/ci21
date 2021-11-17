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
                                    <li class="breadcrumb-item"><a href="#">Job Group</a>
                                    </li>
                                    <li class="breadcrumb-item active"><a href="#">Tambah</a>
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
                                        <div class="col-xl-6 col-md-6 col-12 mb-1">
                                            <div class="form-group">
                                                <label for="basicInput">Name(English)</label>
                                                <input type="text" class="form-control job-group-set-name-eng" id="basicInput" value="{{$groupData['main']['title_eng'] ?? ''}}"/>
                                                <div class="invalid-feedback"></div>
                                            </div>
                                        </div>
                                        <div class="col-xl-6 col-md-6 col-12 mb-1">
                                            <div class="form-group">
                                                <label for="basicInput">Name(Malay, Optional)</label>
                                                <input type="text" class="form-control job-group-set-name-mal" id="basicInput" value="{{$groupData['main']['title_mal'] ?? ''}}"/>
                                                <div class="invalid-feedback"></div>
                                            </div>
                                        </div>
                                        <div class="col-xl-6 col-md-6 col-12 mb-1">
                                            <div class="form-group">
                                                <label for="basicInput">Description(English)</label>
                                                <textarea class="form-control job-group-set-desc-eng">{{$groupData['main']['desc_eng'] ?? ''}}</textarea>
                                                <div class="invalid-feedback"></div>
                                            </div>
                                        </div>
                                        <div class="col-xl-6 col-md-6 col-12 mb-1">
                                            <div class="form-group">
                                                <label for="basicInput">Description(Malay, Optional)</label>
                                                <textarea class="form-control job-group-set-desc-mal">{{$groupData['main']['desc_mal'] ?? ''}}</textarea>
                                                <div class="invalid-feedback"></div>
                                            </div>
                                        </div>
                                        <div class="col-xl-4 col-md-6 col-12 mb-1">
                                            <div class="form-group">
                                                <label for="basicInput">Service Category</label>
                                                <select class="form-control select2 job-group-set-grade-category">
                                                    <option value="">Sila Pilih</option>
                                                    @foreach($grade_categories as $g)
                                                        @if($groupData)
                                                            @if($groupData['main']['grade_categories'] == $g->id)
                                                                <option value="{{$g->id}}" selected>{{$g->name}}</option>
                                                            @else
                                                                <option value="{{$g->id}}">{{$g->name}}</option>
                                                            @endif
                                                        @else
                                                            <option value="{{$g->id}}">{{$g->name}}</option>
                                                        @endif
                                                    @endforeach
                                                </select>
                                                <div class="invalid-feedback"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
                <section id="basic-input">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-xl-6 col-md-6 col-12 mb-1">
                                            <div class="form-group">
                                                <label for="basicInput">Jurusan</label>
                                                <select class="form-control select2 job-group-set-jurusan">
                                                    <option value="">Sila Pilih</option>
                                                    @foreach($jurusan as $j)
                                                        @if($groupData)
                                                            @if($groupData['main']['jurusan'] == $j->kod_jurusan)
                                                                <?php $selectJ = 'selected'; ?>
                                                            @else
                                                                <?php $selectJ = ''; ?>
                                                            @endif
                                                        @else
                                                            <?php $selectJ = ''; ?>
                                                        @endif
                                                        <option value="{{$j->kod_jurusan}}" {{$selectJ}}>{{$j->jurusan}}</option>
                                                    @endforeach
                                                </select>
                                                <div class="invalid-feedback"></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-xl-12 col-md-6 col-12 mb-1">
                                            <div class="table-responsive">
                                                <table class="table table-bordered">
                                                    <thead>
                                                    <tr>
                                                        <th>Items</th>
                                                        <th>Pilih</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody class="item-checkbox">
                                                        <tr>
                                                            <td colspan="2" style="text-align: center">
                                                                Tiada Item Yang Wujud
                                                            </td>
                                                        </tr>
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

                        @if($job_group_sets_id ?? '')
                            <button type="button" style="width: 100%" class="btn btn-warning post-update-job-group">Kemaskini</button>
                        @else
                            <button type="button" style="width: 100%" class="btn btn-success post-add-job-group">Simpan</button>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    <input type="hidden" class="penilaian_id" value="{{$penilaian_id}}">
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
    <script src="{{ asset('js_helper/segment/admin/dictionarybank/jobgroupinsertupdate/swal.js') }}"></script>
    <script src="{{ asset('js_helper/segment/admin/dictionarybank/jobgroupinsertupdate/ajax.js') }}"></script>
    <script src="{{ asset('js_helper/segment/admin/dictionarybank/jobgroupinsertupdate/page_settings.js') }}"></script>
    <script src="{{ asset('js_helper/segment/admin/dictionarybank/jobgroupinsertupdate/datatable.js') }}"></script>
    <script src="{{ asset('js_helper/segment/admin/dictionarybank/jobgroupinsertupdate/index.js') }}"></script>
@endsection

