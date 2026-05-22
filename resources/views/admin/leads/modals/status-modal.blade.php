<!-- Reusable Status Modal -->
<div class="modal fade" id="statusModal" tabindex="-1" aria-labelledby="statusModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form action="{{ url('admin/leads/status') }}" method="POST" id="statusForm">
            @csrf
            <input type="hidden" name="id" id="status_lead_id">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="statusModalLabel">Status Update</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body row g-3">
                    <div class="col-md-12">
                        <label class="form-label">Status</label>
                        <select class="form-select" name="status" id="statusSelect" required>
                            <option value="high">High</option>
                            <option value="low">Low</option>
                            <option value="done">Done</option>
                            <option value="close">Close</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save</button>
                </div>
            </div>
        </form>
    </div>
</div>
