<div class="modal fade text-left modal-primary grade-category-modal" id="primary" tabindex="-1" role="dialog" aria-labelledby="myModalLabel160" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="grade-category-title modal-title" id="myModalLabel160">Primary Modal</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-xl-12 col-md-6 col-12 mb-1">
                        <div class="form-group">
                            <label for="basicInput">Nama</label>
                            <input type="text" class="form-control grade-category-nama" id="basicInput" placeholder=""/>
                            <div class="invalid-feedback"></div>
                        </div>
                    </div>
                    <div class="col-md-12 mb-1">
                        <div class="form-group">
                            <label>Senarai Gred</label>
                            <select class="select2 form-control grade-category-gred-listing" multiple>
                                @if(count($grades) > 0)
                                    @foreach($grades as $g)
                                        <option value="{{$g->id}}">{{$g->name}}</option>
                                    @endforeach
                                @else
                                    <option disabled>Tiada Gred</option>
                                @endif
                            </select>
                            <div class="invalid-feedback"></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Tutup</button>
                <button type="button" class="btn btn-success post-add-grade-category">Tambah</button>
                <button type="button" class="btn btn-success post-update-grade-category">Kemaskini</button>
            </div>
        </div>
    </div>
</div>
<input type="hidden" class="grade-category-id" value="">

<div class="modal fade text-left modal-primary measuring-lvl-modal" id="primary" tabindex="-1" role="dialog" aria-labelledby="myModalLabel160" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="measuring-level-title modal-title" id="myModalLabel160">Primary Modal</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-xl-12 col-md-6 col-12 mb-1">
                        <div class="form-group">
                            <label for="basicInput">Nama</label>
                            <input type="text" class="form-control measuring-lvl-nama" id="basicInput" placeholder=""/>
                            <div class="invalid-feedback"></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Tutup</button>
                <button type="button" class="btn btn-success post-add-measuring-lvl">Tambah</button>
                <button type="button" class="btn btn-success post-update-measuring-lvl">Kemaskini</button>
            </div>
        </div>
    </div>
</div>

<input type="hidden" class="measuring-lvl-id" value="">

<div class="modal fade text-left modal-primary competency-type-modal" id="primary" tabindex="-1" role="dialog" aria-labelledby="myModalLabel160" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="competency-type-title modal-title" id="myModalLabel160">Primary Modal</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-xl-12 col-md-6 col-12 mb-1">
                        <div class="form-group">
                            <label for="basicInput">Nama</label>
                            <input type="text" class="form-control competency-type-nama" id="basicInput" placeholder=""/>
                            <div class="invalid-feedback"></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Tutup</button>
                <button type="button" class="btn btn-success post-add-competency-type">Tambah</button>
                <button type="button" class="btn btn-success post-update-competency-type">Kemaskini</button>
            </div>
        </div>
    </div>
</div>
<input type="hidden" class="competency-type-id" value="">

<div class="modal fade text-left modal-primary scale-skill-set-modal" id="primary" tabindex="-1" role="dialog" aria-labelledby="myModalLabel160" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="scale-skill-set-title modal-title" id="myModalLabel160">Primary Modal</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-xl-12 col-md-6 col-12 mb-1">
                        <div class="form-group">
                            <label for="basicInput">Nama</label>
                            <input type="text" class="form-control scale-skill-set-nama" id="basicInput" placeholder=""/>
                            <div class="invalid-feedback"></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Tutup</button>
                <button type="button" class="btn btn-success post-add-scale-skill-set">Tambah</button>
                <button type="button" class="btn btn-success post-update-scale-skill-set">Kemaskini</button>
            </div>
        </div>
    </div>
</div>
<input type="hidden" class="scale-skill-set-id" value="">

