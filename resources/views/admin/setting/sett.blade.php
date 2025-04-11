@extends('admin.layouts.app')
@section('content')
<div class="container mx-auto p-4">
    <style>
        /* Global styles for the form container */
        .container {
            max-width: 800px;
            margin: 0 auto;
            font-family: Arial, sans-serif;
            color: #e5e5e5; /* Light text color for dark background */
        }

        /* Background and container styling */
        .bg-dark {
            background-color: #1e1e2f; /* Dark gray background */
            color: #e5e5e5; /* Text color for contrast */
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            padding: 24px;
        }

        /* Header styling */
        h1,
        h2 {
            color: #ffffff; /* White text for headers */
            margin-bottom: 16px;
        }

        /* Label and input field styling */
        label {
            font-weight: bold;
            font-size: 14px;
            color: #c4c4c4; /* Light gray for labels */
        }

        input[type="text"],
        input[type="email"],
        input[type="password"] {
            padding: 12px;
            font-size: 16px;
            border: 1px solid #444; /* Border color to blend with dark background */
            border-radius: 8px;
            background-color: #2b2b3d; /* Input background */
            color: #e5e5e5; /* Text color */
            width: 100%;
            box-sizing: border-box;
            margin-top: 8px;
            margin-bottom: 16px;
            transition: border 0.3s, background-color 0.3s;
        }

        input:focus {
            border-color: #0d6efd; /* Blue focus border */
            outline: none;
            box-shadow: 0 0 5px rgba(13, 110, 253, 0.2);
            background-color: #3b3b4d; /* Slightly lighter background */
        }

        /* Button styling */
        button {
            background-color: #0d6efd;
            color: #fff;
            padding: 12px 20px;
            font-size: 16px;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            transition: background-color 0.3s, box-shadow 0.3s;
        }

        button:hover {
            background-color: #0056b3;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        /* Form layout improvements */
        .form-group {
            margin-bottom: 16px;
        }

        .flex {
            display: flex;
            justify-content: flex-end;
        }
    </style>

    <div class="bg-dark col-md-12">
        <h1 class="text-2xl font-bold mb-4">Settings</h1>
        <form method="POST" action="">
            @csrf
            @method('GET')
            <!-- Section thông tin cá nhân -->
            <div class="mb-6">
                <label for="name" class="block text-sm font-medium">Name <span class="text-red-500">*</span></label>
                <input type="text" name="name" id="name" placeholder="Full Name">
            </div>

            <div class="mb-6">
                <label for="mobile_number" class="block text-sm font-medium">Mobile Number <span class="text-red-500">*</span></label>
                <input type="text" name="mobile_number" id="mobile_number" placeholder="Mobile Number">
            </div>

            <div class="mb-6">
                <label for="email" class="block text-sm font-medium">Email Address <span class="text-red-500">*</span></label>
                <input type="email" name="email" id="email" placeholder="Email Address">
            </div>

            <!-- Section thay đổi mật khẩu -->
            <h2 class="text-xl font-bold mt-8 mb-4">Password Change</h2>

            <div class="mb-6">
                <label for="old_password" class="block text-sm font-medium">Old Password <span class="text-red-500">*</span></label>
                <input type="password" name="old_password" id="old_password" placeholder="Old password">
            </div>

            <div class="mb-6">
                <label for="new_password" class="block text-sm font-medium">New Password <span class="text-red-500">*</span></label>
                <input type="password" name="new_password" id="new_password" placeholder="New password">
            </div>

            <div class="mb-6">
                <label for="confirm_password" class="block text-sm font-medium">Confirm New Password <span class="text-red-500">*</span></label>
                <input type="password" name="confirm_password" id="confirm_password" placeholder="Confirm new password">
            </div>

            <div class="flex justify-end">
                <button type="submit">Save Changes</button>
            </div>
        </form>
    </div>
</div>
@endsection
