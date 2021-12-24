<div class="modal fade" id="planetModal" tabindex="-1" aria-labelledby="planetModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="planetModalLabel">Save Planet</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>

      <div class="modal-body">
        <form id="planetForm">
            <input class="form-control" name="id" id="planetId" hidden>

            <div class="form-group">
                <label for="planetName">Name</label>
                <input class="form-control" name="name" id="planetName" placeholder="Enter planet name">
            </div>

            <div class="form-group">
                <label for="planetType">Type</label>
                <select class="form-control" name="type" id="planetType">
                  <!-- populated dynamically on load -->
                </select>
            </div>

            <div class="form-group">
                <label for="planetSize">Size</label>
                <input type="number" class="form-control" name="size" id="planetSize" value="10">
            </div>
        </form>
      </div>

      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button id="planetFormSubmit" type="button" class="btn btn-primary">Save</button>
      </div>
    </div>
  </div>
</div>