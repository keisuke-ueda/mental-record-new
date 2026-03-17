<?php

namespace App\Http\Controllers;

use App\Models\Client;
use Illuminate\Http\Request;

class ClientChartPasswordController extends Controller
{
   public function store(Request $request, Client $client)
    {
        $request->validate([
            'chart_password' => ['required', 'string'],
        ]);

        $masterPassword = env('CLIENT_CHART_PASSWORD', '1234');

        if ($request->chart_password !== $masterPassword) {
            return redirect()->route('clients.index')
                ->with('modal_client_id', $client->id)
                ->withErrors([
                    'chart_password' => 'パスワードが違います。',
                ]);
        }

        session()->put('allowed_chart_client_id', $client->id);

        return redirect()->route('clients.show', $client->id);
    }
}
