<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rules\Password;

class UsersController extends Controller
{
    public function index(Request $request)
    {
        $users = User::query()
            ->when($request->search, function ($query, $search) {
                return $query->where('full_name', 'like', "%{$search}%");
            })
            ->when($request->role, function ($query, $role) {
                return $query->where('role', $role);
            })
            ->when($request->filled('is_active'), function ($query) use ($request) {
                $active = filter_var($request->is_active, FILTER_VALIDATE_BOOLEAN);
                return $query->where('is_active', $active);
            })
            ->orderBy('created_at', 'desc')
            ->paginate(10)
            ->withQueryString();

        return view('admin.users.index', compact('users'));
    }

    public function create()
    {
        $roles = [
            'USER' => 'Người dùng',
            'ADMIN' => 'Quản trị viên',
        ];
        return view('admin.users.create', compact('roles'));
    }

    // HÀM LƯU MỚI (STORE)
    public function store(Request $request)
    {
        $request->validate([
            'full_name' => 'required|string|max:150',
            'email' => 'required|email|max:190|unique:users,email',
            'role' => 'required|in:ADMIN,USER',
            'is_active' => 'required|boolean',
            'phone' => 'nullable|string|max:30',
            'avatar' => 'nullable|image|max:2048',
            'password' => ['required', Password::min(6)], // Tạo mới thì bắt buộc nhập pass
        ]);

        $data = $request->except(['password', 'avatar']);
        $data['password'] = Hash::make($request->password);

        if ($request->hasFile('avatar')) {
            $path = $request->file('avatar')->store('avatars', 'public');
            $data['avatar_url'] = Storage::url($path);
        }

        User::create($data);

        return redirect()->route('admin.users.index')->with('success', 'Thêm người dùng mới thành công!');
    }

    public function edit(User $user)
    {
        $roles = [
            'USER' => 'Người dùng',
            'ADMIN' => 'Quản trị viên',
        ];
        return view('admin.users.edit', compact('user', 'roles'));
    }

    // HÀM CẬP NHẬT (UPDATE)
    public function update(Request $request, User $user)
    {
        $request->validate([
            'full_name' => 'required|string|max:150',
            'email' => 'required|email|max:190|unique:users,email,' . $user->id, // Phải có dấu phẩy ở đây
            'role' => 'required|in:ADMIN,USER',
            'is_active' => 'required|boolean',
            'phone' => 'nullable|string|max:30',
            'avatar' => 'nullable|image|max:2048',
            'password' => ['nullable', Password::min(6)], // Cập nhật thì không bắt buộc pass
        ]);

        $data = $request->except(['password', 'avatar']);

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        if ($request->hasFile('avatar')) {
            // Xóa avatar cũ nếu có
            if ($user->avatar_url) {
                Storage::disk('public')->delete(str_replace('/storage/', '', $user->avatar_url));
            }
            $path = $request->file('avatar')->store('avatars', 'public');
            $data['avatar_url'] = Storage::url($path);
        }

        $user->update($data);

        return redirect()->route('admin.users.index')->with('success', 'Cập nhật thông tin thành công!');
    }

    public function destroy(User $user)
    {
        // Sửa auth()->id thành auth()->id()
        if (auth()->id() === $user->id) {
            return back()->with('error', 'Bạn không thể tự xóa tài khoản của chính mình!');
        }

        if ($user->avatar_url) {
            Storage::disk('public')->delete(str_replace('/storage/', '', $user->avatar_url));
        }

        $user->delete();

        return redirect()->route('admin.users.index')->with('success', 'Đã xóa người dùng thành công!');
    }
}
