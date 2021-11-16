<div class="modal fade text-left modal-primary penilaian-modal" id="primary" role="dialog" aria-labelledby="myModalLabel160" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="penilaian-title modal-title" id="myModalLabel160">Primary Modal</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-xl-8 col-md-6 col-12 mb-1">
                        <div class="form-group">
                            <label for="basicInput">Nama</label>
                            <input type="text" class="form-control penilaian-nama" id="basicInput" placeholder=""/>
                            <div class="invalid-feedback"></div>
                        </div>
                    </div>
                    <div class="col-xl-4 col-md-6 col-12 mb-1">
                        <div class="form-group">
                            <label for="basicInput">Tahun</label>
                            <select class="form-control penilaian-tahun select2">
                                <option value="">Sila Pilih</option>
                                @foreach($year as $y)
                                    <option value="{{$y->id}}">{{$y->year}}</option>
                                @endforeach
                            </select>
                            <div class="invalid-feedback"></div>
                        </div>
                    </div>
                    <div class="col-xl-6 col-md-6 col-12 mb-1">
                        <div class="form-group">
                            <label for="basicInput">Tarikh Mula</label>
                            <input type="text" class="form-control penilaian-tkh-mula" id="basicInput" placeholder=""/>
                            <div class="invalid-feedback"></div>
                        </div>
                    </div>
                    <div class="col-xl-6 col-md-6 col-12 mb-1">
                        <div class="form-group">
                            <label for="basicInput">Tarikh Tamat</label>
                            <input type="text" class="form-control penilaian-tkh-tamat" id="basicInput" placeholder=""/>
                            <div class="invalid-feedback"></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Tutup</button>
                <button type="button" class="btn btn-success post-add-penilaian">Tambah</button>
                <button type="button" class="btn btn-success post-update-penilaian">Kemaskini</button>
            </div>
        </div>
    </div>
</div>
<input type="hidden" class="penilaian-id" value="">
