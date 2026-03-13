@extends('layouts.app')
@section('title', $status->name)
@section('content')
<div class="setup-detail-page">
    <div class="d-flex justify-content-between align-items-center setup-detail-header">
        <h1 class="h4 mb-0 fw-600 d-flex align-items-center gap-2">
            @if($status->color)<span class="badge rounded-pill" style="background:{{ $status->color }}; width:12px; height:12px; padding:0;"></span>@endif
            {{ $status->name }}
        </h1>
        <div class="btn-group">
            <a href="{{ route('statuses.edit', $status) }}" class="btn btn-primary"><i class="bi bi-pencil me-1"></i> Edit</a>
            <a href="{{ route('statuses.index') }}" class="btn btn-outline-secondary"><i class="bi bi-arrow-left me-1"></i> Back</a>
        </div>
    </div>
    <div class="card setup-detail-card">
        <div class="card-header">Status details</div>
        <div class="card-body">
            <dl class="row mb-0">
                <dt class="col-sm-3">Category</dt><dd class="col-sm-9"><span class="badge bg-secondary">{{ $status->category }}</span></dd>
                <dt class="col-sm-3">Color</dt><dd class="col-sm-9">@if($status->color)<span class="badge" style="background:{{ $status->color }}">{{ $status->color }}</span>@else—@endif</dd>
                <dt class="col-sm-3">Order</dt><dd class="col-sm-9">{{ $status->order_no }}</dd>
            </dl>
        </div>
    </div>
</div>
@endsection
