<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;

class EmployeeController extends Controller
{
    private array $allowedRoles = ['agent', 'employee'];

    public function index(Request $request)
    {
        $query = User::whereIn('role', $this->allowedRoles)->latest();

        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('email', 'like', '%' . $request->search . '%');
            });
        }
        if ($request->filled('role')) {
            $query->where('role', $request->role);
        }

        $employees = $query->paginate(15);
        return view('admin.employees.index', compact('employees'));
    }

    public function create()
    {
        return view('admin.employees.create', ['roles' => $this->allowedRoles]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name'     => ['required', 'string', 'max:100'],
            'email'    => ['required', 'email', 'max:150', 'unique:users,email'],
            'phone'    => ['nullable', 'string', 'max:20'],
            'role'     => ['required', Rule::in($this->allowedRoles)],
            'password' => ['required', Password::min(8)->mixedCase()->numbers(), 'confirmed'],
        ]);

        $data['password'] = Hash::make($data['password']);
        $data['is_active'] = true;

        User::create($data);

        return redirect()->route('admin.employees.index')
            ->with('success', 'Employee created successfully.');
    }

    public function edit(User $employee)
    {
        abort_unless(in_array($employee->role, $this->allowedRoles), 404);
        return view('admin.employees.edit', ['employee' => $employee, 'roles' => $this->allowedRoles]);
    }

    public function update(Request $request, User $employee)
    {
        abort_unless(in_array($employee->role, $this->allowedRoles), 404);

        $data = $request->validate([
            'name'  => ['required', 'string', 'max:100'],
            'email' => ['required', 'email', 'max:150', Rule::unique('users', 'email')->ignore($employee->id)],
            'phone' => ['nullable', 'string', 'max:20'],
            'role'  => ['required', Rule::in($this->allowedRoles)],
        ]);

        $employee->update($data);

        return redirect()->route('admin.employees.index')
            ->with('success', 'Employee updated successfully.');
    }

    public function toggleActive(User $employee)
    {
        abort_unless(in_array($employee->role, $this->allowedRoles), 404);

        $employee->update(['is_active' => !$employee->is_active]);

        $status = $employee->is_active ? 'activated' : 'deactivated';
        return back()->with('success', "Employee {$status} successfully.");
    }

    public function resetPassword(Request $request, User $employee)
    {
        abort_unless(in_array($employee->role, $this->allowedRoles), 404);

        $data = $request->validate([
            'password' => ['required', Password::min(8)->mixedCase()->numbers(), 'confirmed'],
        ]);

        $employee->update(['password' => Hash::make($data['password'])]);

        return back()->with('success', 'Password reset successfully.');
    }

    public function destroy(User $employee)
    {
        abort_unless(in_array($employee->role, $this->allowedRoles), 404);
        $employee->delete();
        return redirect()->route('admin.employees.index')->with('success', 'Employee deleted.');
    }
}
