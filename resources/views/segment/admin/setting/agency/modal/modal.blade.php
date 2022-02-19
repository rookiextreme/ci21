<div class="modal fade text-left modal-primary agency-modal" id="primary" tabindex="-1" role="dialog" aria-labelledby="myModalLabel160" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="grade-title modal-title" id="myModalLabel160">Primary Modal</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-xl-12 col-md-6 col-12 mb-1">
                        <div class="form-group">
                            <label for="basicInput">Carian Agensi</label>
                            <select class="agensi-carian form-control" id="select2-ajax"></select>
                            <div class="invalid-feedback"></div>
                        </div>
                    </div>
                    <div class="col-xl-12 col-md-6 col-12 mb-1">
                        <div class="form-group">
                            <label for="basicInput">Pilihan induk</label>
                            <select class="form-control select2 parent-agency">
                                <option value="">Sila Pilih Induk</option>
                                @foreach($agencies as $ss)
                                    <option value="{{$ss['id']}}">{{$ss['name']}}</option>
                                @endforeach
                            </select>
                            <div class="invalid-feedback"></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Tutup</button>
                <button type="button" id="btn-agency" class="btn btn-success post-add-agency">Tambah</button>
            </div>
        </div>
    </div>
</div>
<input type="hidden" class="agency-id" value="">
