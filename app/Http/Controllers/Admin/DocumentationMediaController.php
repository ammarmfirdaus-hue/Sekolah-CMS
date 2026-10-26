<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreDocumentationMediaRequest;
use App\Http\Requests\Admin\UpdateDocumentationMediaRequest;
use App\Models\DocumentationEvent;
use App\Models\DocumentationMedia;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class DocumentationMediaController extends Controller
{
    public function store(StoreDocumentationMediaRequest $request, DocumentationEvent $documentationEvent): RedirectResponse
    {
        $validated = $request->validated();
        $documentationEvent->refresh();
        $hasFeatured = $documentationEvent->media()->where('is_featured', true)->exists();
        $maxSortOrder = $documentationEvent->media()->max('sort_order') ?? 0;

        $uploadedCount = 0;

        foreach ($validated['photos'] as $index => $photo) {
            $path = $photo->store("documentation/events/{$documentationEvent->id}", 'public');

            $isFeatured = false;
            if (! $hasFeatured && $index === 0) {
                $isFeatured = true;
                $hasFeatured = true;
            }

            $documentationEvent->media()->create([
                'type' => 'photo',
                'path' => $path,
                'caption' => $validated['caption'] ?? null,
                'sort_order' => $maxSortOrder + $index + 1,
                'is_featured' => $isFeatured,
            ]);

            $uploadedCount++;
        }

        return redirect()
            ->route('admin.documentation-events.edit', $documentationEvent)
            ->with('status', "{$uploadedCount} foto berhasil diunggah.");
    }

    public function update(UpdateDocumentationMediaRequest $request, DocumentationEvent $documentationEvent, DocumentationMedia $media): RedirectResponse
    {
        if ($media->documentation_event_id !== $documentationEvent->id) {
            abort(404);
        }

        $validated = $request->validated();
        $media->update($validated);

        return redirect()
            ->route('admin.documentation-events.edit', $documentationEvent)
            ->with('status', 'Caption berhasil diperbarui.');
    }

    public function setFeatured(DocumentationEvent $documentationEvent, DocumentationMedia $media): RedirectResponse
    {
        if ($media->documentation_event_id !== $documentationEvent->id) {
            abort(404);
        }

        DB::transaction(function () use ($documentationEvent, $media) {
            $documentationEvent->media()->update(['is_featured' => false]);
            $media->update(['is_featured' => true]);
        });

        return redirect()
            ->route('admin.documentation-events.edit', $documentationEvent)
            ->with('status', 'Featured image berhasil diperbarui.');
    }

    public function destroy(DocumentationEvent $documentationEvent, DocumentationMedia $media): RedirectResponse
    {
        if ($media->documentation_event_id !== $documentationEvent->id) {
            abort(404);
        }

        $path = $media->path;
        $wasFeatured = $media->is_featured;

        $media->delete();

        if ($path && Storage::disk('public')->exists($path)) {
            Storage::disk('public')->delete($path);
        }

        if ($wasFeatured) {
            $nextMedia = $documentationEvent->media()
                ->where('type', 'photo')
                ->orderBy('sort_order')
                ->first();

            if ($nextMedia) {
                $nextMedia->update(['is_featured' => true]);
            }
        }

        return redirect()
            ->route('admin.documentation-events.edit', $documentationEvent)
            ->with('status', 'Media berhasil dihapus.');
    }
}
