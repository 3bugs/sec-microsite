<!DOCTYPE html>
<html>
<body>

<p>Click on the "Choose File" button to upload a file:</p>

<form method="post" action="/testfile" enctype="multipart/form-data">
  @csrf
  <input type="text" id="myText" name="myText"><br><br>
  <input type="file" id="myFile" name="myFile"><br><br>
  <input type="submit">
</form>

</body>
</html>
