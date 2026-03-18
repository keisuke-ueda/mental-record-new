<?php

namespace App\Http\Controllers;

use App\Models\Symptom;
use Illuminate\Http\Request;

class SymptomController extends Controller
{
    /**
     * 症状一覧
     */
    public function index()
    {
        $symptoms = Symptom::latest()->paginate(5);

        return view('symptoms.index', compact('symptoms'));
    }

    /**
     * 症状登録画面
     */
    public function create()
    {
        return view('symptoms.create');
    }

    /**
     * 症状登録処理
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'symptom' => ['required', 'string', 'max:255'],
            'symptom_summary' => ['nullable', 'string'],
        ]);

        Symptom::create($validated);

        return redirect()
            ->route('symptoms.index')
            ->with('success', '症状を登録しました。');
    }

    /**
     * showは今回は使わない
     */
    public function show($id)
    {
        //
    }

    /**
     * 症状編集画面
     */
    public function edit($id)
    {
        $symptom = Symptom::findOrFail($id);

        return view('symptoms.edit', compact('symptom'));
    }

    /**
     * 症状更新処理
     */
    public function update(Request $request, $id)
    {
        $symptom = Symptom::findOrFail($id);

        $validated = $request->validate([
            'symptom' => ['required', 'string', 'max:255'],
            'symptom_summary' => ['nullable', 'string'],
        ]);

        $symptom->update($validated);

        return redirect()
            ->route('symptoms.index')
            ->with('success', '症状を更新しました。');
    }

    /**
     * 症状削除
     */
    public function destroy($id)
    {
        $symptom = Symptom::findOrFail($id);
        $symptom->delete();

        return redirect()
            ->route('symptoms.index')
            ->with('success', '症状を削除しました。');
    }
}