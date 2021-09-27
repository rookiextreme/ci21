<div class="modal fade text-left modal-primary pengguna-modal" id="primary" tabindex="-1" role="dialog" aria-labelledby="myModalLabel160" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="myModalLabel160">Primary Modal</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-xl-12 col-md-6 col-12 mb-1">
                        <div class="form-group">
                            <label for="basicInput">Carian Pengguna</label>
                            <select class="pengguna-carian form-control" id="select2-ajax"></select>
                            <div class="invalid-feedback"></div>
                        </div>
                    </div>
                    <div class="col-xl-12 col-md-6 col-12 mb-1">
                        <div class="form-group">
                            <label for="basicInput">Nama</label>
                            <input type="text" class="form-control pengguna-nama" id="basicInput" placeholder="" readonly/>
                            <div class="invalid-feedback"></div>
                        </div>
                    </div>
                    <div class="col-xl-6 col-md-6 col-12 mb-1">
                        <div class="form-group">
                            <label for="basicInput">Emel</label>
                            <input type="text" class="form-control pengguna-email" id="basicInput" placeholder="" readonly/>
                            <div class="invalid-feedback"></div>
                        </div>
                    </div>
                    <div class="col-xl-6 col-md-6 col-12 mb-1">
                        <div class="form-group">
                            <label for="basicInput">Sektor</label>
                            <input type="text" class="form-control pengguna-sektor" id="basicInput" placeholder="" readonly/>
                            <div class="invalid-feedback"></div>
                        </div>
                    </div>
                    <div class="col-xl-6 col-md-6 col-12 mb-1">
                        <div class="form-group">
                            <label for="basicInput">Cawangan</label>
                            <input type="text" class="form-control pengguna-cawangan" id="basicInput" placeholder="" readonly/>
                            <div class="invalid-feedback"></div>
                        </div>
                    </div>
                    <div class="col-xl-6 col-md-6 col-12 mb-1">
                        <div class="form-group">
                            <label for="basicInput">Bahagian</label>
                            <input type="text" class="form-control pengguna-bahagian" id="basicInput" placeholder="" readonly/>
                            <div class="invalid-feedback"></div>
                        </div>
                    </div>
                    <div class="col-xl-6 col-md-6 col-12 mb-1">
                        <div class="form-group">
                            <label for="basicInput">Unit</label>
                            <input type="text" class="form-control pengguna-unit" id="basicInput" placeholder="" readonly/>
                            <div class="invalid-feedback"></div>
                        </div>
                    </div>
                    <div class="col-xl-6 col-md-6 col-12 mb-1">
                        <div class="form-group">
                            <label for="basicInput">Penempatan</label>
                            <input type="text" class="form-control pengguna-penempatan" id="basicInput" placeholder="" readonly/>
                            <div class="invalid-feedback"></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Tutup</button>
                <button type="button" class="btn btn-success post-add-pengguna">Tambah</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade text-left" id="pengguna-modal-info" tabindex="-1" role="dialog" aria-labelledby="myModalLabel17" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="pengguna-modal-title" id="myModalLabel17"></h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-xl-6 col-md-6 col-12">
                        <div class="form-group">
                            <label for="disabledInput" class="font-weight-bolder">No. Kad Pengenalan</label>
                            <p class="form-control-static pengguna-info-nokp" id="staticInput"></p>
                        </div>
                    </div>
                    <div class="col-xl-6 col-md-6 col-12">
                        <div class="form-group">
                            <label for="disabledInput" class="font-weight-bolder">Penempatan</label>
                            <p class="form-control-static pengguna-info-penempatan" id="staticInput"></p>
                        </div>
                    </div>
                    <div class="col-xl-6 col-md-6 col-12">
                        <div class="form-group">
                            <label for="disabledInput" class="font-weight-bolder">Telefon</label>
                            <p class="form-control-static pengguna-info-telefon" id="staticInput"></p>
                        </div>
                    </div>
                </div>
                <hr>
                <div class="row mb-1">
                    <div class="col-xl-12 col-md-12 col-12">
                        <label for="disabledInput" class="font-weight-bolder"><h4 style="text-decoration: underline;">Peranan Sistem</h4></label>
                    </div>
                </div>
                <div class="row roles-list">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Tutup</button>
                    <button type="button" class="btn btn-primary post-update-roles">Kemaskini Peranan</button>
                </div>
            </div>
        </div>
    </div>
</div>

<input type="hidden" class="user-id" value="">
