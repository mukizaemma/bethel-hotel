<div class="admin-livewire-page d-flex w-100 align-items-stretch">
@include('content-management.includes.sidebar')
<div class="content">
    @include('admin.includes.navbar')

    <div class="container-fluid pt-4 px-4">
        <div class="bg-light rounded h-100 p-4">
            <h4 class="mb-4">Hotel Contacts</h4>
            
            <form action="{{ route('content-management.contacts.update') }}" method="POST">
                @csrf
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Phone</label>
                        <input type="text" class="form-control" name="phone" value="{{ $contact->phone ?? '' }}">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Email</label>
                        <input type="email" class="form-control" name="email" value="{{ $contact->email ?? '' }}">
                    </div>
                </div>
                <div class="mb-3">
                    <label class="form-label">Address</label>
                    <input type="text" class="form-control" name="address" value="{{ $contact->address ?? '' }}">
                </div>
                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label class="form-label">City</label>
                        <input type="text" class="form-control" name="city" value="{{ $contact->city ?? '' }}">
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Country</label>
                        <input type="text" class="form-control" name="country" value="{{ $contact->country ?? '' }}">
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Postal Code</label>
                        <input type="text" class="form-control" name="postal_code" value="{{ $contact->postal_code ?? '' }}">
                    </div>
                </div>
                <div class="mb-3">
                    <label class="form-label">Website</label>
                    <input type="url" class="form-control" name="website" value="{{ $contact->website ?? '' }}">
                </div>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Facebook</label>
                        <input type="url" class="form-control" name="facebook" value="{{ $contact->facebook ?? '' }}">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Twitter</label>
                        <input type="url" class="form-control" name="twitter" value="{{ $contact->twitter ?? '' }}">
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Instagram</label>
                        <input type="url" class="form-control" name="instagram" value="{{ $contact->instagram ?? '' }}">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">LinkedIn</label>
                        <input type="url" class="form-control" name="linkedin" value="{{ $contact->linkedin ?? '' }}">
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">WhatsApp</label>
                        <input type="text" class="form-control" name="whatsapp" value="{{ $contact->whatsapp ?? '' }}">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Latitude</label>
                        <input type="number" step="any" class="form-control" name="latitude" value="{{ $contact->latitude ?? '' }}">
                    </div>
                </div>
                <div class="mb-3">
                    <label class="form-label">Longitude</label>
                    <input type="number" step="any" class="form-control" name="longitude" value="{{ $contact->longitude ?? '' }}">
                </div>
                <button type="submit" class="btn btn-primary">Update Contacts</button>
            </form>
        </div>
    </div>
</div>
</div>
