<div class="admin-livewire-page d-flex w-100 align-items-stretch">
@include('content-management.includes.sidebar')
<div class="content">
    @include('admin.includes.navbar')

    <div class="container-fluid pt-4 px-4">
        <div class="bg-light rounded h-100 p-4">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h4 class="mb-0">SEO Data Management</h4>
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#seoModal" onclick="resetSeoForm()">
                    <i class="fa fa-plus me-2"></i>Add SEO Data
                </button>
            </div>

            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Page Name</th>
                            <th>Meta Title</th>
                            <th>Meta Description</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($seoData as $seo)
                        <tr>
                            <td>{{ $seo->page_name }}</td>
                            <td>{{ $seo->meta_title }}</td>
                            <td>{{ Str::limit($seo->meta_description, 50) }}</td>
                            <td>
                                <button class="btn btn-sm btn-warning" onclick="editSeo({{ $seo->id }})">
                                    <i class="fa fa-edit"></i>
                                </button>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- SEO Modal -->
<div class="modal fade" id="seoModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="seoModalTitle">Add SEO Data</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="seoForm" enctype="multipart/form-data">
                <div class="modal-body">
                    <input type="hidden" id="seo_id" name="id">
                    <div class="mb-3">
                        <label class="form-label">Page Name *</label>
                        <input type="text" class="form-control" id="seo_page_name" name="page_name" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Meta Title</label>
                        <input type="text" class="form-control" id="seo_meta_title" name="meta_title">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Meta Description</label>
                        <textarea class="form-control" id="seo_meta_description" name="meta_description" rows="3"></textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Meta Keywords</label>
                        <input type="text" class="form-control" id="seo_meta_keywords" name="meta_keywords" placeholder="keyword1, keyword2, keyword3">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">OG Title</label>
                        <input type="text" class="form-control" id="seo_og_title" name="og_title">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">OG Description</label>
                        <textarea class="form-control" id="seo_og_description" name="og_description" rows="3"></textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">OG Image</label>
                        <input type="file" class="form-control" id="seo_og_image" name="og_image" accept="image/*">
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
let currentSeoId = null;

function resetSeoForm() {
    currentSeoId = null;
    document.getElementById('seoForm').reset();
    document.getElementById('seo_id').value = '';
    document.getElementById('seoModalTitle').textContent = 'Add SEO Data';
}

function editSeo(id) {
    // Fetch and populate SEO data
    fetch(`/content-management/seo-data/${id}`)
        .then(response => response.json())
        .then(data => {
            currentSeoId = id;
            document.getElementById('seo_id').value = data.id;
            document.getElementById('seo_page_name').value = data.page_name;
            document.getElementById('seo_meta_title').value = data.meta_title || '';
            document.getElementById('seo_meta_description').value = data.meta_description || '';
            document.getElementById('seo_meta_keywords').value = data.meta_keywords || '';
            document.getElementById('seo_og_title').value = data.og_title || '';
            document.getElementById('seo_og_description').value = data.og_description || '';
            document.getElementById('seoModalTitle').textContent = 'Edit SEO Data';
            new bootstrap.Modal(document.getElementById('seoModal')).show();
        });
}

document.getElementById('seoForm').addEventListener('submit', function(e) {
    e.preventDefault();
    const formData = new FormData(this);
    const url = currentSeoId 
        ? `/content-management/seo-data/update?id=${currentSeoId}`
        : '/content-management/seo-data/store';
    
    fetch(url, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Accept': 'application/json'
        },
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Close modal using jQuery (more reliable)
            const modalElement = document.getElementById('seoModal');
            if (modalElement && typeof jQuery !== 'undefined') {
                jQuery(modalElement).modal('hide');
            } else if (modalElement) {
                // Fallback: manually hide
                modalElement.classList.remove('show');
                modalElement.style.display = 'none';
                document.body.classList.remove('modal-open');
                const backdrop = document.querySelector('.modal-backdrop');
                if (backdrop) backdrop.remove();
            }
            setTimeout(() => location.reload(), 300);
        }
    });
});
</script>
</div>
