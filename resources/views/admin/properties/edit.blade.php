@extends('layouts.admin')
@section('title', 'Edit Property')
@section('breadcrumb', 'Properties / Edit')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="page-title">Edit Property</h1>
    <div class="d-flex gap-2">
        <a href="{{ route('properties.show', $property->slug) }}" target="_blank" class="btn btn-outline-secondary rounded-pill px-3">
            <i class="bi bi-eye me-1"></i>View
        </a>
        <a href="{{ route('admin.properties.index') }}" class="btn btn-outline-secondary rounded-pill px-3">
            <i class="bi bi-arrow-left me-1"></i>Back
        </a>
    </div>
</div>

<form method="POST" action="{{ route('admin.properties.update', $property) }}" enctype="multipart/form-data" id="propertyForm">
    @csrf @method('PUT')
    @include('admin.properties._form')
</form>
@endsection
