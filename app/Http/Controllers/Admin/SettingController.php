<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\ImageHelper;
use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SettingController extends Controller
{

    public function __construct()
    {
        $this->middleware('permission:view setting')->only('index');
        $this->middleware('permission:create setting')->only(['create', 'store']);
        $this->middleware('permission:edit setting')->only(['edit', 'update']);
        $this->middleware('permission:delete setting')->only('destroy');
    }

    /**
     * Display a listing of the resource.
     */
   public function index()
    {
        $data    = Setting::first();
        $setting = $data; // marquee section uses $setting variable
        return view('admin.settings.index', compact('data', 'setting'));
    }
 
    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $data = Setting::findOrFail($id);
 
        // ── Image uploads ──────────────────────────────────────────
        $header_logo = $request->hasFile('header_logo') ? ImageHelper::uploadImage($request->file('header_logo')) : null;
        $footer_logo = $request->hasFile('footer_logo') ? ImageHelper::uploadImage($request->file('footer_logo')) : null;
        $favicon     = $request->hasFile('favicon')     ? ImageHelper::uploadImage($request->file('favicon'))     : null;
        $meta_image  = $request->hasFile('meta_image')  ? ImageHelper::uploadImage($request->file('meta_image'))  : null;
        $mobile_logo = $request->hasFile('mobile_logo') ? ImageHelper::uploadImage($request->file('mobile_logo')) : null;
        $certificate = $request->hasFile('certificate') ? ImageHelper::uploadImage($request->file('certificate')) : null;
 
        // ── Delete old images if new ones uploaded ─────────────────
        if ($request->hasFile('header_logo') && $data->header_logo) {
            Storage::disk('public')->delete($data->header_logo);
        }
        if ($request->hasFile('footer_logo') && $data->footer_logo) {
            Storage::disk('public')->delete($data->footer_logo);
        }
        if ($request->hasFile('favicon') && $data->favicon) {
            Storage::disk('public')->delete($data->favicon);
        }
        if ($request->hasFile('meta_image') && $data->meta_image) {
            Storage::disk('public')->delete($data->meta_image);
        }
        if ($request->hasFile('mobile_logo') && $data->mobile_logo) {
            Storage::disk('public')->delete($data->mobile_logo);
        }
        if ($request->hasFile('certificate') && $data->certificate) {
            Storage::disk('public')->delete($data->certificate);
        }
 
        // ── Build update array ─────────────────────────────────────
        $input = $request->except([
            '_token', '_method',
            'header_logo', 'footer_logo', 'favicon',
            'meta_image', 'mobile_logo', 'certificate',
        ]);
 
        if ($header_logo) $input['header_logo'] = $header_logo;
        if ($footer_logo) $input['footer_logo'] = $footer_logo;
        if ($favicon)     $input['favicon']     = $favicon;
        if ($meta_image)  $input['meta_image']  = $meta_image;
        if ($mobile_logo) $input['mobile_logo'] = $mobile_logo;
        if ($certificate) $input['certificate'] = $certificate;
 
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