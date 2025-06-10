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

                    div.innerHTML = `<img img-key="${randomImageKey}" class='output_multiple_image' src="${picFile.result}"/><span onclick="deleteMultipleImageItem(this.parentElement)" class="d-none"><svg width="20" height="22" viewBox="0 0 20 22" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M7.32617 2.21719L6.50977 3.4375H12.7402L11.9238 2.21719C11.8594 2.12266 11.752 2.0625 11.6359 2.0625H7.60977C7.49375 2.0625 7.38633 2.11836 7.32187 2.21719H7.32617ZM13.6426 1.07422L15.2195 3.4375H15.8125H17.875H18.2188C18.7902 3.4375 19.25 3.89727 19.25 4.46875C19.25 5.04023 18.7902 5.5 18.2188 5.5H17.875V18.5625C17.875 20.4617 16.3367 22 14.4375 22H4.8125C2.91328 22 1.375 20.4617 1.375 18.5625V5.5H1.03125C0.459766 5.5 0 5.04023 0 4.46875C0 3.89727 0.459766 3.4375 1.03125 3.4375H1.375H3.4375H4.03047L5.60742 1.06992C6.0543 0.403906 6.80625 0 7.60977 0H11.6359C12.4395 0 13.1914 0.403906 13.6383 1.06992L13.6426 1.07422ZM3.4375 5.5V18.5625C3.4375 19.323 4.05195 19.9375 4.8125 19.9375H14.4375C15.198 19.9375 15.8125 19.323 15.8125 18.5625V5.5H3.4375ZM6.875 8.25V17.1875C6.875 17.5656 6.56563 17.875 6.1875 17.875C5.80937 17.875 5.5 17.5656 5.5 17.1875V8.25C5.5 7.87187 5.80937 7.5625 6.1875 7.5625C6.56563 7.5625 6.875 7.87187 6.875 8.25ZM10.3125 8.25V17.1875C10.3125 17.5656 10.0031 17.875 9.625 17.875C9.24687 17.875 8.9375 17.5656 8.9375 17.1875V8.25C8.9375 7.87187 9.24687 7.5625 9.625 7.5625C10.0031 7.5625 10.3125 7.87187 10.3125 8.25ZM13.75 8.25V17.1875C13.75 17.5656 13.4406 17.875 13.0625 17.875C12.6844 17.875 12.375 17.5656 12.375 17.1875V8.25C12.375 7.87187 12.6844 7.5625 13.0625 7.5625C13.4406 7.5625 13.75 7.87187 13.75 8.25Z" fill="white"/>
                    </svg>
                    </span>`;
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