{{--Scale Level--}}
<div class="modal fade text-left modal-primary scale-level-modal" id="primary" tabindex="-1" role="dialog" aria-labelledby="myModalLabel160" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="scale-level-title modal-title" id="myModalLabel160">Primary Modal</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-xl-12 col-md-6 col-12 mb-1">
                        <div class="form-group">
                            <label for="basicInput">Nama</label>
                            <input type="text" class="form-control scale-level-nama" id="basicInput" placeholder=""/>
                            <div class="invalid-feedback"></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Tutup</button>
                <button type="button" class="btn btn-success post-add-scale-level">Tambah</button>
                <button type="button" class="btn btn-success post-update-scale-level">Kemaskini</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade text-left modal-primary scale-level-set-modal" id="primary" tabindex="-1" role="dialog" aria-labelledby="myModalLabel160" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="scale-level-set-title modal-title" id="myModalLabel160">Primary Modal</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row mb-2">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="basicInput">Nama</label>
                            <input type="text" class="form-control scale-level-set-nama" id="basicInput" placeholder=""/>
                            <div class="invalid-feedback"></div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="basicInput">Skill Set</label>
                            <select class="form-control select2 scale-level-set-skill-set" data-placeholder="Sila Pilih">
                                <option value="">Sila Pilih</option>
                                @foreach($skillSet as $ss)
                                    <option value="{{$ss->id}}">{{$ss->name}}</option>
                                @endforeach
                            </select>
                            <div class="invalid-feedback"></div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="basicInput">Skor</label>
                            <input type="text" class="form-control scale-level-set-score" id="basicInput" placeholder=""/>
                            <div class="invalid-feedback"></div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <button type="button" class="btn btn-success post-add-scale-level-set form" style="width: 100%">Tambah</button>
                        <button type="button" class="btn btn-warning post-update-scale-level-set form" style="width: 100%">Kemaskini</button>
                        <button type="button" class="btn btn-success reset-scale-level-set form" style="width: 100%">Tambah Baru</button>
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <table class="scale-level-set-table table">
                                <thead>
                                <tr>
                                    <th>Nama</th>
                                    <th>Skill Set</th>
                                    <th>Skor</th>
                                    <th>Aktif</th>
                                    <th>Aksi</th>
                                </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<input type="hidden" class="scale-level-id" value="">
<input type="hidden" class="scale-level-set-id" value="">

{{--Competency Type--}}
<div class="modal fade text-left modal-primary competency-type-set-modal" id="primary" tabindex="-1" role="dialog" aria-labelledby="myModalLabel160" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="competency-type-set-title modal-title" id="myModalLabel160">Primary Modal</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-xl-12 col-md-6 col-12 mb-1">
                        <div class="form-group">
                            <label for="basicInput">Competency Type</label>
                            <select class="select2 form-control competency-type-set-com-type" data-placeholder="Sila Pilih">
                                @if(count($competency_type) > 0)
                                    <option value="">Sila Pilih</option>
                                    @foreach($competency_type as $ct)
                                        <option value="{{$ct->id}}">{{$ct->name}}</option>
                                    @endforeach
                                @else
                                    <option value="">Tiada Scale Level</option>
                                @endif
                            </select>
                            <div class="invalid-feedback"></div>
                        </div>
                        <div class="form-group">
                            <label for="basicInput">Scale Level</label>
                            <select class="select2 form-control competency-type-set-scale-level" data-placeholder="Sila Pilih">
                                @if(count($scale_level) > 0)
                                    <option value="">Sila Pilih</option>
                                    @foreach($scale_level as $sl)
                                        <option value="{{$sl->id}}">{{$sl->name}}</option>
                                    @endforeach
                                @else
                                    <option value="">Tiada Scale Level</option>
                                @endif
                            </select>
                            <div class="invalid-feedback"></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Tutup</button>
                <button type="button" class="btn btn-success post-add-competency-type-set">Tambah</button>
                <button type="button" class="btn btn-success post-update-competency-type-set">Kemaskini</button>
            </div>
        </div>
    </div>
</div>
<input type="hidden" class="competency-type-set-id" value="">
