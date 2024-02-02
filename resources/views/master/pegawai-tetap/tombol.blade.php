
    {{-- <a data-toggle="modal" data-target="#modal-lg" href="/mstr/jaritan/update/{{ $data->id }}" class="btn btn-warning btn-sm update-btn" style="float: left; margin-left: 5px; "> <i class="fas fa-edit"></i></a> --}}
    <a data-toggle="modal"  href="#" data-id="{{ $data->id }}" class="btn btn-warning btn-sm update-btn" style="float: left; margin-left: 5px;"> <i class="fas fa-edit"></i></a>

    <a href="#" data-id="{{ $data->id }}" class="btn btn-danger btn-sm del" style="float: left; margin-left: 5px; "> <i class="fas fa-trash-alt"></i></a>

    <div class="modal fade" id="test">
      <div class="modal-dialog modal-lg">
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title">Update Data Pegawai Tetap</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>

          <div class="modal-body">
            <form action="" method="">
              @csrf
                <div class="form-group">
                    <label for="nama">Nama Pegawai</label>
                    <input name="nama" type="text" class="form-control" id="nama" required>
                </div>                          
                <div class="form-group">
                    <label for="alamat">Alamat</label>
                    <input name="alamat" type="text" class="form-control" id="alamat" required>
                </div>                          
                <div class="form-group">
                    <label for="no_telp">Nomor Telepon</label>
                    <input name="no_telp" type="text" class="form-control" id="no_telp" required>
                </div>                          
                <div class="form-group">
                    <label for="jenis_kelamin">Jenis Kelamin</label>
                    <select name="jenis_kelamin" id="jk" class="form-control">
                      <option>~ Pilih ~</option>
                      <option value="Perempuan">Perempuan</option>
                      <option value="Laki-laki">Laki-laki</option>
                    </select>
                    {{-- <input name="JK" type="text" class="form-control" id="jk" required> --}}
                </div>                          
                <div class="form-group">
                    <label for="gaji_pokok">Gaji Pokok</label>
                    <input name="gaji_pokok" type="text" class="form-control" id="gaji" required>
                </div>                          
                                       
                <div class="form-group">
                  <label>Status</label>
                  <select name="status" id="status" class="form-control">
                    <option> ~ Pilih ~</option>
                    <option value="active">Aktif</option>
                    <option value="inactive">Tidak Aktif</option>
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

    @push('scripts')
    <script>
      $('.card-body').on('click', '.update-btn', function(e){
          e.preventDefault();
          var id = $(this).data('id');

          // Tambahkan pernyataan console.log untuk menampilkan nilai id
          console.log('Nilai $data->id:', id);

          // Selanjutnya, gunakan nilai 'id' sesuai kebutuhan Anda
          // ...
      });
    </script>
    @endpush