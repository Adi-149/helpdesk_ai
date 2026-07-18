<?php

namespace App\Http\Controllers;

use App\Models\KnowledgeBase;
use App\Models\KnowledgeBaseLog;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class KnowledgeBaseController extends Controller
{
    /**
     * Daftar semua knowledge base dengan pencarian dan filter.
     */
    public function index(Request $request): View
    {
        $query = KnowledgeBase::query()->with(['creator', 'updater']);

        // Filter kategori
        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }

        // Filter access level
        if ($request->filled('access_level')) {
            $query->where('access_level', $request->access_level);
        }

        // Filter status
        if ($request->filled('status')) {
            $query->where('is_active', $request->status === 'active');
        }

        // Pencarian
        if ($request->filled('search')) {
            $query->search($request->search);
        }

        $knowledgeItems = $query->orderBy('updated_at', 'desc')->paginate(15)->withQueryString();

        // Statistik ringkas
        $totalKnowledge = KnowledgeBase::count();
        $activeKnowledge = KnowledgeBase::where('is_active', true)->count();

        return view('admin.knowledge-base.index', compact(
            'knowledgeItems',
            'totalKnowledge',
            'activeKnowledge'
        ));
    }

    /**
     * Form tambah knowledge baru.
     */
    public function create(): View
    {
        return view('admin.knowledge-base.create');
    }

    /**
     * Simpan knowledge baru.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'title'        => 'required|string|max:255',
            'category'     => 'required|in:' . implode(',', array_keys(KnowledgeBase::CATEGORIES)),
            'keywords'     => 'required|string|max:1000',
            'content'      => 'required|string',
            'access_level' => 'required|in:' . implode(',', array_keys(KnowledgeBase::ACCESS_LEVELS)),
            'is_active'    => 'sometimes|boolean',
        ]);

        $validated['is_active']   = $request->boolean('is_active', true);
        $validated['created_by']  = auth()->id();
        $validated['updated_by']  = auth()->id();

        $knowledge = KnowledgeBase::create($validated);

        // Catat log
        KnowledgeBaseLog::create([
            'knowledge_base_id' => $knowledge->id,
            'user_id'           => auth()->id(),
            'action'            => 'create',
            'old_data'          => null,
            'new_data'          => $knowledge->toArray(),
            'created_at'        => now(),
        ]);

        return redirect()
            ->route('admin.knowledge-base.index')
            ->with('status', 'Data knowledge berhasil ditambahkan.');
    }

    /**
     * Form edit knowledge.
     */
    public function edit(int $id): View
    {
        $knowledge = KnowledgeBase::findOrFail($id);
        return view('admin.knowledge-base.edit', compact('knowledge'));
    }

    /**
     * Update knowledge.
     */
    public function update(Request $request, int $id): RedirectResponse
    {
        $knowledge = KnowledgeBase::findOrFail($id);

        $validated = $request->validate([
            'title'        => 'required|string|max:255',
            'category'     => 'required|in:' . implode(',', array_keys(KnowledgeBase::CATEGORIES)),
            'keywords'     => 'required|string|max:1000',
            'content'      => 'required|string',
            'access_level' => 'required|in:' . implode(',', array_keys(KnowledgeBase::ACCESS_LEVELS)),
            'is_active'    => 'sometimes|boolean',
        ]);

        $oldData = $knowledge->toArray();

        $validated['is_active']  = $request->boolean('is_active', true);
        $validated['updated_by'] = auth()->id();

        $knowledge->update($validated);

        // Catat log
        KnowledgeBaseLog::create([
            'knowledge_base_id' => $knowledge->id,
            'user_id'           => auth()->id(),
            'action'            => 'update',
            'old_data'          => $oldData,
            'new_data'          => $knowledge->fresh()->toArray(),
            'created_at'        => now(),
        ]);

        return redirect()
            ->route('admin.knowledge-base.index')
            ->with('status', 'Data knowledge berhasil diperbarui.');
    }

    /**
     * Hapus knowledge.
     */
    public function destroy(int $id): RedirectResponse
    {
        $knowledge = KnowledgeBase::findOrFail($id);
        $oldData = $knowledge->toArray();

        // Catat log sebelum hapus
        KnowledgeBaseLog::create([
            'knowledge_base_id' => $knowledge->id,
            'user_id'           => auth()->id(),
            'action'            => 'delete',
            'old_data'          => $oldData,
            'new_data'          => null,
            'created_at'        => now(),
        ]);

        $knowledge->delete();

        return redirect()
            ->route('admin.knowledge-base.index')
            ->with('status', 'Data knowledge berhasil dihapus.');
    }

    /**
     * Toggle status aktif/nonaktif knowledge.
     */
    public function toggleActive(int $id): RedirectResponse
    {
        $knowledge = KnowledgeBase::findOrFail($id);
        $oldData = $knowledge->toArray();

        $knowledge->update([
            'is_active'  => !$knowledge->is_active,
            'updated_by' => auth()->id(),
        ]);

        // Catat log
        KnowledgeBaseLog::create([
            'knowledge_base_id' => $knowledge->id,
            'user_id'           => auth()->id(),
            'action'            => 'update',
            'old_data'          => $oldData,
            'new_data'          => $knowledge->fresh()->toArray(),
            'created_at'        => now(),
        ]);

        $statusText = $knowledge->is_active ? 'diaktifkan' : 'dinonaktifkan';
        return redirect()
            ->route('admin.knowledge-base.index')
            ->with('status', "Knowledge \"{$knowledge->title}\" berhasil {$statusText}.");
    }

    /**
     * Riwayat perubahan knowledge base.
     */
    public function logs(Request $request): View
    {
        $query = KnowledgeBaseLog::with(['knowledgeBase', 'user'])
            ->orderBy('created_at', 'desc');

        // Filter berdasarkan aksi
        if ($request->filled('action')) {
            $query->where('action', $request->action);
        }

        $logs = $query->paginate(20)->withQueryString();

        return view('admin.knowledge-base.logs', compact('logs'));
    }

    /**
     * Statistik penggunaan knowledge base.
     */
    public function statistics(): View
    {
        $totalKnowledge = KnowledgeBase::count();
        $activeKnowledge = KnowledgeBase::where('is_active', true)->count();
        $inactiveKnowledge = KnowledgeBase::where('is_active', false)->count();

        // Per kategori
        $categoryCounts = [];
        foreach (KnowledgeBase::CATEGORIES as $key => $label) {
            $categoryCounts[$key] = [
                'label' => $label,
                'count' => KnowledgeBase::where('category', $key)->count(),
            ];
        }

        // Per access level
        $accessCounts = [];
        foreach (KnowledgeBase::ACCESS_LEVELS as $key => $label) {
            $accessCounts[$key] = [
                'label' => $label,
                'count' => KnowledgeBase::where('access_level', $key)->count(),
            ];
        }

        // Aktivitas terbaru
        $recentLogs = KnowledgeBaseLog::with(['knowledgeBase', 'user'])
            ->orderBy('created_at', 'desc')
            ->take(10)
            ->get();

        return view('admin.knowledge-base.statistics', compact(
            'totalKnowledge',
            'activeKnowledge',
            'inactiveKnowledge',
            'categoryCounts',
            'accessCounts',
            'recentLogs'
        ));
    }
}
