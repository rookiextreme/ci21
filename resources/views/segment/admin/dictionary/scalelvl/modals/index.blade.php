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
