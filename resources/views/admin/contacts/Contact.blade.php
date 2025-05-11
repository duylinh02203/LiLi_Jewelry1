@extends('admin.layouts.app')
@section('content')
<div class="content-wrapper">
        <div class="page-header">
            <h3 class="page-title">Contact</h3>
            <nav>
            </nav>
            @if ($message = Session::get('success'))
                <div id="alert" class="alert alert-success" style="position: absolute; width: 80%;">
                    {{ $message }}
                </div>
            @endif
        </div>
        <div class="row">
            <div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <div class="search-add-wrapper"
                            style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
                            <div class="search-bar col-lg-3" style="width: 250px; flex: 1;">
                                <form class="nav-link mt-2 mt-md-0 d-lg-flex search">
                                    <input type="text" style="padding: 15;" class="form-control"
                                        placeholder="Search Contact">
                                </form>
                            </div>
                        </div>
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>STT</th>
                                        <th>Tên</th>
                                        <th>Họ</th>
                                        <th>Email</th>
                                        <th>Số điện thoại</th>
                                        <th>Bình luận</th>
                                        <th>Chức năng</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if (count($contacts) > 0)
                                        @foreach ($contacts as $index => $contact)
                                            <tr>
                                                <td>{{ ++$index }}</td>
                                                <td>{{ $contact->first_name }}</td>
                                                <td>{{ $contact->last_name }}</td>
                                                <td>{{ $contact->email }}</td>
                                                <td>{{ $contact->phone }}</td>
                                                <td>{{ $contact->comment }}</td>
                                                <td>
                                                    <a href="{{ route('admin.contact.remove', $contact->id) }}">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="button" class="btn btn-delete">Delete</button>
                                                    </a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @else
                                        <tr>
                                            <td colspan="5" class="text-center">No data found</td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>
                            <div style="position: absolute; bottom: 10px; right: 20px;">
                                <div style="display: flex; gap: 8px;">
                                    <button
                                        style="padding: 8px 14px; border-radius: 8px; background-color: #2d2d44; color: #ffffff; font-size: 14px; font-weight: 500; text-align: center; border: 1px solid #444; transition: all 0.3s ease;">Previous</button>
                                    <button
                                        style="padding: 8px 14px; border-radius: 8px; background-color: #2d2d44; color: #ffffff; font-size: 14px; font-weight: 500; text-align: center; border: 1px solid #444; transition: all 0.3s ease;">1</button>
                                    <button
                                        style="padding: 8px 14px; border-radius: 8px; background-color: #2d2d44; color: #ffffff; font-size: 14px; font-weight: 500; text-align: center; border: 1px solid #444; transition: all 0.3s ease;">2</button>
                                    <button
                                        style="padding: 8px 14px; border-radius: 8px; background-color: #2d2d44; color: #ffffff; font-size: 14px; font-weight: 500; text-align: center; border: 1px solid #444; transition: all 0.3s ease;">3</button>
                                    <button
                                        style="padding: 8px 14px; border-radius: 8px; background-color: #2d2d44; color: #ffffff; font-size: 14px; font-weight: 500; text-align: center; border: 1px solid #444; transition: all 0.3s ease;">Next</button>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        setTimeout(function() {
            let alert = document.getElementById('alert');
            if (alert) {
                alert.style.transition = 'opacity 0.5s ease';
                alert.style.opacity = '0';
                setTimeout(function() {
                    alert.style.display = 'none';
                }, 500);
            }
        }, 3000);
    </script>
@endsection