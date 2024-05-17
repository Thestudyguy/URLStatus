<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#new-client">
    New <i class="fas fa-plus"></i>
</button>
<div class="modal fade disable" id="new-client">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
        <div class="overlay" id="overlay">
        <i class="loader"></i>
            </div>
            <div class="modal-header">
                <h4 class="modal-title">New Client</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div id="alert-error-container">
            </div>
            <div class="modal-body">
                <div class="card">
                    <div class="card-header">
                        Client
                    </div>
                <div class="card-body">
                    <div class="form-group">
                        <label for="client">Client:</label>
                        <input type="text" class="form-control" id="client" name="client">
                    </div>
                    <div class="form-group">
                        <label for="email">Email:</label>
                        <input type="email" class="form-control" id="email" name="email">
                    </div>
                    <div class="form-group">
                        <label for="contact_number">Contact:</label>
                        <input type="number" class="form-control" id="contact" name="contact">
                    </div>
                </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col col-lg-6 col-md-6 col-6">
                        <div class="card" id="card-url">
                            <div class="card-header">URL</div>
                            <div class="card-body">
                                <div class="input-group input-group-url">
                                </div>
                            </div>
                            <div class="card-footer">
                                <button class="btn btn-primary btn-sm" id="add-url-button">Add Url <i class="fas fa-plus"></i></button>
                            </div>
                        </div>
                    </div>
                    <div class="col col-lg-6 col-md-6 col-6">
                        <div class="card border" id="card-email">
                            <div class="card-header">Email to notify</div>
                            <div class="card-body">
                            <div class="input-group input-group-email">
                                </div>
                            </div>
                            <div class="card-footer"><button class="btn btn-primary btn-sm" id="add-email-button">Add Email <i class="fas fa-plus"></i></button></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
            {{-- <button type="button" class="btn btn-success swalDefaultSuccess">
                  Launch Success Toast
                </button> --}}
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="button" id="saveBtn" class="btn btn-primary">Save</button>
            </div>
        </div>
    </div>
</div>