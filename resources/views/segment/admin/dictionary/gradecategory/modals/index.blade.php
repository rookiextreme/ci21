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
