<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use App\Services\HistoryService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TagController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $list = Tag::all();
        return view('tag/list', compact('list'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('tag/create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string',
        ]);

        $tag = Tag::create([
            'name' => $request->name
        ]);

        $history = [
            'user_id' => auth()->user()->id,
            'type' => 'created',
            'source' => 'tag',
            'source_id' => $tag->id,
            'note' => $tag->name,
        ];

        HistoryService::addRecord($history);

        return redirect()->route('tag.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Tag $tag)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Tag $tag)
    {
        return view('tag/edit', compact('tag'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Tag $tag)
    {
        $request->validate([
            'name' => 'required|string',
        ]);

        $old_tag_name = $tag->name;

        $tag->name = $request->name;
        $tag->save();

        $history = [
            'user_id' => auth()->user()->id,
            'type' => 'edited',
            'source' => 'tag',
            'source_id' => $tag->id,
            'note' => "$old_tag_name -> $tag->name",
        ];

        HistoryService::addRecord($history);

        return redirect()->route('tag.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Tag $tag)
    {
        if ($tag) {
            $tag->delete();
        }
        $history = [
            'user_id' => auth()->user()->id,
            'type' => 'deleted',
            'source' => 'tag',
            'source_id' => $tag->id,
            'note' => $tag->name,
            "note_json" => true
        ];

        HistoryService::addRecord($history);

        return redirect()->route('tag.index');
    }
}
