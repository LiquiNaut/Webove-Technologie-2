<!DOCTYPE html>
<html lang="sk">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css"
          integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm"
          crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"
            integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN"
            crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"
            integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q"
            crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"
            integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl"
            crossorigin="anonymous"></script>

    <script src="script.js"></script>
    <link rel="stylesheet" href="style.css">

    <title>File uploader</title>

</head>
<body>
<div>
    <div class="modal-content text-center" id="modal1">
    <form action="upload.php" method="post" enctype="multipart/form-data">
        <div class="form-group">
            <label for="filename"><b>Insert your filename:</b></label>
            <input name="filename" type="text" id="filename" class="form-control col-md-auto text-center" placeholder="File name">
        </div>
        Select image to upload:
        <input type="file" name="fileToUpload" id="fileToUpload">
        <input type="submit" value="Upload" name="submit" id="sub2">
    </form>
    </div>
    <div class="modal-content" id="modal2">
    <table class="table" id="Table">
        <thead>
        <tr>
            <th onclick="sortable(0)" scope="col">Name</th>
            <th onclick="sortable(1)" scope="col">Size</th>
            <th onclick="sortable(2)" scope="col">Date of the upload</th>
        </tr>
        </thead>
        <tbody>
        <?php
        $target_dir = "../files/";
        $files = scandir($target_dir);

        foreach ($files as $item) {
            if (($item == ".") && ($target_dir == "../files/")) {

            }else if(($item == "..") && ($target_dir == "../files/")) {

            }else if(is_dir($target_dir.$item)){
                echo '<tr><td> <a type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModalCenter" href=" ' . $target_dir.$item .'">' . $item . '</a></td>';
                echo "<td>"," ","</td>";
                echo "<td>"," ","</td></tr>";
            }else{
                echo "<tr><td>",$item,"</td>";
                echo "<td>",filesize($target_dir.$item),"</td>";
                echo "<td>",date("F d Y H:i:s", filectime($target_dir.$item)),"</td></tr>";
            }
        }
        ?>
        </tbody>
    </table>
    </div>
    <div>

        <!-- Modal -->
        <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-body">
                        <div class="modal-content" id="modal2">
                            <table class="table" id="Table">
                                <thead>
                                <tr>
                                    <th scope="col">Name</th>
                                    <th scope="col">Size</th>
                                    <th scope="col">Date of the upload</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php
                                $target_dir = "../files/NewSubfolder/";
                                $files = scandir($target_dir);

                                foreach ($files as $item) {
                                    if (($item == ".") && ($target_dir == "../files/NewSubfolder/")) {

                                    }else if(($item == "..") && ($target_dir == "../files/NewSubfolder/")) {

                                    }else if(is_dir($target_dir.$item)){
                                        echo "<tr><td>",$item,"</td>";
                                        echo "<td>"," ","</td>";
                                        echo "<td>"," ","</td></tr>";
                                    }else{
                                        echo "<tr><td>",$item,"</td>";
                                        echo "<td>",filesize($target_dir.$item),"</td>";
                                        echo "<td>",date("F d Y H:i:s", filectime($target_dir.$item)),"</td></tr>";
                                    }
                                }
                                ?>
                                </tbody>
                            </table>
                        </div>
                        <div class="text-center">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

</body>
</html>

