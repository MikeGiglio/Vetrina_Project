<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Photo;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PhotosController extends Controller
{
    public function index()
    {
        $photos = Photo::orderBy('sort_order')->get();

        return view('admin.photos', compact('photos'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'photos'   => ['required', 'array'],
            'photos.*' => ['mimes:jpg,jpeg,png,gif,webp,avif,svg', 'max:20480'],
        ]);

        $maxOrder = Photo::max('sort_order') ?? 0;

        $titles = $request->input('titles', []);

        foreach ($request->file('photos') as $i => $file) {
            $ext      = $file->getClientOriginalExtension();
            $filename = Str::random(12) . '.' . $ext;

            $file->move(public_path('images/house'), $filename);

            $title = isset($titles[$i]) && trim($titles[$i]) !== ''
                ? trim($titles[$i])
                : pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);

            Photo::create([
                'filename'   => $filename,
                'alt'        => $title,
                'sort_order' => ++$maxOrder,
            ]);
        }

        return redirect()->back()->with('success', 'Foto caricate con successo.');
    }

    public function destroy(Photo $photo)
    {
        $filepath = public_path('images/house/' . $photo->filename);
        if (file_exists($filepath)) {
            unlink($filepath);
        }

        $photo->delete();

        return redirect()->back()->with('success', 'Foto eliminata.');
    }

    public function updateAlt(Request $request, Photo $photo)
    {
        $request->validate(['alt' => ['required', 'string', 'max:120']]);
        $photo->update(['alt' => trim($request->alt)]);
        return redirect()->back()->with('success', 'Titolo aggiornato.');
    }

    public function reorder(Request $request)
    {
        $request->validate([
            'items'            => ['required', 'array'],
            'items.*.id'       => ['required', 'integer'],
            'items.*.sort_order' => ['required', 'integer'],
        ]);

        foreach ($request->items as $item) {
            Photo::where('id', $item['id'])->update(['sort_order' => $item['sort_order']]);
        }

        return response()->json(['ok' => true]);
    }

    public function toggle(Photo $photo)
    {
        $photo->update(['is_active' => ! $photo->is_active]);

        return redirect()->back()->with('success', 'Stato foto aggiornato.');
    }
}
