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
