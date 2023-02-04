<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreImageRequest;
use App\Http\Requests\UpdateImageRequest;
use App\Models\Image;
use App\Models\Result;
use Log;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\Request;

class ImageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreImageRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreImageRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Image  $image
     * @return \Illuminate\Http\Response
     */
    public function show(Image $image)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Image  $image
     * @return \Illuminate\Http\Response
     */
    public function edit(Image $image)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateImageRequest  $request
     * @param  \App\Models\Image  $image
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateImageRequest $request, Image $image)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Image  $image
     * @return \Illuminate\Http\Response
     */
    public function destroy(Image $image)
    {
        //
    }

    public function rejectImage(Image $image)
    {
        $image->update(['status' => 'unauthorized']);
        return back();
    }

    public function acceptImage(Image $image)
    {
        $image->update(['status' => 'authorized']);
        return back();
    }


    /**
     * Chiamata quando faccio l'upload dell'immagine
     */
    public function resultImageUpload(UpdateImageRequest $request, Result $result)
    {
        // $request = Request();
        if ($request->file('file')) {
            Log::debug('result id:' . $result->id . ' image:' . $request->file('file')->getPathname());

            $uuid = Str::uuid();
            $extension = $request->file->getClientOriginalExtension();
            $imageName = $uuid . '.' . $extension;

            $image = $request->file('file');
            $image->move(public_path('images'), $imageName);

            $result->images()->create(['filename' => $imageName]);

            return response()->json(['success' => $imageName]);
        }

        return response()->json(['error' => 'No file uploaded']);
    }
}
