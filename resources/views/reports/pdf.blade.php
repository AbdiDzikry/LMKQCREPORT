<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>LMK QC Report - {{ $report->part_number }}</title>
    <style>
        @page { margin: 0.3cm; }
        body { font-family: 'Arial', sans-serif; font-size: 7pt; margin: 0; padding: 0; color: #000; }
        table { width: 100%; border-collapse: collapse; table-layout: fixed; margin-bottom: -1px; }
        th, td { border: 0.5pt solid #000; padding: 2px 4px; vertical-align: middle; }
        .no-border { border: none !important; }
        .text-center { text-align: center; }
        .font-bold { font-weight: bold; }
        .bg-cyan { background-color: #ccffff; }
        .bg-gray { background-color: #f3f4f6; }
        
        .header-title { font-size: 16pt; font-weight: bold; line-height: 1.1; }
        .header-subtitle { font-size: 14pt; font-weight: bold; }
        .company-name { font-size: 8pt; font-weight: bold; line-height: 1; }
        
        .approve-stamp { 
            border: 1pt solid #000; padding: 1px 3px; font-weight: bold; font-size: 7pt; 
            display: inline-block; transform: rotate(-15deg); margin-top: 5px;
        }

        .section-title { font-weight: bold; font-size: 8pt; padding: 2px 0; }
        
        .arrow-text { font-size: 14pt; font-weight: bold; }
        .diamond-shape { width: 20px; height: 20px; border: 1pt solid #000; transform: rotate(45deg); margin: 5px auto; }

        .grid-container { width: 100%; height: 80px; border: 0.5pt solid #000; position: relative; }
        .grid-line { border-bottom: 0.1pt dotted #999; height: 8px; }
        .dotted-line { border-bottom: 0.5pt dotted #000; margin-top: 10px; height: 1px; }

        .watermark { 
            position: absolute; top: 40%; left: 30%; transform: rotate(-30deg);
            font-size: 80pt; color: rgba(220, 220, 220, 0.4); z-index: -100; font-weight: bold;
        }
        
        .avoid-break { page-break-inside: avoid; }
    </style>
</head>
<body>
    <div class="watermark">Page 1</div>

    <!-- MAIN HEADER TABLE (Combined to avoid nesting) -->
    <table>
        <tr>
            <td rowspan="3" style="width: 15%; text-align: center;">
                <img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAIAAAACACAYAAADDPmHLAAAA" style="width: 35px; height: 35px;"><br>
                <div class="company-name">PT. DHARMA POLIMETAL Tbk</div>
            </td>
            <td rowspan="3" style="width: 55%; text-align: center;">
                <div class="header-title">LAPORAN MASALAH KUALITAS</div>
                <div class="header-subtitle">(Internal Problem Report QC)</div>
            </td>
            <td colspan="2" class="text-center bg-gray font-bold" style="width: 15%;">Dibuat</td>
            <td colspan="2" class="text-center bg-gray font-bold" style="width: 15%;">Disetujui</td>
        </tr>
        <tr>
            <td class="text-center" style="font-size: 6pt;">PIC QC</td>
            <td class="text-center" style="font-size: 6pt;">Sect Head QC</td>
            <td class="text-center" style="font-size: 6pt;">PIC IQC</td>
            <td class="text-center" style="font-size: 6pt;">PIC Procurement</td>
        </tr>
        <tr style="height: 40px;">
            <td class="text-center">
                <div class="approve-stamp">APPROVE</div><br>
                <span style="font-size: 6pt;">{{ $report->pic_qc }}</span>
            </td>
            <td class="text-center">
                @if($report->status === 'accepted')
                    <div class="approve-stamp">APPROVE</div><br>
                    <span style="font-size: 6pt;">{{ $report->verifier->name ?? 'Rohman' }}</span>
                @endif
            </td>
            <td></td>
            <td></td>
        </tr>
    </table>

    <div class="section-title">1. BACKGROUND</div>
    <table>
        <tr>
            <td style="width: 15%;">No. Registrasi</td>
            <td style="width: 35%;" class="text-center">{{ 'LMK/' . sprintf('%04d', $report->id) . '/' . $report->report_date->format('m/Y') }}</td>
            <td style="width: 20%;" class="bg-cyan">Informasi problem dari :</td>
            <td style="width: 30%;" class="bg-cyan">{{ $report->section }}</td>
        </tr>
        <tr>
            <td>Part Comp Name</td>
            <td class="text-center">{{ $report->comp_name_2w ?: $report->part_name }}</td>
            <td>Line Problem</td>
            <td class="text-center">: {{ $report->line_problem }}</td>
        </tr>
        <tr>
            <td>Part Comp Number</td>
            <td class="text-center">{{ $report->part_number }}</td>
            <td>Tanggal</td>
            <td class="text-center">: {{ $report->report_date->format('d M Y') }}</td>
        </tr>
        <tr>
            <td>Type / Model</td>
            <td class="text-center">{{ $report->type }}</td>
            <td>Jam</td>
            <td class="text-center">: -</td>
        </tr>
        <tr>
            <td>Nama Part OHP</td>
            <td class="text-center">{{ $report->part_name }}</td>
            <td>Customer</td>
            <td class="text-center">: {{ $report->customer }}</td>
        </tr>
        <tr>
            <td>No. Part OHP</td>
            <td class="text-center">{{ $report->part_number }}</td>
            <td colspan="2" rowspan="5" style="vertical-align: top;">
                <div class="font-bold">Detail Problem:</div>
                <div style="font-style: italic; margin-top: 5px;">{{ strtoupper($report->detail) }}</div>
            </td>
        </tr>
        <tr>
            <td>Jumlah NG</td>
            <td class="text-center">{{ $report->quantity }} Pcs</td>
        </tr>
        <tr>
            <td>Problem Status</td>
            <td class="text-center font-bold" style="color: {{ $report->problem_status == 'berulang' ? 'red' : 'black' }}">{{ strtoupper($report->problem_status) }}</td>
        </tr>
        <tr>
            <td>Line Stop</td>
            <td class="text-center">Tidak</td>
        </tr>
        <tr>
            <td>Klasifikasi</td>
            <td class="text-center">{{ $report->category }} / {{ ucfirst($report->problem_type) }}</td>
        </tr>
    </table>

    <div style="width: 100%; margin-top: 5px;">
        <div style="width: 40%; float: left;">
            <div class="section-title">2. ILUSTRASI PROBLEM:</div>
            <div style="border: 0.5pt solid #000; height: 110px; text-align: center;">
                @if($report->illustration_image && file_exists(public_path('storage/' . $report->illustration_image)))
                    <img src="{{ public_path('storage/' . $report->illustration_image) }}" style="max-height: 100px; max-width: 90%; margin-top: 5px;">
                @else
                    <div style="margin-top: 45px; color: #999;">(No Image)</div>
                @endif
            </div>

            <div class="section-title">3. IDENTIFICATION PROBLEM</div>
            <div style="border: 0.5pt solid #000; padding: 5px;">
                <div style="font-weight: bold; margin-bottom: 5px;">Flow Proses (Possibility Of Problem)</div>
                <table class="no-border">
                    <tr>
                        <td class="text-center" style="border: 0.5pt solid #000; width: 18%; height: 30px;"></td>
                        <td class="no-border text-center" style="width: 5%;"><span class="arrow-text">&gt;</span></td>
                        <td class="text-center" style="border: 0.5pt solid #000; width: 18%;"></td>
                        <td class="no-border text-center" style="width: 5%;"><span class="arrow-text">&gt;</span></td>
                        <td class="text-center" style="border: 0.5pt solid #000; width: 18%;"></td>
                        <td class="no-border text-center" style="width: 5%;"><span class="arrow-text">&gt;</span></td>
                        <td class="text-center" style="border: 0.5pt solid #000; width: 18%;"></td>
                        <td class="no-border text-center" style="width: 5%;"><span class="arrow-text">&gt;</span></td>
                        <td class="no-border" style="width: 10%;"><div class="diamond-shape"></div></td>
                    </tr>
                </table>
            </div>

            <div class="section-title">4. FTA 4M + 1E</div>
            <table>
                <tr class="bg-gray">
                    <td class="text-center font-bold" style="width: 25%;">4M + 1E</td>
                    <td class="text-center font-bold">Control Point</td>
                    <td class="text-center font-bold" style="width: 15%;">Std</td>
                    <td class="text-center font-bold" style="width: 15%;">Act</td>
                    <td class="text-center font-bold" style="width: 12%;">Judg</td>
                </tr>
                <tr><td>MAN</td><td></td><td></td><td></td><td></td></tr>
                <tr><td>MACHINE</td><td></td><td></td><td></td><td></td></tr>
                <tr><td>METHODE</td><td></td><td></td><td></td><td></td></tr>
                <tr><td>MATERIAL</td><td></td><td></td><td></td><td></td></tr>
                <tr><td>ENVIRONMENT</td><td></td><td></td><td></td><td></td></tr>
            </table>
            <div style="border: 0.5pt solid #000; border-top: none; padding: 2px;">Note :</div>
        </div>

        <div style="width: 59%; float: right;">
            <div class="section-title">5. TEMPORARY ACTION</div>
            <div style="border: 0.5pt solid #000; height: 145px;"></div>

            <div class="section-title">6. OUTFLOW (WHY SEND)</div>
            <table>
                <tr class="bg-gray">
                    <td class="text-center font-bold" style="width: 30%;">PROBLEM</td>
                    <td class="text-center font-bold">5 WHY ANALYSIS</td>
                    <td class="text-center font-bold" style="width: 20%;">Root Couse</td>
                </tr>
                <tr>
                    <td style="height: 65px; vertical-align: top;">{{ $report->detail }}</td>
                    <td style="padding: 0; vertical-align: top;">
                        <div style="border-bottom: 0.1pt solid #ccc; padding: 1px 3px;">Why 1: </div>
                        <div style="border-bottom: 0.1pt solid #ccc; padding: 1px 3px;">Why 2: </div>
                        <div style="border-bottom: 0.1pt solid #ccc; padding: 1px 3px;">Why 3: </div>
                        <div style="border-bottom: 0.1pt solid #ccc; padding: 1px 3px;">Why 4: </div>
                        <div style="padding: 1px 3px;">Why 5: </div>
                    </td>
                    <td></td>
                </tr>
            </table>

            <div class="section-title">7. OCCURRENCE PREVENTION (WHY MADE)</div>
            <table>
                <tr class="bg-gray">
                    <td class="text-center font-bold" style="width: 30%;">PROBLEM</td>
                    <td class="text-center font-bold">5 WHY ANALYSIS</td>
                    <td class="text-center font-bold" style="width: 20%;">Root Couse</td>
                </tr>
                <tr>
                    <td style="height: 65px; vertical-align: top;">{{ $report->detail }}</td>
                    <td style="padding: 0; vertical-align: top;">
                        <div style="border-bottom: 0.1pt solid #ccc; padding: 1px 3px;">Why 1: </div>
                        <div style="border-bottom: 0.1pt solid #ccc; padding: 1px 3px;">Why 2: </div>
                        <div style="border-bottom: 0.1pt solid #ccc; padding: 1px 3px;">Why 3: </div>
                        <div style="border-bottom: 0.1pt solid #ccc; padding: 1px 3px;">Why 4: </div>
                        <div style="padding: 1px 3px;">Why 5: </div>
                    </td>
                    <td></td>
                </tr>
            </table>

            <div style="width: 100%; margin-top: 5px;">
                <div style="width: 35%; float: left;">
                    <div class="section-title">8. PERBAIKAN</div>
                    <div style="border: 0.5pt solid #000; height: 100px;"></div>
                </div>
                <div style="width: 63%; float: right;">
                    <div class="section-title">9. EVALUASI PERBAIKAN</div>
                    <div class="grid-container">
                        @for($i=0; $i<8; $i++) <div class="grid-line"></div> @endfor
                    </div>
                    <div class="dotted-line"></div>
                    <div class="dotted-line"></div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>