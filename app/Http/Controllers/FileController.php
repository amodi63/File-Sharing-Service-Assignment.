<?php

namespace App\Http\Controllers;

use App\Http\Requests\FileRequest;
use App\Models\File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\URL;
use Illuminate\View\View;
use ZipArchive;

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

    public function store(Request $request)
    {
        try {
            $uploadedFiles = $request->input('documents', []);

            if (empty($uploadedFiles)) {
                return back()->with('error', 'No files found');
            }
            $randomName = uniqid('zip_', true);
            $zipFileName = $randomName . '.zip';

            $result = File::createZip($uploadedFiles, $zipFileName);
         
            
        if (!$result) {
            return response()->json(['message' => 'Could not create zip file'], 500);
        }

        
        $cleanFileName = pathinfo($zipFileName, PATHINFO_BASENAME);
            $link = URL::signedRoute('files.download', ['filename' => $cleanFileName]) ;
            return response()->json([
                'link'=> $link,
                'status' => true
            ]);
        } catch (\Exception $e) {
            return back()->with('error', 'An error occurred: ' . $e->getMessage());
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function upload(Request $request)
    {
        $request->validate([
            'file' => ['required', 'file', 'max:50000']
        ]);
        $file = $request->file('file');
        return response()->json([
            'name'          => $file->store('files', 'uploads'),
            'original_name' => $file->getClientOriginalName(),
        ]);
        return response(['status' => false]);
    }


    public function getFileLink(Request $request)
    {
     //
    }
    public function downloadZip(Request $request, $filename)
    {
        $cleanFileName = pathinfo($filename, PATHINFO_BASENAME);
    
        $zipPath = public_path($filename);
    
        if (file_exists($zipPath)) {
            return response()->download($zipPath, $cleanFileName); 
        }
        abort(404);
    }
    
}
