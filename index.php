<?php 
    include_once('database.php');
    $sql = 'Select * from '.$tbname.' order by id asc';
    $result = $conn->query($sql);

    $gallery_html = '';

    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $gallery_html .= '<div class="gallery-item" data-id="'.$row['id'].'" data-url="'.$row['imgURL'].'" data-description="'.$row['imgDescription'].'" style="background-image:url(./upload/'.$row['imgName'].')"><div class="item-desc">'.$row['imgDescription'].'</div></div>';
        }
    } else {
        $gallery_html='No Images';
    }
    $conn->close();
?>
<!DOCTYPE HTML>
<html>
<head>
    <title>Image Uploader</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="bootstrap-4.6.0-dist/css/bootstrap.min.css">
    <script src="js/jquery-3.5.1.min.js"></script>
    <script src="js/popper-1.16.0.min.js"></script>
    <script src="bootstrap-4.6.0-dist/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="css/main.css">
    <script src="js/main.js"></script>
</head>
<body>
    <div class="toast mt-3">
        <div class="toast-body">
        </div>
    </div>
    <p class="caption mt-5 text-center mb-4">Image Uploader with url and description</p>
    <div class="d-flex justify-content-center">
        <div class="side-bar text-center">
            <form id="uploadimage" action="" method="post" enctype="multipart/form-data">
                <input type="hidden" name="ajax-action" class="ajax-action" value="" />
                <input type="hidden" name="active-img" class="active-img" value="" />
                <div class="p-3">
                    <input type="button" value="Upload" class="img-submit button-custom">
                    <input type="file" name="file" id="file" style="display: none">
                    <a href="javascript:;" class="img-file button-custom">Browser</a>
                    <input type="text" name="img-url" class="img-url" placeholder="Img Url">
                    <input type="text" name="img-desc" class="img-desc" placeholder="Img Description">
                </div>
                <div class="p-3 pt-5">
                    <a href="javascript:;" class="img-delete button-custom">Delete</a>
                    <a href="javascript:;" class="img-update button-custom">Update</a>
                </div>
            </form>
        </div>
        <div class="img-content">
            <div class="img-gallery">
                <?php
                    echo $gallery_html;
                ?>
            </div>
            <div class="img-uploader text-center" style="display: none;">
                <p class="mt-4 mb-3">Preview Image</p>
                <div><img id="previewing"></div>
                <input type="button" value="Cancel" class="mt-3">
            </div>
        </div>
    </div>
    <div id="loading" style="display: none;">
        <img src="images/loading_circle.gif"> Loading...
    </div>
</body>
</html>