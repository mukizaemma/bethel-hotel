@extends('layouts.adminBase')

@section('content')
<div class="admin-livewire-page d-flex w-100 align-items-stretch">
    @include('content-management.includes.sidebar')
    <div class="content">
        @include('admin.includes.navbar')

        <div class="container-fluid pt-4 px-4">
            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif
            @if (session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif

            <div class="bg-light rounded p-4 mb-4">
                <h4 class="mb-1">Hosting</h4>
                <p class="text-muted mb-4">Annual renewal for {{ $profile->domain }}. The renewal date is 1 August. An unpaid invoice becomes expired on that date until a super admin confirms it as paid.</p>

                <div class="row g-3">
                    <div class="col-md-4">
                        <div class="border rounded bg-white p-3 h-100">
                            <div class="text-muted small">Domain registration</div>
                            <strong>{{ $profile->registrar }}</strong>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="border rounded bg-white p-3 h-100">
                            <div class="text-muted small">Hosting server</div>
                            <strong>{{ $profile->hosting_provider }}</strong>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="border rounded bg-white p-3 h-100">
                            <div class="text-muted small">Domain</div>
                            <strong>{{ $profile->domain }}</strong>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="border rounded bg-white p-3 h-100">
                            <div class="text-muted small">Annual hosting</div>
                            <strong>${{ rtrim(rtrim(number_format((float) $profile->annual_hosting_usd, 2), '0'), '.') }}</strong>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="border rounded bg-white p-3 h-100">
                            <div class="text-muted small">Annual support</div>
                            <strong>{{ number_format((int) $profile->annual_support_rwf) }} RWF</strong>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="border rounded bg-white p-3 h-100">
                            <div class="text-muted small">Renewal emails</div>
                            <strong>{{ $profile->notificationEmail() }}</strong>
                            <div class="small text-muted mt-1">30 days before, 15 days before, and on 1 August.</div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-light rounded p-4 mb-4">
                <h5 class="mb-3">Current dollar rate</h5>
                <form action="{{ route('content-management.hosting.rate') }}" method="POST" class="row g-3 align-items-end">
                    @csrf
                    <div class="col-md-4">
                        <label for="usd_to_rwf_rate" class="form-label">1 USD in RWF</label>
                        <input type="number" class="form-control @error('usd_to_rwf_rate') is-invalid @enderror" id="usd_to_rwf_rate" name="usd_to_rwf_rate" min="1" step="0.01" value="{{ old('usd_to_rwf_rate', $profile->usd_to_rwf_rate) }}" required>
                        @error('usd_to_rwf_rate')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-5">
                        <div class="small text-muted">Hosting in RWF</div>
                        <div id="hosting-preview" class="fw-semibold">—</div>
                        <div class="small text-muted mt-2">Total to pay (hosting + {{ number_format((int) $profile->annual_support_rwf) }} RWF support)</div>
                        <div id="total-preview" class="fw-semibold">—</div>
                    </div>
                    <div class="col-md-3">
                        <button type="submit" class="btn btn-primary">Save rate</button>
                    </div>
                </form>
                @if($previewTotal !== null)
                    <p class="mb-0 mt-3">Saved total on the active invoice: <strong>{{ number_format($previewTotal) }} RWF</strong> (hosting {{ number_format($previewHosting) }} + support {{ number_format((int) $profile->annual_support_rwf) }}).</p>
                @else
                    <p class="mb-0 mt-3 text-muted">The active invoice total appears here after the rate is saved. The paid invoice stays at 130,000 RWF.</p>
                @endif
            </div>

            <div class="bg-light rounded p-4">
                <h5 class="mb-3">Annual invoices</h5>
                <div class="table-responsive">
                    <table class="table table-bordered align-middle bg-white">
                        <thead>
                            <tr>
                                <th>Invoice</th>
                                <th>Period</th>
                                <th>Hosting</th>
                                <th>Support</th>
                                <th>Total (RWF)</th>
                                <th>Status</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($invoices as $invoice)
                                <tr>
                                    <td>{{ $invoice->invoice_number }}</td>
                                    <td>{{ $invoice->periodLabel() }}</td>
                                    <td>{{ $invoice->hostingAmountLabel() }}</td>
                                    <td>{{ $invoice->supportLabel() }}</td>
                                    <td>{{ $invoice->totalLabel() }}</td>
                                    <td>
                                        @if($invoice->status === 'paid')
                                            <span class="badge bg-success">Paid</span>
                                        @elseif($invoice->status === 'expired')
                                            <span class="badge bg-danger">Expired</span>
                                        @else
                                            <span class="badge bg-primary">Active</span>
                                        @endif
                                    </td>
                                    <td class="text-nowrap">
                                        <a class="btn btn-sm btn-outline-primary" href="{{ route('content-management.hosting.show', $invoice) }}">View / print</a>
                                        @if(auth()->user()->isAdmin() && ! $invoice->isPaid())
                                            <form action="{{ route('content-management.hosting.paid', $invoice) }}" method="POST" class="d-inline" onsubmit="return confirm('Confirm this invoice as paid?');">
                                                @csrf
                                                <button type="submit" class="btn btn-sm btn-success">Mark paid</button>
                                            </form>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
(function () {
    var input = document.getElementById('usd_to_rwf_rate');
    var hosting = document.getElementById('hosting-preview');
    var total = document.getElementById('total-preview');
    var usd = {{ (float) $profile->annual_hosting_usd }};
    var support = {{ (int) $profile->annual_support_rwf }};

    function money(value) {
        return Math.round(value).toLocaleString('en-US') + ' RWF';
    }

    function paint() {
        var rate = parseFloat(input.value);
        if (!rate || rate <= 0) {
            hosting.textContent = '—';
            total.textContent = '—';
            return;
        }
        var hostingRwf = Math.round(usd * rate);
        hosting.textContent = '$' + usd + ' × ' + rate.toLocaleString('en-US') + ' = ' + money(hostingRwf);
        total.textContent = money(hostingRwf + support);
    }

    input.addEventListener('input', paint);
    paint();
})();
</script>
@endpush
