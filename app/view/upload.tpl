<!DOCTYPE html>
<html>
<head lang="en">
    <meta charset="UTF-8">
    <title></title>
    <script src="/src/external/components/jquery/dist/jquery.js" type="text/javascript"></script>
    <script src="src/external/components/cloudinary/js/jquery.ui.widget.js" type="text/javascript"></script>
    <script src="/src/external/components/cloudinary/js/jquery.iframe-transport.js"
            type="text/javascript"></script>
    <script src="src/external/components/cloudinary/js/jquery.fileupload.js" type="text/javascript"></script>

    <script src="/src/external/components/cloudinary/js/jquery.cloudinary.js"
            type="text/javascript"></script>
    {{$cloudinary_js_config}}
</head>
<body>

<form action="uploaded.php" method="post">
    {{$cl_image_upload_tag}}
    <button type="submit">ok</button>
</form>

</body>
<script>
    $(document).ready(function() {
        $('.cloudinary-fileupload').cloudinary_fileupload({
            disableImageResize: false,
            imageMaxWidth: 800,                           // 800 is an example value
            imageMaxHeight: 600,                          // 600 is an example value
            maxFileSize: 20000000,                        // 20MB is an example value
            loadImageMaxFileSize: 20000000,               // default is 10MB
            acceptFileTypes: /(\.|\/)(gif|jpe?g|png|bmp|ico)$/i
        });
    });
</script>

</html>