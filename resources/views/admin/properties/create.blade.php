@extends('layouts.admin')
@section('title', 'Add Property')
@section('breadcrumb', 'Properties / Add New')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="page-title">Add New Property</h1>
    <a href="{{ route('admin.properties.index') }}" class="btn btn-outline-secondary rounded-pill px-3">
        <i class="bi bi-arrow-left me-1"></i>Back
    </a>
</div>

<form method="POST" action="{{ route('admin.properties.store') }}" enctype="multipart/form-data" id="propertyForm">
    @csrf
    @include('admin.properties._form')
</form>
@endsection
