function imageCrop(width, height) {
    const image_width = width;
    const image_height = height;

    let uploadCrop,
        tempFilename,
        rawImg,
        imageId;


    $('.image-crop').on('change', function () {
        tempFilename = $(this).val().split('\\').pop();
        imageId = $(this).attr('id');
        readFile(this);
    });

    function readFile(input) {
        if (input.files && input.files[0]) {
            let reader = new FileReader();
            reader.onload = function (e) {
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

    $('#cropImagePop').on('shown.bs.modal', function () {
        uploadCrop.croppie('bind', {
            url: rawImg
        }).then(function () {
            console.log('Croppie bind complete');
        });
    });

    $('#cropImageBtn').on('click', function (ev) {
        uploadCrop.croppie('result', {
            type: 'base64',
            format: 'webp',
            size: {
                width: image_width,
                height: image_height
            }
        }).then(function (res) {
            $('#image').val(res);
            $('#image-preview').attr('src', res);
            $('#cropImagePop').modal('hide');
        });
    });
}

export default imageCrop;
