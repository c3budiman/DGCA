@extends('layouts.dlayout')

@section('title')
  Adding Soal UAS Assessment
@endsection

@section('css')
  <script src="{{ asset('js/app2.js') }}"></script>
@endsection

@section('soal')
<div class="content">
    <div class="container-fluid">

        <div class="row">
            <div class="col-12">
                <div class="card-box table-responsive">
                    <h4 class="m-t-0 header-title">Soal UAS Assessment</h4>
                    <p class="text-muted font-14 m-b-30">
                        Menu ini untuk menambah soal untuk uas Assessment
                    </p>

                    <div class="pull-right" style="margin-top:-50px">
                        <a href="/parameter/addsoal"> <button type="submit" class="btn btn-success btn-sm"> <i class="fa fa-plus"></i> Add Soal </button> </a>
                        <!-- <button type="button"  href="/addsoal" class="btn btn-xs btn-success"> <i class="fa fa-plus"></i> Add</button> -->
                    </div>

                    <br>

                    <table id="contoh" class="table table-bordered table-hover datatable">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Soal</th>
                                <th>Aktif</th>
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
        <form class="form-horizontal" role="form">
          {{ csrf_field() }}
          <div class="form-group">
            <label class="control-label col-sm-2" for="id">ID:</label>
            <div class="col-sm-10">
              <input type="text" class="form-control" id="fid" disabled>
            </div>
          </div>

          <div class="form-group">
            <label class="control-label col-sm-10" for="name">Roles Name:</label>
            <div class="col-sm-10">
              <input type="name" class="form-control" id="n">
            </div>
          </div>

        </form>


        <div class="modal-footer">
          <button type="button" class="btn actionBtn" data-dismiss="modal">
            <span id="footer_action_button" class='glyphicon'> </span>
          </button>
          <button type="button" class="btn btn-warning" data-dismiss="modal">
            <span class='glyphicon glyphicon-remove'></span> Cancel
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

  // DataTable
  $('.datatable').DataTable({
      processing: true,
      serverSide: true,
      ajax: '{{ route('soal/json') }}',
      columns: [
          {data: 'id', name: 'id'},
          {data: 'soal', name: 'soal'},
          {data: 'aktif', name: 'aktif'},
          {data: 'action', name: 'action', orderable: false, searchable: false},
      ]
  });


  // ShowModals
  $(document).on('click', '.edit-modal', function() {
        $('#footer_action_button').text("Edit");
        $('#footer_action_button').addClass('glyphicon-check');
        $('#footer_action_button').removeClass('glyphicon-trash');
        $('.actionBtn').addClass('btn-success');
        $('.actionBtn').removeClass('btn-danger');
        $('.actionBtn').addClass('edit');
        $('.modal-title').text('Editing Roles');
        $('.deleteContent').hide();
        $('.form-horizontal').show();
        $('#fid').val($(this).data('id'));
        $('#n').val($(this).data('namarule'));
        $('#myModal').modal('show');
    });

    $('.modal-footer').on('click', '.edit', function() {
        $.ajax({
            type: "POST",
            url: "/roles/edit",
            dataType: "json",
            data: {
              '_token': $('input[name=_token]').val(),
              id: $("#fid").val(),
              namaRule: $("#n").val(),
            },
            success: function (data, status) {
                $('.datatable').DataTable().ajax.reload(null, false);
            },
            error: function (request, status, error) {
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
