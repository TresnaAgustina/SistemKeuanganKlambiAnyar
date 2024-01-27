
    {{-- <a data-toggle="modal" data-target="#modal-lg" href="/mstr/jaritan/update/{{ $data->id }}" class="btn btn-warning btn-sm update-btn" style="float: left; margin-left: 5px; "> <i class="fas fa-edit"></i></a> --}}
    <a data-toggle="modal"  href="#" data-id="{{ $data->id }}" class="btn btn-warning btn-sm update-btn" style="float: left; margin-left: 5px;"> <i class="fas fa-edit"></i></a>

    <a href="#" data-id="{{ $data->id }}" class="btn btn-danger btn-sm del" style="float: left; margin-left: 5px; "> <i class="fas fa-trash-alt"></i></a>
    
   
    <div class="modal fade" id="test">
      <div class="modal-dialog modal-lg">
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title">Tambah Data Jaritan</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>

          <div class="modal-body">
            <form>
                <div class="form-group">
                    <label for="jenis">Jenis Jaritan</label>
                    <input type="text" class="form-control" id="jenis" >
                </div>
                <div class="form-group">
                    <label for="hargaDalam">Harga Dalam</label>
                    <input type="text" class="form-control" id="hargaDalam" >
                </div>                          
                <div class="form-group">
                    <label for="hargaLuar">Harga Luar</label>
                    <input type="text" class="form-control" id="hargaLuar" >
                </div>                          

                {{-- <div class="card-footer">
                <button type="submit" class="btn btn-primary">Submit</button>
                </div> --}}

                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary simpan">Simpan</button>
                </div>
            </form>
          </div>
        </div>
        <!-- /.modal-content -->
      </div>
      <!-- /.modal-dialog -->
    </div>

