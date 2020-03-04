<?php

namespace App\Http\Controllers;

use App\Note;
use App\Tag;
use Illuminate\Http\Request;

class NoteController extends Controller
{
    public function store(Request $request)
    {
        $note = Note::create([
            'note_text' => $request->input('content_no_html', '')
        ]);

        $tags = explode(',', $note->tags);
        foreach ($tags as $tagString) {
            $tag = Tag::firstOrCreate(['name' => $tagString]);
            $note->tags()->attach($tag->id);
        }

        return response()->noContent();
    }

}
