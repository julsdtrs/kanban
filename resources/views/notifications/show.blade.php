@extends('layouts.app')
@section('title', 'Notification')
@section('content')
<div class="d-flex justify-content-between align-items-center mb-4"><h1 class="h3 mb-0">Notification</h1><a href="{{ route('notifications.index') }}" class="btn btn-outline-secondary">Back</a></div>
<div class="card border-0 shadow-sm"><div class="card-body">
<dl class="row mb-0"><dt class="col-sm-3">Title</dt><dd class="col-sm-9">{{ $notification->title ?? '-' }}</dd><dt class="col-sm-3">Message</dt><dd class="col-sm-9">{{ $notification->message ?? '-' }}</dd><dt class="col-sm-3">Issue</dt><dd class="col-sm-9">@if($notification->issue)<a href="{{ route('issues.show', $notification->issue) }}">{{ $notification->issue->issue_key }}</a> — {{ Str::limit($notification->issue->summary, 60) }}@else—@endif</dd><dt class="col-sm-3">Read</dt><dd class="col-sm-9">{{ $notification->is_read ? 'Yes' : 'No' }}</dd><dt class="col-sm-3">Date</dt><dd class="col-sm-9">{{ $notification->created_at ? $notification->created_at->format('Y-m-d H:i') : '-' }}</dd></dl>
<form action="{{ route('notifications.update', $notification) }}" method="POST" class="mt-3">@csrf @method('PUT')<input type="hidden" name="is_read" value="1"><button type="submit" class="btn btn-primary">Mark as read</button></form>
</div></div>
@endsection
