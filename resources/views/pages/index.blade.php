@extends('layouts.dlayout')
@section('title') {{DB::table('setting_situses')->where('id','=','1')->first()->namaSitus}} Home Pages Setting @endsection

@section('content')

  <div class="content">
      <div class="container-fluid">

          <div class="row">
              <div class="col-12">
                  <div class="card-box table-responsive">
                      <h4 class="m-t-0 header-title">Mengatur Slider</h4>
                      <p class="text-muted font-14 m-b-30">
                          Anda bisa menambah, mengedit dan menghapus slider dimenu ini.
                      </p>
                      <div class="pull-right" style="margin-top:-50px">
                          <button type="button"  href="#" class="btn btn-xs btn-success" id="tambah"> <i class="fa fa-plus"></i> Tambah</button>
                      </div>
                      <br>

                      <table id="contoh" class="table table-bordered table-hover datatable">
                          <thead>
                              <tr>
                                  <th>id</th>
                                  <th>Title</th>
                                  <th>Image</th>
                                  <th>Description</th>
                                  <th>Button`s Title</th>
                                  <th>Link</th>
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
                      <h4 class="m-t-0 header-title">More content coming soon..</h4>
                      <p class="text-muted font-14 m-b-30">
                          ....
                      </p>
                      <div class="pull-right" style="margin-top:-50px">
                          <button type="button"  href="#" class="btn btn-xs btn-success" id="tambah"> <i class="fa fa-plus"></i> Tambah</button>
                      </div>
                      <br>

                      <table id="contoh2" class="table table-bordered table-hover datatable">
                          <thead>
                              <tr>
                                  <th>id</th>
                                  <th>Title</th>
                                  <th>Image</th>
                                  <th colspan="10%">Action</th>
                              </tr>
                          </thead>
                      </table>
                  </div>
              </div>
          </div>
      </div>
  </div>


@endsection


@section('jstambahan')


  <!-- Sweet Alert Js  -->
  <script src="plugins/sweet-alert/sweetalert2.min.js"></script>

  <script type="text/javascript">
    $(document).ready(function() {
      // DataTable
      $('.datatable').DataTable({
              "language": {
              "url": "https://cdn.datatables.net/plug-ins/1.10.16/i18n/Indonesian-Alternative.json"
          },
          processing: true,
          serverSide: true,
          ajax: '{{ route('slide/json') }}',
          columns: [
              {data: 'id', name: 'id'},
              {data: 'title', name: 'title'},
              {data: 'imagesnya', name: 'imagesnya', orderable: false, searchable: false},
              {data: 'description', name: 'description',orderable: false, searchable: false},
              {data: 'btn_title', name: 'btn_title'},
              {data: 'link', name: 'link', orderable: false, searchable: false},
              {data: 'action', name: 'action', orderable: false, searchable: false},
          ]
      });
    });
  </script>

  @if (session('status'))
    <script type="text/javascript">
    !function ($) {
      "use strict";
      var SweetAlert = function () {
      };
      SweetAlert.prototype.init = function () {
          $(document).ready(function () {
              swal(
                  {
                      title: 'Sukses!',
                      text: '{{ session('status') }}',
                      type: 'success',
                      confirmButtonClass: 'btn btn-confirm mt-2'
                  }
              )
          });
        },
     $.SweetAlert = new SweetAlert, $.SweetAlert.Constructor = SweetAlert
          }(window.jQuery),
            function ($) {
                "use strict";
                $.SweetAlert.init()
            } (window.jQuery);
    </script>
  @endif

  @if($errors->any())
  <script type="text/javascript">
  !function ($) {
    "use strict";
    var SweetAlert = function () {
    };
    SweetAlert.prototype.init = function () {
        $(document).ready(function () {
            swal(
                {
                    title: 'Error!',
                    text: '{{$errors->first()}}',
                    type: 'error',
                    confirmButtonClass: 'btn btn-confirm mt-2'
                }
            )
        });
      },
   $.SweetAlert = new SweetAlert, $.SweetAlert.Constructor = SweetAlert
        }(window.jQuery),
          function ($) {
              "use strict";
              $.SweetAlert.init()
          } (window.jQuery);
  </script>
  @endif

@endsection
