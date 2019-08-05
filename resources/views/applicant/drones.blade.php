@extends('layouts.dlayout')

@section('title') {{DB::table('setting_situses')->where('id','=','1')->first()->namaSitus}} | Pendaftaran @endsection

@section('content')
<div class="content">
    <div class="container-fluid">

<div class="row">
    <div class="col-12">
        <div class="card-box table-responsive">
            <h4 class="m-t-0 header-title">Non Approved Drones List</h4>
            <p class="text-muted font-14 m-b-30">
                You can add, edit and delete drones in this menu.
            </p>
            <div class="pull-right" style="margin-top:-50px">
                <a  href="addDrones" class="btn btn-xs btn-success"> <i class="fa fa-plus"></i> Add</a>
            </div>

            <br>

            <table id="contoh" class="table table-bordered table-hover datatable">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Manufacturer</th>
                        <th>Model</th>
                        <th>Term of Ownership</th>
                        <th>Term of Possession</th>
                        <th colspan="10%">Action</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <div class="card-box table-responsive">
            <h4 class="m-t-0 header-title">Approved Drones List</h4>
            <p class="text-muted font-14 m-b-30">
                You can delete drones in this menu.
            </p>
            <br>

            <table id="contoh2" class="table table-bordered table-hover datatable2">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Manufacturer</th>
                        <th>Model</th>
                        <th>Term of Ownership</th>
                        <th>Term of Possession</th>
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
        </form>
        <div class="deleteContent">
          Are you sure to delete user with id : <span class="dname"></span> <span
            class="hidden did"></span> ?
            <input type="hidden" id="iddelete">
        </div>


        <div class="modal-footer">
          <button type="button" class="btn actionBtn" data-dismiss="modal" onclick="HideAgain()">
            <span id="footer_action_button" class='glyphicon'> </span>
          </button>
          <button type="button" class="btn btn-warning" data-dismiss="modal" onclick="HideAgain()">
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
      ajax: '{{ route('nadrones/json') }}',
      columns: [
          {data: 'DT_Row_Index', name: 'DT_Row_Index', orderable: false, searchable: false},
          {data: 'manufacturer', name: 'manufacturer'},
          {data: 'model', name: 'model'},
          {data: 'termofowenership', name: 'termofowenership'},
          {data: 'termofposession', name: 'termofposession'},
          {data: 'action', name: 'action', orderable: false, searchable: false},
      ]
  });

  $('.datatable2').DataTable({
      processing: true,
      serverSide: true,
      ajax: '{{ route('appdrones/json') }}',
      columns: [
          {data: 'DT_Row_Index', name: 'DT_Row_Index', orderable: false, searchable: false},
          {data: 'manufacturer', name: 'manufacturer'},
          {data: 'model', name: 'model'},
          {data: 'termofowenership', name: 'termofowenership'},
          {data: 'termofposession', name: 'termofposession'},
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
      $('.deleteContent').show();
      $('.form-horizontal').hide();
      $('#iddelete').val($(this).data('id'));
      $('.dname').html($(this).data('name'));
      $('#myModal').modal('show');
  });

    $('.modal-footer').on('click', '.delete', function() {
        $.ajax({
            type: "POST",
            <?php
            $link = DB::table('setting_situses')->where('id','=','1')->first()->alamatSitus;
             ?>
            url: "{{$link}}/drones/delete",
            dataType: "json",
            data: {
              '_token': $('input[name=_token]').val(),
              id: $("#iddelete").val(),
            },
            success: function (data, status) {
                $('.datatable').DataTable().ajax.reload(null, false);
                $('.datatable2').DataTable().ajax.reload(null, false);
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
