<div class="modal fade text-left modal-primary bank-col-modal" id="primary" tabindex="-1" role="dialog" aria-labelledby="myModalLabel160" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="bank-col-title modal-title" id="myModalLabel160">Primary Modal</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-xl-12 col-md-6 col-12 mb-1">
                        <div class="form-group">
                            <label for="basicInput">Nama(Eng)</label>
                            <input type="text" class="form-control bank-col-nama-eng" id="basicInput" placeholder=""/>
                            <div class="invalid-feedback"></div>
                        </div>
                        <div class="form-group">
                            <label for="basicInput">Nama(Malay, Optional)</label>
                            <input type="text" class="form-control bank-col-nama-melayu" id="basicInput" placeholder=""/>
                            <div class="invalid-feedback"></div>
                        </div>
                        <div class="form-group">
                            <label for="basicInput">Measuring Level</label>
                            <select class="form-control select2 bank-col-measuring-level">
                                @if(count($measuring_level) > 0)
                                    <option value="">Sila Pilih</option>
                                    @foreach($measuring_level as $ml)
                                        <option value="{{$ml->id}}">{{$ml->name}}</option>
                                    @endforeach
                                @else
                                    <option value="">Tiada Measuring Level</option>
                                @endif
                            </select>
                            <div class="invalid-feedback"></div>
                        </div>
                        <div class="form-group">
                            <label for="basicInput">Competency Type</label>
                            <select class="form-control select2 bank-col-com-type">
                                @if(count($competency_type) > 0)
                                    <option value="">Sila Pilih</option>
                                    @foreach($competency_type as $ct)
                                        <option value="{{$ct->id}}">{{$ct->dictBankCompetencyTypeScaleBridgeCompetency->name}}  ({{$ct->dictBankCompetencyTypeScaleBridgeScale->name}})</option>
                                    @endforeach
                                @else
                                    <option value="">Tiada Competency Type</option>
                                @endif
                            </select>
                            <div class="invalid-feedback"></div>
                        </div>
                        <div class="form-group">
                            <label for="basicInput">Jurusan</label>
                            <select class="form-control select2 bank-col-jurusan">
                                @if(count($jurusan) > 0)
                                    <option value="">Tiada Jurusan</option>
                                    @foreach($jurusan as $j)
                                        <option value="{{$j->kod_jurusan}}">{{$j->jurusan}}</option>
                                    @endforeach
                                @else
                                    <option value="">Tiada Jurusan</option>
                                @endif
                            </select>
                            <div class="invalid-feedback"></div>
                        </div>
                        <div class="form-group">
                            <label for="basicInput">Grade Category</label>
                            <select class="form-control select2 bank-col-grade-category">
                                @if(count($grade_category) > 0)
                                    <option value="">Sila Pilih</option>
                                    @foreach($grade_category as $gc)
                                        <option value="{{$gc->id}}">{{$gc->name}}</option>
                                    @endforeach
                                @else
                                    <option value="">Tiada Jurusan</option>
                                @endif
                            </select>
                            <div class="invalid-feedback"></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Tutup</button>
                <button type="button" class="btn btn-success post-add-bank-col">Tambah</button>
                <button type="button" class="btn btn-success post-update-bank-col">Kemaskini</button>
            </div>
        </div>
    </div>
</div>
<input type="hidden" class="bank-col-id" value="">

<div class="modal fade text-left modal-primary bank-col-ques-modal" id="primary" tabindex="-1" role="dialog" aria-labelledby="myModalLabel160" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="bank-col-ques-title modal-title" id="myModalLabel160">Primary Modal</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-xl-6 col-md-6 col-12 mb-1">
                        <div class="form-group">
                            <label for="exampleFormControlTextarea1">Soalan(Eng)</label>
                            <textarea class="form-control bank-col-ques-nama-eng" rows="3" placeholder="English"></textarea>
                            <div class="invalid-feedback"></div>
                        </div>
                    </div>
                    <div class="col-xl-6 col-md-6 col-12 mb-1">
                        <div class="form-group">
                            <label for="exampleFormControlTextarea1">Soalan(Malay)</label>
                            <textarea class="form-control bank-col-ques-nama-melayu" rows="3" placeholder="Melayu"></textarea>
                            <div class="invalid-feedback"></div>
                        </div>
                    </div>
                    <div class="col-xl-12 col-md-6 col-12 mb-1">
                        <button type="button" class="btn btn-success post-add-bank-col-ques">Tambah</button>
                        <button type="button" class="btn btn-warning post-update-bank-col-ques">Kemaskini</button>
                        <button type="button" class="btn btn-success post-reset-bank-col-ques">Tambah Baru</button>
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <table class="bank-listing-ques-table table">
                                <thead>
                                <tr>
                                    <th>Nama(Eng)</th>
                                    <th>Nama(Melayu)</th>
                                    <th>Aktif</th>
                                    <th>Aksi</th>
                                </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>
<input type="hidden" class="bank-col-ques-id" value="">
