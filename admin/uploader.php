<?php

if(isset($_FILES['filefield'])){
$file=$_FILES['filefield'];
$upload_directory='uploads/';
$ext_str = "gif,jpg,jpeg,mp3,tiff,bmp,doc,docx,ppt,pptx,txt,pdf";
$allowed_extensions=explode(',',$ext_str);
$max_file_size = 10485760;//10 mb remember 1024bytes =1kbytes /* check allowed extensions here */
$ext = substr($file['name'], strrpos($file['name'], '.') + 1); //get file extension from last sub string from last . character
if (!in_array($ext, $allowed_extensions) ) {
echo "only".$ext_str." files allowed to upload"; // exit the script by warning

} /* check file size of the file if it exceeds the specified size warn user */

if($file['size']>=$max_file_size){

echo "only the file less than ".$max_file_size."mb  allowed to upload"; // exit the script by warning

}

//if(!move_uploaded_file($file['tmp_name'],$upload_directory.$file['name'])){

$path=md5(microtime()).'.'.$ext;

if(move_uploaded_file($file['tmp_name'],$upload_directory.$path)){

mysql_connect("localhost","root","");

mysql_select_db("upload");

echo"Your File Successfully Uploaded";

mysql_query("INSERT INTO gravator VALUES ('', '$path')");

}

else{

echo "The file cant moved to target directory."; //file can't moved with unknown reasons likr cleaning of server temperory files cleaning

}

}

/*

Hurrey we uploaded a file to server successfully.

*/

?>
<form action="" method="post" enctype="multipart/form-data">
<label>Upload File

<input id="filefield" type="file" name="filefield" />

</label>

<label>

<input id="Upload" type="submit" name="Upload" value="Upload" />

<!-- This hidden input will force the  PHP max upload size. it may work on all servers. -->

<input type="hidden" name="MAX_FILE_SIZE" value="100000" />

</label></form>




<?php //  display  file  upload  form
if  (!isset($_POST['submit']))  { ?>
<form enctype="multipart/form-data" action="<?php echo $_SERVER['PHP_SELF']?>" method="post">

<input type="hidden" name="MAX_FILE_SIZE" value="8000000" />&nbsp&nbsp Select file:

<input type="file" name="data" />

<input type="submit" name="submit" value="Upload  File" /></form>

<?php
}  else  {
//  check  uploaded  file  size
if  ($_FILES['data']['size']  ==  0)  {
die("ERROR:  Zero  byte  file  upload");
}
//  check  if  file  type  is  allowed  (optional)
$allowedFileTypes  =  array("image/gif",  "image/jpeg",  "image/pjpeg");
if  (!in_array($_FILES['data']['type'],  $allowedFileTypes)) {
die("ERROR:  File  type  not  permitted");
} //  check  if  this  is  a  valid  upload
if  (!is_uploaded_file($_FILES['data']['tmp_name']))   {
die("ERROR:  Not  a  valid  file  upload"); } //  set  the  name  of  the  target  directory
$uploadDir  =  "./uploads/"; //  copy  the  uploaded  file  to  the  directory
move_uploaded_file($_FILES['data']['tmp_name'],  $uploadDir  .  $_FILES['data']['name'])  or  die("Cannot  copy  uploaded  file"); //  display  success  message
echo  "File  successfully  uploaded  to  "  .  $uploadDir  .$_FILES['data']['name']; }
 ?>
