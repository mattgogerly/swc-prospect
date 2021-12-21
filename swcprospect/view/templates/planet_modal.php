<div class="modal fade" id="planetModal" tabindex="-1" aria-labelledby="planetModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="planetModalLabel">Save Planet</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>

      <div class="modal-body">
        <form>
            <div class="form-group">
                <label for="planetName">Name</label>
                <input class="form-control" id="planetName" placeholder="Enter planet name" value="<?= $planet->getName() ?>">
            </div>

            <div class="form-group">
                <label for="planetType">Type</label>
                <select class="form-control" id="planetType">
                    <option>1</option>
                    <option>2</option>
                    <option>3</option>
                    <option>4</option>
                    <option>5</option>
                </select>
            </div>

            <div class="form-group">
                <label for="planetSize">Size</label>
                <input type="number" class="form-control" id="planetSize" placeholder="10" value="<?= $planet->getSize() ?>">
            </div>
        </form>
      </div>

      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Save</button>
      </div>
    </div>
  </div>
</div>