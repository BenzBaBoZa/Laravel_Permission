<?php

namespace App\Http\Controllers;

use App\Models\Permission;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    public function index()
{
    $users = User::paginate(5); // แสดง 5 รายการต่อหน้า
    $users = User::with('role_permissions')->paginate(5);
    // $role_permissions = DB::table('users')
    // ->join('role_permissions','users.role_id','=','role_permissions.id') 
    // ->where('users.id',auth()->user()->id)
    // ->select('role_permissions.role');

    // dd( $role_permissions);
    // ดึงข้อมูล role_permissions ทั้งหมด

    return view('roleupdate.role', compact('users'));
    }

    public function show($id)
    {
        $user = User::with('role_permissions')->findOrFail($id);
        return view('roleupdate.showrole', compact('user'));
    }

    public function edit($id)
    {
    $user = User::findOrFail($id);
    $rolePermissions = \App\Models\RolePermission::all(); // ดึงข้อมูล role_permissions ทั้งหมด
    return view('roleupdate.editrole', compact('user', 'rolePermissions'));
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);
        
        $request->validate([
            'role_id' => 'required|exists:role_permissions,id',
        ]);

        $user->update([
            'role_id' => $request->role_id,
        ]);

        return redirect()->route('role.index')->with('success', 'User role updated successfully');
    }

    public function create()
    {
        $rolePermissions = \App\Models\RolePermission::all(); // ดึงข้อมูล role_permissions ทั้งหมด
        return view('roleupdate.add_user', compact('rolePermissions'));
    }

    public function store(Request $request)
    {
    $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|string|email|max:255|unique:users',
        'password' => 'required|string|min:8|confirmed',
        'role_id' => 'required|exists:role_permissions,id',
    ]);

    User::create([
        'name' => $request->name,
        'email' => $request->email,
        'password' => Hash::make($request->password),
        'role_id' => $request->role_id,
    ]);

    return redirect()->route('role.index')->with('success', 'User added successfully.');
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->route('role.index')->with('success', 'User deleted successfully.');
    }

    public function search(Request $request)
    {
        $query = $request->input('query');

        $users = User::with('role_permissions')
            ->where(function ($q) use ($query) {
                $q->where('name', 'LIKE', "%{$query}%")
                ->orWhereHas('role_permissions', function($q) use ($query) {
                    $q->where('role', 'LIKE', "%{$query}%");
                });
            })
            ->paginate(5);

        return view('roleupdate.role', compact('users'));
    }

}
