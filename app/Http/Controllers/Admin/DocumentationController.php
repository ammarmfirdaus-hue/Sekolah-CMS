<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreDocumentationEventRequest;
use App\Http\Requests\Admin\UpdateDocumentationEventRequest;
use App\Models\DocumentationEvent;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\View\View;

class DocumentationController extends Controller
{
    public function index(): View
    {
        $events = DocumentationEvent::query()
            ->withCount('media')
            ->latestFirst()
            ->paginate(10);

        return view('admin.documentation.index', compact('events'));
    }

    public function create(): View
    {
        return view('admin.documentation.create');
    }

    public function store(StoreDocumentationEventRequest $request): RedirectResponse
    {
        $data = $request->validated();

        $data['slug'] = Str::slug($data['title']);

        $event = DocumentationEvent::query()->create($data);

        return redirect()
            ->route('admin.documentation-events.edit', $event)
            ->with('status', 'Dokumentasi berhasil ditambahkan. Silakan upload foto.');
    }

    public function edit(DocumentationEvent $documentationEvent): View
    {
        $documentationEvent->load(['media' => function ($query) {
            $query->orderBy('sort_order');
        }]);

        return view('admin.documentation.edit', compact('documentationEvent'));
    }

    public function update(UpdateDocumentationEventRequest $request, DocumentationEvent $documentationEvent): RedirectResponse
    {
        $data = $request->validated();

        $documentationEvent->update($data);

        return redirect()
            ->route('admin.documentation-events.index')
            ->with('status', 'Dokumentasi berhasil diperbarui.');
    }

    public function destroy(DocumentationEvent $documentationEvent): RedirectResponse
    {
        $mediaPaths = $documentationEvent->media()->pluck('path')->filter();

        $documentationEvent->delete();

        foreach ($mediaPaths as $path) {
            if (Storage::disk('public')->exists($path)) {
                Storage::disk('public')->delete($path);
            }
        }

        return redirect()
            ->route('admin.documentation-events.index')
            ->with('status', 'Dokumentasi berhasil dihapus.');
    }
}
