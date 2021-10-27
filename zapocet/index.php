<?php

if($_POST){
    var_dump(strip_tags($_POST['inputbox']));
}
?>
<!--script injection-->
<!DOCTYPE html>
<html lang="sk">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js" integrity="sha384-JEW9xMcG8R+pH31jmWH6WWP0WintQrMb4s7ZOdauHnUtxwoG2vI5DkLtS3qm9Ekf" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.1/dist/umd/popper.min.js" integrity="sha384-SR1sx49pcuLnqZUnnPwx6FCym0wLsk5JZuNx2bPPENzswTNFaQU1RDvt3wT4gWFG" crossorigin="anonymous"></script>

    <link rel="stylesheet" type="text/css" href="style.css" media="screen"/>

    <title>Simple Web</title>
</head>
<body>
<section id="cover">
    <div id="cover-caption">
        <div id="container" class="container">
            <div class="row">
                <div class="col-sm-10 offset-sm-1 text-center">
                    <h1 class="display-3">Insert script</h1>
                    <div class="info-form">
                        <form action="index.php" method="post" class="form-inline justify-content-center">
                            <div class="form-group">
                                <label for="inputbox"></label><br>
                                <textarea name="inputbox" id="inputbox" cols="30" rows="10"></textarea>
                            </div>
                            <br>
                            <button type="submit" class="btn btn-success ">Submit code</button>
                        </form>
                    </div>
                    <br>
                </div>
            </div>
        </div>
    </div>
</section>
</body>
</html>



<!--<script>-->
<!--    alert("you'been hacked");-->
<!--    const number = parseInt(prompt('Enter a positive number: '));-->
<!--    let n1 = 0, n2 = 1, nextTerm;-->
<!---->
<!--    console.log('Fibonacci Series:');-->
<!--    console.log(n1); // print 0-->
<!--    console.log(n2); // print 1-->
<!---->
<!--    nextTerm = n1 + n2;-->
<!---->
<!--    while (nextTerm <= number) {-->
<!---->
<!--        // print the next term-->
<!--        console.log(nextTerm);-->
<!---->
<!--        n1 = n2;-->
<!--        n2 = nextTerm;-->
<!--        nextTerm = n1 + n2;-->
<!--    }-->
<!--</script>-->
