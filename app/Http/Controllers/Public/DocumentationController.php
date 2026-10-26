<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\DocumentationEvent;
use Illuminate\View\View;

class DocumentationController extends Controller
{
    public function index(): View
    {
        $events = DocumentationEvent::query()
            ->published()
            ->with(['media' => function ($query) {
                $query->orderBy('sort_order');
            }])
            ->latestFirst()
            ->get();

        $groupedEvents = $events->groupBy(function ($event) {
            return $event->event_date->format('Y');
        })->map(function ($yearEvents) {
            return $yearEvents->groupBy(function ($event) {
                return $event->event_date->format('Y-m');
            });
        });

        return view('public.documentation.index', compact('groupedEvents'));
    }
}
