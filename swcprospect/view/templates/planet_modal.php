<div class="modal fade" id="planetModal" tabindex="-1" aria-labelledby="planetModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="planetModalLabel">Save Planet</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>

      <form id="planetForm">
        <div class="modal-body">
          <input name="planetId" id="planetId" hidden>

          <div class="row mb-3">
              <label class="col-sm-2 col-form-label" for="planetName">Name</label>
              <div class="col-sm-10">
                <input class="form-control" name="name" id="planetName" placeholder="Enter planet name" required>
              </div>
          </div>

          <div class="row mb-3">
              <label class="col-sm-2 col-form-label" for="planetType">Type</label>
              <div class="col-sm-10">
                <select class="form-control" name="type" id="planetType" required>
                  <!-- populated dynamically on load -->
                </select>
              </div>
          </div>

          <div class="row mb-3">
              <label class="col-sm-2 col-form-label" for="planetSize">Size</label>
              <div class="col-sm-10">
                <input type="number" class="form-control" name="size" id="planetSize" value="10" required>
              </div>
          </div>

          <div class="row mb-3">
            <label class="col-sm-2 col-form-label" for="terrainMap">Terrain Map</label>
            <div class="col-sm-10">
              <textarea class="form-control" rows="10" name="terrainMap" id="terrainMap" required><?php
              for ($i = 0; $i < 10; $i++) {
                  echo "1, 1, 1, 1, 1, 1, 1, 1, 1, 1";

                  if ($i != 9) {
                      echo ",\n";
                  }
              }
                ?></textarea>
            </div>
          </div>
        </div>

        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary">Save</button>
        </div>
      </form>
    </div>
  </div>
</div>