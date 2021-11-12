<div class="modal fade text-left modal-primary que-bank-modal" id="primary" tabindex="-1" role="dialog" aria-labelledby="myModalLabel160" aria-hidden="true">
		<div class="modal-dialog modal-dialog-centered modal-lg" role="document">
			<div class="modal-content">
				<div class="modal-header">
	                <h5 class="que-bank-title modal-title" id="myModalLabel160">Tambah Soalan</h5>
	                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
	                    <span aria-hidden="true">&times;</span>
	                </button>
	            </div>
	            <div class="modal-body">
	            	<div class="row">
	            		<div class="form-group col-md-6">
			                                    	<label class="form-label" for="measuring-lvl">Tahap Pengukuran</label>
			                                        <select id="" name="measuring-lvl" class="form-control select2 select-measuring-lvl">
			                                        	 @if(count($measuring_level) > 0)
                                    <option value="">Sila Pilih</option>
                                    @foreach($measuring_level as $ml)
                                        <option value="{{$ml->id}}">{{$ml->name}}</option>
                                    @endforeach
                                @else
                                    <option value="">Tiada Tahap Pengukuran</option>
                                @endif
			                                        </select>
			                                        <input type="hidden" class="hidden-id-measuring" />
			                                    </div>
			            <div class="form-group col-md-6">
			                                    	<label class="form-label" for="competency-type">Jenis Kecekapan</label>
			                                        <select class="form-control select2 select-com-type">
                                @if(count($competency_type) > 0)
                                    <option value="">Sila Pilih</option>
                                    @foreach($competency_type as $ct)
                                        <option value="{{$ct->id}}">{{$ct->dictColCompetencyTypeScaleBridgeCompetency->name}} ({{$ct->dictColCompetencyTypeScaleBridgeScale->name}})</option>
                                    @endforeach
                                @else
                                    <option value="">Tiada Jenis Kecekapan</option>
                                @endif
                            </select>
                            <div class="invalid-feedback"></div>
			                                        <input type="hidden" class="hidden-id-competency" />
			                                    </div>
	            	
	           
	            
	            	<div class="form-group col-md-6">
	            			<label for="basicInput">Kategori Gred</label>
                            <select class="form-control select2 select-grade-category">
                                @if(count($grade_category) > 0)
                                    <option value="">Sila Pilih</option>
                                    @foreach($grade_category as $gc)
                                        <option value="{{$gc->id}}">{{$gc->name}}</option>
                                    @endforeach
                                @else
                                    <option value="">Tiada Kategori Gred</option>
                                @endif
                            </select>
                            <div class="invalid-feedback"></div>
	            	</div>
	            	<div class="form-group col-md-6">
	            		<label for="basicInput">Jurusan</label>
                            <select class="form-control select2 select-jurusan">
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
	             </div>
	            <div class="modal-footer">
	                <button type="button" class="btn btn-danger" data-dismiss="modal">Tutup</button>
	                <button type="button" class="btn btn-success post-add-bank-item">Tambah</button>
	            </div>
			</div>
		</div>
</div>