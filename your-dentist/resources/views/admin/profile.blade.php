@extends('layouts.dashboard')

@section('title', 'Edit Profile | Admin Dashboard')

@section('content')
    <div class="max-w-4xl mx-auto">
        <div class="mb-6">
            <h1 class="text-3xl font-bold text-gray-900">My Profile</h1>
            <p class="text-gray-600 mt-1">Manage your personal information and account settings</p>
        </div>
        
        @include('components.profile-edit-form', [
            'user' => auth()->user(),
            'updateRoute' => route('admin.profile.update'),
            'cancelRoute' => route('admin.dashboard')
        ])
    </div>
@endsection 