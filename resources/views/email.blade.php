<div class="modal fade" id="emailModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="lead" id="exampleModalLabel">Remove Url</h5>
          <div class="spinner-border text-secondary" role="status" id="loadingIndicatorModal" style="display: none; align-items: center; justify-content: center; font-size: 12px;">
            <span class="visually-hidden">Loading...</span>
        </div>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
          <input type="number" id="removeIDRef" hidden></input>
        </div>
        <div class="modal-body">
            Are you sure you want to remove this url <span class="lead text-primary" id="urlRef"></span> ?
        </div>
        <center>
          
        </center>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
          <button type="button" class="btn btn-danger" onclick="">Save</button>
        </div>
      </div>
    </div>
  </div>
  