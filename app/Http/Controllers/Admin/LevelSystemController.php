<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CommissionEarn;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class LevelSystemController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:view level')->only('index');
        $this->middleware('permission:create level')->only(['create', 'store']);
        $this->middleware('permission:edit level')->only(['edit', 'update']);
        $this->middleware('permission:delete level')->only('destroy');
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = CommissionEarn::latest()->get();
        return view('admin.level.index',compact('data'));
    }

   public function report(Request $request)
    {
        $query = CommissionEarn::with(['level', 'user', 'affiliate'])->latest();

        // Date Filter Apply
        if ($request->start_date && $request->end_date) {
            $query->whereBetween('created_at', [
                $request->start_date . ' 00:00:00',
                $request->end_date . ' 23:59:59'
            ]);
        }

        $data = $query->get();

        // Summary
        $totalAmount = $data->sum('amount');
        $totalSales  = $data->sum('total_sales');

        return view('admin.level.report', compact('data', 'totalAmount', 'totalSales'));
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
