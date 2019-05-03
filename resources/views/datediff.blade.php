<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>dateDiff</title>
  </head>
  <body>
    <form class="" action="/datediff" method="post">
      {{csrf_field()}}
      <label for="">Date 1 : </label>
      <br>
      <input type="text" name="date1" value="">
      <br>
      <label for="">Date 2 : </label>
      <br>
      <input type="text" name="date2" value="">
      <br>
      <input type="submit">
    </form>
  </body>
</html>
