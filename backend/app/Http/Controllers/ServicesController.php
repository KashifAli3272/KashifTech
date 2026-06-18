<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;


class ServicesController extends Controller
{


    // ── List ─────────────────────────────────────────────────


    public function index(Request $request): JsonResponse
    {
        $query = Service::ordered();

        if ($request->filled('search')) {
            $q = $request->search;
            $query->where(function ($q2) use ($q) {
                $q2->where('title', 'like', "%{$q}%")
                   ->orWhere('description', 'like', "%{$q}%");
            });
        }

        $services = $query->get();

        return response()->json([
            'success'  => true,
            'services' => $services,
            'total'    => $services->count(),
            'active'   => $services->where('is_active', true)->count(),
        ]);
    }


    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'category' =>  'required|string|max:255',
            'title'       => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
            'icon'        => 'required|string|max:50',
            'icon_bg'     => ['required', 'regex:/^#([0-9a-fA-F]{3}|[0-9a-fA-F]{6})$/'],
            'icon_color'  => ['required', 'regex:/^#([0-9a-fA-F]{3}|[0-9a-fA-F]{6})$/'],
            'tags'        => 'nullable|array',
            'tags.*'      => 'string|max:50',
            'is_active'   => 'boolean',
            'sort_order'  => 'integer|min:0',
        ]);

        // Default sort_order to end of list
        if (!isset($validated['sort_order'])) {
            $validated['sort_order'] = Service::max('sort_order') + 1;
        }

        $service = Service::create($validated);

        return response()->json([
            'success' => true,
            'message' => 'Service created successfully.',
            'service' => $service,
        ], 201);
    }

    // ── Read one ─────────────────────────────────────────────

    /**
     * GET /admin/services/{service}
     */
    public function show(Service $service): JsonResponse
    {
        return response()->json([
            'success' => true,
            'service' => $service,
        ]);
    }

    // ── Update ───────────────────────────────────────────────

    /**
     * PUT /admin/services/{service}
     */
    public function update(Request $request, Service $service): JsonResponse
    {
        $validated = $request->validate([
            'category' =>  'sometimes|required|string|max:255',
             'title'       => 'sometimes|required|string|max:255',
            'description' => 'nullable|string|max:1000',
            'icon'        => 'sometimes|required|string|max:50',
            'icon_bg'     => ['sometimes', 'required', 'regex:/^#([0-9a-fA-F]{3}|[0-9a-fA-F]{6})$/'],
            'icon_colo  r'  => ['sometimes', 'required', 'regex:/^#([0-9a-fA-F]{3}|[0-9a-fA-F]{6})$/'],
            'tags'        => 'nullable|array',
            'tags.*'      => 'string|max:50',
            'is_active'   => 'boolean',
            'sort_order'  => 'integer|min:0',
        ]);

        $service->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'Service updated successfully.',
            'service' => $service->fresh(),
        ]);
    }

    // ── Toggle active ─────────────────────────────────────────

    /**
     * PATCH /admin/services/{service}/toggle
     * Flips is_active without a full update payload.
     */
    public function toggle(Service $service): JsonResponse
    {
        $service->toggleActive();

        return response()->json([
            'success'   => true,
            'message'   => $service->is_active ? 'Service is now active.' : 'Service is now hidden.',
            'is_active' => $service->is_active,
        ]);
    }

    // ── Reorder ───────────────────────────────────────────────

    /**
     * POST /admin/services/reorder
     * Body: { "ids": [3, 1, 5, 2, 4, 6] }
     * Saves sort_order based on array position.
     */
    public function reorder(Request $request): JsonResponse
    {
        $request->validate([
            'ids'   => 'required|array',
            'ids.*' => 'integer|exists:services,id',
        ]);

        foreach ($request->ids as $position => $id) {
            Service::where('id', $id)->update(['sort_order' => $position]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Services reordered successfully.',
        ]);
    }

    // ── Delete ────────────────────────────────────────────────

    /**
     * DELETE /admin/services/{service}
     */
    public function destroy(Service $service): JsonResponse
    {
        $service->delete();

        return response()->json([
            'success' => true,
            'message' => 'Service deleted successfully.',
        ]);
    }
}


