<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Withdrawal;
use Illuminate\Http\Request;

class LevelSystemWithdrawalController extends Controller
{
     public function __construct()
    {
        $this->middleware('permission:view level-widthdrawal')->only('index');
        $this->middleware('permission:create level-widthdrawal')->only(['create', 'store']);
        $this->middleware('permission:edit level-widthdrawal')->only(['edit', 'update']);
        $this->middleware('permission:delete level-widthdrawal')->only('destroy');
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $status = $request->query('status', 'pending'); // ডিফল্ট pending

        $withdrawals = Withdrawal::where('status', $status)->get();

        return view('admin.level.withdraw.index', compact('withdrawals', 'status'));
    }

    // Update the status of the withdrawal request
    public function updateStatus(Request $request, $id)
    {
        $withdraw = Withdrawal::findOrFail($id);
        $withdraw->status = $request->status;
        $withdraw->save();

        return response()->json(['success' => true]);
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
