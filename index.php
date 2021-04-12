<?php
$result = null;
if (isset($_FILES["converter"])) {
    include "function/execute.php";
    move_uploaded_file($_FILES["converter"]['tmp_name'], __DIR__ . '/IN/' . basename($_FILES['converter']['name']));
    $get = new Execute();
    $name = $get->getContent($_FILES['converter']['name']);
    $result = "<div class='alert alert-success text-center' role='alert'>This is your file genereted -> {$name}</div>";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Freelancer.com</title>
    <link rel='stylesheet' href='https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css' integrity='sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u' crossorigin='anonymous'>
    <script src='https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js' integrity='sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa' crossorigin='anonymous'></script>
    <style>
        * {
            box-sizing: border-box;
        }
        .toTop {
            margin-top: 20%;
        }
        .center-100 {
            margin:0 auto 0 auto;
            width:100%;
        }
    </style>
</head>
<body style="width: 99%;">
    <div class='row toTop'>
        <?php
        if ($result != null) {
            echo "<div class='col-md-12'>";
            echo $result;
            echo "</div>";
        }
        ?>
        <div class='col-md-3'></div>
        <div class='col-md-6'>
            <form action='' method='post' name="process" enctype='multipart/form-data'>
                <div class='input-append center-100'>
                    <input type='file' class='form-control' name='converter' aria-describedby='basic-addon1'>
                    <br />
                    <div class='row text-center'>
                        <button type="submit" value="Search" class="btn btn-primary"><i class="fa fa-file"></i> File Process</button>
                    </div>
                </div>
            </form>
        </div>
        <div class="col-md-3"></div>
    </div>
    <div class="row" style='margin-top: 50px;'>
        <div class="col-md-4"></div>
        <div class='col-md-4'>
        <?php
        $path = "OUT/";
        if (file_exists($path)) {
            $directory = dir($path);
            echo "<ul>";
            while ($file = $directory->read()) {
                if ($file != "." && $file != "..") {
                    $removeExt      = explode(".", $file);
                    echo "<li><a href='{$path}{$file}' class='text-bold' target='_blank'>{$file}</a></li>";
                }
            }
            echo "</ul>";
            $directory->close();
        }
        ?>
        </div>
        <div class='col-md-4'>
    </div>
</body>
</html>
