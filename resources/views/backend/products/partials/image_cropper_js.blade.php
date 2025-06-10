<script type="text/javascript">
    $(document).ready(function() {

        const image_width = 570;
        const image_height = 360;

        // Start upload preview image

        let uploadCrop,
            tempFilename,
            rawImg,
            imageId;

        function readFile(input) {
            // $(".cr-image").attr('src', "");
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function(e) {
                    $('#upload-demo').addClass('ready');
                    $('#cropImagePop').modal('show');
                    rawImg = e.target.result;
                }
                reader.readAsDataURL(input.files[0]);
            } else {
                swal("Sorry - you're browser doesn't support the FileReader API");
            }
        }

        uploadCrop = $('#upload-demo').croppie({
            viewport: {
                width: image_width,
                height: image_height,
            },
            enforceBoundary: false,
            enableExif: true
        });

        $('#cropImagePop').on('shown.bs.modal', function() {
            uploadCrop.croppie('bind', {
                url: rawImg
            }).then(() => {}));
        });

        $('.image-crop').on('change', function() {
            // imageId = $(this).data('id');
            // tempFilename = $(this).val();
            // $('#cancelCropBtn').data('id', imageId);
            readFile(this);
        });

        $('#cropImageBtn').on('click', function(ev) {

            uploadCrop.croppie('result', {
                type: 'base64',
                format: 'webp',
                size: {
                    width: image_width,
                    height: image_height
                }
            }).then(function(res) {
                $('#image').val(res);
                $('#image-preview').attr('src', res);
                $('#cropImagePop').modal('hide');
            });
        });
    })
</script>
