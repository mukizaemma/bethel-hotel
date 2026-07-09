<div class="admin-livewire-page d-flex w-100 align-items-stretch">
@include('content-management.includes.sidebar')
<div class="content">
    @include('admin.includes.navbar')

    <div class="container-fluid pt-4 px-4">
        <div class="bg-light rounded h-100 p-4">
            <h4 class="mb-4">Terms & Conditions</h4>
            <form action="{{ route('content-management.terms.update') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label class="form-label">Content</label>
                    <textarea class="form-control" name="content" rows="15" id="termsContent">{{ $terms->content ?? '' }}</textarea>
                </div>
                <div class="mb-3">
                    <label class="form-label">Status</label>
                    <select class="form-control" name="status">
                        <option value="active" {{ ($terms->status ?? '') == 'active' ? 'selected' : '' }}>Active</option>
                        <option value="inactive" {{ ($terms->status ?? '') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                    </select>
                </div>
                <button type="submit" class="btn btn-primary">Update Terms & Conditions</button>
            </form>
        </div>
    </div>
</div>
</div>
</div>

@push('scripts')
<script>
jQuery(function ($) {
    var $tc = $('#termsContent');
    if ($tc.length && !$tc.next('.note-editor').length) {
        $tc.summernote({
            placeholder: 'Hotel policies and terms…',
            tabsize: 2,
            height: 420,
            disableResizeEditor: true,
            toolbar: [
                ['style', ['style']],
                ['font', ['bold', 'underline', 'clear']],
                ['color', ['color']],
                ['para', ['ul', 'ol', 'paragraph']],
                ['table', ['table']],
                ['insert', ['link', 'picture', 'video']],
                ['view', ['fullscreen', 'codeview', 'help']]
            ]
        });
    }
    $(document).on('submit', 'form[action*="terms-conditions/update"]', function () {
        if ($tc.length && $tc.next('.note-editor').length) {
            $tc.val($tc.summernote('code'));
        }
    });
});
</script>
@endpush
