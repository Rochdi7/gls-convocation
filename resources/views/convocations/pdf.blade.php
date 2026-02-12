{{-- resources/views/convocations/pdf.blade.php --}}
<!doctype html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <title>Convocation - {{ $student->student_code }}</title>
    <style>
        :root {
            --primary-color: #1a365d;
            --secondary-color: #4a5568;
            --border-color: #e2e8f0;
            --bg-gray: #f8fafc;
            --text-main: #1e293b;
        }

        @page { size: A4; margin: 0; }

        body {
            margin: 0;
            padding: 0;
            font-family: 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;
            color: var(--text-main);
            line-height: 1.6;
            -webkit-print-color-adjust: exact;
        }

        .page {
            width: 210mm;
            min-height: 297mm;
            padding: 25mm 20mm;
            box-sizing: border-box;
            position: relative;
            display: flex;
            flex-direction: column;
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 40px;
            border-bottom: 2px solid var(--primary-color);
            padding-bottom: 20px;
        }

        .logo img {
            height: 75px;
            width: auto;
            display: block;
        }

        .date-ref {
            text-align: right;
            font-size: 13px;
            color: var(--secondary-color);
        }

        .date-ref span { display:block; margin-bottom:4px; }
        .date-ref strong { color: var(--text-main); }

        .address-section {
            display: flex;
            justify-content: space-between;
            margin-bottom: 50px;
            font-size: 14px;
        }

        .school-info { color: var(--secondary-color); }
        .school-info strong {
            font-size: 16px;
            color: var(--primary-color);
            display: block;
            margin-bottom: 5px;
        }

        .recipient-info {
            text-align: right;
            border-right: 3px solid var(--border-color);
            padding-right: 15px;
        }

        .recipient-info strong { font-size: 15px; }

        .subject {
            background: var(--bg-gray);
            border-left: 5px solid var(--primary-color);
            padding: 15px 20px;
            margin-bottom: 30px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .subject strong {
            font-size: 15px;
            color: var(--primary-color);
        }

        .letter-content p {
            margin-bottom: 15px;
            font-size: 15px;
            text-align: justify;
        }

        .details-container {
            margin: 25px 0;
            border: 1px solid var(--border-color);
            border-radius: 4px;
            overflow: hidden;
        }

        table { width:100%; border-collapse:collapse; font-size:14px; }
        td { padding:14px 18px; border-bottom:1px solid var(--border-color); }

        tr:last-child td { border-bottom:none; }

        td:first-child {
            width: 30%;
            background: var(--bg-gray);
            font-weight: 600;
            color: var(--secondary-color);
            text-transform: uppercase;
            font-size: 12px;
        }

        td:last-child { color: var(--text-main); font-weight: 500; }

        .instructions {
            margin-top: 30px;
            padding: 20px;
            background: #fff;
            border: 1px dashed var(--border-color);
        }

        .instructions strong {
            display: block;
            margin-bottom: 10px;
            color: var(--primary-color);
            text-decoration: underline;
        }

        .instructions ul { margin:0; padding-left:20px; }
        .instructions li { margin-bottom:8px; font-size:14px; }

        .signature-wrapper {
            margin-top: auto;
            padding-top: 40px;
            display: flex;
            justify-content: flex-end;
            gap: 22px;
            align-items: flex-end;
        }

        .signature { text-align:center; width:250px; }

        .signature-line {
            border-top: 1px solid var(--text-main);
            margin-top: 50px;
            padding-top: 10px;
            font-weight: bold;
            font-size: 14px;
            color: var(--primary-color);
        }

        .stamp-box {
            width: 190px;
            height: 120px;
            border: 2px dashed var(--border-color);
            border-radius: 10px;
        }

        .footer {
            margin-top: 40px;
            font-size: 11px;
            color: #94a3b8;
            text-align: center;
            border-top: 1px solid var(--border-color);
            padding-top: 15px;
            font-style: italic;
        }
    </style>
</head>

<body>
<div class="page">

    <div class="header">
        <div class="logo">
            {{-- IMPORTANT: mets ton logo dans public/assets/images/logo/gls.png --}}
            <img src="{{ public_path('assets/images/logo/gls.png') }}" alt="GLS Logo">
        </div>

        <div class="date-ref">
            <span>Date : <strong>{{ optional($student->letter_date)->format('d F Y') ?? now()->format('d F Y') }}</strong></span>
            <span>Référence : <strong>{{ $student->reference ?? 'GLS-EX-2026-A2' }}</strong></span>
        </div>
    </div>

    <div class="address-section">
        <div class="school-info">
            <strong>GLS Sprachenzentrum</strong>
            {{ $student->center_name ?? 'Centre Marrakech' }}<br>
            {!! $student->address_block ?? '3ème étage Bureau 28, Immeuble Espace,<br>Av. Yacoub El Mansour, Marrakesh 40000<br>Maroc' !!}
        </div>

        <div class="recipient-info">
            À l’attention de :<br>
            <strong>{{ $student->full_name }}</strong><br>
            Identifiant étudiant : <strong>{{ $student->student_code }}</strong>
        </div>
    </div>

    <div class="subject">
        <strong>Objet : Convocation à l’examen Goethe-Zertifikat {{ $student->level ?? 'A2' }}</strong>
    </div>

    <div class="letter-content">
        <p>Madame, Monsieur,</p>

        <p>
            Par la présente, nous vous informons que vous êtes officiellement convoqué(e) pour vous présenter à
            l’examen organisé par <strong>GLS Sprachenzentrum</strong>.
            Veuillez prendre connaissance des informations ci-dessous et respecter strictement les consignes.
        </p>
    </div>

    <div class="details-container">
        <table>
            <tr>
                <td>Niveau</td>
                <td>{{ $student->level ?? 'A2' }}</td>
            </tr>
            <tr>
                <td>Classe</td>
                <td>{{ $student->class_name ?? '-' }}</td>
            </tr>
            <tr>
                <td>Date(s) de l’examen</td>
                <td>{{ $student->exam_dates ?? '16 - 17 février 2026' }}</td>
            </tr>
            <tr>
                <td>Heure</td>
                <td>{{ $student->exam_time ?? '18h00 - 21h30' }}</td>
            </tr>
            <tr>
                <td>Lieu</td>
                <td>
                    GLS Sprachenzentrum – {{ $student->center_name ?? 'Centre Marrakech' }}<br>
                    {!! $student->address_block ?? '3ème étage Bureau 28, Immeuble Espace,<br>Av. Yacoub El Mansour, Marrakesh 40000<br>Maroc' !!}
                </td>
            </tr>
        </table>
    </div>

    <div class="instructions">
        <strong>Instructions importantes :</strong>
        <ul>
            <li>Se présenter 30 minutes avant l’heure prévue.</li>
            <li>Apporter une pièce d’identité valide (Carte Nationale ou Passeport).</li>
            <li>Les téléphones portables et tout appareil électronique sont strictement interdits dans la salle d’examen.</li>
            <li>Tout retard pourra entraîner un refus d’accès à l’examen.</li>
            <li>Respecter le règlement intérieur du centre.</li>
        </ul>
    </div>

    <p style="margin-top:25px; font-size: 15px;">
        Nous vous souhaitons pleine réussite pour cet examen.
    </p>

    <div class="signature-wrapper">
        <div class="signature">
            <div class="signature-line">
                Administration<br>
                GLS Sprachenzentrum
            </div>
        </div>

        <div class="stamp-box"></div>
    </div>

    <div class="footer">
        Document officiel – GLS Sprachenzentrum – {{ $student->center_name ?? 'Centre Marrakech' }}<br>
        Ce document est valable sans modification.
    </div>

</div>
</body>
</html>
