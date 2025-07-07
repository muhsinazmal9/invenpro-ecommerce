window.onload = function () {
    //Check File API support
    if (window.File && window.FileList && window.FileReader) {
        const filesInput = document.getElementById("gallery_images_input");

        filesInput.addEventListener("change", function (event) {
            // remove placeholder image first
            const imagePreviewPlaceholder = document.querySelector(
                ".gallery-image-preview-placeholder"
            );

            if (imagePreviewPlaceholder) {
                imagePreviewPlaceholder.remove();
            }

            const files = event.target.files; //FileList object
            const output = document.getElementById("images_preview");
            $("#multipleImageNewFeatureTitle").removeClass("d-none");

            for (let i = 0; i < files.length; i++) {
                const file = files[i];

                //Only pics
                // if (!file.type.match("image")) continue;

                const picReader = new FileReader();

                picReader.addEventListener("load", function (event) {
                    const picFile = event.target;

                    // generate random key
                    const randomImageKey = Math.random()
                        .toString(36)
                        .substring(2, 8);

                    $("#multiple_images").append(
                        `<input type="hidden" class="${randomImageKey}"  name="image_gallery[]" value="${picFile.result}">`
                    );

                    const div = document.createElement(`div`);
                    div.classList.add("col-4");
                    div.classList.add("product-upload-photo");

                    div.innerHTML = `<img img-key="${randomImageKey}" class='output_multiple_image' src="${picFile.result}"/>
                        <span onclick="deleteMultipleImageItem(this.parentElement)" class="d-none"><i class="mdi mdi-close"></i></span>`;
                    output.insertBefore(div, null);
                });

                //Read the image
                picReader.readAsDataURL(file);
            }
        });
    } else {
        console.log("Your browser does not support File API");
    }
};
