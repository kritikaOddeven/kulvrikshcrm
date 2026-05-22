@extends('admin.layouts.app')
@section('pagetitle','Profile | Kulvriksh')
@section('admin-content')
<div class="py-3 d-flex align-items-sm-center flex-sm-row flex-column">
    <div class="flex-grow-1">
        <h4 class="page-title">Profile</h4>
        <p>Profile</p>
    </div>
</div>

<div class="row">
    {{-- Alert message --}}
    <x-alert />
    <div class="col-12">
        <!-- <img src="{{ asset('assets/admin/images/small/user-image.jpg') }}" class="rounded-top-2 img-fluid" alt="image data"> -->
        <div class="profile-backbox"></div>
        <div class="hando-main-sections">
            <form action="{{ route('admin.profile.update-image') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="hando-profile-main position-relative">
                    <img src="{{ asset(get_profile_image(Auth::user()->profile_image, Auth::user()->name)) }}"
                        class="rounded-circle img-fluid avatar-xxl img-thumbnail float-start" alt="Profile Image"
                        id="profileImagePreview">

                    <label for="profileImageInput" class="sil-profile_main-pic-change img-thumbnail position-absolute"
                        style="top: 80px; left: auto; cursor: pointer; right: 0;">
                        <i class="ri-camera-ai-line text-white"></i>
                    </label>

                    <input type="file" name="profile_image" id="profileImageInput" accept=".png, .jpg, .jpeg"
                        style="display: none;" onchange="this.form.submit()">
                </div>

            </form>
            <div class="overflow-hidden">
                <h4 class="card-title">{{ $user->name }}</h4>
                <span class="fs-15">India</span></span>
            </div>
        </div>
        @error('profile_image')
        <span class="text-danger">{{ $message }}</span>
        @enderror
    </div>
</div>


