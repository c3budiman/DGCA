<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
  <title>{{$front->nama}} Menu`s Code</title>
  <style type="text/css" media="screen">
    body {
        overflow: hidden;
    }

    #editor {
        margin: 0;
        position: absolute;
        top: 0;
        bottom: 0;
        left: 0;
        right: 0;
    }

    #save {
      position: fixed;
      right: 40px;
      top: 10px;
    }
  </style>
  <link href="{{URL::asset('assets/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
  <script src="{{ URL::asset('assets/js/jquery.min.js') }}"></script>
  <script src="{{ URL::asset('assets/js/jquery.core.js') }}"></script>
</head>
<body>
{{ csrf_field() }}
<pre id="editor">{{ $front->content }}</pre>
<button id="save" type="button" name="button" onclick="save()" class="btn btn-success">Save</button>

<script src="{!! asset('assets/src-noconflict/ace.js') !!}" type="text/javascript" charset="utf-8"></script>
<script>
    var editor = ace.edit("editor");
    editor.setTheme("ace/theme/twilight");
    editor.session.setMode("ace/mode/html");

    function save() {
      var r = confirm("Ubah Nama Menu? \n (pilih batal/cancel untuk lanjut save tanpa mengubah nama menu)");
      if (r == true) {
        $(document).ready(function() {
          var nama_menu = prompt("Masukkan Nama Menu yang Baru : ", "{{$front->nama}}");
          $.ajax({
              type: "POST",
              url: "/front/edit",
              dataType: "json",
              data: {
                '_token': $('input[name=_token]').val(),
                id: {{$front->id}},
                nama: nama_menu,
                content: editor.getValue(),
              },
              success: function (data, status) {
                  if (data.eror) {
                    alert(data.eror);
                  } else {
                    alert("data berhasil disimpan");
                  }
              },
              error: function (request, status, error) {
                  console.log(request.responseJSON);
                  $.each(request.responseJSON.errors, function( index, value ) {
                    alert( value );
                  });
              }
          });
        });
      } else {
        $(document).ready(function() {
          $.ajax({
              type: "POST",
              url: "/front/edit",
              dataType: "json",
              data: {
                '_token': $('input[name=_token]').val(),
                id: {{$front->id}},
                nama: "{{$front->nama}}",
                content: editor.getValue(),
              },
              success: function (data, status) {
                if (data.eror) {
                  alert(data.eror);
                } else {
                  alert("data berhasil disimpan");
                }
              },
              error: function (request, status, error) {
                  console.log(request.responseJSON);
                  $.each(request.responseJSON.errors, function( index, value ) {
                    alert( value );
                  });
              }
          });
        });
      }
    }
</script>

</body>
</html>
