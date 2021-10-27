<?php
$target_dir = "../files/";
$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
$imageExtension = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

$filename = basename($_FILES["fileToUpload"]["name"], ".$imageExtension");


if($_POST['filename'] == null){
    $filename = $filename.time().".".$imageExtension;
}else{
    $filename = $_POST['filename'].time().".".$imageExtension;
}


if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_dir . $filename)) {
    echo "The file ". htmlspecialchars(basename( $_FILES["fileToUpload"]["name"])). " has been uploaded.";
} else {
    var_dump($_FILES['fileToUpload']['error'] );
    echo "Sorry, there was an error uploading your file.";
}
