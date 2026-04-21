@extends('admin.includes.master')

@section('title', 'Quản lý Người Dùng')

@section('content')
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Danh sách Người Dùng</h1>
        <a href="{{ route('users.create') }}" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">
            <i class="fas fa-user-plus fa-sm text-white-50"></i> Thêm người dùng mới
        </a>
    </div>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Tất cả tài khoản</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover" width="100%" cellspacing="0">
                    <thead class="thead-light">
                        <tr>
                            <th>STT</th>
                            <th>Họ tên</th>
                            <th>Email</th>
                            <th>Số ĐT</th>
                            <th>Vai trò</th>
                            <th>Trạng thái</th>
                            <th>Thao tác</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($users as $key => $user)
                            <tr>
                                <td>{{ $users->firstItem() + $key }}</td>
                                <td><strong>{{ $user->hoten }}</strong></td>
                                <td>{{ $user->email }}</td>
                                <td>{{ $user->sodienthoai ?? 'Chưa cập nhật' }}</td>
                                <td>
                                    @if($user->vaitro == 1)
                                        <span class="badge badge-danger">Quản trị viên</span>
                                    @else
                                        <span class="badge badge-info">Khách hàng</span>
                                    @endif
                                </td>
                                <td>
                                    @if($user->trangthai == 1)
                                        <span class="badge badge-success">Hoạt động</span>
                                    @else
                                        <span class="badge badge-secondary">Bị khóa</span>
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ route('users.edit', $user->id) }}" class="btn btn-primary btn-sm" title="Sửa">
                                        <i class="fas fa-edit"></i>
                                    </a>

                                    <form action="{{ route('users.toggleStatus', $user->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('PUT')
                                        @if($user->trangthai == 1)
                                            <button type="submit" class="btn btn-warning btn-sm" title="Khóa tài khoản"
                                                onclick="return confirm('Bạn có chắc muốn KHÓA tài khoản này? Người dùng sẽ không thể đăng nhập.')">
                                                <i class="fas fa-lock"></i>
                                            </button>
                                        @else
                                            <button type="submit" class="btn btn-success btn-sm" title="Mở khóa tài khoản">
                                                <i class="fas fa-unlock"></i>
                                            </button>
                                        @endif
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center text-muted py-4">Chưa có người dùng nào.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="d-flex justify-content-end mt-3">
                {{ $users->links('pagination::bootstrap-4') }}
            </div>
        </div>
    </div>
@endsection