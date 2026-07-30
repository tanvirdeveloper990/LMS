<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\ImageHelper;
use App\Http\Controllers\Controller;
use App\Models\Faq;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class FaqController extends Controller
{


    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $faqs = Faq::latest()->get();
        return view('admin.faqs.index', compact('faqs'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.faqs.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title'       => 'required|string|max:255',
            'description' => 'nullable|string',
            'image'       => 'nullable|image|max:2048',
            'status'      => 'nullable|boolean',
        ]);

        $input = $request->except(['_token', '_method', 'image']);

        if ($request->hasFile('image')) {
            $input['image'] = ImageHelper::uploadImage($request->file('image'));
        }

        $input['status'] = $request->has('status') ? 1 : 0;

        Faq::create($input);

        return redirect()->route('admin.faqs.index')->with('success', 'FAQ created successfully.');
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
        $faq = Faq::findOrFail($id);
        return view('admin.faqs.edit', compact('faq'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $faq = Faq::findOrFail($id);

        $request->validate([
            'title'       => 'required|string|max:255',
            'description' => 'nullable|string',
            'image'       => 'nullable|image|max:2048',
            'status'      => 'nullable|boolean',
        ]);

        $input = $request->except(['_token', '_method', 'image']);

        if ($request->hasFile('image')) {
            $input['image'] = ImageHelper::uploadImage($request->file('image'));

            if ($faq->image) {
                Storage::disk('public')->delete($faq->image);
            }
        }

        $input['status'] = $request->has('status') ? 1 : 0;

        $faq->update($input);

        return redirect()->route('admin.faqs.index')->with('success', 'FAQ updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $faq = Faq::findOrFail($id);

        if ($faq->image) {
            Storage::disk('public')->delete($faq->image);
        }

        $faq->delete();

        return redirect()->back()->with('success', 'FAQ deleted successfully.');
    }
}
