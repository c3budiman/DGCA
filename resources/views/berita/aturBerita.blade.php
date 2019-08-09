@php
  $logo = DB::table('setting_situses')->where('id','=','1')->get()->first()->logo;
@endphp
@extends('layouts.dlayout')

@section('title')
  Berita
@endsection

@section('content')
  {{ csrf_field() }}
  <div class="content">
      <div class="container-fluid">

          <div class="row">
              <div class="col-12">
                  <div class="card-box table-responsive">
                      <h4 class="m-t-0 header-title">Mengatur Berita di Aplikasi</h4>
                      <p class="text-muted font-14 m-b-30">
                          Anda bisa menambah, mengedit dan menghapus berita yang akan tampil di aplikasi disini
                      </p>
                      <div class="pull-right" style="margin-top:-50px">
                          {{-- <a href="/addsidebar" class="btn btn-xs btn-success"> <i class="fa fa-plus"></i> Tambah</a> --}}
                          <a class="btn btn-xs btn-success" href="/tambahBerita" id="tambah"> <i class="fa fa-plus"></i> Tambah</a>
                      </div>

                      <br>

                      <table id="contoh" class="table table-bordered table-hover datatable">
                          <thead>
                              <tr>
                                  <th>Id</th>
                                  <th>Judul</th>
                                  <th>Author</th>
                                  <th colspan="10%">Action</th>
                              </tr>
                          </thead>
                      </table>
                  </div>
              </div>
          </div>
      </div>
  </div>

  <div id="myModal" class="modal fade" role="dialog">
    <div class="modal-dialog">
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title"></h4>
        </div>
        <div class="modal-body">

          <div class="deleteContent">
            Apakah anda yakin akan mendelete berita dengan judul : <span class="nama-kar"></span> ?
              <input type="hidden" id="iddelete">
          </div>


          <div class="modal-footer">
            <button type="button" class="btn actionBtn" data-dismiss="modal">
              <span id="footer_action_button" class='glyphicon'> </span>
            </button>
            <button type="button" class="btn btn-warning" data-dismiss="modal">
    <span class='glyphicon glyphicon-remove'></span> Batal
            </button>
          </div>
        </div>
      </div>
    </div>
  </div>

@endsection

@section('js')
  <script type="text/javascript">
  $(document).ready(function() {
    $('.datatable').DataTable({
            "language": {
            "url": "https://cdn.datatables.net/plug-ins/1.10.16/i18n/Indonesian-Alternative.json"
        },
        processing: true,
        serverSide: true,
        ajax: '{{ route('berita/json') }}',
        columns: [
            {data: 'id_berita', name: 'id_berita'},
            {data: 'judul', name: 'judul'},
            {data: 'authornya.nama', name: 'authornya.nama'},
            {data: 'action', name: 'action', orderable: false, searchable: false},
        ]
    });

    $(document).on('click', '.delete-modal', function() {
        $('#footer_action_button').text(" Delete");
        $('#footer_action_button').removeClass('glyphicon-check');
        $('#footer_action_button').addClass('glyphicon-trash');
        $('.actionBtn').removeClass('btn-success');
        $('.actionBtn').addClass('btn-danger');
        $('.actionBtn').addClass('delete');
        $('.modal-title').text('Delete');
        $('.did').text($(this).data('id'));
        $('.nama-kar').text($(this).data('nama'));
        $('.deleteContent').show();
        $('.form-horizontal').hide();
        $('#iddelete').val($(this).data('id'));
        $('#myModal').modal('show');
    });

    $('.modal-footer').on('click', '.delete', function() {
        $.ajax({
            type: "POST",
            url: "/delete/berita",
            dataType: "json",
            data: {
              '_token': $('input[name=_token]').val(),
              id_berita: $("#iddelete").val(),
            },
            success: function (data, status) {
              $(document).ready(function() {
                $('.datatable').DataTable().ajax.reload(null, false);
              });
            },
            error: function (request, status, error) {
                console.log($("#iddelete").val());
                console.log(request.responseJSON);
                $.each(request.responseJSON.errors, function( index, value ) {
                  alert( value );
                });
            }
        });
    });


  });
  </script>
@endsection
