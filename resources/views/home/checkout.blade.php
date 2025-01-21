@extends('layouts.app')

@section('content')
    <div class=" mt-4">
        <h4 class="mb-4">Checkout</h4>

        <div class="row">
            <!-- Delivery Address -->
            <div class="col-lg-8">
                <div class="card mb-4">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h5 class="card-title mb-0">Alamat Pengiriman</h5>
                            <button type="button" class="btn btn-outline-custom btn-sm" data-bs-toggle="modal"
                                data-bs-target="#addAddressModal">
                                <i class="bi bi-plus"></i> Tambah Alamat Baru
                            </button>
                        </div>

                        <div class="addresses-container">
                            @foreach (auth()->user()->addresses as $address)
                                <div
                                    class="address-item mb-3 p-3 border rounded @if ($address->is_primary) border-custom @endif">
                                    <div class="form-check">
                                        <input class="form-check-input custom-radio" type="radio" name="selected_address"
                                            id="address_{{ $address->id }}" value="{{ $address->id }}"
                                            @if ($address->is_primary) checked @endif>
                                        <label class="form-check-label" for="address_{{ $address->id }}">
                                            <strong>{{ $address->label }}</strong>
                                            @if ($address->is_primary)
                                                <span class="badge bg-custom ms-2">Utama</span>
                                            @endif
                                        </label>
                                    </div>
                                    <div class="ms-4 mt-2">
                                        <p class="mb-1"><strong>{{ $address->receiver_name }}</strong></p>
                                        <p class="mb-1">{{ $address->phone_number }}</p>
                                        <p class="mb-0">{{ $address->full_address }}</p>
                                    </div>
                                    <div class="mt-2 ms-4">
                                        <button type="button" class="btn btn-link btn-sm p-0 text-custom me-3"
                                            data-bs-toggle="modal" data-bs-target="#editAddressModal"
                                            data-address-id="{{ $address->id }}">
                                            Edit
                                        </button>
                                        @if (!$address->is_primary)
                                            <button type="button" class="btn btn-link btn-sm p-0 text-danger"
                                                onclick="deleteAddress({{ $address->id }})">
                                                Hapus
                                            </button>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <!-- Add Address Modal -->
                <div class="modal fade" id="addAddressModal" tabindex="-1">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Tambah Alamat Baru</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>
                            <div class="modal-body">
                                <form id="addAddressForm">
                                    <div class="mb-3">
                                        <label class="form-label">Label Alamat</label>
                                        <input type="text" class="form-control" name="label"
                                            placeholder="Rumah, Kantor, dll">
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Nama Penerima</label>
                                        <input type="text" class="form-control" name="receiver_name" required>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Nomor Telepon</label>
                                        <input type="tel" class="form-control" name="phone_number" required>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Alamat Lengkap</label>
                                        <textarea class="form-control" name="full_address" rows="3" required></textarea>
                                    </div>
                                    <div class="mb-3 form-check">
                                        <input type="checkbox" class="form-check-input checkbox-custom" name="is_primary"
                                            id="makeAddressPrimary">
                                        <label class="form-check-label" for="makeAddressPrimary">Jadikan Alamat
                                            Utama</label>
                                    </div>
                                </form>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                <button type="button" class="btn btn-custom" onclick="saveNewAddress()">Simpan</button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Edit Address Modal -->
                <div class="modal fade" id="editAddressModal" tabindex="-1">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Edit Alamat</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>
                            <div class="modal-body">
                                <form id="editAddressForm">
                                    <input type="hidden" name="address_id">
                                    <div class="mb-3">
                                        <label class="form-label">Label Alamat</label>
                                        <input type="text" class="form-control" name="label"
                                            value="{{ $address->label }}" placeholder="Rumah, Kantor, dll">
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Nama Penerima</label>
                                        <input type="text" class="form-control" name="receiver_name"
                                            value="{{ $address->receiver_name }}" required>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Nomor Telepon</label>
                                        <input type="tel" class="form-control" name="phone_number"
                                            value="{{ $address->phone_number }}" required>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Alamat Lengkap</label>
                                        <textarea class="form-control" name="full_address" rows="3" required>{{ $address->full_address }}</textarea required></textarea>
                                    </div>
                                    <div class="mb-3 form-check">
                                        <input type="checkbox" class="form-check-input checkbox-custom"
                                            {{ $address->is_primary ? 'checked' : '' }} name="is_primary"
                                            id="editMakeAddressPrimary">
                                        <label class="form-check-label" for="editMakeAddressPrimary">Jadikan Alamat
                                            Utama</label>
                                    </div>
                                </form>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                <button type="button" class="btn btn-custom" onclick="updateAddress()">Simpan</button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Purchase Details -->
                <div class="card mb-4">
                    <div class="card-body">
                        <h5 class="card-title mb-4">Detail Pembelian</h5>
                        <div id="checkout-items">
                            @if (isset($cartItems))
                                @if ($isFromCart)
                                    {{-- Cart checkout items --}}
                                    @foreach ($cartItems as $item)
                                        @php
                                            $originalPrice = $item->product->harga * $item->quantity;
                                            $discountAmount = ($originalPrice * $item->product->diskon) / 100;
                                            $subtotal = $originalPrice - $discountAmount;
                                        @endphp
                                        <div class="checkout-item border-bottom py-3" {{-- data-item-id="{{ $item->product->id }}"  --}}
                                            data-item-id="{{ $item->product->id }}"
                                            data-price="{{ $item->product->harga }}"
                                            data-quantity="{{ $item->quantity }}"
                                            data-discount="{{ $item->product->diskon }}">
                                            <div class="row align-items-center">
                                                <div class="col-auto">
                                                    <img src="{{ asset('storage/' . $item->product->gambar) }}"
                                                        alt="{{ $item->product->nama_produk }}" class="rounded"
                                                        width="80">
                                                </div>
                                                <div class="col">
                                                    <h6 class="mb-1">{{ $item->product->nama_produk }}</h6>
                                                    <div class="text-muted small">
                                                        {{ $item->quantity }} x
                                                        Rp{{ number_format($item->product->harga, 0, ',', '.') }}
                                                        @if ($item->product->diskon > 0)
                                                            <span class="text-danger">(Diskon
                                                                {{ $item->product->diskon }}%)</span>
                                                        @endif
                                                    </div>
                                                    <div class="text-danger mt-1">
                                                        Rp{{ number_format($subtotal, 0, ',', '.') }}
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                @else
                                    {{-- Direct purchase items --}}
                                    @foreach ($cartItems as $item)
                                        @php
                                            $originalPrice = $item['price'] * $item['quantity'];
                                            $discountAmount = ($originalPrice * $item['discount']) / 100;
                                            $subtotal = $originalPrice - $discountAmount;
                                        @endphp
                                        <div class="checkout-item border-bottom py-3"
                                            data-item-id="{{ $item['product']->id }}" data-price="{{ $item['price'] }}"
                                            data-quantity="{{ $item['quantity'] }}"
                                            data-discount="{{ $item['discount'] }}">
                                            <div class="row align-items-center">
                                                <div class="col-auto">
                                                    <img src="{{ asset('storage/' . $item['product']->gambar) }}"
                                                        alt="{{ $item['product']->nama_produk }}" class="rounded"
                                                        width="80">
                                                </div>
                                                <div class="col">
                                                    <h6 class="mb-1">{{ $item['product']->nama_produk }}</h6>
                                                    <div class="text-muted small">
                                                        {{ $item['quantity'] }} x
                                                        Rp{{ number_format($item['price'], 0, ',', '.') }}
                                                        @if ($item['discount'] > 0)
                                                            <span class="text-danger">(Diskon
                                                                {{ $item['discount'] }}%)</span>
                                                        @endif
                                                    </div>
                                                    <div class="text-danger mt-1">
                                                        Rp{{ number_format($subtotal, 0, ',', '.') }}
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                @endif
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Notes Section -->
                <div class="card mb-4">
                    <div class="card-body">
                        <h5 class="card-title mb-3">Catatan untuk Penjual</h5>
                        <textarea class="form-control" id="seller_notes" name="notes" rows="2"
                            placeholder="Tambahkan catatan untuk penjual (opsional)"></textarea>
                    </div>
                </div>

                <!-- Payment Method -->
                <div class="card mb-4">
                    <div class="card-body">
                        <h5 class="card-title mb-3">Metode Pembayaran</h5>
                        <div class="form-check mb-2">
                            <input class="form-check-input custom-radio" type="radio" name="payment_method"
                                id="cod" value="Cash on Delivery" checked>
                            <label class="form-check-label" for="cod">
                                COD (Cash on Delivery)
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input custom-radio" type="radio" name="payment_method"
                                id="transfer" value="Transfer">
                            <label class="form-check-label" for="transfer">
                                Transfer Bank
                            </label>
                        </div>

                        <div id="transfer-proof" class="mt-3 d-none">
                            <label class="form-label">Upload Bukti Transfer</label>
                            <input type="file" class="form-control" id="proof_of_payment" accept="image/*">
                        </div>
                    </div>
                </div>
            </div>

            <!-- Order Summary Section -->
            <div class="col-lg-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title mb-4">Ringkasan Pesanan</h5>

                        <div class="d-flex justify-content-between mb-2">
                            <span>Total Harga (@if ($isFromCart)
                                    {{ $cartItems->count() }}
                                @else
                                    1
                                @endif barang)</span>
                            <span id="total-price">Rp{{ number_format($totalPrice, 0, ',', '.') }}</span>
                        </div>

                        <div class="d-flex justify-content-between mb-2 text-success">
                            <span>Total Diskon</span>
                            <span id="total-discount">-Rp{{ number_format($totalDiscount, 0, ',', '.') }}</span>
                        </div>

                        <hr>

                        <div class="d-flex justify-content-between mb-4">
                            <strong>Total Tagihan</strong>
                            <strong class="text-danger" id="grand-total">
                                Rp{{ number_format($grandTotal, 0, ',', '.') }}
                            </strong>
                        </div>

                        <button class="btn btn-custom w-100" id="btn-pay">
                            <i class="bi bi-shield-lock"></i> Bayar Sekarang
                        </button>

                        <input type="hidden" id="is-from-cart" value="{{ $isFromCart ? 'true' : 'false' }}">
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const paymentMethodInputs = document.querySelectorAll('input[name="payment_method"]');
            const transferProofDiv = document.getElementById('transfer-proof');

            paymentMethodInputs.forEach(input => {
                input.addEventListener('change', function() {
                    if (this.value === 'Transfer') {
                        transferProofDiv.classList.remove('d-none');
                    } else {
                        transferProofDiv.classList.add('d-none');
                        // Clear any uploaded file when switching to COD
                        document.getElementById('proof_of_payment').value = '';
                    }
                });
            });

            // Handle address management
            const editAddressModal = document.getElementById('editAddressModal');
            if (editAddressModal) {
                editAddressModal.addEventListener('show.bs.modal', function(event) {
                    const button = event.relatedTarget;
                    const addressId = button.getAttribute('data-address-id');

                    // Fetch address details
                    fetch(`/addresses/${addressId}`)
                        .then(response => response.json())
                        .then(data => {
                            const form = document.getElementById('editAddressForm');
                            form.querySelector('[name="address_id"]').value = data.id;
                            form.querySelector('[name="label"]').value = data.label;
                            form.querySelector('[name="receiver_name"]').value = data.receiver_name;
                            form.querySelector('[name="phone_number"]').value = data.phone_number;
                            form.querySelector('[name="full_address"]').value = data.full_address;
                            form.querySelector('[name="is_primary"]').checked = data.is_primary;
                        });
                });
            }

            // Save new address
            window.saveNewAddress = async function() {
                const form = document.getElementById('addAddressForm');
                const formData = new FormData(form);
                const data = Object.fromEntries(formData.entries());

                // Convert is_primary checkbox value to boolean
                data.is_primary = formData.get('is_primary') === 'on';

                try {
                    const response = await fetch('/addresses', {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')
                                .content,
                            'Content-Type': 'application/json',
                            'Accept': 'application/json'
                        },
                        body: JSON.stringify(data)
                    });

                    const result = await response.json();

                    if (result.success) {
                        window.location.reload();
                    } else {
                        throw new Error(result.message || 'Failed to save address');
                    }
                } catch (error) {
                    console.error('Error:', error);
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Error saving address: ' + error.message
                    });
                }
            };

            // Update address
            window.updateAddress = async function() {
                const form = document.getElementById('editAddressForm');
                const formData = new FormData(form);
                const addressId = formData.get('address_id');
                const data = Object.fromEntries(formData.entries());

                // Convert is_primary checkbox value to boolean
                data.is_primary = formData.get('is_primary') === 'on';

                try {
                    const response = await fetch(`/addresses/${addressId}`, {
                        method: 'PUT',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')
                                .content,
                            'Content-Type': 'application/json',
                            'Accept': 'application/json'
                        },
                        body: JSON.stringify(data)
                    });

                    const result = await response.json();

                    if (result.success) {
                        window.location.reload();
                    } else {
                        throw new Error(result.message || 'Failed to update address');
                    }
                } catch (error) {
                    console.error('Error:', error);
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Error updating address: ' + error.message
                    });
                }
            };

            // Delete address
            window.deleteAddress = async function(addressId) {
                const result = await Swal.fire({
                    title: 'Yakin Hapus Alamat ini?',
                    text: "Tindakan ini tidak bisa dikembalikan!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Ya, Hapus!',
                    cancelButtonText: 'Batal'
                });

                if (result.isConfirmed) {
                    try {
                        const response = await fetch(`/addresses/${addressId}`, {
                            method: 'DELETE',
                            headers: {
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')
                                    .content,
                                'Accept': 'application/json'
                            }
                        });

                        const result = await response.json();

                        if (result.success) {
                            Swal.fire(
                                'Terhapus!',
                                'Alamat berhasil dihapus',
                                'success'
                            ).then(() => {
                                window.location.reload();
                            });
                        } else {
                            throw new Error(result.message || 'Failed to delete address');
                        }
                    } catch (error) {
                        console.error('Error:', error);
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'Error deleting address: ' + error.message
                        });
                    }
                }
            };

            // Handle checkout form submission
            const btnPay = document.getElementById('btn-pay');
            btnPay.addEventListener('click', async function(e) {
                e.preventDefault();

                const selectedAddress = document.querySelector(
                    'input[name="selected_address"]:checked');
                if (!selectedAddress) {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Alamat Belum Dipilih',
                        text: 'Silahkan pilih alamat terlebih dahulu.'
                    });
                    return;
                }

                const paymentMethod = document.querySelector('input[name="payment_method"]:checked')
                    .value;
                const sellerNotes = document.getElementById('seller_notes').value;


                // Collect items data from the DOM
                const items = [];
                document.querySelectorAll('.checkout-item').forEach(item => {
                    items.push({
                        id: item.dataset.itemId,
                        nama_produk: item.querySelector('h6').textContent.trim(),
                        price: parseFloat(item.dataset.price || item.dataset.harga),
                        quantity: parseInt(item.dataset.quantity || item.dataset
                            .jumlah),
                        discount: parseFloat(item.dataset.discount || item.dataset
                            .diskon || 0)
                    });
                });
                // const formData = new FormData();

                // Collect form data
                const formData = new FormData();
                formData.append('payment_method', paymentMethod);
                formData.append('seller_notes', document.getElementById('seller_notes').value);
                formData.append('items', JSON.stringify(items));
                formData.append('address_id', selectedAddress.value);
                formData.append('isFromCart', document.getElementById('is-from-cart').value);

                // Validate proof of payment for transfer method
                if (paymentMethod === 'Transfer') {
                    const proofFile = document.getElementById('proof_of_payment').files[0];
                    if (!proofFile) {
                        Swal.fire({
                            icon: 'warning',
                            title: 'Bukti Pembayaran Diperlukan',
                            text: 'Silahkan upload bukti pembayaran untuk metode transfer.'
                        });
                        return;
                    }

                    // Validate file type
                    const allowedTypes = ['image/jpeg', 'image/png', 'image/jpg'];
                    if (!allowedTypes.includes(proofFile.type)) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Format File Tidak Sesuai',
                            text: 'Bukti pembayaran harus berupa gambar (JPG, JPEG, atau PNG)'
                        });
                        return;
                    }

                    // Validate file size (max 2MB)
                    const maxSize = 2 * 1024 * 1024; // 2MB in bytes
                    if (proofFile.size > maxSize) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Ukuran File Terlalu Besar',
                            text: 'Maksimal ukuran file adalah 2MB'
                        });
                        return;
                    }
                }

                // Add proof of payment if method is transfer
                if (paymentMethod === 'Transfer') {
                    formData.append('proof_of_payment', document.getElementById('proof_of_payment')
                        .files[0]);
                }

                // Add payment method, notes, items, and selected address to form data
                formData.append('payment_method', paymentMethod);
                formData.append('seller_notes', sellerNotes);
                formData.append('items', JSON.stringify(items));
                formData.append('address_id', selectedAddress.value);
                formData.append('isFromCart', document.getElementById('is-from-cart').value);

                // If transfer method is selected, add proof of payment
                if (paymentMethod === 'Transfer') {
                    const proofFile = document.getElementById('proof_of_payment').files[0];
                    if (!proofFile) {
                        Swal.fire({
                            icon: 'warning',
                            title: 'Bukti Pembayaran Belum Dipilih',
                            text: 'Silahkan upload bukti pembayaran terlebih dahulu.'
                        });
                        return;
                    }
                    formData.append('proof_of_payment', proofFile);
                }



                try {
                    // Show loading state
                    Swal.fire({
                        title: 'Memproses pesanan',
                        text: 'Tunggu bentar...',
                        allowOutsideClick: false,
                        showConfirmButton: false,
                        willOpen: () => {
                            Swal.showLoading();
                        }
                    });

                    const response = await fetch('/checkout', {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector(
                                    'meta[name="csrf-token"]')
                                .content
                        },
                        body: formData
                    });

                    const result = await response.json();

                    if (response.ok && result.success) {
                        // Clear cart session storage if it exists
                        if (sessionStorage.getItem('checkoutItems')) {
                            sessionStorage.removeItem('checkoutItems');
                            sessionStorage.removeItem('checkoutSummary');
                        }

                        // Show success message and redirect
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil!',
                            text: 'Pesanan Anda telah berhasil dilakukan',
                            showConfirmButton: true,
                            confirmButtonText: 'Lihat Pesanan',
                        }).then((swalResult) => {
                            if (swalResult.isConfirmed) {
                                window.location.href = result.redirect_url;
                            }
                        });
                    } else {
                        throw new Error(result.message ||
                            'Terjadi kesalahan saat memproses pesanan Anda');
                    }
                } catch (error) {
                    console.error('Kesalahan pemrosesan pembayaran:', error);
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: error.message ||
                            'Terjadi kesalahan saat memproses pesanan Anda'
                    });
                }
            });
        });
    </script>
@endsection
