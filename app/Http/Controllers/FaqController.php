<?php

namespace App\Http\Controllers;

use App\Models\Faq;
use App\Models\Category;
use App\Models\Tag;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Validation\Rule;

class FaqController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->input('search');

        $faqs = Faq::query()
            ->with(['category', 'tags']) /* Eager-Loading */
            ->when($search, function ($query, $search) {
                $query->where(function ($q) use ($search) {
                    $q->where('question', 'like', "%{$search}%")
                    ->orWhere('answer', 'like', "%{$search}%")
                    ->orWhereHas('tags', function ($tagQuery) use ($search) {
                        $tagQuery->where('name', 'like', "%{$search}%");
                    });
                });
            })
            ->get();

        return Inertia::render('Admin/Faq', [
            'faqs' => $faqs,
            'tags' => Tag::all(),
            'categories' => Category::all(),
            'title' => 'FAQ Verwaltung',
            'description' => 'Willkommen im Bereich für die Verwaltung Ihrer Fragen. Hier können Sie neue Fragen für Quizzes, Tests oder FAQs erstellen, bestehende Fragen anpassen und Ihre Fragensammlungen effizient organisieren.',
            'filters' => [
                'search' => $search,
            ],
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
     * Store a newly created FAQ in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate($this->rules());

        $faq = Faq::create([
            'question'    => $validated['question'],
            'answer'      => $validated['answer'],
            'category_id' => $validated['category'],
        ]);

        // Tags zuordnen
        $faq->tags()->sync($validated['tags'] ?? []);

        return redirect()
            ->route('faqs.index')
            ->with('success', 'FAQ erfolgreich erstellt.');
    }


    /**
     * Display the specified resource.
     */
    public function show(Faq $faq)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Faq $faq)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Faq $faq)
    {
        $validated = $request->validate($this->rules($faq));

        $faq->update([
            'question'    => $validated['question'],
            'answer'      => $validated['answer'],
            'category_id' => $validated['category'],
        ]);

        // Tags anpassen (ersetzt alte durch neue)
        $faq->tags()->sync($validated['tags'] ?? []);

        return redirect()
            ->route('faqs.index')
            ->with('success', 'FAQ erfolgreich aktualisiert.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Faq $faq)
    {
        $faq->tags()->detach(); // Tags entfernen
        $faq->delete();

        return redirect()
            ->route('faqs.index')
            ->with('success', 'FAQ erfolgreich gelöscht.');
    }

    /**
     * Validation rules for FAQ.
     */
    private function rules(?Faq $faq = null): array
    {
        return [
            'question'     => [
                'required',
                'string',
                'max:255',
                Rule::unique('faqs', 'question')->ignore($faq?->id),
            ],
            'answer'       => ['required', 'string'],
            'category'     => ['required', 'exists:categories,id'],
            'tags'         => ['nullable', 'array'],
            'tags.*'       => ['integer', 'exists:tags,id'],
        ];
    }
}
