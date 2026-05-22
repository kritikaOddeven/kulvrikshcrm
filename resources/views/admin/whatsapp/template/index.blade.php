@extends('admin.layouts.app')
@section('pagetitle','Whatsapp-Message | Kulvriksh')
@section('admin-content')
    <div class="row py-3 align-items-sm-center justify-content-between gap-2">
        <div class="col-auto">
            <h4 class="page-title">View All Template</h4>
            <ol class="breadcrumb m-0 py-0">
                <li class="breadcrumb-item"><a href="javascript: void(0);">WhatsApp Message</a></li>
                <li class="breadcrumb-item active">View All Template</li>
            </ol>
        </div>
        <div class="d-flex flex-wrap gap-2 col-auto">
            <a href="{{url('admin/whatsapp/template/add')}}" type="button" class="btn btn-primary">+ Add Template</a>
           
        </div>
    </div>

    <div class="row">
        {{-- Alert message --}}
        <x-alert />
        <div class="col-12">
            <div class="card">

                <div class="card-body card-body2">
                    <table id="datatable" class="table table-responsive">
                        <thead class="table-info">
                            <tr>
                                <th>Template Name</th>
                                <th>Template Type</th>
                                <th>Message Preview</th>
                                <th data-orderable="false">Action</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach ($templates as $template)
                                <tr>
                                    <td>{{ $template->template_name }}</td>
                                    <td>{{ $template->template_type ?? 'Text Message Only' }}</td>
                                    <td>{{ Str::limit($template->message_text, 100) }}</td>
                                    <td>
                                        <div class="d-flex gap-2">
                                            <a href="{{ url('admin/whatsapp/template/view/' . $template->id) }}" class="view-icon-btn btn-sm btn-action rounded-pill mr-1" title="view"><i class="ri-eye-line"></i></a>
                                        
                                            <a href="{{ url('admin/whatsapp/template/edit/' . $template->id) }}" class="edit-icon-btn btn-sm btn-action rounded-pill mr-1" title="edit"><i class="ri-edit-line"></i></a>
                                            
                                            <form action="{{ url('admin/whatsapp/template/delete/' . $template->id) }}" method="POST" id="deleteForm_{{ $template->id }}" style="display:inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="button" class="delete-icon-btn btn-sm btn-action mr-1" data-bs-toggle="tooltip" title="delete" data-title="Delete WhatsApp Template" data-description="Are you sure you want to delete this Template?" onclick="deleteAccount(this, {{ $template->id }})">
                                                    <i class="ri-delete-bin-6-line"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>

                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection 