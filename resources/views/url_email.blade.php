<div class="modal fade" id="urlemailModal" tabindex="-1" role="dialog" aria-labelledby="urlemailModal" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="lead" id="exampleModalLabelURLMail">New URL</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="alert visually-hidden m-3" id="mdlAlrt">
        <strong><div id="alertTitle"></div></strong>
        <div style="font-size: 12px;" id="pasText"></div>
      </div>
      <div class="modal-body">
         <div class="input-group">
          <input type="text" class="form-control" placeholder="Enter URL" name="url" id="url">
        </div>
        <hr>
        <div id="emailInputs" class="mt-3">
          <div class="input-group mt emailInput" id="emailInputGroup_1">
            <input type="email" class="form-control emailInput" placeholder="Enter Email" name="email[]" required>
            <button class="btn btn-outline-danger px-3" id="testID" type="button" onclick="removeEmailInput(1)">Remove</button>
          </div>
        </div>
        <button type="button" class="btn btn-primary mt-2" id="addEmailInput">Add Email</button>
      </div>
      <div class="modal-footer">
        <button type="button" id="closeSaveModal" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
        <button type="button" id="saveBtn" class="btn btn-primary" onclick="saveURLandEmail()">
        <div class="spinner-border text-secondary" role="status" id="loadingIndicatorSave" style="display: none; align-items: center; justify-content: center; font-size: 18px; width: 20px; height: 20px;">
          <span class="visually-hidden">Loading...</span>
        </div>
        <span class="" id="samText">Scan & Save</span></button>
      </div>
    </div>
  </div>
</div>