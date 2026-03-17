<?php

namespace App\Http\Controllers;

use App\Models\Disease;
use Illuminate\Http\Request;

class DiseaseController extends Controller
{
    /**
     * 病名一覧
     */
    public function index()
    {
        $diseases = Disease::latest()->paginate(10);

        return view('diseases.index', compact('diseases'));
    }

    /**
     * 病名登録画面
     */
    public function create()
    {
        return view('diseases.create');
    }

    /**
     * 病名登録処理
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'disease' => ['required', 'string', 'max:255'],
            'disease_summary' => ['nullable', 'string'],
        ]);

        Disease::create($validated);

        return redirect()
            ->route('diseases.index')
            ->with('success', '病名を登録しました。');
    }

    /**
     * showは今回は使わない
     */
    public function show($id)
    {
        //
    }

    /**
     * 病名編集画面
     */
    public function edit($id)
    {
        $disease = Disease::findOrFail($id);

        return view('diseases.edit', compact('disease'));
    }

    /**
     * 病名更新処理
     */
    public function update(Request $request, $id)
    {
        $disease = Disease::findOrFail($id);

        $validated = $request->validate([
            'disease' => ['required', 'string', 'max:255'],
            'disease_summary' => ['nullable', 'string'],
        ]);

        $disease->update($validated);

        return redirect()
            ->route('diseases.index')
            ->with('success', '病名を更新しました。');
    }

    /**
     * 病名削除
     */
    public function destroy($id)
    {
        $disease = Disease::findOrFail($id);
        $disease->delete();

        return redirect()
            ->route('diseases.index')
            ->with('success', '病名を削除しました。');
    }
}
