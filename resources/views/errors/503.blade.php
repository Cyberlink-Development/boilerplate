@extends('admin.common.master')

@section('page_sub_title')
    ~ Under Maintenance
@endsection

@section('sub-content')
    <div class="container-body">
        <div class="container">
            <h1>Under Maintenance</h1>
            <p>We are currently performing scheduled maintenance. We apologize for any inconvenience this may cause.</p>
            <p>Please check back later.</p>
            <div class="contact">
                <p>If you need assistance, please contact our support team at <a href="">...</a>.</p>
            </div>
        </div>
    </div>
@endsection

@section('maintain-styles')
    <style>
        .container-body {
            font-family: Arial, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 85vh;
            margin: 0;
            background-color: #f8f9fa;
            color: #343a40;
        }
        .container {
            text-align: center;
        }
        .container h1{
            font-size: 3rem;
            margin-bottom: 1rem;
            color: rgb(196, 49, 49)
        }
        p {
            font-size: 1.25rem;
        }
        .contact {
            margin-top: 2rem;
        }
    </style>
@endsection
