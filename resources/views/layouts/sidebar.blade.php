@php
use Illuminate\Support\Facades\DB;

$role_permissions = DB::table('users')
    ->select('role_permissions.*')
    ->join('role_permissions', 'users.role_id', '=', 'role_permissions.id')
    ->where('users.id', auth()->user()->id)
    ->first();
@endphp

<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">
    <!-- ส่วนหัวของ Sidebar -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.html">
        <div class="sidebar-brand-icon rotate-n-15">
            <img src="/admin_assets/img/img_nav/LOGO-ESH-01.png" alt="Logo" style="width: 40px; height: 40px;">
        </div>
        <div class="sidebar-brand-text mx-3">Easy Share Hub <sup>1.0</sup></div>
    </a>

    <!-- เส้นคั่น -->
    <hr class="sidebar-divider my-0">

    @if($role_permissions->Product_Set == 2)
    {{-- แสดงตัวเลือกควบคุมทั้งหมดสำหรับ Product --}}
    @endif

    <!-- รายการเมนู Dashboard -->
    <li class="nav-item">
        <a class="nav-link" href="{{ route('dashboard') }}">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span>
        </a>
    </li>

    @if($role_permissions->Product_Set > 0)
    {{-- ส่วนของ Product --}}
    <li class="nav-item">
        <a class="nav-link" href="{{ route('products.index') }}">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Product</span>
        </a>
    </li>
    @endif


    @if($role_permissions->Profile_Set > 0)
    {{-- ส่วนของ Profile --}}
    <li class="nav-item">
        <a class="nav-link" href="/profile">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Profile</span>
        </a>
    </li>
    @endif

    @if($role_permissions->System_Users_Set > 0)
    {{-- ส่วนของ System Users --}}
    <li class="nav-item">
        <a class="nav-link" href="/role">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>System Users</span>
        </a>
    </li>
    @endif

    @if($role_permissions->Permissions_Set > 0)
    {{-- ส่วนของ Permissions --}}
    <li class="nav-item">
        <a class="nav-link" href="/home">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Permission</span>
        </a>
    </li>
    @endif

    <!-- เส้นคั่น -->
    <hr class="sidebar-divider d-none d-md-block">

    <!-- ปุ่มย่อ/ขยาย Sidebar -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>
</ul>