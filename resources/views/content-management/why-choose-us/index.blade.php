@extends('layouts.adminBase')

@section('content')
<div class="admin-livewire-page d-flex w-100 align-items-stretch">
@include('content-management.includes.sidebar')
<div class="content">
    @include('admin.includes.navbar')

    <div class="container-fluid pt-4 px-4">
        <div class="bg-light rounded h-100 p-4">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h4 class="mb-0">Why Choose Us</h4>
                    <p class="text-muted small mb-0">Manage bullet points shown on the website (e.g. location, values, services).</p>
                </div>
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#wcuModal" onclick="resetWcuForm()">
                    <i class="fa fa-plus me-2"></i>Add item
                </button>
            </div>

            <div class="table-responsive">
                <table class="table table-bordered align-middle">
                    <thead>
                        <tr>
                            <th style="width:72px">Order</th>
                            <th>Title</th>
                            <th>Description</th>
                            <th style="width:120px">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($items as $item)
                        <tr>
                            <td>{{ $item->sort_order }}</td>
                            <td><strong>{{ $item->title }}</strong></td>
                            <td class="small text-muted">{{ Str::limit(strip_tags($item->description ?? ''), 120) }}</td>
                            <td>
                                <button type="button" class="btn btn-sm btn-warning" onclick="editWcu({{ $item->id }})" title="Edit">
                                    <i class="fa fa-edit"></i>
                                </button>
                                <button type="button" class="btn btn-sm btn-danger" onclick="deleteWcu({{ $item->id }})" title="Delete">
                                    <i class="fa fa-trash"></i>
                                </button>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="text-center text-muted py-4">No items yet. Add your first reason or run the seeder.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
</div>

<div class="modal fade" id="wcuModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="wcuModalTitle">Add item</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="wcuForm">
                <div class="modal-body">
                    <input type="hidden" id="wcu_id" name="id">
                    <div class="mb-3">
                        <label class="form-label" for="wcu_title">Title <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="wcu_title" name="title" required maxlength="255">
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="wcu_description">Description</label>
                        <textarea class="form-control" id="wcu_description" name="description" rows="5" placeholder="Short paragraph explaining this point"></textarea>
                    </div>
                    <div class="mb-0">
                        <label class="form-label" for="wcu_sort_order">Display order</label>
                        <input type="number" class="form-control" id="wcu_sort_order" name="sort_order" value="0" min="0" max="9999">
                        <div class="form-text">Lower numbers appear first.</div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
let currentWcuId = null;
const wcuBaseUrl = @json(url('content-management/why-choose-us'));

function resetWcuForm() {
    currentWcuId = null;
    document.getElementById('wcuForm').reset();
    document.getElementById('wcu_id').value = '';
    document.getElementById('wcu_sort_order').value = '0';
    document.getElementById('wcuModalTitle').textContent = 'Add item';
}

function editWcu(id) {
    fetch(`${wcuBaseUrl}/${id}`)
        .then(r => r.json())
        .then(data => {
            currentWcuId = id;
            document.getElementById('wcu_id').value = data.id;
            document.getElementById('wcu_title').value = data.title || '';
            document.getElementById('wcu_description').value = data.description || '';
            document.getElementById('wcu_sort_order').value = data.sort_order ?? 0;
            document.getElementById('wcuModalTitle').textContent = 'Edit item';
            new bootstrap.Modal(document.getElementById('wcuModal')).show();
        });
}

function deleteWcu(id) {
    if (!confirm('Delete this item?')) return;
    fetch(`${wcuBaseUrl}/${id}`, {
        method: 'DELETE',
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Accept': 'application/json',
            'Content-Type': 'application/json'
        }
    })
    .then(r => r.json())
    .then(data => {
        if (data.success) location.reload();
    });
}

document.getElementById('wcuForm').addEventListener('submit', function(e) {
    e.preventDefault();
    const payload = {
        title: document.getElementById('wcu_title').value,
        description: document.getElementById('wcu_description').value,
        sort_order: parseInt(document.getElementById('wcu_sort_order').value, 10) || 0
    };
    const url = currentWcuId
        ? `${wcuBaseUrl}/${currentWcuId}/update`
        : @json(route('content-management.why-choose-us.store'));

    fetch(url, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Accept': 'application/json',
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(payload)
    })
    .then(r => r.json())
    .then(data => {
        if (data.success) {
            const el = document.getElementById('wcuModal');
            if (el && typeof bootstrap !== 'undefined') bootstrap.Modal.getInstance(el)?.hide();
            setTimeout(() => location.reload(), 200);
        }
    });
});
</script>
@endsection
