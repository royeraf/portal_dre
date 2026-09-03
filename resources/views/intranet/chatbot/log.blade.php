<x-app-layout>
    <x-slot name="header">
        <h2><i class="icon ion-ios-chatboxes-outline"></i> Consultas al asistente
            <small class="mg-b-0">Qué pregunta la ciudadanía y qué responde la IA</small>
        </h2>
    </x-slot>

    <div class="row mb-3">
        @foreach([
            ['Consultas (30 días)', $resumen['ultimos30'], 'primary'],
            ['Total histórico', $resumen['total'], 'secondary'],
            ['Sin fuente encontrada', $resumen['sin_fuentes'], 'warning'],
            ['Piden aclaración', $resumen['aclaraciones'], 'secondary'],
            ['Con error', $resumen['errores'], 'danger'],
            ['Respuestas útiles', $resumen['utiles'], 'success'],
            ['Por revisar', $resumen['no_utiles'], 'danger'],
            ['Tokens (30 días)', number_format($resumen['tokens']), 'info'],
            ['Latencia media', $resumen['ms_medio'] . ' ms', 'success'],
        ] as [$titulo, $valor, $color])
            <div class="col-md-2 col-6 mb-2">
                <div class="card">
                    <div class="card-body p-2 text-center">
                        <div class="tx-11 text-muted">{{ $titulo }}</div>
                        <div class="tx-20 tx-bold text-{{ $color }}">{{ $valor }}</div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <div class="alert alert-info">
        Las consultas se guardan con datos personales comunes ocultos y se eliminan automáticamente después de
        {{ config('chatbot.retention_days') }} días. Este registro es solo para auditoría de calidad y está restringido.
        <strong>No copies ni uses su contenido para una finalidad distinta.</strong>
    </div>

    <div class="mb-3">
        <a href="{{ route('chatbot.log') }}" class="btn btn-sm {{ $origen ? 'btn-outline-secondary' : 'btn-secondary' }}">Todas</a>
        @foreach(['modelo' => 'Respondidas por la IA', 'respaldo_error_modelo' => 'Error de IA', 'respaldo_limite_diario' => 'Tope de gasto', 'respaldo_sin_api' => 'Sin API key'] as $clave => $etiqueta)
            <a href="{{ route('chatbot.log', ['origen' => $clave]) }}"
               class="btn btn-sm {{ $origen === $clave ? 'btn-secondary' : 'btn-outline-secondary' }}">{{ $etiqueta }}</a>
        @endforeach
    </div>

    <div class="table-responsive">
        <table class="table table-bordered table-hover tx-12">
            <thead>
                <tr>
                    <th style="width:140px">Fecha</th>
                    <th>Consulta y respuesta</th>
                    <th style="width:150px">Fuentes citadas</th>
                    <th style="width:90px">Valoración</th>
                    <th style="width:110px">Coste</th>
                </tr>
            </thead>
            <tbody>
                @forelse($consultas as $c)
                    <tr>
                        <td class="text-nowrap">
                            {{ \Illuminate\Support\Carbon::parse($c->created_at)->format('d/m/Y H:i') }}<br>
                            @if($c->origen === 'modelo')
                                <span class="badge badge-success">IA</span>
                            @elseif($c->origen === 'sin_fuentes')
                                <span class="badge badge-warning">Sin fuente</span>
                            @elseif($c->origen === 'error')
                                <span class="badge badge-danger" title="{{ $c->error }}">Error</span>
                            @else
                                <span class="badge badge-secondary">{{ $c->origen }}</span>
                            @endif
                        </td>
                        <td>
                            <strong>{{ $c->pregunta }}</strong>
                            <div class="text-muted mt-1" style="white-space:pre-wrap">{{ $c->respuesta }}</div>
                            @if($c->error)
                                <div class="text-danger mt-1 tx-11">{{ $c->error }}</div>
                            @endif
                        </td>
                        <td>
                            @forelse(json_decode($c->fuentes, true) ?: [] as $f)
                                <div class="tx-11">{{ $f['title'] ?? '-' }}</div>
                            @empty
                                <span class="text-muted">—</span>
                            @endforelse
                        </td>
                        <td class="text-center tx-16" title="Valoración anónima de esta respuesta">
                            @if((int) $c->feedback === 1)
                                👍
                            @elseif((int) $c->feedback === -1)
                                👎
                            @else
                                <span class="text-muted">—</span>
                            @endif
                        </td>
                        <td class="text-nowrap tx-11">
                            @if($c->tokens_entrada || $c->tokens_salida)
                                {{ number_format($c->tokens_entrada) }} ent.<br>
                                {{ number_format($c->tokens_salida) }} sal.<br>
                            @endif
                            <span class="text-muted">{{ $c->ms }} ms</span>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="5" class="text-center text-muted">Todavía no hay consultas registradas.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{ $consultas->links() }}
</x-app-layout>
