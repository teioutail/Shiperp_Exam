<!-- Modal For Provider -->
<div class="modal fade" id="providerModal" tabindex="-1" role="dialog" aria-labelledby="providerLabel" aria-hidden="true">
<div class="modal-dialog" role="document">
    <div class="modal-content">
    <div class="modal-header">
        <h5 class="modal-title" id="providerLabel">Modal</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <div class="modal-body">
        <form>
            <!-- Id -->
            <input type="hidden" name="pro_id" id="pro_id" value="">
            <!-- Name -->
            <div class="form-group">
                <label for="name">Name</label>
                <input type="text" id="pro_name" name="pro_name" class="form-control" aria-describedby="pro_name">
            </div>
            <!-- URL -->
            <div class="form-group">
                <label for="description">URL</label>
                <input type="text" id="pro_url" name="pro_url" class="form-control" aria-describedby="pro_url">
            </div>
        </form>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary save_changes">Save changes</button>
    </div>
    </div>
</div>
</div>