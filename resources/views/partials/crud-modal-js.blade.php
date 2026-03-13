<script>
(function() {
    var container = '{{ $containerSelector }}';
    var refreshUrl = '{{ $refreshUrl }}';
    if (typeof TaskFlow === 'undefined' || !TaskFlow.crudModal || typeof TaskFlow.crudModal.open !== 'function') return;
    $('#{{ $createButtonId }}').on('click', function() {
        TaskFlow.crudModal.open({
            title: '{{ $createTitle }}',
            loadUrl: '{{ $createLoadUrl }}' + (String('{{ $createLoadUrl }}').indexOf('?') >= 0 ? '&' : '?') + 'modal=1',
            submitUrl: '{{ $createSubmitUrl }}',
            method: 'POST',
            refreshUrl: refreshUrl,
            refreshSelector: container
        });
    });
    $(document).on('click', container + ' .btn-edit', function() {
        var btn = $(this);
        TaskFlow.crudModal.open({
            title: btn.data('title'),
            loadUrl: btn.data('load'),
            submitUrl: btn.data('submit'),
            method: btn.data('method') || 'PUT',
            refreshUrl: refreshUrl,
            refreshSelector: container
        });
    });
    $(document).on('click', container + ' .btn-delete', function() {
        var btn = $(this);
        if (!confirm(btn.data('confirm') || 'Delete?')) return;
        var token = (typeof TaskFlow !== 'undefined' && TaskFlow.csrf) ? TaskFlow.csrf : (document.querySelector('meta[name="csrf-token"]') && document.querySelector('meta[name="csrf-token"]').getAttribute('content'));
        var headers = { 'X-Requested-With': 'XMLHttpRequest', 'Accept': 'application/json' };
        if (token) headers['X-CSRF-TOKEN'] = token;
        $.ajax({
            url: btn.data('url'),
            method: 'DELETE',
            data: { _token: token },
            headers: headers
        }).done(function() {
            if (TaskFlow.toast) TaskFlow.toast('success', 'Deleted.');
            $.get(refreshUrl).then(function(html) { var el = document.querySelector(container); if (el) el.innerHTML = html; });
        }).fail(function() { if (TaskFlow.toast) TaskFlow.toast('error', 'Delete failed.'); });
    });
})();
</script>
