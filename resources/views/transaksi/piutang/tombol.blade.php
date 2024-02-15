@if ($data->status == "Belum Lunas")
<a href="/piutang/bayar/{{ $data->id }}"  class="btn btn-primary btn-sm edit" style="float: left; margin-left: 5px; "> <i class="fas fa-edit"></i></a>
@else
-
@endif
