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

        $event = DocumentationEvent::query()->create([
            'title' => $data['title'],
            'slug' => $data['slug'],
            'event_date' => $data['event_date'],
            'location' => $data['location'] ?? null,
            'description' => $data['description'] ?? null,
            'is_published' => $data['is_published'],
        ]);

        if ($request->hasFile('photos')) {
            $maxSortOrder = 0;
            $caption = $data['general_caption'] ?? null;
            foreach ($request->file('photos') as $index => $photo) {
                $path = $photo->store("documentation/events/{$event->id}", 'public');
                $event->media()->create([
                    'type' => 'photo',
                    'path' => $path,
                    'caption' => $caption,
                    'sort_order' => $maxSortOrder + $index + 1,
                    'is_featured' => false,
                ]);
            }
        }

        return redirect()
            ->route('admin.documentation-events.index')
            ->with('status', 'Dokumentasi dan foto berhasil ditambahkan.');
    }

    public function edit(DocumentationEvent $documentationEvent): View
    {
        $documentationEvent->load(['media' => function ($query) {
            $query->orderBy('sort_order')->orderBy('id');
        }]);

        return view('admin.documentation.edit', compact('documentationEvent'));
    }

    public function update(UpdateDocumentationEventRequest $request, DocumentationEvent $documentationEvent): RedirectResponse
    {
        $data = $request->validated();
        $documentationEvent->update([
            'title' => $data['title'],
            'event_date' => $data['event_date'],
            'location' => $data['location'] ?? null,
            'description' => $data['description'] ?? null,
            'is_published' => $data['is_published'],
        ]);

        // Process batch caption updates
        if (isset($data['captions']) && is_array($data['captions'])) {
            foreach ($data['captions'] as $mediaId => $captionText) {
                // Only update media that belongs to this event
                $media = $documentationEvent->media()->find($mediaId);
                if ($media) {
                    $media->update(['caption' => $captionText]);
                }
            }
        }

        // Process new additional photos
        if ($request->hasFile('new_photos')) {
            $maxSortOrder = $documentationEvent->media()->max('sort_order') ?? 0;
            $caption = $data['new_photos_caption'] ?? null;
            
            foreach ($request->file('new_photos') as $index => $photo) {
                $path = $photo->store("documentation/events/{$documentationEvent->id}", 'public');
                $documentationEvent->media()->create([
                    'type' => 'photo',
                    'path' => $path,
                    'caption' => $caption,
                    'sort_order' => $maxSortOrder + $index + 1,
                    'is_featured' => false,
                ]);
            }
        }

        return redirect()
            ->route('admin.documentation-events.edit', $documentationEvent)
            ->with('status', 'Perubahan dokumentasi berhasil disimpan.');
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
