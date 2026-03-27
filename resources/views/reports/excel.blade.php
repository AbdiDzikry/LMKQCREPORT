<table style="border-collapse: collapse;">
    <!-- Top Header -->
    <tr>
        <td colspan="3" rowspan="5"
            style="border: 2px solid black; text-align: center; vertical-align: middle; font-weight: bold; font-size: 14pt;">
            PT. DHARMA POLIMETAL Tbk<br><span style="font-size: 8pt;">DHARMA Group</span></td>
        <td colspan="11" rowspan="5"
            style="border: 2px solid black; text-align: center; vertical-align: middle; font-weight: bold; font-size: 24pt;">
            LAPORAN MASALAH KUALITAS<br>(Internal Problem Report QC)</td>
        <td colspan="4" style="border: 1px solid black; text-align: center; font-weight: bold; font-size: 8pt;">Dibuat
        </td>
        <td colspan="4" style="border: 1px solid black; text-align: center; font-weight: bold; font-size: 8pt;">
            Disetujui</td>
    </tr>
    <tr>
        <td colspan="2" style="border: 1px solid black; text-align: center; font-size: 8pt;">PIC QC</td>
        <td colspan="2" style="border: 1px solid black; text-align: center; font-size: 8pt;">Sect Head QC</td>
        <td colspan="2" style="border: 1px solid black; text-align: center; font-size: 8pt;">PIC IQC</td>
        <td colspan="2" style="border: 1px solid black; text-align: center; font-size: 8pt;">PIC Procurement</td>
    </tr>
    <tr>
        <td colspan="2" rowspan="3"
            style="border: 1px solid black; text-align: center; vertical-align: bottom; height: 50px;">
            {{ $report->pic_qc }}</td>
        <td colspan="2" rowspan="3"
            style="border: 1px solid black; text-align: center; vertical-align: middle; font-weight: bold; color: green;">
            {{ $report->status === 'accepted' ? 'VERIFIED' : '' }}</td>
        <td colspan="2" rowspan="3" style="border: 1px solid black;"></td>
        <td colspan="2" rowspan="3" style="border: 1px solid black;"></td>
    </tr>
    <tr></tr>
    <tr></tr>

    <!-- ROW 6: Section 1 & 5 -->
    <tr>
        <td colspan="8" style="border: 1px solid black; font-weight: bold; font-size: 9pt;">1. BACKGROUND</td>
        <td colspan="14" style="border: 1px solid black; font-weight: bold; font-size: 9pt;">5. TEMPORARY ACTION</td>
    </tr>

    <!-- ROW 7+ Background Data & Temp Action -->
    <tr>
        <td colspan="3" style="border: 1px solid black; font-size: 8pt;">No. Registrasi</td>
        <td colspan="2" style="border: 1px solid black; font-size: 8pt;">LMK/{{ sprintf('%04d', $report->id) }}</td>
        <td colspan="3" style="border: 1px solid black; font-size: 8pt; background-color: #e2e8f0;">Informasi problem
            dari :</td>
        <td colspan="14" rowspan="11" style="border: 1px solid black; vertical-align: top; padding: 5px;"></td>
    </tr>
    <tr>
        <td colspan="3" style="border: 1px solid black; font-size: 8pt;">Part Comp Name</td>
        <td colspan="2" style="border: 1px solid black; font-size: 8pt;">
            {{ $report->comp_name_2w ?: $report->part_name }}</td>
        <td colspan="3" style="border: 1px solid black; font-size: 8pt;">Line Problem : {{ $report->line_problem }}</td>
    </tr>
    <tr>
        <td colspan="3" style="border: 1px solid black; font-size: 8pt;">Part Comp Number</td>
        <td colspan="2" style="border: 1px solid black; font-size: 8pt;">{{ $report->part_number }}</td>
        <td colspan="3" style="border: 1px solid black; font-size: 8pt;">Tanggal :
            {{ $report->report_date->format('d/m/Y') }}</td>
    </tr>
    <tr>
        <td colspan="3" style="border: 1px solid black; font-size: 8pt;">Type / Model</td>
        <td colspan="2" style="border: 1px solid black; font-size: 8pt;">{{ $report->type }}</td>
        <td colspan="3" style="border: 1px solid black; font-size: 8pt;">Jam : -</td>
    </tr>
    <tr>
        <td colspan="3" style="border: 1px solid black; font-size: 8pt;">Nama Part OHP</td>
        <td colspan="2" style="border: 1px solid black; font-size: 8pt;">{{ $report->part_name }}</td>
        <td colspan="3" style="border: 1px solid black; font-size: 8pt;">Customer : {{ $report->customer }}</td>
    </tr>
    <tr>
        <td colspan="3" style="border: 1px solid black; font-size: 8pt;">No. Part OHP</td>
        <td colspan="5" style="border: 1px solid black; font-size: 8pt;">{{ $report->part_number }}</td>
    </tr>
    <tr>
        <td colspan="3" style="border: 1px solid black; font-size: 8pt;">Jumlah NG</td>
        <td colspan="5" style="border: 1px solid black; font-size: 8pt;">{{ $report->quantity }}</td>
    </tr>
    <tr>
        <td colspan="3" style="border: 1px solid black; font-size: 8pt;">Problem Status</td>
        <td colspan="5"
            style="border: 1px solid black; font-size: 8pt; font-weight: bold; color: {{ $report->problem_status == 'berulang' ? 'red' : 'black' }}">
            {{ strtoupper($report->problem_status) }}</td>
    </tr>
    <tr>
        <td colspan="3" style="border: 1px solid black; font-size: 8pt;">Line Stop</td>
        <td colspan="5" style="border: 1px solid black; font-size: 8pt;">-</td>
    </tr>
    <tr>
        <td colspan="3" style="border: 1px solid black; font-size: 8pt;">Klasifikasi</td>
        <td colspan="5" style="border: 1px solid black; font-size: 8pt;">{{ $report->category }}</td>
    </tr>
    <tr>
        <td colspan="3" style="border: 1px solid black; font-size: 8pt;">Detail Problem</td>
        <td colspan="5" style="border: 1px solid black; font-size: 8pt; height: 30px; vertical-align: top;">
            {{ $report->detail }}</td>
    </tr>

    <!-- ROW 18: Section 2 & 6 -->
    <tr>
        <td colspan="8" style="border: 1px solid black; font-weight: bold; font-size: 9pt;">2. ILUSTRASI PROBLEM:</td>
        <td colspan="14" style="border: 1px solid black; font-weight: bold; font-size: 9pt;">6. OUTFLOW (WHY SEND)</td>
    </tr>

    <!-- ROW 19: Image & RCA 6 -->
    <tr>
        <td colspan="8" rowspan="10"
            style="border: 1px solid black; text-align: center; vertical-align: middle; color: #a0aec0;">Page 1</td>
        <td colspan="4" style="border: 1px solid black; text-align: center; font-weight: bold; font-size: 8pt;">PROBLEM
        </td>
        <td colspan="2" style="border: 1px solid black; text-align: center; font-weight: bold; font-size: 8pt;">Why 1
        </td>
        <td colspan="2" style="border: 1px solid black; text-align: center; font-weight: bold; font-size: 8pt;">Why 2
        </td>
        <td colspan="2" style="border: 1px solid black; text-align: center; font-weight: bold; font-size: 8pt;">Why 3
        </td>
        <td colspan="2" style="border: 1px solid black; text-align: center; font-weight: bold; font-size: 8pt;">Why 4
        </td>
        <td colspan="2" style="border: 1px solid black; text-align: center; font-weight: bold; font-size: 8pt;">Why 5
        </td>
        <td colspan="2" style="border: 1px solid black; text-align: center; font-weight: bold; font-size: 8pt;">Root
            Cause</td>
    </tr>
    <tr>
        <td colspan="4" rowspan="3" style="border: 1px solid black; vertical-align: top; font-size: 8pt;">
            {{ $report->detail }}</td>
        <td colspan="2" rowspan="3" style="border: 1px solid black;"></td>
        <td colspan="2" rowspan="3" style="border: 1px solid black;"></td>
        <td colspan="2" rowspan="3" style="border: 1px solid black;"></td>
        <td colspan="2" rowspan="3" style="border: 1px solid black;"></td>
        <td colspan="2" rowspan="3" style="border: 1px solid black;"></td>
        <td colspan="2" rowspan="3" style="border: 1px solid black;"></td>
    </tr>
    <tr></tr>
    <tr></tr>

    <!-- ROW 23: Section 7 -->
    <tr>
        <td colspan="14" style="border: 1px solid black; font-weight: bold; font-size: 9pt;">7. OCCURRENCE PREVENTION
            (WHY MADE)</td>
    </tr>
    <tr>
        <td colspan="4" style="border: 1px solid black; text-align: center; font-weight: bold; font-size: 8pt;">PROBLEM
        </td>
        <td colspan="2" style="border: 1px solid black; text-align: center; font-weight: bold; font-size: 8pt;">Why 1
        </td>
        <td colspan="2" style="border: 1px solid black; text-align: center; font-weight: bold; font-size: 8pt;">Why 2
        </td>
        <td colspan="2" style="border: 1px solid black; text-align: center; font-weight: bold; font-size: 8pt;">Why 3
        </td>
        <td colspan="2" style="border: 1px solid black; text-align: center; font-weight: bold; font-size: 8pt;">Why 4
        </td>
        <td colspan="2" style="border: 1px solid black; text-align: center; font-weight: bold; font-size: 8pt;">Why 5
        </td>
        <td colspan="2" style="border: 1px solid black; text-align: center; font-weight: bold; font-size: 8pt;">Root
            Cause</td>
    </tr>
    <tr>
        <td colspan="4" rowspan="4" style="border: 1px solid black; vertical-align: top; font-size: 8pt;">
            {{ $report->detail }}</td>
        <td colspan="2" rowspan="4" style="border: 1px solid black;"></td>
        <td colspan="2" rowspan="4" style="border: 1px solid black;"></td>
        <td colspan="2" rowspan="4" style="border: 1px solid black;"></td>
        <td colspan="2" rowspan="4" style="border: 1px solid black;"></td>
        <td colspan="2" rowspan="4" style="border: 1px solid black;"></td>
        <td colspan="2" rowspan="4" style="border: 1px solid black;"></td>
    </tr>
    <tr></tr>
    <tr></tr>
    <tr></tr>

    <!-- ROW 29: Section 3 & 8 & 9 Layout Prep -->
    <tr>
        <td colspan="8" style="border: 1px solid black; font-weight: bold; font-size: 9pt;">3. IDENTIFICATION PROBLEM
        </td>
        <td colspan="7" style="border: 1px solid black; font-weight: bold; font-size: 9pt;">8. PERBAIKAN</td>
        <td colspan="7" style="border: 1px solid black; font-weight: bold; font-size: 9pt;">9. EVALUASI PERBAIKAN</td>
    </tr>

    <!-- ROW 30: Flow Process & Areas -->
    <tr>
        <td colspan="8" rowspan="9" style="border: 1px solid black; vertical-align: top; padding: 5px;">
            <div style="font-size: 8pt; margin-bottom: 5px;">Flow Proses (Possibility Of Problem)</div>
            <div style="font-size: 24pt; letter-spacing: -2px;">&#10148; &#10148; &#10148; &#10148; &#9672;</div>
        </td>
        <td colspan="7" rowspan="19" style="border: 1px solid black; vertical-align: top;"></td>
        <td colspan="7" rowspan="19"
            style="border: 1px solid black; vertical-align: top; padding: 5px; text-align: center;">
            <div style="width: 100%; height: 100px; border: 1px solid #ccc; margin-bottom: 20px;">[Chart Area]</div>
            <hr style="border-top: 1px dotted black;"><br>
            <hr style="border-top: 1px dotted black;"><br>
            <hr style="border-top: 1px dotted black;">
        </td>
    </tr>
    <tr></tr>
    <tr></tr>
    <tr></tr>
    <tr></tr>
    <tr></tr>
    <tr></tr>
    <tr></tr>
    <tr></tr>

    <!-- ROW 39: Section 4 -->
    <tr>
        <td colspan="8" style="border: 1px solid black; font-weight: bold; font-size: 9pt;">4. FTA 4M + 1E</td>
    </tr>
    <tr>
        <td colspan="2" style="border: 1px solid black; text-align: center; font-weight: bold; font-size: 8pt;">4M + 1E
        </td>
        <td colspan="3" style="border: 1px solid black; text-align: center; font-weight: bold; font-size: 8pt;">Control
            Point</td>
        <td style="border: 1px solid black; text-align: center; font-weight: bold; font-size: 8pt;">Std</td>
        <td style="border: 1px solid black; text-align: center; font-weight: bold; font-size: 8pt;">Act</td>
        <td style="border: 1px solid black; text-align: center; font-weight: bold; font-size: 8pt;">Judg</td>
    </tr>
    <tr>
        <td colspan="2" style="border: 1px solid black; text-align: center; font-size: 8pt; font-weight: bold;">MAN</td>
        <td colspan="3" style="border: 1px solid black;"></td>
        <td style="border: 1px solid black;"></td>
        <td style="border: 1px solid black;"></td>
        <td style="border: 1px solid black;"></td>
    </tr>
    <tr>
        <td colspan="2" style="border: 1px solid black; text-align: center; font-size: 8pt; font-weight: bold;">MACHINE
        </td>
        <td colspan="3" style="border: 1px solid black;"></td>
        <td style="border: 1px solid black;"></td>
        <td style="border: 1px solid black;"></td>
        <td style="border: 1px solid black;"></td>
    </tr>
    <tr>
        <td colspan="2" style="border: 1px solid black; text-align: center; font-size: 8pt; font-weight: bold;">METHODE
        </td>
        <td colspan="3" style="border: 1px solid black;"></td>
        <td style="border: 1px solid black;"></td>
        <td style="border: 1px solid black;"></td>
        <td style="border: 1px solid black;"></td>
    </tr>
    <tr>
        <td colspan="2" style="border: 1px solid black; text-align: center; font-size: 8pt; font-weight: bold;">MATERIAL
        </td>
        <td colspan="3" style="border: 1px solid black;"></td>
        <td style="border: 1px solid black;"></td>
        <td style="border: 1px solid black;"></td>
        <td style="border: 1px solid black;"></td>
    </tr>
    <tr>
        <td colspan="2" style="border: 1px solid black; text-align: center; font-size: 8pt; font-weight: bold;">
            ENVIRONMENT</td>
        <td colspan="3" style="border: 1px solid black;"></td>
        <td style="border: 1px solid black;"></td>
        <td style="border: 1px solid black;"></td>
        <td style="border: 1px solid black;"></td>
    </tr>
    <tr>
        <td colspan="8" rowspan="3" style="border: 1px solid black; vertical-align: top; font-size: 8pt;">Note :</td>
    </tr>
    <tr></tr>
    <tr></tr>
</table>