<div class="row">
    <div class="col-lg-3 col-md-12">
        <div class="card">
            <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">

                @can('view_profile')
                <a class="nav-link {{ !session('password_error') ? 'active' : '' }}" id="v-pills-profile-tab"
                    data-bs-toggle="pill" href="#v-pills-profile" role="tab" aria-controls="v-pills-profile"
                    aria-selected="{{ !session('password_error') ? 'true' : 'false' }}">Personal Information</a>
                @endcan

                @can('update_password')
                @can('view_profile')

                <a class="nav-link {{ session('password_error') ? 'active' : '' }}" id="v-pills-password-tab"
                    data-bs-toggle="pill" href="#v-pills-password" role="tab" aria-controls="v-pills-password"
                    aria-selected="{{ session('password_error') ? 'true' : 'false' }}" tabindex="-1">Change Password</a>

                @endcan
                @endcan
            </div>
        </div>
    </div>
    <div class="col-lg-9 col-md-12">

        <div class="tab-content p-0 text-muted mt-md-0" id="v-pills-tabContent">
            @can('view_profile')
            <div class="tab-pane fade {{ !session('password_error') ? 'active show' : '' }}" id="v-pills-profile"
                role="tabpanel" aria-labelledby="v-pills-profile-tab">
                <div class="card">
                    <div class="card-header">
                        <div class="profile">
                            <h4 class="card-title">Personal Information</h4>
                        </div>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('admin.update.profile') }}" method="POST">
                            @csrf
                            <div class="row">
                                <input type="hidden" name="id" value="{{ $user->id }}">
                                <div class="col-md-6">
                                    <div class="form-group mb-3 row">
                                        <label class="form-label">Name
                                            <x-required-star />
                                        </label>
                                        <div class="col-lg-12 col-xl-12">
                                            <input class="form-control" type="text" name="name"
                                                value="{{ $user->name }}">
                                            <span class="text-danger">
                                                @error('name')
                                                {{ $message }}
                                                @enderror
                                            </span>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group mb-3 row">
                                        <label class="form-label">Role
                                            <x-required-star />
                                        </label>
                                        <div class="col-lg-12 col-xl-12">
                                            @php
                                            $roleName = $user->roles->pluck('name')->first() ?? '';
                                            $formattedRoleName = ucwords(str_replace(['_', '-'], ' ', $roleName));
                                            @endphp
                                            <input class="form-control" type="text" disabled name=""
                                                value="{{ $formattedRoleName ?? '' }}">
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group mb-3 row">
                                        <label class="form-label">Phone</label>
                                        <div class="col-lg-12 col-xl-12">
                                            <div class="input-group">
                                                <span class="input-group-text"><i class="ri-phone-line"></i></span>
                                                <input class="form-control" type="text" placeholder="Phone" name="phone"
                                                    value="{{ $user->phone }}" maxlength="10"
                                                    oninput="this.value = this.value.replace(/[^0-9]/g, '')">
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group mb-3 row">
                                        <label class="form-label">Email
                                            <x-required-star />
                                        </label>
                                        <div class="col-lg-12 col-xl-12">
                                            <div class="input-group">
                                                <span class="input-group-text"><i class="ri-mail-line"></i></span>
                                                <input type="text" class="form-control" value="{{ $user->email }}"
                                                    placeholder="Email" name="email">
                                                <span class="text-danger">
                                                    @error('email')
                                                    {{ $message }}
                                                    @enderror
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                {{-- <div class="col-md-6">
                                    <div class="form-group mb-3 row">
                                        <label class="form-label">Country</label>
                                        <div class="col-lg-12 col-xl-12">
                                            <input class="form-control" type="text" name="" value="India">
                                        </div>
                                    </div>
                                </div> --}}
                                @can('update_profile')
                                <div class="col-lg-12 col-xl-12 text-end">
                                    <button type="submit" class="btn btn-primary mb-2 mb-md-0">Save</button>
                                </div>
                                @endcan
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            @endcan

            @can('update_password')
              @can('view_profile')
            <div class="tab-pane fade {{ session('password_error') ? 'active show' : '' }}" id="v-pills-password"
                role="tabpanel" aria-labelledby="v-pills-password-tab">
                <div class="card">
                    <div class="card-header">
                        <div class="profile">
                            <h4 class="card-title">Change Password</h4>
                        </div>
                    </div>

                    <div class="card-body mb-0">
                        <form action="{{ route('admin.update.password') }}" method="POST" class="needs-validation">
                            @csrf
                            <input type="hidden" name="email" value="{{ $user->email }}">
                            <div class="row">
                                <div class="col-lg-4 col-md-6">
                                    <div class="form-group mb-3 row">
                                        <label class="form-label">Old Password
                                            <x-required-star />
                                        </label>
                                        <div class="col-lg-12 col-xl-12">
                                            <input class="form-control" type="password" name="current_password"
                                                placeholder="Old Password">
                                            @error('current_password')
                                            <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-6">
                                    <div class="form-group mb-3 row">
                                        <label class="form-label">New Password
                                            <x-required-star />
                                        </label>
                                        <div class="col-lg-12 col-xl-12">
                                            <input class="form-control" type="password" id="new_password"
                                                name="new_password" placeholder="New Password">
                                            @error('new_password')
                                            <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-6">
                                    <div class="form-group mb-3 row">
                                        <label class="form-label">Confirm Password<x-required-star /></label>
                                        <div class="col-lg-12 col-xl-12">
                                            <input class="form-control" type="password" id="confirm_password"
                                                name="password_confirmation" placeholder="Confirm Password">
                                            <span id="password_error" style="color:red; font-size: 14px;"></span>
                                            @error('password_confirmation')
                                            <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-12 col-xl-12 text-end">
                                    <button type="submit" class="btn btn-primary mb-2 mb-md-0">Change Password</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div><!-- end col -->
            </div><!-- end row -->
              @endcan
            @endcan
        </div>
    </div>


    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const newPassword = document.getElementById('new_password');
        const confirmPassword = document.getElementById('confirm_password');
        const errorSpan = document.getElementById('password_error');

        confirmPassword.addEventListener('input', function() {
            if (newPassword.value !== confirmPassword.value) {
                errorSpan.textContent = "Passwords do not match.";
            } else {
                errorSpan.textContent = "";
            }
        });
    });
    </script>
    @endsection