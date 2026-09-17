<div class="admin-livewire-page d-flex w-100 align-items-stretch">
@include('content-management.includes.sidebar')
<div class="content">
    @include('admin.includes.navbar')

    <div class="container-fluid pt-4 px-4">
        <div class="bg-light rounded h-100 p-4">
            <div class="mb-4">
                <h4 class="mb-2">Page header images</h4>
                <p class="text-muted small mb-0">
                    Only pages that appear on the public website are listed. Set one <strong>default</strong> header for all of them, then change a page individually when it needs a different photo. Upload a new file or pick one already in the media library so the same image is not stored twice.
                </p>
            </div>

            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <strong>Error:</strong> {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if ($errors->any())
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @php
                $defaultImage = $defaultHero?->background_image;
            @endphp

            <div class="row">
                @foreach($pageHeroes as $pageHero)
                    @php
                        $isDefault = $pageHero->page_slug === 'default';
                        $usesDefault = ! $isDefault && empty($pageHero->background_image) && filled($defaultImage);
                        $previewPath = $pageHero->background_image ?: ($usesDefault ? $defaultImage : null);
                    @endphp
                <div class="col-md-6 col-lg-4 mb-4">
                    <div class="card h-100 {{ $isDefault ? 'border-primary' : '' }}">
                        <div class="card-header d-flex justify-content-between align-items-start flex-wrap gap-2">
                            <div>
                                <h5 class="mb-0">{{ $pageHero->page_name }}</h5>
                                @if($isDefault)
                                    <small class="text-primary d-block">Applies to every page below until that page has its own image.</small>
                                @elseif(isset($heroPaths[$pageHero->page_slug]))
                                    <small class="text-muted d-block">Public page: <code>{{ $heroPaths[$pageHero->page_slug] }}</code></small>
                                @endif
                            </div>
                            @if($isDefault)
                                <span class="badge bg-primary">Default</span>
                            @elseif($pageHero->background_image)
                                <span class="badge bg-success">Own image</span>
                            @elseif($usesDefault)
                                <span class="badge bg-info text-dark">Using default</span>
                            @else
                                <span class="badge bg-secondary">No image</span>
                            @endif
                        </div>
                        <div class="card-body">
                            @if($previewPath)
                                <img src="{{ asset('storage/' . $previewPath) }}"
                                     class="img-fluid rounded mb-3"
                                     alt="{{ $pageHero->page_name }}"
                                     style="max-height: 180px; width: 100%; object-fit: cover;">
                            @else
                                <div class="bg-secondary rounded mb-3 d-flex align-items-center justify-content-center"
                                     style="height: 160px;">
                                    <i class="fa fa-image fa-3x text-white-50"></i>
                                </div>
                            @endif

                            @if(! $isDefault && $pageHero->caption)
                                <p class="text-muted mb-2 small"><strong>Title:</strong> {{ $pageHero->caption }}</p>
                            @endif

                            <button type="button" class="btn btn-primary btn-sm w-100"
                                    data-bs-toggle="modal"
                                    data-bs-target="#editHeroModal{{ $pageHero->id }}">
                                <i class="fa fa-edit me-2"></i>{{ $isDefault ? 'Set default image' : 'Edit this page' }}
                            </button>
                        </div>
                    </div>
                </div>

                <div class="modal fade" id="editHeroModal{{ $pageHero->id }}" tabindex="-1">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">{{ $isDefault ? 'Default header image' : 'Header — '.$pageHero->page_name }}</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>
                            <form action="{{ route('content-management.page-heroes.update', $pageHero->id) }}"
                                  method="POST"
                                  enctype="multipart/form-data">
                                @csrf
                                <div class="modal-body">
                                    @if($isDefault)
                                        <p class="small text-muted">This photo is shown on all public pages listed here until a page has its own image.</p>
                                    @else
                                        <p class="small text-muted">Leave the image empty to keep using the default header. Upload or select a photo only if this page needs its own.</p>
                                    @endif
                                    <div class="mb-3">
                                        <label class="form-label">Background image</label>
                                        @if($previewPath)
                                            <div class="mb-2">
                                                <img src="{{ asset('storage/' . $previewPath) }}"
                                                     class="img-fluid rounded"
                                                     alt="Current image"
                                                     style="max-height: 200px;">
                                            </div>
                                        @endif
                                        @include('content-management.includes.media-picker', [
                                            'pickerId' => 'hero-picker-'.$pageHero->id,
                                            'multiple' => false,
                                            'existingName' => 'existing_media_id',
                                            'fileName' => 'background_image',
                                            'fileId' => 'hero_image_'.$pageHero->id,
                                            'pickerHint' => 'Upload a new photo or select one already in the library. Files over 700 KB are compressed. Matching files reuse the existing library image.',
                                        ])
                                    </div>
                                    @if($pageHero->background_image)
                                    <div class="mb-3 form-check">
                                        <input type="checkbox" class="form-check-input" name="remove_background_image" id="remove_bg_{{ $pageHero->id }}" value="1">
                                        <label class="form-check-label" for="remove_bg_{{ $pageHero->id }}">
                                            {{ $isDefault ? 'Remove the default image' : 'Remove this page’s image (revert to the default header)' }}
                                        </label>
                                    </div>
                                    @endif

                                    @if(! $isDefault)
                                    <div class="mb-3">
                                        <label class="form-label">Caption</label>
                                        <input type="text"
                                               class="form-control"
                                               name="caption"
                                               value="{{ $pageHero->caption }}"
                                               placeholder="Main heading on the hero">
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Description</label>
                                        <textarea class="form-control"
                                                  name="description"
                                                  rows="3"
                                                  placeholder="Optional subtitle">{{ $pageHero->description }}</textarea>
                                    </div>
                                    @endif
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-primary">Save</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
