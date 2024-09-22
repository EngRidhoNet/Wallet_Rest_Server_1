@extends('layouts.main')

@section('title', 'Dashboard')

@section('content')
    <div class="pagetitle">
        <h1>Dashboard</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                <li class="breadcrumb-item active">Dashboard</li>
            </ol>
        </nav>
    </div>

    <section class="section dashboard">
        <div class="row">
            <div class="col-lg-12"> <!-- Ubah dari col-lg-8 ke col-lg-12 agar memenuhi lebar layar -->
                <div class="row">
                    <!-- Sales Card -->
                    <div class="col-xxl-4 col-md-6">
                        <div class="card info-card sales-card">
                            <div class="card-body">
                                <h5 class="card-title">Sales <span>| Today</span></h5>
                                <div class="d-flex align-items-center">
                                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                        <i class="bi bi-cart"></i>
                                    </div>
                                    <div class="ps-3">
                                        <h6>145</h6>
                                        <span class="text-success small pt-1 fw-bold">12%</span>
                                        <span class="text-muted small pt-2 ps-1">increase</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div><!-- End Sales Card -->

                    <!-- Wallet Balance Card -->
                    <div class="col-xxl-4 col-md-6">
                        <div class="card info-card balance-card">
                            <div class="card-body">
                                <h5 class="card-title">Wallet Balance</h5>
                                <div class="d-flex align-items-center">
                                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                        <i class="bi bi-wallet2"></i>
                                    </div>
                                    <div class="ps-3">
                                        <h6>$balance</h6>
                                        <span class="text-muted small pt-2 ps-1">Available balance</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div><!-- End Wallet Balance Card -->

                    {{-- start tables --}}
                    <div class="container mt-5">
                        <h2 class="mb-4">Transactions</h2>
                        <!-- Table Responsive -->
                        <div class="table-responsive">
                            <table id="transactionsTable" class="table table-bordered table-hover" style="width: 100%;">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Wallet ID</th>
                                        <th>Amount</th>
                                        <th>Transaction Type</th>
                                        <th>Created At</th>
                                        <th>Updated At</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>1</td>
                                        <td>101</td>
                                        <td>500.00</td>
                                        <td>Deposit</td>
                                        <td>2024-09-17 10:15:32</td>
                                        <td>2024-09-17 11:00:45</td>
                                    </tr>
                                    <tr>
                                        <td>2</td>
                                        <td>102</td>
                                        <td>300.00</td>
                                        <td>Withdraw</td>
                                        <td>2024-09-18 12:20:10</td>
                                        <td>2024-09-18 12:45:22</td>
                                    </tr>
                                    <tr>
                                        <td>3</td>
                                        <td>101</td>
                                        <td>150.00</td>
                                        <td>Payment</td>
                                        <td>2024-09-19 08:30:12</td>
                                        <td>2024-09-19 09:10:05</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        {{-- end tables --}}
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
