<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\MenuPermission;
use Illuminate\Http\Request;

class PermissionController extends Controller
{
    private array $managedRoles = ['agent', 'employee'];

    private array $menus = [
        'dashboard'   => ['icon' => 'bi-speedometer2', 'label' => 'Dashboard'],
        'properties'  => ['icon' => 'bi-houses',       'label' => 'Properties'],
        'bookings'    => ['icon' => 'bi-calendar-check','label' => 'Bookings'],
        'categories'  => ['icon' => 'bi-tags',         'label' => 'Categories'],
        'testimonials'=> ['icon' => 'bi-chat-quote',   'label' => 'Testimonials'],
        'messages'    => ['icon' => 'bi-envelope',     'label' => 'Messages'],
        'settings'    => ['icon' => 'bi-gear',         'label' => 'Settings'],
        'employees'   => ['icon' => 'bi-people',       'label' => 'Employees'],
        'permissions' => ['icon' => 'bi-shield-check', 'label' => 'Permissions'],
    ];

    public function index()
    {
        $permissions = [];
        foreach ($this->managedRoles as $role) {
            $permissions[$role] = MenuPermission::where('role', $role)->pluck('menu_key')->toArray();
        }

        return view('admin.permissions.index', [
            'roles'       => $this->managedRoles,
            'menus'       => $this->menus,
            'permissions' => $permissions,
        ]);
    }

    public function update(Request $request)
    {
        $request->validate([
            'role' => ['required', 'in:' . implode(',', $this->managedRoles)],
        ]);

        $role     = $request->input('role');
        $menuKeys = $request->input('menus', []);

        // Ensure only valid menu keys are accepted
        $validKeys = array_filter($menuKeys, fn($k) => array_key_exists($k, $this->menus));

        MenuPermission::syncForRole($role, array_values($validKeys));

        return redirect()->route('admin.permissions.index')
            ->with('success', ucfirst($role) . ' permissions updated successfully.');
    }
}
