<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\ImageHelper;
use App\Http\Controllers\Controller;
use App\Models\About;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AboutController extends Controller
{

    public function __construct()
    {
        $this->middleware('permission:view about')->only('index');
        $this->middleware('permission:create about')->only(['create', 'store']);
        $this->middleware('permission:edit about')->only(['edit', 'update']);
        $this->middleware('permission:delete about')->only('destroy');
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data  = About::first();
        $about = $data;
        return view('admin.about.index', compact('data', 'about'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $data = About::findOrFail($id);

        // ── Image uploads ──────────────────────────────────────────
        $card1_image = $request->hasFile('card1_image') ? ImageHelper::uploadImage($request->file('card1_image')) : null;
        $card2_image = $request->hasFile('card2_image') ? ImageHelper::uploadImage($request->file('card2_image')) : null;
        $card3_image = $request->hasFile('card3_image') ? ImageHelper::uploadImage($request->file('card3_image')) : null;
        $card4_image = $request->hasFile('card4_image') ? ImageHelper::uploadImage($request->file('card4_image')) : null;
        $image       = $request->hasFile('image')       ? ImageHelper::uploadImage($request->file('image'))       : null;
        $badge_image = $request->hasFile('badge_image') ? ImageHelper::uploadImage($request->file('badge_image')) : null;

        // ── Delete old images if new ones uploaded ─────────────────
        if ($request->hasFile('card1_image') && $data->card1_image) {
            Storage::disk('public')->delete($data->card1_image);
        }
        if ($request->hasFile('card2_image') && $data->card2_image) {
            Storage::disk('public')->delete($data->card2_image);
        }
        if ($request->hasFile('card3_image') && $data->card3_image) {
            Storage::disk('public')->delete($data->card3_image);
        }
        if ($request->hasFile('card4_image') && $data->card4_image) {
            Storage::disk('public')->delete($data->card4_image);
        }
        if ($request->hasFile('image') && $data->image) {
            Storage::disk('public')->delete($data->image);
        }
        if ($request->hasFile('badge_image') && $data->badge_image) {
            Storage::disk('public')->delete($data->badge_image);
        }

        // ── Build update array ─────────────────────────────────────
        $input = $request->except([
            '_token', '_method',
            'card1_image', 'card2_image', 'card3_image', 'card4_image',
            'image', 'badge_image',
        ]);

        if ($card1_image) $input['card1_image'] = $card1_image;
        if ($card2_image) $input['card2_image'] = $card2_image;
        if ($card3_image) $input['card3_image'] = $card3_image;
        if ($card4_image) $input['card4_image'] = $card4_image;
        if ($image)       $input['image']       = $image;
        if ($badge_image) $input['badge_image'] = $badge_image;

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
