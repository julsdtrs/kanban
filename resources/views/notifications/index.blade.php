@extends('layouts.app')
@section('title', 'Notifications')
@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3 mb-0">Notifications</h1>
</div>
<div class="card border-0 shadow-sm">
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-light"><tr><th>Title</th><th>Message</th><th>Issue</th><th>Read</th><th>Date</th><th width="80"></th></tr></thead>
            <tbody>
                @forelse($notifications as $notification)
                <tr class="{{ $notification->is_read ? '' : 'table-active' }}">
                    <td>{{ Str::limit($notification->title ?? $notification->message, 40) }}</td>
                    <td>{{ Str::limit($notification->message, 50) }}</td>
                    <td>@if($notification->issue)<a href="{{ route('issues.show', $notification->issue) }}">{{ $notification->issue->issue_key }}</a>@else—@endif</td>
                    <td>@if($notification->is_read)<span class="badge bg-secondary">Read</span>@else<span class="badge bg-primary">Unread</span>@endif</td>
                    <td>{{ $notification->created_at ? $notification->created_at->format('Y-m-d H:i') : '-' }}</td>
                    <td><a href="{{ route('notifications.show', $notification) }}" class="btn btn-sm btn-outline-secondary">View</a></td>
                </tr>
                @empty
                <tr><td colspan="6" class="text-center text-muted py-4">No notifications.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($notifications->hasPages())<div class="card-footer bg-white">{{ $notifications->links() }}</div>@endif
</div>
@endsection
