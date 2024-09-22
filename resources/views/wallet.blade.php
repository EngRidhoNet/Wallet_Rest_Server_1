@extends('layouts.main')

@section('title', 'Dashboard')

@section('content')
    <div class="pagetitle">
        <h1>Wallet</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                <li class="breadcrumb-item active">Wallet</li>
            </ol>
        </nav>
    </div>
    <section class="section dashboard">
        <div class="row">
            <div class="col-lg-12"> <!-- Full width -->
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title">Your Wallet</h5>
                        <button id="addWalletBtn" class="btn btn-primary float-end" data-bs-toggle="modal"
                            data-bs-target="#walletModal">Add Wallet</button>
                    </div>
                    <div class="card-body">
                        <table id="walletTable" class="table">
                            <thead>
                                <tr>
                                    <th>Saldo</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- Data akan diisi oleh JavaScript -->
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Modal untuk Deposit -->
    <div class="modal fade" id="depositModal" tabindex="-1" aria-labelledby="depositModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="depositModalLabel">Deposit to Wallet</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="depositForm">
                        @csrf
                        <div class="mb-3">
                            <label for="depositAmount" class="form-label">Amount to Deposit</label>
                            <input type="number" class="form-control" id="depositAmount" name="depositAmount"
                                min="0" step="0.01" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Deposit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal untuk Withdraw -->
    <div class="modal fade" id="withdrawModal" tabindex="-1" aria-labelledby="withdrawModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="withdrawModalLabel">Withdraw from Wallet</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="withdrawForm">
                        @csrf
                        <div class="mb-3">
                            <label for="withdrawAmount" class="form-label">Amount to Withdraw</label>
                            <input type="number" class="form-control" id="withdrawAmount" name="withdrawAmount"
                                min="0" step="0.01" required>
                        </div>
                        <button type="submit" class="btn btn-warning">Withdraw</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal untuk Pay -->
    <div class="modal fade" id="payModal" tabindex="-1" aria-labelledby="payModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="payModalLabel">Make a Payment</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="payForm">
                        @csrf
                        <div class="mb-3">
                            <label for="payAmount" class="form-label">Payment Amount</label>
                            <input type="number" class="form-control" id="payAmount" name="payAmount" min="0"
                                step="0.01" required>
                        </div>
                        <div class="mb-3">
                            <label for="paymentDescription" class="form-label">Payment Description</label>
                            <input type="text" class="form-control" id="paymentDescription" name="paymentDescription"
                                required>
                        </div>
                        <button type="submit" class="btn btn-info">Pay</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal for Add/Edit Wallet -->
    <div class="modal fade" id="walletModal" tabindex="-1" aria-labelledby="walletModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="walletModalLabel">Add/Edit Wallet</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="walletForm">
                        @csrf
                        <div class="mb-3">
                            <label for="balance" class="form-label">Balance</label>
                            <input type="number" class="form-control" id="balance" name="balance"
                                placeholder="Enter wallet balance" required>
                        </div>
                        <input type="hidden" id="walletId">
                        <button type="submit" class="btn btn-primary">Save</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.1.0/js/bootstrap.bundle.min.js"></script>
    <script>
        $(document).ready(function() {
            const userId = {!! json_encode(auth()->id()) !!};
            // console.log(userId);
            // Fetch user's wallet

            $(document).ready(function() {
                $('#walletForm').on('submit', function(e) {
                    e.preventDefault();
                    createWallet();
                });
            });

            function createWallet() {
                var walletId = $('#walletId').val();
                var balance = $('#balance').val();

                $.ajax({
                    url: walletId ? '/api/wallet/update/' + walletId : '/api/wallet/create',
                    method: walletId ? 'PUT' : 'POST',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: {
                        user_id: userId, // Ensure userId is defined globally or pass it to the function
                        balance: balance
                    },
                    success: function(wallet) {
                        fetchUserWallet(); // Ensure this function is defined
                        $('#walletModal').modal('hide');
                        alert(walletId ? "Dompet berhasil diperbarui!" :
                        "Dompet berhasil ditambahkan!");
                    },
                    error: function(xhr, status, error) {
                        console.error("Error creating/updating wallet:", error);
                        alert(walletId ? "Gagal memperbarui dompet. Silakan coba lagi." :
                            "Gagal menambahkan dompet. Silakan coba lagi.");
                    }
                });
            }

            function fetchUserWallet() {
                $.ajax({
                    url: `/api/wallet/${userId}`,
                    method: 'GET',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token "]').attr('content')
                    },
                    success: function(wallet) {
                        updateWalletDisplay(wallet);
                    },
                    error: function(xhr, status, error) {
                        console.error("Error fetching wallet:", error);
                        alert("Gagal memuat informasi dompet. Silakan coba lagi.");
                    }
                });
            }

            function updateWalletDisplay(wallet) {
                let row = `
                    <tr>
                        <td>${parseFloat(wallet.balance).toLocaleString('id-ID', { style: 'currency', currency: 'IDR' })}</td>
                        <td>
                            <button class="btn btn-primary btn-sm depositBtn" data-bs-toggle="modal" data-bs-target="#depositModal">Deposit</button>
                            <button class="btn btn-warning btn-sm withdrawBtn" data-bs-toggle="modal" data-bs-target="#withdrawModal">Withdraw</button>
                            <button class="btn btn-info btn-sm payBtn" data-bs-toggle="modal" data-bs-target="#payModal">Pay</button>
                        </td>
                    </tr>
                `;
                $('#walletTable tbody').html(row);
            }

            fetchUserWallet();

            // Deposit
            $(document).on('click', '.depositBtn', function() {
                $('#depositModal').modal('show');
            });

            $('#depositForm').submit(function(e) {
                e.preventDefault();

                let amount = $('#depositAmount').val();

                $.ajax({
                    url: '/api/wallet/deposit',
                    method: 'POST',
                    contentType: 'application/json',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    // Mengatur Content-Type ke application/json

                    data: JSON.stringify({
                        user_id: userId,
                        amount: amount
                    }),
                    success: function(wallet) {
                        updateWalletDisplay(wallet);
                        $('#depositModal').modal('hide');
                        alert("Deposit berhasil!");
                    },
                    error: function(xhr, status, error) {
                        console.error("Error depositing:", error);
                        console.log(xhr.responseText);
                        alert("Gagal melakukan deposit. Silakan coba lagi.");
                    }
                });
            });
            // Withdraw
            $(document).on('click', '.withdrawBtn', function() {
                $('#withdrawModal').modal('show');
            });

            $('#withdrawForm').submit(function(e) {
                e.preventDefault();
                let amount = $('#withdrawAmount').val();

                $.ajax({
                    url: '/api/wallet/withdraw',
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: {
                        user_id: userId,
                        amount: amount
                    },
                    success: function(wallet) {
                        updateWalletDisplay(wallet);
                        $('#withdrawModal').modal('hide');
                        alert("Penarikan berhasil!");
                    },
                    error: function(xhr, status, error) {
                        console.error("Error withdrawing:", error);
                        alert(xhr.responseJSON.message ||
                            "Gagal melakukan penarikan. Silakan coba lagi.");
                    }
                });
            });

            // Pay
            $(document).on('click', '.payBtn', function() {
                $('#payModal').modal('show');
            });

            $('#payForm').submit(function(e) {
                e.preventDefault();
                let amount = $('#payAmount').val();

                $.ajax({
                    url: '/api/wallet/pay',
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: {
                        user_id: userId,
                        amount: amount
                    },
                    success: function(wallet) {
                        updateWalletDisplay(wallet);
                        $('#payModal').modal('hide');
                        alert("Pembayaran berhasil!");
                    },
                    error: function(xhr, status, error) {
                        console.error("Error paying:", error);
                        alert("Gagal melakukan pembayaran. Silakan coba lagi.");
                    }
                });
            });
        });
    </script>

@endsection
