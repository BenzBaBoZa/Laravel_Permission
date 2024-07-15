<?php

namespace App\Http\Controllers;

use App\Models\RolePermission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use App\Models\Permission;

class PermissionController extends Controller
{
    public function index()
    {
        $permissions = RolePermission::paginate(10);
        return view('permissions.home', compact('permissions'));
    }

    public function create()
    {
        return view('permissions.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'role' => 'required|unique:role_permissions,role',
            'Product_Set' => 'required|in:0,1,2',
            'Profile_Set' => 'required|in:0,1,2',
            'System_Users_Set' => 'required|in:0,1,2',
            'Permissions_Set' => 'required|in:0,1,2',
        ]);

        // ตรวจสอบว่า Role มีอยู่แล้วหรือไม่
        if (RolePermission::where('role', $request->role)->exists()) {
            // เก็บการแจ้งเตือนในเซสชัน
            Session::flash('error', 'Role Name already exists.');
            return redirect()->back()->withInput();
        }

        RolePermission::create([
            'role' => $request->role,
            'Product_Set' => $request->Product_Set,
            'Profile_Set' => $request->Profile_Set,
            'System_Users_Set' => $request->System_Users_Set,
            'Permissions_Set' => $request->Permissions_Set,
        ]);

        return redirect()->route('permissions.index')->with('success', 'Permission added successfully.');
    }

    public function show($id)
    {
        $permission = RolePermission::findOrFail($id);
        return view('permissions.show', compact('permission'));
    }

    public function edit($id)
    {
        $permission = RolePermission::findOrFail($id);
        return view('permissions.edit', compact('permission'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'role' => 'required|string|max:255',
            'Product_Set' => 'required|integer',
            'Profile_Set' => 'required|integer',
            'System_Users_Set' => 'required|integer',
            'Permissions_Set' => 'required|integer',
        ]);

        $permission = RolePermission::findOrFail($id);
        $permission->update($request->all());

        return redirect()->route('permissions.index')->with('success', 'Permission updated successfully.');
    }

    public function destroy($id)
    {
        $permission = RolePermission::findOrFail($id);
        $permission->delete();

        return redirect()->route('permissions.index')->with('success', 'Permission deleted successfully.');
    }

    public function someControllerMethod()
    {
        // Fetch the logged-in user
        $user = auth()->user();

        // Assuming you have a relationship or method to get permissions
        $permissions = [
            'Product_Set' => $user->role->Product_Set,
            'Profile_Set' => $user->role->Profile_Set,
            'System_Users_Set' => $user->role->System_Users_Set,
            'Permissions_Set' => $user->role->Permissions_Set,
        ];

        // Pass permissions to the view
        return view('your-view-name', compact('permissions'));
    }

    public function search(Request $request)
    {
        $query = $request->input('query');

        // dd($query);
        $permissions = RolePermission::query()
            ->when($query, function ($q) use ($query) {
                return $q->where('role', 'LIKE', "%{$query}%");
            })
            ->orderBy('created_at', 'DESC')
            ->paginate(5);
        // dd($permissions);

        // return view('permissions.index', compact('permissions'));
        return view('permissions.home', compact('permissions'));
    }
}
