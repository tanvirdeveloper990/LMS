<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class CustomerController extends Controller
{
    
    
    public function index(Request $request)
    {
        $now = \Carbon\Carbon::now();
    
        $customers = User::when($request->search, function ($q) use ($request) {
                $q->where(function ($q2) use ($request) {
                    $q2->where('name',  'like', '%'.$request->search.'%')
                       ->orWhere('email', 'like', '%'.$request->search.'%')
                       ->orWhere('phone', 'like', '%'.$request->search.'%');
                });
            })
            ->when($request->range === 'this_month', function ($q) use ($now) {
                $q->whereMonth('created_at', $now->month)->whereYear('created_at', $now->year);
            })
            ->when($request->range === 'this_year', function ($q) use ($now) {
                $q->whereYear('created_at', $now->year);
            })
            ->when($request->range === 'custom' && $request->date_from, function ($q) use ($request) {
                $q->whereDate('created_at', '>=', $request->date_from);
            })
            ->when($request->range === 'custom' && $request->date_to, function ($q) use ($request) {
                $q->whereDate('created_at', '<=', $request->date_to);
            })
            ->latest()
            ->paginate(20);
    
        return view('admin.customers.index', compact('customers'));
    }

    public function create()
    {
        return view('admin.customers.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'    => 'required|string|max:255',
            'email'   => 'nullable|email|unique:users,email',
            'phone'   => 'required|string|max:20|unique:users,phone',
            'address' => 'nullable|string|max:500',
            'image'   => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('customers', 'public');
        }

        User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'phone'    => $request->phone,
            'address'  => $request->address,
            'image'    => $imagePath,
            'password' => Hash::make('password123'),
            'status'   => 1,
        ]);

        return redirect()->route('admin.customers.index')
                         ->with('success', 'Customer created successfully!');
    }

    public function show($id)
    {
        $customer = User::with('orders')->findOrFail($id);
        return view('admin.customers.show', compact('customer'));
    }

    public function edit($id)
    {
        $customer = User::findOrFail($id);
        return view('admin.customers.edit', compact('customer'));
    }

    public function update(Request $request, $id)
    {
        $customer = User::findOrFail($id);

        $request->validate([
            'name'    => 'required|string|max:255',
            'email'   => 'nullable|email|unique:users,email,'.$customer->id,
            'phone'   => 'required|string|max:20|unique:users,phone,'.$customer->id,
            'address' => 'nullable|string|max:500',
            'image'   => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $imagePath = $customer->image;
        if ($request->hasFile('image')) {
            if ($customer->image) {
                Storage::disk('public')->delete($customer->image);
            }
            $imagePath = $request->file('image')->store('customers', 'public');
        }

        $customer->update([
            'name'    => $request->name,
            'email'   => $request->email,
            'phone'   => $request->phone,
            'address' => $request->address,
            'image'   => $imagePath,
        ]);

        return redirect()->route('admin.customers.index')
                         ->with('success', 'Customer updated successfully!');
    }

    public function destroy($id)
    {
        $customer = User::findOrFail($id);

        if ($customer->image) {
            Storage::disk('public')->delete($customer->image);
        }

        $customer->delete();

        return redirect()->route('admin.customers.index')
                         ->with('success', 'Customer deleted successfully!');
    }
}