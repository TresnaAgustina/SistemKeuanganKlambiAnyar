
    <a href="#" data-id="{{ $data->id }}" class="btn btn-warning btn-sm edit" style="float: left; margin-left: 5px; "> <i class="fas fa-edit"></i></a>

    <a href="#" data-id="{{ $data->id }}" class="btn btn-danger btn-sm del" style="float: left; margin-left: 5px; "> <i class="fas fa-trash-alt"></i></a>

    <div class="modal fade" id="test">
        <div class="modal-dialog modal-lg">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">Tambah Data Pengeluaran</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
  
            <div class="modal-body">
              <form action="" method="">
                @csrf
                  <div class="form-group">
                      <label for="nama">Nama Atribut</label>
                      <input type="text" class="form-control" id="nama" name="nama_atribut" required >
                  </div>
                  <div class="form-group">
                    <label>Tipe</label>
                    <select name="tipe" id="tipe" class="form-control">
                      <option value="perusahaan">Perusahaan</option>
                      <option value="pribadi">Pribadi</option>
                    </select>
                  </div> 
                                          
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

   

