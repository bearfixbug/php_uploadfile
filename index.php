<?php
    session_start();
    $_SESSION['RespDisplay'] = 'none';

    if(isset($_POST['btn-submit'])) {
        $filename = $_FILES['uploadfile']['name'];
        $ext = pathinfo($filename, PATHINFO_EXTENSION);
        $allowed = array('jpg', 'png', 'jpeg');
        if(!in_array($ext, $allowed)) {
            $_SESSION['RespClass'] = 'danger';
            $_SESSION['RespDisplay'] = 'block';
            $_SESSION['RespMessage'] = 'Invalid file name extension';
        }
        else {
            $name = explode(".", $filename);
            $ext = $name[1];
            $milliseconds = round(microtime(true) * 1000);
            $newfilename = $milliseconds . "." . $ext;
            //1645378115933.png

            $tmpname = $_FILES['uploadfile']['tmp_name'];
            $moveto = './uploads/' . $newfilename;
            //./uploads/1645378115933.png

            if(move_uploaded_file($tmpname, $moveto)) {
                chmod('./uploads/'.$newfilename, 0777);
                $_SESSION['RespClass'] = 'success';
                $_SESSION['RespDisplay'] = 'block';
                $_SESSION['RespMessage'] = 'Upload successfully';
                $_SESSION['Result'] = $newfilename;
            }
            else {
                $_SESSION['RespClass'] = 'danger';
                $_SESSION['RespDisplay'] = 'block';
                $_SESSION['RespMessage'] = 'Upload fail. Something is went wrong!';
            }
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
</head>
<body>

    <form class="container" action="./index.php" method="post" enctype="multipart/form-data">
        <br>
        <div class="alert alert-<?php echo $_SESSION['RespClass']; ?>" role="alert" style="display: <?php echo $_SESSION['RespDisplay']; ?>">
            <?php echo $_SESSION['RespMessage']; ?>
        </div>
        <h1>Upload file PHP</h1>

        <?php if(isset($_SESSION['Result']) && $_SESSION['RespClass'] == 'success') { ?>
            <img src="./uploads/<?php echo $_SESSION['Result']; ?>" style="width: 500px; object-fit: cover; display: <?php echo $_SESSION['RespDisplay']; ?>">
        <?php } ?>

        <div class="mb-3">
            <input type="file" name="uploadfile"  class="form-control" required>
        </div>
        <button type="submit" name="btn-submit" class="btn btn-primary">
            Upload
        </button>
        
    </form>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>
</html>