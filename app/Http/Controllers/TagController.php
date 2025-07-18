<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Validation\Rule;

class TagController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Inertia::render('Admin/Tag', [
            'tags' => Tag::all(),
            'title' => 'Tag Verwaltung',
            'description' => 'Hier verwalten Sie die Schlagwörter (Tags) für Ihre Inhalte. Erstellen, bearbeiten und organisieren Sie Tags, um die Auffindbarkeit und Kategorisierung Ihrer digitalen Trainings zu optimieren.'
        ]);
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
        $request->validate($this->rules());

        Tag::create($request->only('name'));

        return redirect()
            ->route('tags.index')
            ->with('success', 'Tag erfolgreich erstellt.');
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
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Tag $tag)
    {
        $request->validate($this->rules($tag));

        $tag->update($request->only('name'));

        return redirect()
            ->route('tags.index')
            ->with('success', 'Tag erfolgreich aktualisiert.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Tag $tag)
    {
        $tag->delete();

        return redirect()
            ->route('tags.index')
            ->with('success', 'Tag erfolgreich gelöscht.');
    }

    /**
     * Validation rules for Tag.
     */
    private function rules(?Tag $tag = null): array
    {
        return [
            'name' => [
                'required',
                'string',
                'max:30',
                Rule::unique('tags', 'name')->ignore($tag?->id),
            ],
        ];
    }
}
