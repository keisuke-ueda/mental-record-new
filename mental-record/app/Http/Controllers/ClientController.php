<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Disease;
use App\Models\Medicine;
use App\Models\Record;
use App\Models\Symptom;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $clients = Client::latest()->paginate(5);
        return view('clients.index', compact('clients'));
    }


    /**
     * クライエント登録画面
     */
    public function create()
    {
        $sexOptions = [
            'male' => 'male',
            'female' => 'female',
            'lgbtq' => 'LGBTQ',
            'other' => 'other',
        ];
        return view('clients.create', compact('sexOptions'));
    }


    /**
     * クライエント登録処理
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:50'],
            'nickname' => ['required', 'string', 'max:50'],
            'age' => ['required', 'string', 'max:10'],
            'sex' => ['required', 'string', 'max:50'],
            'occupation' => ['nullable', 'string', 'max:40'],
        ]);

        $client = Client::create($validated);

        return redirect()
            ->route('clients.show', $client->id)
            ->with('success', 'クライエントを登録しました。');
    }


    /**
     * クライエント詳細
     */
    public function show(Request $request, $id)
    {
        $client = Client::findOrFail($id);

        // 簡易パスワード通過チェック
        if (session('allowed_chart_client_id') != $client->id) {
            return redirect()->route('clients.index')
                ->with('chart_error', 'カルテを見るにはパスワード入力が必要です。');
        }

        // 表示処理
        $records = Record::with(['diseases', 'symptoms', 'medicines', 'images'])
            ->where('client_id', $client->id)
            ->orderBy('counseling_date', 'desc')
            ->orderBy('id', 'desc')
            ->get();

        $selectedRecord = null;

        if ($request->filled('record_id')) {
            $selectedRecord = Record::with(['diseases', 'symptoms', 'medicines', 'images'])
                ->where('client_id', $client->id)
                ->findOrFail($request->record_id);
        } elseif ($records->isNotEmpty()) {
            $selectedRecord = $records->first();
        }

        $diseases = Disease::orderBy('disease')->get();
        $symptoms = Symptom::orderBy('symptom')->get();
        $medicines = Medicine::orderBy('medicine')->get();

        return view('clients.show', compact(
            'client',
            'records',
            'selectedRecord',
            'diseases',
            'symptoms',
            'medicines'
        ));
    }


    /**
     * クライエント編集画面
     */
    public function edit($id)
    {
        $client = Client::findOrFail($id);

        $sexOptions = [
            'male' => '男性',
            'female' => '女性',
            'other' => 'その他',
            'no_answer' => '回答しない',
        ];

        return view('clients.edit', compact('client', 'sexOptions'));
    }


    /**
     * クライエント更新処理
     */
    public function update(Request $request, $id)
    {
        $client = Client::findOrFail($id);

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:50'],
            'nickname' => ['required', 'string', 'max:50'],
            'age' => ['required', 'string', 'max:10'],
            'sex' => ['required', 'string', 'max:50'],
            'occupation' => ['nullable', 'string', 'max:40'],
        ]);

        $client->update($validated);

        return redirect()
            ->route('clients.show', $client->id)
            ->with('success', 'クライエント情報を更新しました。');
    }


    /**
     * クライエント削除
     */
    public function destroy($id)
    {
        $client = Client::findOrFail($id);
        $client->delete();

        return redirect()
            ->route('clients.index')
            ->with('success', 'クライエントを削除しました。');
    }


}
