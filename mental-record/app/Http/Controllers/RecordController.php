<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Record;
use App\Models\RecordImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;


class RecordController extends Controller
{
    public function store(Client $client, Request $request)
    {
        $validated = $request->validate([
            'counseling_date' => ['required', 'date'],
            'counseling_data' => ['nullable', 'string'],
            'disease_ids' => ['nullable', 'array'],
            'disease_ids.*' => ['exists:diseases,id'],
            'symptom_ids' => ['nullable', 'array'],
            'symptom_ids.*' => ['exists:symptoms,id'],
            'medicine_ids' => ['nullable', 'array'],
            'medicine_ids.*' => ['exists:medicines,id'],
            'images' => ['nullable', 'array'],
            'images.*' => ['file', 'mimes:jpg,jpeg,png,webp', 'max:5120'],
        ]);

        $record = DB::transaction(function () use ($client, $request, $validated) {
            $record = Record::where('client_id', $client->id)
                ->whereDate('counseling_date', $validated['counseling_date'])
                ->first();

            if ($record) {
                $record->update([
                    'counseling_data' => $validated['counseling_data'] ?? null,
                ]);
            } else {
                $record = Record::create([
                    'client_id' => $client->id,
                    'counseling_date' => $validated['counseling_date'],
                    'counseling_data' => $validated['counseling_data'] ?? null,
                ]);
            }

            $record->diseases()->sync($validated['disease_ids'] ?? []);
            $record->symptoms()->sync($validated['symptom_ids'] ?? []);
            $record->medicines()->sync($validated['medicine_ids'] ?? []);

            if ($request->hasFile('images')) {
                foreach ($request->file('images') as $image) {
                    if ($image->isValid()) {
                        $path = $image->store('records/' . $record->id, 'public');

                        RecordImage::create([
                            'record_id' => $record->id,
                            'image_path' => $path,
                        ]);
                    }
                }
            }

            return $record;
        });

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'record_id' => $record->id,
                'redirect_url' => route('clients.show', [
                    'client' => $client->id,
                    'record_id' => $record->id,
                ]),
            ]);
        }

        return redirect()
            ->route('clients.show', [
                'client' => $client->id,
                'record_id' => $record->id,
            ])
            ->with('success', 'カルテを保存しました。');
    }

    public function destroy(Client $client, Record $record)
    {
        abort_unless($record->client_id === $client->id, 404);

        DB::transaction(function () use ($record) {
            foreach ($record->images as $image) {
                Storage::disk('public')->delete($image->image_path);
            }

            $record->diseases()->detach();
            $record->symptoms()->detach();
            $record->medicines()->detach();
            $record->images()->delete();
            $record->delete();
        });

        $nextRecord = Record::where('client_id', $client->id)
            ->orderBy('counseling_date', 'desc')
            ->orderBy('id', 'desc')
            ->first();

        if ($nextRecord) {
            return redirect()
                ->route('clients.show', [
                    'client' => $client->id,
                    'record_id' => $nextRecord->id,
                ])
                ->with('success', 'カルテを削除しました。');
        }

        return redirect()
            ->route('clients.show', ['client' => $client->id])
            ->with('success', 'カルテを削除しました。');
    }

    public function destroyImage(Client $client, Record $record, RecordImage $image)
    {
        abort_unless($record->client_id === $client->id, 404);
        abort_unless($image->record_id === $record->id, 404);

        Storage::disk('public')->delete($image->image_path);
        $image->delete();

        return redirect()
            ->route('clients.show', [
                'client' => $client->id,
                'record_id' => $record->id,
            ])
            ->with('success', '画像を削除しました。');
    }
}