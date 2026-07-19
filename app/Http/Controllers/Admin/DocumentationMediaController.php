<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DocumentationEvent;
use App\Models\DocumentationMedia;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;

class DocumentationMediaController extends Controller
{
    public function destroy(DocumentationEvent $documentationEvent, DocumentationMedia $media): RedirectResponse
    {
        if ($media->documentation_event_id !== $documentationEvent->id) {
            abort(404);
        }

        $path = $media->path;

        $media->delete();

        if ($path && Storage::disk('public')->exists($path)) {
            Storage::disk('public')->delete($path);
        }

        return redirect()
            ->route('admin.documentation-events.edit', $documentationEvent)
            ->with('status', 'Media berhasil dihapus.');
    }
}
