<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class ChatbotLogController extends Controller
{
    public function index(Request $request): View
    {
        $origen = $request->query('origen');

        $consultas = DB::table('chatbot_consultas')
            ->when($origen, fn ($q) => $q->where('origen', $origen))
            ->orderByDesc('id')
            ->paginate(30)
            ->withQueryString();

        $desde = now()->subDays(30);

        return view('intranet.chatbot.log', [
            'consultas' => $consultas,
            'origen' => $origen,
            'resumen' => [
                'total' => DB::table('chatbot_consultas')->count(),
                'ultimos30' => DB::table('chatbot_consultas')->where('created_at', '>=', $desde)->count(),
                'sin_fuentes' => DB::table('chatbot_consultas')->where('estado', 'not_found')->count(),
                'aclaraciones' => DB::table('chatbot_consultas')->where('estado', 'clarification')->count(),
                'errores' => DB::table('chatbot_consultas')->where('origen', 'like', 'respaldo_%')->count(),
                'tokens' => DB::table('chatbot_consultas')->where('created_at', '>=', $desde)
                    ->sum(DB::raw('COALESCE(tokens_entrada,0) + COALESCE(tokens_salida,0)')),
                'ms_medio' => (int) DB::table('chatbot_consultas')->where('origen', 'modelo')->avg('ms'),
            ],
        ]);
    }
}
