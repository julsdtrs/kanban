@extends('layouts.app')
@section('title', $priority->name)
@section('content')
<div class="setup-detail-page">
    <div class="d-flex justify-content-between align-items-center setup-detail-header">
        <h1 class="h4 mb-0 fw-600">{{ $priority->name }}</h1>
        <div class="btn-group">
            <a href="{{ route('priorities.edit', $priority) }}" class="btn btn-primary"><i class="bi bi-pencil me-1"></i> Edit</a>
            <a href="{{ route('priorities.index') }}" class="btn btn-outline-secondary"><i class="bi bi-arrow-left me-1"></i> Back</a>
        </div>
    </div>
    <div class="card setup-detail-card">
        <div class="card-header">Priority details</div>
        <div class="card-body">
            <dl class="row mb-0">
                <dt class="col-sm-3">Level</dt><dd class="col-sm-9">{{ $priority->level }}</dd>
                <dt class="col-sm-3">Color</dt><dd class="col-sm-9">@if($priority->color)<span class="badge" style="background:{{ $priority->color }}">{{ $priority->color }}</span>@else—@endif</dd>
            </dl>
        </div>
    </div>
</div>
@endsection
