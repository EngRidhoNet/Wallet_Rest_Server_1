@extends('layouts.main')

@section('title', 'Dashboard')

@section('content')
    <style>

  body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }
        .container {
            max-width: 1200px;
            margin: auto;
            padding: 20px;
        }
        h2 {
            color: #333;
        }
        .endpoint {
            background-color: white;
            border-radius: 8px;
            margin: 20px 0;
            padding: 15px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        .method {
            font-weight: bold;
            color: #ff9800;
        }
        .auth-required {
            font-size: 12px;
            color: red;
            font-style: italic;
        }
        pre {
            background-color: #f1f1f1;
            padding: 10px;
            border-radius: 8px;
        }
       
        @media (max-width: 768px) {
            .container {
                padding: 10px;
            }
        }
    </style>
    <div class="pagetitle">
        <h1>Api Documentation</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                <li class="breadcrumb-item active">Api Documentation</li>
            </ol>
        </nav>
    </div>

    <section class="section dashboard">
        <div class="row">
            <div class="col-lg-12"> <!-- Ubah dari col-lg-8 ke col-lg-12 agar memenuhi lebar layar -->
                <div class="row">


                    <div class="container">
                        <section>
                            <h2>Wallet Endpoints</h2>

                            <div class="endpoint">
                                <p><span class="method">GET</span> /wallet/{id}</p>
                                <p>Retrieve a specific wallet by ID.</p>
                                <p><strong>Response:</strong></p>
                                <pre>{
  "id": 1,
  "balance": 1000,
  "user_id": 123
}</pre>
                            </div>

                            <div class="endpoint">
                                <p><span class="method">POST</span> /wallet/deposit</p>
                                <p>Deposit funds into the wallet.</p>
                                <p><strong>Request Body:</strong></p>
                                <pre>{
  "wallet_id": 1,
  "amount": 500
}</pre>
                                <p><strong>Response:</strong></p>
                                <pre>{
  "success": true,
  "new_balance": 1500
}</pre>
                            </div>

                            <div class="endpoint">
                                <p><span class="method">POST</span> /wallet/withdraw</p>
                                <p>Withdraw funds from the wallet.</p>
                                <p><strong>Request Body:</strong></p>
                                <pre>{
  "wallet_id": 1,
  "amount": 200
}</pre>
                                <p><strong>Response:</strong></p>
                                <pre>{
  "success": true,
  "new_balance": 800
}</pre>
                            </div>

                            <div class="endpoint">
                                <p><span class="method">POST</span> /wallet/pay</p>
                                <p>Make a payment from the wallet.</p>
                                <p><strong>Request Body:</strong></p>
                                <pre>{
  "wallet_id": 1,
  "amount": 300,
  "recipient_id": 456
}</pre>
                                <p><strong>Response:</strong></p>
                                <pre>{
  "success": true,
  "new_balance": 700
}</pre>
                            </div>
                        </section>

                        <section>
                            <h2>Authentication Endpoints</h2>

                            <div class="endpoint">
                                <p><span class="method">POST</span> /register</p>
                                <p>Register a new user.</p>
                                <p><strong>Request Body:</strong></p>
                                <pre>{
  "name": "John Doe",
  "email": "john@example.com",
  "password": "password123"
}</pre>
                                <p><strong>Response:</strong></p>
                                <pre>{
  "success": true,
  "token": "abcdef123456"
}</pre>
                            </div>

                            <div class="endpoint">
                                <p><span class="method">POST</span> /login</p>
                                <p>Login and receive a token.</p>
                                <p><strong>Request Body:</strong></p>
                                <pre>{
  "email": "john@example.com",
  "password": "password123"
}</pre>
                                <p><strong>Response:</strong></p>
                                <pre>{
  "success": true,
  "token": "abcdef123456"
}</pre>
                            </div>

                            <div class="endpoint">
                                <p><span class="method">POST</span> /logout <span class="auth-required">(Requires
                                        Authentication)</span></p>
                                <p>Logout the authenticated user.</p>
                                <p><strong>Response:</strong></p>
                                <pre>{
  "success": true,
  "message": "Logged out"
}</pre>
                            </div>
                        </section>
                    </div>





                </div>
            </div>
        </div>
    </section>
@endsection
