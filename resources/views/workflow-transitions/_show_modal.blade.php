<div class="card setup-detail-card border-0 shadow-none mb-0">
    <div class="card-header">Transition details</div>
    <div class="card-body">
        <dl class="row mb-0">
            <dt class="col-sm-3">Workflow</dt><dd class="col-sm-9">{{ $workflowTransition->workflow->name ?? '-' }}</dd>
            <dt class="col-sm-3">From status</dt><dd class="col-sm-9">{{ $workflowTransition->fromStatus->name ?? '-' }}</dd>
            <dt class="col-sm-3">To status</dt><dd class="col-sm-9">{{ $workflowTransition->toStatus->name ?? '-' }}</dd>
            <dt class="col-sm-3">Transition name</dt><dd class="col-sm-9">{{ $workflowTransition->transition_name ?? '-' }}</dd>
        </dl>
    </div>
</div>
