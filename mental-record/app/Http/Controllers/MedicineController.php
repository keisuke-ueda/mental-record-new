<?php

namespace App\Http\Controllers;

use App\Models\Medicine;
use Illuminate\Http\Request;

class MedicineController extends Controller
{
    /**
     * 薬品一覧
     */
    public function index()
    {
        $medicines = Medicine::latest()->paginate(5);

        return view('medicines.index', compact('medicines'));
    }

    /**
     * 薬品登録画面
     */
    public function create()
    {
        return view('medicines.create');
    }

    /**
     * 薬品登録処理
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'medicine' => ['required', 'string', 'max:255'],
            'product_name' => ['required', 'string', 'max:100'],
            'category' => ['required', 'string', 'max:50'],
            'efficacy' => ['nullable', 'string'],
        ]);

        Medicine::create($validated);

        return redirect()
            ->route('medicines.index')
            ->with('success', '薬品を登録しました。');
    }

    /**
     * showは今回は使わない
     */
    public function show($id)
    {
        //
    }

    /**
     * 薬品編集画面
     */
    public function edit($id)
    {
        $medicine = Medicine::findOrFail($id);

        return view('medicines.edit', compact('medicine'));
    }

    /**
     * 薬品更新処理
     */
    public function update(Request $request, $id)
    {
        $medicine = Medicine::findOrFail($id);

        $validated = $request->validate([
            'medicine' => ['required', 'string', 'max:255'],
            'product_name' => ['required', 'string', 'max:100'],
            'category' => ['required', 'string', 'max:50'],
            'efficacy' => ['nullable', 'string'],
        ]);

        $medicine->update($validated);

        return redirect()
            ->route('medicines.index')
            ->with('success', '薬品を更新しました。');
    }

    /**
     * 薬品削除
     */
    public function destroy($id)
    {
        $medicine = Medicine::findOrFail($id);
        $medicine->delete();

        return redirect()
            ->route('medicines.index')
            ->with('success', '薬品を削除しました。');
    }
}