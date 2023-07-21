<?php

namespace App\Http\Controllers;

use App\Http\Requests\FileRequest;
use App\Models\File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class FileController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $files = File::latest()->get();
        return view('files.index', compact('files'));
    }

    public function create(): View
    {
        return view('files.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(FileRequest $request)
    {
        $file = $request->file('file');
        $data = [
            'name' => $file->getClientOriginalName(),
            'size' => $file->getSize(),
            'path' => $file->store('files', 'uploads')
        ];

        $createdFile = File::create($data);

        if ($createdFile) {
            return response([
                'message' => 'File uploaded successfully!',
                'status' => true,
            ]);
        }

        return response(['status' => false]);
    }

    public function getFileLink(File $file)
    {

        if ($file->isLinkExpired()) {

            return response()->json(['message' => 'This File Is Not Found!', 'status' => false]);
        }

        $path =  $file->path;
        $data = [
            'file_link' => $path,
            'downloadRoute' => route('files.download', $file->id),
            'status' => true
        ];
        return response()->json($data);
    }
    public function downloadFile(File $file)
    {
        if ($file->isLinkExpired()) {

            abort(404, 'This File Is Not Found!');
        }
        try {
            $file->increment('download_count');
            $relative_file_path = public_path('uploads/' . $file->path);

            return response()->download($relative_file_path, $file->name);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Failed to download the file.'], 500);
        }
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
