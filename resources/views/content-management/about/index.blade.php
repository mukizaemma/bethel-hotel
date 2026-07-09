<div class="admin-livewire-page d-flex w-100 align-items-stretch">
@include('content-management.includes.sidebar')
<div class="content">
    @include('admin.includes.navbar')

    <div class="container-fluid pt-4 px-4">
        <ul class="nav nav-tabs mb-4">
            <li class="nav-item">
                <a class="nav-link active" data-bs-toggle="tab" href="#about">About Hotel</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-bs-toggle="tab" href="#tab-terms">Terms & Conditions</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-bs-toggle="tab" href="#seo">SEO Data</a>
            </li>
                @if(strtolower((string) auth()->user()->email) === 'admin@iremetech.com')
            <li class="nav-item">
                <a class="nav-link" data-bs-toggle="tab" href="#users">System Users</a>
            </li>
            @endif
        </ul>

        <div class="tab-content">
            <div id="about" class="tab-pane fade show active">
                <div class="bg-light rounded h-100 p-4">
                    <h4 class="mb-4">About Hotel</h4>
                    <form action="{{ route('content-management.about.update') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label">Title</label>
                            <input type="text" class="form-control" name="title" value="{{ $about->title ?? '' }}">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Sub Title</label>
                            <input type="text" class="form-control" name="subTitle" value="{{ $about->subTitle ?? '' }}">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Founder Description</label>
                            <textarea class="form-control" name="founderDescription" rows="4">{{ $about->founderDescription ?? '' }}</textarea>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Vision</label>
                            <textarea class="form-control" name="vision" rows="4">{{ $about->vision ?? '' }}</textarea>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Mission</label>
                            <textarea class="form-control" name="mission" rows="4">{{ $about->mission ?? '' }}</textarea>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Story Description</label>
                            <textarea class="form-control" name="storyDescription" rows="4">{{ $about->storyDescription ?? '' }}</textarea>
                        </div>
                        <div class="row">
                            <div class="col-md-3 mb-3">
                                <label class="form-label">Image 1</label>
                                <input type="file" class="form-control" name="image1" accept="image/*">
                            </div>
                            <div class="col-md-3 mb-3">
                                <label class="form-label">Image 2</label>
                                <input type="file" class="form-control" name="image2" accept="image/*">
                            </div>
                            <div class="col-md-3 mb-3">
                                <label class="form-label">Image 3</label>
                                <input type="file" class="form-control" name="image3" accept="image/*">
                            </div>
                            <div class="col-md-3 mb-3">
                                <label class="form-label">Image 4</label>
                                <input type="file" class="form-control" name="image4" accept="image/*">
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Story Image</label>
                            <input type="file" class="form-control" name="storyImage" accept="image/*">
                        </div>
                        <button type="submit" class="btn btn-primary">Update About</button>
                    </form>
                </div>
            </div>
            <div id="tab-terms" class="tab-pane fade">
                @php $terms = App\Models\TermsCondition::first(); @endphp
                <div class="bg-light rounded h-100 p-4">
                    <h4 class="mb-4">Terms & Conditions</h4>
                    <form action="{{ route('content-management.terms.update') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label">Content</label>
                            <textarea class="form-control" name="content" rows="10" id="termsContent">{{ $terms?->content ?? '' }}</textarea>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Status</label>
                            <select class="form-control" name="status">
                                <option value="active" {{ ($terms?->status ?? '') == 'active' ? 'selected' : '' }}>Active</option>
                                <option value="inactive" {{ ($terms?->status ?? '') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary">Update Terms</button>
                    </form>
                </div>
            </div>
            <div id="seo" class="tab-pane fade">
                @php $seoData = App\Models\SeoData::all(); @endphp
                <div class="bg-light rounded h-100 p-4">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h4 class="mb-0">SEO Data</h4>
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
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($seoData as $seo)
                                <tr>
                                    <td>{{ $seo->page_name }}</td>
                                    <td>{{ $seo->meta_title }}</td>
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
            @if(strtolower((string) auth()->user()->email) === 'admin@iremetech.com')
            <div id="users" class="tab-pane fade">
                @php 
                    $users = App\Models\User::with('role')->latest()->get();
                    $roles = App\Models\Role::all();
                @endphp
                @include('content-management.users.index')
            </div>
            @endif
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
            <form id="seoForm">
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
                        <input type="text" class="form-control" id="seo_meta_keywords" name="meta_keywords">
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
$(document).ready(function() {
    $('#termsContent').summernote({
        height: 300
    });
});

function resetSeoForm() {
    document.getElementById('seoForm').reset();
    document.getElementById('seo_id').value = '';
    document.getElementById('seoModalTitle').textContent = 'Add SEO Data';
}

function editSeo(id) {
    // Implementation for editing SEO
    alert('Edit SEO functionality');
}
</script>
</div>
