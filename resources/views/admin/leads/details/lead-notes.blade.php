{{-- Notes --}}
<div class="accordion-item">

    <h2 class="accordion-header">
        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapseEight" aria-expanded="true" aria-controls="panelsStayOpen-collapseEight">
            Notes
        </button>
    </h2>
    <div id="panelsStayOpen-collapseEight" class="accordion-collapse collapse show">
        <div class="accordion-body">
            <div class="text-end mb-2">
                <a href="{{ url('admin/leads/' . $data->id . '/attachment') }}" class="text-end view-all-attachment-text">View All Attachment</a>
            </div>
            <div class="row mt-1">
                @foreach ($data->leadNote as $item)
                    <div class="col-md-12 mb-2">
                        <div class="d-flex justify-content-between mb-1">
                            <label class="d-flex align-items-center mb-2 form-label">
                                <img src="{{ asset(get_profile_image($item->user->profile_image, $item->user->name)) }}" class="avatar avatar-sm rounded-circle me-2">
                                {{ $item->user->name ?? '' }}
                            </label>
                            <span class="text-end form-label">{{ $item->created_at->format('D d F, g:i') }}</span>
                        </div>
                        <textarea name="content" class="form-control" rows="8" readonly>{!!$item->content !!}</textarea>
                    </div>
                @endforeach

            </div>
        </div>

    </div>
</div>
