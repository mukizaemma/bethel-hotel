{{-- Reusable upload-or-select control. Attributes: name (existing ids field), input-name (file field), multiple, file-id --}}
@php
    $pickerId = $pickerId ?? ('media-picker-'.uniqid());
    $multiple = $multiple ?? true;
    $existingName = $existingName ?? 'existing_media_ids[]';
    $fileName = $fileName ?? 'images[]';
    $fileId = $fileId ?? null;
    $fileRequired = $fileRequired ?? false;
@endphp
<div class="media-picker" data-picker-id="{{ $pickerId }}" data-multiple="{{ $multiple ? '1' : '0' }}" data-existing-name="{{ $existingName }}">
    <ul class="nav nav-tabs mb-3" role="tablist">
        <li class="nav-item">
            <button class="nav-link active" type="button" data-bs-toggle="tab" data-bs-target="#{{ $pickerId }}-upload" role="tab">Upload new</button>
        </li>
        <li class="nav-item">
            <button class="nav-link" type="button" data-bs-toggle="tab" data-bs-target="#{{ $pickerId }}-library" role="tab">Select existing</button>
        </li>
    </ul>
    <div class="tab-content">
        <div class="tab-pane fade show active" id="{{ $pickerId }}-upload" role="tabpanel">
            <input type="file" class="form-control" name="{{ $fileName }}" @if($fileId) id="{{ $fileId }}" @endif accept="image/*" @if($multiple) multiple @endif @if($fileRequired) required @endif>
            <small class="text-muted d-block mt-1">Files over 700 KB are compressed automatically. Leave empty if you are selecting existing images.</small>
        </div>
        <div class="tab-pane fade" id="{{ $pickerId }}-library" role="tabpanel">
            <div class="media-picker-selected mb-2 small text-muted">None selected</div>
            <div class="media-picker-grid border rounded p-2" style="max-height: 280px; overflow-y: auto;">
                <div class="text-muted small">Loading library…</div>
            </div>
            <div class="media-picker-ids"></div>
        </div>
    </div>
</div>
