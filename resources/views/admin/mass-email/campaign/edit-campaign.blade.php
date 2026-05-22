<div class="modal fade" id="editCampaignModal" tabindex="-1" aria-labelledby="exampleModalPopoversLabel" aria-modal="true">
    <div class="modal-dialog ">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalPopoversLabel">Edit Mail Campaign</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <form id="editCampaignForm" action="{{ route('admin.mass-email.campaign.update') }}" method="POST">
                @csrf
               
                <div class="modal-body row g-3">
                    <input type="hidden" name="id" id="id">
                    <div class="col-md-6">
                        <label for="validationDefault01" class="form-label">Template Name <x-required-star /></label>
                        <select class="form-select" id="template_id" name="template_id">
                            @foreach ($templates as $item)
                                <option value="{{ $item->id }}">{{ $item->template_name }}</option>
                            @endforeach
                        </select>
                        <span class="text-danger">
                            @error('template_id')
                                {{ $message }}
                            @enderror
                        </span>
                    </div>

                    <div class="col-md-6">
                        <label for="validationDefault04" class="form-label">Status</label>
                        <select class="form-select" id="status" readonly disabled>
                            <option value="pending">Pending</option>
                        </select>
                    </div>

                    <div class="col-md-6">
                        <label for="validationDefault01" class="form-label">Start Date <x-required-star /></label>
                        <div class="position-relative">
                            <input type="text" class="form-control basic-datepicker" id="start_date" name="start_date" placeholder="dd-mm-yyyy">
                            <i class="ri-calendar-2-line calendar-icon"></i>
                        </div>
                        <span class="text-danger" id="start_date_error">
                            @error('start_date')
                                {{ $message }}
                            @enderror
                        </span>
                    </div>

                    <div class="col-md-6">
                        <label for="validationDefault01" class="form-label">Start Time <x-required-star /></label>
                        <div class="position-relative">
                            <input type="text" class="form-control" id="start_time" name="start_time" placeholder="Enter start time">
                            <i class="ri-calendar-2-line calendar-icon"></i>
                        </div>
                        <span class="text-danger" id="start_time_error">
                            @error('start_time')
                                {{ $message }}
                            @enderror
                        </span>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                    <button type="submit" name="submit" class="btn btn-primary">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>
