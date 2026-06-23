@extends('layouts.app')

@section('content')
    <div class="space-y-6">
        <h2 class="font-bold text-2xl text-gray-900 leading-tight">
            {{ __('Pengaturan Profil') }}
        </h2>

        <div class="space-y-6">
            <!-- Update Profile Info Card -->
            <div class="p-6 sm:p-8 bg-white shadow-sm rounded-2xl border border-gray-100">
                <div class="max-w-xl text-gray-900">
                    @include('profile.partials.update-profile-information-form')
                </div>
            </div>

            <!-- Update Password Card -->
            <div class="p-6 sm:p-8 bg-white shadow-sm rounded-2xl border border-gray-100">
                <div class="max-w-xl text-gray-900">
                    @include('profile.partials.update-password-form')
                </div>
            </div>

            <!-- Delete Account Card -->
            <div class="p-6 sm:p-8 bg-white shadow-sm rounded-2xl border border-gray-100">
                <div class="max-w-xl text-gray-900">
                    @include('profile.partials.delete-user-form')
                </div>
            </div>
        </div>
    </div>
@endsection

