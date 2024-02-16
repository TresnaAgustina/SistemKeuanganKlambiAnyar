@if ($data->status == "belum lunas")
<a href="/kasbon-tetap/bayar/{{ $data->id }}"  class="btn btn-primary btn-sm edit" style="float: left; margin-left: 5px; "> <i class="fas fa-edit"></i></a>
@else
-
@endif
