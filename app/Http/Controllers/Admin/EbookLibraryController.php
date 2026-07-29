<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\ImageHelper;
use App\Http\Controllers\Controller;
use App\Models\EbookLibrary;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class EbookLibraryController extends Controller
{

    public function __construct()
    {
        $this->middleware('permission:view ebook library')->only('index');
        $this->middleware('permission:create ebook library')->only(['create', 'store']);
        $this->middleware('permission:edit ebook library')->only(['edit', 'update']);
        $this->middleware('permission:delete ebook library')->only('destroy');
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data         = EbookLibrary::first();
        $ebookLibrary = $data;
        return view('admin.ebook-library.index', compact('data', 'ebookLibrary'));
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
        $data = EbookLibrary::findOrFail($id);

        // ── Image uploads ──────────────────────────────────────────
        $image       = $request->hasFile('image')       ? ImageHelper::uploadImage($request->file('image'))       : null;
        $card1_image = $request->hasFile('card1_image') ? ImageHelper::uploadImage($request->file('card1_image')) : null;
        $card2_image = $request->hasFile('card2_image') ? ImageHelper::uploadImage($request->file('card2_image')) : null;
        $card3_image = $request->hasFile('card3_image') ? ImageHelper::uploadImage($request->file('card3_image')) : null;

        // ── Delete old images if new ones uploaded ─────────────────
        if ($request->hasFile('image') && $data->image) {
            Storage::disk('public')->delete($data->image);
        }
        if ($request->hasFile('card1_image') && $data->card1_image) {
            Storage::disk('public')->delete($data->card1_image);
        }
        if ($request->hasFile('card2_image') && $data->card2_image) {
            Storage::disk('public')->delete($data->card2_image);
        }
        if ($request->hasFile('card3_image') && $data->card3_image) {
            Storage::disk('public')->delete($data->card3_image);
        }

        // ── Build update array ─────────────────────────────────────
        $input = $request->except([
            '_token', '_method',
            'image', 'card1_image', 'card2_image', 'card3_image',
        ]);

        if ($image)       $input['image']       = $image;
        if ($card1_image) $input['card1_image'] = $card1_image;
        if ($card2_image) $input['card2_image'] = $card2_image;
        if ($card3_image) $input['card3_image'] = $card3_image;

        $data->update($input);

        return redirect()->back()->with('success', 'Information updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
