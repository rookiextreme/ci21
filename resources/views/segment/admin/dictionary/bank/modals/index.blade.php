<div class="modal fade text-left modal-primary dict-bank-modal" id="primary" tabindex="-1" role="dialog" aria-labelledby="myModalLabel160" aria-hidden="true">
		<div class="modal-dialog modal-dialog-centered modal-lg" role="document">
			<div class="modal-content">
				<div class="modal-header">
	                <h5 class="dict-bank-title modal-title" id="myModalLabel160">Tambah Penilaian</h5>
	                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
	                    <span aria-hidden="true">&times;</span>
	                </button>
	            </div>
	            <div class="modal-body">
	            	<div class="row">
	            		<div class="col-xl-12 col-md-6 col-12 mb-1">
	            			<section class="modern-horizontal-wizard">
	            				<div class="bs-stepper wizard-modern dict-bank-wizard">
	            					<div class="bs-stepper-header">
	            						<div class="step" data-target="#maklumat-asas">
			                                <button type="button" class="step-trigger">
			                                    <span class="bs-stepper-box">
			                                        <i data-feather="file-text" class="font-medium-3"></i>
			                                    </span>
			                                    <span class="bs-stepper-label">
			                                        <span class="bs-stepper-title">Maklumat Asas</span>
			                                        <span class="bs-stepper-subtitle">Isian Maklumat Asas</span>
			                                    </span>
			                                </button>
			                            </div>
			                             <div class="line">
			                                <i data-feather="chevron-right" class="font-medium-2"></i>
			                            </div>
			                            <div class="step" data-target="#maklumat-kategori">
			                                <button type="button" class="step-trigger">
			                                    <span class="bs-stepper-box">
			                                        <i data-feather="file-text" class="font-medium-3"></i>
			                                    </span>
			                                    <span class="bs-stepper-label">
			                                        <span class="bs-stepper-title">Maklumat Kategori</span>
			                                        <span class="bs-stepper-subtitle">Isian Maklumat Kategori</span>
			                                    </span>
			                                </button>
			                            </div>
	            					</div>
	            					<div class="bs-stepper-content">
	            						
	            						<div id="maklumat-asas" class="content">
	            							<div class="content-header">
			                                    <h5 class="mb-0">Maklumat Asas</h5>
			                                    <small class="text-muted"></small>
			                                </div>
			                                 <div class="row">
			                                 	<div class="form-group col-md-6">
			                                        <label class="form-label" for="title">Tajuk</label>
			                                        <input type="text" id="title" value="" name="title" class="form-control title-bank-text"/>
			                                        <input type="hidden" class="hidden-id-bank" />
			                                    </div>
			                                    <div class="form-group col-md-6">
			                                    	<label class="form-label" for="title">Tahun</label>
			                                        <select id="title" name="title" class="form-control select2 year-bank-select">
			                                        	<option value="">- Sila Pilih Tahun -</option>
			                                        	@foreach($years as $year)
			                                        	<option value="{{$year}}">{{$year}}</option>
			                                        	@endforeach
			                                        </select>
			                                    </div>
			                                 </div>
			                                 <div class="row">
			                                 	<div class="col-md-6 form-group">
				                                    <label for="tkh_mula">Tarikh mula</label>
				                                    <input type="text" id="tkh_mula" name="" class="form-control flatpickr-date-time start-date-bank" />
				                                </div>
				                                <div class="col-md-6 form-group">
				                                    <label for="tkh_akhir">Tarikh akhir</label>
				                                    <input type="text" id="tkh_akhir" name="" class="form-control flatpickr-date-time end-date-bank" />
				                                </div>
			                                 </div>
			                                 <div class="d-flex justify-content-between">
			                                    <button class="btn btn-outline-secondary btn-prev" disabled>
			                                        <i data-feather="arrow-left" class="align-middle mr-sm-25 mr-0"></i>
			                                        <span class="align-middle d-sm-inline-block d-none">Previous</span>
			                                    </button>
			                                    <button class="btn btn-primary btn-next">
			                                        <span class="align-middle d-sm-inline-block d-none">Next</span>
			                                        <i data-feather="arrow-right" class="align-middle ml-sm-25 ml-0"></i>
			                                    </button>
			                                </div>
	            						</div>

	            						<div id="maklumat-kategori" class="content">
	            							<div class="content-header">
			                                    <h5 class="mb-0">Maklumat Kategori</h5>
			                                    <small class="text-muted"></small>
			                                </div>
			                                <div class="row">
			                                    <div class="form-group col-md-6">
			                                    	<label class="form-label" for="competency-type">Jenis Kecekapan</label>
			                                        <select id="" name="competency-type" class="form-control select2 select-compentency-type">
			                                        	<option value="">- Sila Pilih Jenis Kecekapan -</option>
			                                        	@foreach($competency_types as $ct)
			                                        	<option value="{{$ct->id}}">{{$ct->name}}</option>
			                                        	@endforeach
			                                        </select>
			                                        <input type="hidden" class="hidden-id-competency" />
			                                    </div>
			                                    <div class="form-group col-md-6">
			                                    	<label class="form-label" for="measuring-lvl">Tahap Pengukuran</label>
			                                        <select id="" name="measuring-lvl" class="form-control select2 select-measuring-lvl">
			                                        	<option value="">- Sila Pilih Tahap Pengukuran -</option>
			                                        	@foreach($measuring_levels as $ml)
			                                        	<option value="{{$ml->id}}">{{$ml->name}}</option>
			                                        	@endforeach
			                                        </select>
			                                        <input type="hidden" class="hidden-id-measuring" />
			                                    </div>
			                                </div>
			                                <div class="row">
			                                	<div class="form-group col-md-6">
			                                    	<label class="form-label" for="grade-category">Kategori Gred</label>
			                                        <select id="" name="grade-category" class="form-control select2 select-grade-category">
			                                        	<option value="">- Sila Pilih Kategori Gred -</option>
			                                        	@foreach($grade_category as $gc)
			                                        	<option value="{{$gc->id}}">{{$gc->name}}</option>
			                                        	@endforeach
			                                        </select>
			                                        <input type="hidden" class="hidden-id-grade-catgory" />
			                                    </div>
			                                    <div class="form-group col-md-6">
			                                    	<label class="form-label" for="grades">Gred - Gred</label>
			                                        <select id="" name="grades" class="form-control select2 select-grades" multiple>
			                                        	<option value="">- Sila Pilih Gred -</option>
			                                        	@foreach($grades as $g)
			                                        	<option value="{{$g->id}}">{{$g->name}}</option>
			                                        	@endforeach
			                                        </select>
			                                    </div>
			                                </div>
			                                <div class="d-flex justify-content-between">
			                                    <button class="btn btn-primary btn-prev">
			                                        <i data-feather="arrow-left" class="align-middle mr-sm-25 mr-0"></i>
			                                        <span class="align-middle d-sm-inline-block d-none">Previous</span>
			                                    </button>
			                                    <button class="btn btn-success btn-submit btn-save-bank">Save</button>
			                                    <button class="btn btn-success btn-submit btn-submit-bank">Submit</button>
			                                </div>
	            						</div>
	            					</div>
	            				</div>
	            			</section>
	            		</div>
	            	</div>
	            </div>
			</div>
		</div>
</div>
<input type="hidden" class="dict-bank-id" value="">