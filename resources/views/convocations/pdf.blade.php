<!doctype html>
<html lang="fr">

<head>
    <meta charset="utf-8">
    <title>Convocation Examen - GLS Sprachenzentrum</title>
    <style>
        :root {
            --primary-color: #1a365d;
            --secondary-color: #4a5568;
            --border-color: #e2e8f0;
            --bg-gray: #f8fafc;
            --text-main: #1e293b;
        }

        @page {
            size: A4;
            margin: 0;
        }

        body {
            background: #e5e7eb;
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
            margin: 20mm auto;
            background: #ffffff;
            padding: 25mm 20mm 32mm;
            /* ✅ reserve espace en bas pour le footer */
            box-sizing: border-box;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
            position: relative;
        }

        @media print {
            body {
                background: none;
            }

            .page {
                margin: 0;
                box-shadow: none;
            }
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

        .date-ref span {
            display: block;
            margin-bottom: 4px;
        }

        .date-ref strong {
            color: var(--text-main);
        }

        .address-section {
            display: flex;
            justify-content: space-between;
            margin-bottom: 50px;
            font-size: 14px;
        }

        .school-info {
            color: var(--secondary-color);
        }

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

        .recipient-info strong {
            font-size: 15px;
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

        .details table {
            width: 100%;
            border-collapse: collapse;
            font-size: 14px;
        }

        .details td {
            padding: 14px 18px;
            border-bottom: 1px solid var(--border-color);
        }

        .details tr:last-child td {
            border-bottom: none;
        }

        .details td:first-child {
            width: 30%;
            background: var(--bg-gray);
            font-weight: 600;
            color: var(--secondary-color);
            text-transform: uppercase;
            font-size: 12px;
        }

        .details td:last-child {
            color: var(--text-main);
            font-weight: 600;
        }

        .signature-wrapper {
            margin-top: 40px;
            display: flex;
            justify-content: flex-end;
            gap: 22px;
            align-items: flex-end;
        }

        .signature {
            text-align: center;
            width: 250px;
        }

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

        /* ✅ Footer fixé en bas (toujours visible sur la page) */
        .footer {
            position: absolute;
            left: 20mm;
            right: 20mm;
            bottom: 12mm;
            font-size: 11px;
            color: #94a3b8;
            text-align: center;
            border-top: 1px solid var(--border-color);
            padding-top: 10px;
            font-style: italic;
            line-height: 1.35;
        }

        /* ✅ Un peu d’air entre les 2 lignes */
        .footer .line {
            display: block;
            margin-top: 3px;
        }
    </style>
</head>

<body>

    <div class="page">

        <div class="header">
            <div class="logo">
                <img src="{{ public_path('assets/logo/gls-noir.png') }}" alt="GLS Logo">
            </div>

            <div class="date-ref">
                <span>Date : <strong>16-17 février 2026</strong></span>
                <span>
                    Classe :
                    <strong>
                        {{ is_array($student) ? $student['class_name'] ?? '-' : $student->class_name ?? '-' }}
                    </strong>
                </span>
            </div>

        </div>

        <div class="address-section">
            <div class="school-info">
                <strong>GLS Sprachenzentrum</strong>
                Centre Marrakech<br>
                3ème étage Bureau 28, Immeuble Espace,<br>
                Av. Yacoub El Mansour, Marrakesh 40000<br>
                Maroc
            </div>

            <div class="recipient-info">
                À l’attention de :<br>
                <strong>
                    {{ is_array($student) ? $student['full_name'] ?? '-' : $student->full_name ?? '-' }}
                </strong><br>

                Identifiant étudiant :
                <strong>
                    {{ is_array($student) ? $student['student_code'] ?? '-' : $student->student_code ?? '-' }}
                </strong>
            </div>

        </div>

        <div class="letter-content">
            <p>Madame, Monsieur,</p>

            <p>
                Par la présente, nous vous informons que vous êtes officiellement convoqué(e) pour vous présenter à
                l’examen suivant organisé par <strong>GLS Sprachenzentrum</strong>.
                Veuillez prendre connaissance des informations ci-dessous et respecter strictement les consignes.
            </p>
        </div>

        <div class="details-container">
            <div class="details">
                <table>
                    <tr>
                        <td>Niveau</td>
                        <td>A2</td>
                    </tr>

                    <!-- ✅ NOUVELLE LIGNE : student_code -->
                    <tr>
                        <td>Classe Et Numero Table</td>
                        <td>
                            Classe
                            {{ is_array($student) ? $student['class_name'] ?? '-' : $student->class_name ?? '-' }}
                            —
                            {{ is_array($student) ? $student['student_code'] ?? '-' : $student->student_code ?? '-' }}

                        </td>
                    </tr>

                    <tr>
                        <td>Date(s) de l’examen</td>
                        <td>16 - 17 février 2026</td>
                    </tr>
                    <tr>
                        <td>Heure</td>
                        <td>18h00 - 21h30</td>
                    </tr>
                </table>
            </div>
        </div>

        <p style="margin-top:25px; font-size:15px;">
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
            <span>Document officiel – GLS Sprachenzentrum – Centre Marrakech</span>
            <span class="line">Ce document est valable sans modification.</span>
        </div>

    </div>

</body>

</html>
