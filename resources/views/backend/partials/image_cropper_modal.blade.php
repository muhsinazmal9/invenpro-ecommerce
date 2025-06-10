<style>
    @media (min-width: 576px) {
        .modal-dialog {
            max-width: 600px;
            margin: 1.75rem auto;
        }
    }
</style>

<div class="modal fade" id="cropImagePop" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header " style="background:#3c5ef0;">
                <h3 class="modal-title text-white" id="myModalLabel"> Upload Image
                </h3>
                <button onclick="$('#cropImagePop').modal('hide');" type="button" class="close text-white btn fs-1"
                    data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body justify-content-center justify-content-center text-center">
                <div id="upload-demo" class="center-block "></div>
                <span style="">Set zoom level</span>
            </div>
            <div class="modal-footer text-center mt-5">
                <button onclick="$('#cropImagePop').modal('hide');" type="button" style="cursor:pointer"
                    class="main-btn danger-btn btn-hover btn-sm me-2 " data-dismiss="modal">Cancel</button>
                <button type="button" id="cropImageBtn" class="main-btn primary-btn btn-hover btn-sm">Save
                    Photo</button>
            </div>
        </div>
    </div>
</div>
