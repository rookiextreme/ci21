<div class="modal fade text-left modal-primary penyelia-modal" id="primary" tabindex="-1" role="dialog" aria-labelledby="myModalLabel160" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="penyelia-title modal-title" id="myModalLabel160">Primary Modal</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <section id="basic-datatable">
                    <div class="row">
                        <div class="col-xl-4 col-md-6 col-4 mb-1">
                            <div class="form-group">
                                <label for="basicInput">Nama/Nokp</label>
                                <input type="text" class="form-control" id="penyelia-nama" placeholder=""/>
                            </div>
                        </div>
                        <div class="col-xl-4 col-md-6 col-4 mb-1">
                            <div class="form-group">
                                <label for="basicInput">Gred</label>
                                <select class="form-control" id="penyelia-gred">
                                    <option value="">Papar Semua</option>
                                    <option value="41">Gred 41</option>
                                    <option value="44">Gred 44</option>
                                    <option value="48">Gred 48</option>
                                    <option value="52">Gred 52</option>
                                    <option value="54">Gred 54</option>
                                    <option value="55">Gred Jusa/Turus</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-xl-4 col-md-6 col-4 mb-1">
                            <div class="form-group">
                                <label for="basicInput">Jurusan</label>
                                <select class="form-control" id="penyelia-jurusan">
                                    <option value="">Papar Semua</option>
                                    @foreach($jurusan as $j)
                                        <option value="{{$j->kod_jurusan}}">{{$j->jurusan}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <table class="penyelia-table table">
                                    <thead>
                                    <tr>
                                        <th>Nama</th>
                                        <th>Nokp</th>
                                        <th>Jurusan</th>
                                        <th>Gred</th>
                                        <th>Tindakan</th>
                                    </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </div>
</div>
<input type="hidden" class="grade-id" value="">

<div class="modal fade text-left modal-primary job-group-modal" id="primary" tabindex="-1" role="dialog" aria-labelledby="myModalLabel160" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="job-group-title modal-title" id="myModalLabel160">Primary Modal</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <section id="basic-datatable">
                    <div class="row">
                        <div class="col-xl-12 col-md-6 col-12 mb-1">
                            <div class="form-group">
                                <label for="basicInput">Jurusan</label>
                                <select class="form-control" id="job-group-jurusan">
                                    <option value="">Papar Semua</option>
                                    @foreach($jurusan as $j)
                                        <option value="{{$j->kod_jurusan}}">{{$j->jurusan}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <table class="job-group-table table">
                                    <thead>
                                    <tr>
                                        <th>Job Group</th>
                                        <th>Jurusan</th>
                                        <th>Tindakan</th>
                                    </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </div>
</div>
