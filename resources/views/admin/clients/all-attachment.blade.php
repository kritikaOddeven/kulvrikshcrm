@extends('admin.layouts.app')
@section('pagetitle','Client Attachment | Kulvriksh')
@section('admin-content')
    <div class="py-3 d-flex align-items-sm-center flex-sm-row flex-column">
        <div class="flex-grow-1">
            <h4 class="page-title">View All Attachment</h4>
            <ol class="breadcrumb m-0 py-0">
                <li class="breadcrumb-item"><a href="{{url('admin/clients')}}">Client</a></li>
                <li class="breadcrumb-item active">View All Attachment</li>
            </ol>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card">

                <div class="card-body card-body2">
                    <table id="datatable" class="table table-responsive">
                        <thead class="table-info">
                            <tr>
                                <th>Date</th>
                                <th>Client Name</th>
                                <th>Agent Name</th>
                                <th>Document Name</th>
                                <th data-orderable="false">Action</th>
                            </tr>
                        </thead>

                        <tbody>
                            
                            @forelse ($attachments as $attachment)
                                <tr>
                                    <td>{{ $attachment->created_at->format('Y-m-d') }}</td>
                                    <td>{{ $attachment->lead->first_name.' '. $attachment->lead->last_name}}</td>
                                    <td>{{ $attachment->note->user->name }}</td>
                                    <td>
                                        @if($attachment->type == 'image')
                                            <i class="ri-image-line me-1"></i>
                                        @elseif($attachment->type == 'audio')
                                            <i class="ri-file-music-line me-1"></i>
                                        @elseif($attachment->type == 'application')
                                            <i class="ri-file-pdf-line me-1"></i>
                                        @else
                                            <i class="ri-file-line me-1"></i>
                                        @endif
                                        {{ $attachment->attachment }}
                                    </td>
                                    <td>
                                        <div class="d-flex gap-2">
                                            <a href="{{ asset($attachment->attachment) }}" class="btn-sm edit-icon-btn" download title="Download">
                                                <i class="ri-download-2-line"></i>
                                            </a>
                                            <a href="{{ asset($attachment->attachment) }}" target="_blank" class="view-icon-btn btn-sm btn-action mr-1" title="View">
                                                <i class="ri-eye-line"></i>
                                            </a>
                                            <form action="{{ url('admin/leads/attachment/delete/' . $attachment->id) }}" id="deleteForm_{{ $attachment->id }}" method="POST" style="display:inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="button" class="delete-icon-btn btn-sm btn-action mr-1" data-title="Delete Attachment" data-description="Are you sure you want to delete this attachment?" onclick="deleteAccount(this, {{ $attachment->id }})">
                                                    <i class="ri-delete-bin-6-line"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5">No attachments found for this lead.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
