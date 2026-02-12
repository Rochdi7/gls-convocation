{{-- resources/views/convocations/index.blade.php --}}
<!doctype html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <title>Convocations A2 - GLS</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <style>
        body{font-family:Segoe UI,Roboto,Arial,sans-serif;background:#f3f4f6;margin:0;padding:24px;color:#111827}
        .wrap{max-width:1100px;margin:0 auto}
        .card{background:#fff;border-radius:14px;padding:18px;box-shadow:0 10px 25px rgba(0,0,0,.06);margin-bottom:16px}
        .top{display:flex;align-items:flex-start;justify-content:space-between;gap:12px;flex-wrap:wrap}
        h1{font-size:18px;margin:0}
        p{margin:8px 0 0;color:#6b7280;font-size:13px}
        .msg{padding:10px 12px;border-radius:12px;background:#ecfeff;border:1px solid #cffafe;color:#155e75;margin-bottom:12px}
        .err{padding:10px 12px;border-radius:12px;background:#fef2f2;border:1px solid #fecaca;color:#991b1b;margin-bottom:12px}
        textarea{width:100%;min-height:200px;border:1px solid #e5e7eb;border-radius:12px;padding:12px;font-family:ui-monospace,SFMono-Regular,Menlo,Monaco,Consolas,"Liberation Mono","Courier New",monospace;font-size:12px;box-sizing:border-box}
        .row{display:flex;gap:10px;align-items:center;justify-content:space-between;flex-wrap:wrap;margin-top:12px}
        .btn{display:inline-block;padding:10px 14px;border-radius:12px;border:0;background:#111827;color:#fff;cursor:pointer;font-weight:600}
        .btn2{display:inline-block;padding:10px 14px;border-radius:12px;border:1px solid #e5e7eb;background:#fff;color:#111827;text-decoration:none;font-weight:600}
        .btn:disabled{opacity:.6;cursor:not-allowed}
        table{width:100%;border-collapse:collapse}
        th,td{padding:10px 12px;border-bottom:1px solid #eee;text-align:left;font-size:14px;vertical-align:top}
        th{background:#f8fafc;font-weight:700}
        .muted{color:#6b7280;font-size:12px}
        .badge{display:inline-block;padding:3px 8px;border-radius:999px;background:#f1f5f9;border:1px solid #e2e8f0;font-size:12px;color:#0f172a}
        .actions a{display:inline-block;padding:8px 10px;border-radius:10px;border:1px solid #e5e7eb;text-decoration:none;color:#111827;font-size:13px;margin-right:6px}
        .actions a:hover{background:#f9fafb}
        .footer-row{display:flex;align-items:center;justify-content:space-between;gap:12px;flex-wrap:wrap;margin-top:12px}
        .hint{font-size:12px;color:#6b7280;line-height:1.5}
        code{background:#f8fafc;border:1px solid #e5e7eb;border-radius:8px;padding:2px 6px}
    </style>
</head>
<body>
<div class="wrap">

    <div class="card">
        <div class="top">
            <div>
                <h1>Convocations Examen (A2) — Import JSON → Liste → PDF/ZIP</h1>
                <p>Colle ton JSON (137 étudiants) puis clique <strong>Importer</strong>. Ensuite export PDF individuel ou ZIP.</p>
            </div>
            <div class="row" style="margin-top:0">
                <a class="btn2" href="{{ route('convocations.zip') }}">Exporter tout (ZIP)</a>
            </div>
        </div>

        @if (session('success'))
            <div class="msg">{{ session('success') }}</div>
        @endif

        @if ($errors->any())
            <div class="err">
                @foreach ($errors->all() as $e)
                    <div>{{ $e }}</div>
                @endforeach
            </div>
        @endif

        <form method="POST" action="{{ route('convocations.importJson') }}">
            @csrf
            <label class="muted">JSON à importer</label>
            <textarea name="payload" placeholder='Ex: [{"full_name":"Sara Benali","student_code":"GLS-MA-2026-0001","class_name":"Salle 1"}]'>{{ old('payload') }}</textarea>

            <div class="row">
                <button class="btn" type="submit">Importer JSON</button>
                <div class="hint">
                    Champs attendus : <code>full_name</code>, <code>student_code</code>, <code>class_name</code> (optionnel).<br>
                    Champs optionnels : <code>level</code>, <code>center_name</code>, <code>reference</code>, <code>letter_date</code>, <code>exam_dates</code>, <code>exam_time</code>, <code>address_block</code>.
                </div>
            </div>
        </form>
    </div>

    <div class="card">
        <div class="footer-row">
            <div>
                <strong>Liste des étudiants</strong>
                <div class="muted">Total (page) : {{ $students->count() }} — Total (DB) : {{ $students->total() }}</div>
            </div>
            <div class="muted">
                Niveau par défaut : <span class="badge">A2</span> — Dates : <span class="badge">16 - 17 février 2026</span> — Heure : <span class="badge">18h00 - 21h30</span>
            </div>
        </div>

        <div style="overflow:auto;margin-top:12px;border:1px solid #eee;border-radius:12px">
            <table>
                <thead>
                    <tr>
                        <th style="min-width:260px">Nom</th>
                        <th style="min-width:170px">Code</th>
                        <th style="min-width:140px">Niveau</th>
                        <th style="min-width:160px">Classe</th>
                        <th style="min-width:210px">Centre</th>
                        <th style="min-width:170px">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($students as $s)
                        <tr>
                            <td>{{ $s->full_name }}</td>
                            <td><span class="badge">{{ $s->student_code }}</span></td>
                            <td>{{ $s->level }}</td>
                            <td>{{ $s->class_name ?? '-' }}</td>
                            <td>{{ $s->center_name }}</td>
                            <td class="actions">
                                <a href="{{ route('convocations.pdf', $s) }}">PDF</a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="muted" style="padding:16px">
                                Aucun étudiant pour le moment. Colle un JSON puis clique “Importer JSON”.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div style="margin-top:12px">
            {{ $students->links() }}
        </div>
    </div>

</div>
</body>
</html>
