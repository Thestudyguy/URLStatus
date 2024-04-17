<div class="modal fade" id="urlemailModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
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
           <div class="input-group">
            <input type="text" class="form-control" placeholder="Enter URL" name="url" id="url">
            <button class="btn btn-outline-secondary" type="button" onclick="scanURL()">Scan URL</button>
        </div>
        <div id="resultContainer">
            <strong>
                <p id="res">Result: </p>
            </strong>
            <p id="url-detected"></p>
            <p id="final-result"></p>
        </div>
        <textarea name="email" id="insertMail" style="resize: none;" placeholder="email must be seperated by comma" cols="30" rows="10" class="form-control mt-1"></textarea>
        <div class="spinner-border text-secondary" role="status" id="loadingIndicator" style="display: none; align-items: center; justify-content: center;">
            <span class="visually-hidden">Loading...</span>
        </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
          <button type="button" class="btn btn-primary" onclick="saveURLandEmail()">Save</button>
        </div>
      </div>
    </div>
  </div>
<!-- php ([a-zA-Z0-9]+)([\_\.\-{1}])?([a-zA-Z0-9]+)\@([a-zA-Z0-9]+)([\.])([a-zA-Z\.]+) -->