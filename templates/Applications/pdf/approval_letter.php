<?php
/**
 * EKAP approval letter PDF template.
 *
 * Expected variables:
 * @var \App\Model\Entity\Application $application
 * @var array $letter
 * @var mixed $approvalReview
 * @var mixed $approvalDate
 * @var string|null $uitmLogoData
 * @var string|null $ekapLogoData
 * @var string|null $signatureData
 */

$this->assign(
    'title',
    'Surat Kelulusan - ' . ($application->reference_no ?: 'EKAP')
);

$months = [
    1 => 'Januari',
    2 => 'Februari',
    3 => 'Mac',
    4 => 'April',
    5 => 'Mei',
    6 => 'Jun',
    7 => 'Julai',
    8 => 'Ogos',
    9 => 'September',
    10 => 'Oktober',
    11 => 'November',
    12 => 'Disember',
];

$formatMalayDate = static function ($value) use ($months): string {
    if ($value === null || $value === '') {
        return '-';
    }

    if (is_object($value) && method_exists($value, 'format')) {
        $day = (int)$value->format('j');
        $month = $months[(int)$value->format('n')] ?? $value->format('F');
        $year = $value->format('Y');

        return $day . ' ' . $month . ' ' . $year;
    }

    try {
        $date = new \DateTimeImmutable((string)$value);
        $day = (int)$date->format('j');
        $month = $months[(int)$date->format('n')] ?? $date->format('F');

        return $day . ' ' . $month . ' ' . $date->format('Y');
    } catch (\Throwable $exception) {
        return (string)$value;
    }
};

$formatDateTime = static function ($value) use ($formatMalayDate): string {
    if ($value === null || $value === '') {
        return '-';
    }

    if (is_object($value) && method_exists($value, 'format')) {
        return $formatMalayDate($value) . ', ' . $value->format('h:i A');
    }

    return (string)$value;
};

$money = static function ($value): string {
    return 'RM' . number_format((float)($value ?? 0), 2);
};

$studentName = $application->user->full_name ?? 'Pemohon';
$studentFaculty = $application->user->faculty ?? '';
$studentNumber = $application->user->student_no ?? '';
$clubName = $application->club->club_name ?? '-';
$programmeTitle = mb_strtoupper(
    (string)($application->program_title ?: 'PROGRAM'),
    'UTF-8'
);
$approvedAmount = $application->approved_amount
    ?? $application->requested_allocation
    ?? $application->estimated_budget
    ?? 0;
?>

<style>
    @page {
        size: A4 portrait;
        margin: 28mm 20mm 28mm 20mm;
    }

    * {
        box-sizing: border-box;
    }

    body {
        margin: 0;
        font-family:"Verdana", sans-serif;
        font-size: 10.2pt;
        line-height: 1.48;
        color: #111827;
    }

    .top-band {
        position: fixed;
        top: -28mm;
        left: -20mm;
        right: -20mm;
        height: 10mm;
        background: #173b6c;
        border-right: 70mm solid #8f2b7c;
    }

    .letterhead {
        width: 100%;
        border-collapse: collapse;
        margin-bottom: 7mm;
    }

    .letterhead td {
        vertical-align: top;
    }

    .brand-cell {
        width: 58%;
    }

    .reference-cell {
        width: 42%;
        padding-top: 2mm;
    }

    .brand-wrap {
        display: table;
        width: 100%;
    }

    .brand-logo,
    .brand-text {
        display: table-cell;
        vertical-align: middle;
    }

    .brand-logo {
        width: 34mm;
        padding-right: 4mm;
    }

    .brand-logo img {
        width: 31mm;
        max-height: 24mm;
        object-fit: contain;
    }

    .logo-fallback {
        width: 29mm;
        height: 22mm;
        border: 1.5pt solid #173b6c;
        color: #173b6c;
        font-size: 18pt;
        font-weight: bold;
        text-align: center;
        padding-top: 6mm;
    }

    .university {
        font-size: 12pt;
        font-weight: bold;
        color: #173b6c;
    }

    .faculty {
        font-size: 10pt;
        font-weight: bold;
        color: #8f2b7c;
        margin-top: 1mm;
    }

    .office {
        font-size: 8.5pt;
        color: #4b5563;
        margin-top: 1mm;
    }

    .reference-table {
        width: 100%;
        border-collapse: collapse;
        font-size: 9.4pt;
    }

    .reference-table td {
        padding: 0.4mm 0;
    }

    .reference-label {
        width: 31mm;
        color: #374151;
    }

    .recipient {
        margin-bottom: 7mm;
    }

    .recipient p {
        margin: 0;
    }

    .salutation {
        margin: 0 0 4mm;
    }

    .subject {
        margin: 0 0 4mm;
        font-size: 11pt;
        line-height: 1.35;
        font-weight: bold;
        text-align: justify;
    }

    .subject-secondary {
        display: block;
        margin-top: 2mm;
        text-align: center;
    }

    .paragraph {
        margin: 0 0 3.2mm;
        text-align: justify;
    }

    .numbered {
        display: table;
        width: 100%;
        margin-bottom: 3.2mm;
    }

    .numbered-number,
    .numbered-text {
        display: table-cell;
        vertical-align: top;
    }

    .numbered-number {
        width: 12mm;
    }

    .terms {
        margin: 1mm 0 5mm;
        padding: 0;
    }

    .term-row {
        display: table;
        width: 100%;
        margin-bottom: 2.4mm;
        page-break-inside: avoid;
    }

    .term-index,
    .term-text {
        display: table-cell;
        vertical-align: top;
    }

    .term-index {
        width: 14mm;
        padding-left: 2mm;
    }

    .signature-block {
        margin-top: 8mm;
        page-break-inside: avoid;
    }

    .signature-image {
        width: 35mm;
        max-height: 18mm;
        object-fit: contain;
        margin: 3mm 0 1mm;
    }

    .signature-space {
        height: 16mm;
    }

    .signatory-name {
        font-weight: bold;
    }

    .cc {
        margin-top: 7mm;
        font-size: 9.2pt;
    }

    .footer {
        position: fixed;
        left: 0;
        right: 0;
        bottom: -20mm;
        border-top: 0.7pt solid #9ca3af;
        padding-top: 2mm;
        font-size: 7.5pt;
        color: #4b5563;
    }

    .footer-table {
        width: 100%;
        border-collapse: collapse;
    }

    .footer-right {
        text-align: right;
    }

    .page-break {
        page-break-before: always;
    }

    .attachment-heading {
        text-align: center;
        font-size: 12pt;
        font-weight: bold;
        margin: 0 0 6mm;
    }

    .attachment-subheading {
        text-align: center;
        font-size: 10.5pt;
        font-weight: bold;
        margin: -3mm 0 7mm;
    }

    .details-table {
        width: 100%;
        border-collapse: collapse;
        margin-bottom: 7mm;
    }

    .details-table th,
    .details-table td {
        border: 0.7pt solid #4b5563;
        padding: 2.5mm;
        vertical-align: top;
    }

    .details-table th {
        width: 35%;
        background: #eef2f7;
        text-align: left;
    }

    .decision-box {
        border: 1pt solid #173b6c;
        background: #f8fafc;
        padding: 4mm;
        margin-bottom: 7mm;
        page-break-inside: avoid;
    }

    .decision-title {
        color: #173b6c;
        font-weight: bold;
        margin-bottom: 2mm;
    }

    .budget-table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 3mm;
    }

    .budget-table th,
    .budget-table td {
        border: 0.7pt solid #4b5563;
        padding: 2.5mm;
    }

    .budget-table th {
        background: #eef2f7;
        text-align: left;
    }

    .amount {
        text-align: right;
        white-space: nowrap;
    }

    .approved-stamp {
        display: inline-block;
        border: 2pt solid #166534;
        color: #166534;
        padding: 2mm 5mm;
        font-weight: bold;
        letter-spacing: 1pt;
        transform: rotate(-3deg);
        margin-top: 3mm;
    }

    .keep-together {
        page-break-inside: avoid;
    }
</style>

<div class="top-band"></div>

<div class="footer">
    <table class="footer-table">
        <tr>
            <td>
                <?= h($letter['faculty_name']) ?>,
                <?= h($letter['university_name']) ?><br>
                <?= h($letter['campus_name']) ?>,
                <?= h($letter['postal_address']) ?>
            </td>
            <td class="footer-right">
                e-KAP - Kelulusan Aktiviti Pelajar<br>
                Dokumen dijana secara elektronik
            </td>
        </tr>
    </table>
</div>

<table class="letterhead">
    <tr>
        <td class="brand-cell">
            <div class="brand-wrap">
                <div class="brand-logo">
                    <?php if (!empty($uitmLogoData)): ?>
                        <img
                            src="<?= h($uitmLogoData) ?>"
                            alt="UiTM Logo"
                            style="
                                width: 30mm;
                                max-height: 22mm;
                                object-fit: contain;
                            "
                        >
                    <?php endif; ?>

                    <?php if (!empty($ekapLogoData)): ?>
                        <img
                            src="<?= h($ekapLogoData) ?>"
                            alt="EKAP Logo"
                            style="
                                width: 25mm;
                                max-height: 18mm;
                                object-fit: contain;
                                margin-left: 4mm;
                            "
                        >
                    <?php endif; ?>

                    <?php if (
                        empty($uitmLogoData) &&
                        empty($ekapLogoData)
                    ): ?>
                        <div class="logo-fallback">e-KAP</div>
                    <?php endif; ?>
                </div>

                <div class="brand-text">
                    <div class="university">
                        <?= h($letter['university_name']) ?>
                    </div>

                    <div class="faculty">
                        <?= h($letter['faculty_name']) ?>
                    </div>

                    <div class="office">
                        <?= h($letter['office_name']) ?><br>
                        <?= h($letter['campus_name']) ?>
                    </div>
                </div>
            </div>
        </td>

        <td class="reference-cell">
            <table class="reference-table">
                <tr>
                    <td class="reference-label">Rujukan</td>
                    <td>: <?= h($letter['reference']) ?></td>
                </tr>
                <tr>
                    <td class="reference-label">Tarikh</td>
                    <td>: <?= h($formatMalayDate($approvalDate)) ?></td>
                </tr>
            </table>
        </td>
    </tr>
</table>

<div class="recipient">
    <p><?= h($studentName) ?></p>

    <?php if ($studentNumber !== ''): ?>
        <p>No. Pelajar: <?= h($studentNumber) ?></p>
    <?php endif; ?>

    <p>Wakil <?= h($clubName) ?></p>

    <?php if ($studentFaculty !== ''): ?>
        <p><?= h($studentFaculty) ?></p>
    <?php endif; ?>

    <p><?= h($letter['university_name']) ?></p>
    <p><?= h($letter['campus_name']) ?></p>
</div>

<p class="salutation">Assalamualaikum dan Salam Sejahtera,</p>
<p class="salutation">Saudara/Saudari,</p>

<div class="subject">
    KEPUTUSAN PERMOHONAN KELULUSAN DAN PERUNTUKAN KEWANGAN
    BAGI PENGANJURAN PROGRAM
    <span class="subject-secondary">
        <?= h($programmeTitle) ?>
    </span>
</div>

<p class="paragraph">
    Dengan hormatnya perkara di atas adalah dirujuk.
</p>

<div class="numbered">
    <div class="numbered-number">2.</div>
    <div class="numbered-text">
        Sukacita dimaklumkan bahawa permohonan penganjuran program
        <strong><?= h($application->program_title) ?></strong>
        yang dikemukakan melalui Sistem e-KAP telah diteliti dan
        <strong>DILULUSKAN</strong> oleh pihak Hal Ehwal Pelajar.
    </div>
</div>

<div class="numbered">
    <div class="numbered-number">3.</div>
    <div class="numbered-text">
        Program tersebut dijadualkan berlangsung pada
        <strong><?= h($formatDateTime($application->start_datetime)) ?></strong>
        hingga
        <strong><?= h($formatDateTime($application->end_datetime)) ?></strong>
        bertempat di
        <strong><?= h($application->venue ?: '-') ?></strong>.
        Peruntukan yang diluluskan adalah sebanyak
        <strong><?= h($money($approvedAmount)) ?></strong>.
        Ringkasan kelulusan adalah seperti di Lampiran A.
    </div>
</div>

<div class="numbered">
    <div class="numbered-number">4.</div>
    <div class="numbered-text">
        Kelulusan ini tertakluk kepada syarat-syarat berikut:
    </div>
</div>

<div class="terms">
    <div class="term-row">
        <div class="term-index">i.</div>
        <div class="term-text">
            Penganjuran hendaklah mematuhi peraturan universiti,
            undang-undang yang berkuat kuasa, serta nilai dan tatakelakuan
            pelajar.
        </div>
    </div>

    <div class="term-row">
        <div class="term-index">ii.</div>
        <div class="term-text">
            Sebarang pindaan terhadap tarikh, tempat, skop, tentatif,
            perbelanjaan atau kertas kerja asal hendaklah mendapatkan kelulusan
            bertulis daripada pihak Hal Ehwal Pelajar terlebih dahulu.
        </div>
    </div>

    <div class="term-row">
        <div class="term-index">iii.</div>
        <div class="term-text">
            Sebarang tajaan dalam bentuk wang atau barangan hendaklah
            diuruskan melalui saluran kewangan universiti yang telah diluluskan.
        </div>
    </div>

    <div class="term-row">
        <div class="term-index">iv.</div>
        <div class="term-text">
            Penasihat, penganjur dan pegawai pengiring bertanggungjawab
            memastikan pengurusan program, kebajikan peserta serta keselamatan
            pelajar dilaksanakan dengan sewajarnya.
        </div>
    </div>

    <div class="term-row">
        <div class="term-index">v.</div>
        <div class="term-text">
            Program di luar kampus atau program berisiko hendaklah memperoleh
            semua kebenaran tambahan, perlindungan dan dokumen keselamatan yang
            diperlukan sebelum pelaksanaan.
        </div>
    </div>

    <div class="term-row">
        <div class="term-index">vi.</div>
        <div class="term-text">
            Peruntukan yang diluluskan hanya boleh digunakan bagi tujuan dan
            komponen perbelanjaan program yang telah dipersetujui.
        </div>
    </div>

    <div class="term-row">
        <div class="term-index">vii.</div>
        <div class="term-text">
            Laporan lengkap program berserta bukti bergambar hendaklah
            dikemukakan dalam tempoh empat belas (14) hari atau dua (2) minggu selepas program
            selesai.
        </div>
    </div>

    <div class="term-row">
        <div class="term-index">viii.</div>
        <div class="term-text">
            Dokumen tuntutan atau pelarasan kewangan hendaklah dihantar dalam
            tempoh yang ditetapkan oleh pihak universiti. Kegagalan mematuhi
            syarat boleh menyebabkan kelulusan atau pembiayaan ditarik balik.
        </div>
    </div>
</div>

<p class="paragraph">
    Sekian, terima kasih.
</p>

<p class="paragraph">
    <strong>"BERKHIDMAT UNTUK NEGARA"</strong>
</p>

<div class="signature-block">
    <p>Saya yang menjalankan amanah,</p>

    <?php if (!empty($signatureData)): ?>
        <img
            class="signature-image"
            src="<?= h($signatureData) ?>"
            alt="Tandatangan"
        >
    <?php else: ?>
        <div class="signature-space"></div>
    <?php endif; ?>

    <div class="signatory-name">
        <?= h(mb_strtoupper($letter['signatory_name'], 'UTF-8')) ?>
    </div>

    <div><?= h($letter['signatory_position']) ?></div>
    <div><?= h($letter['office_name']) ?></div>
    <div>b.p. <?= h($letter['faculty_name']) ?></div>
</div>

<div class="cc">
    <strong>sk:</strong>
    <?= h($letter['carbon_copy']) ?>
</div>

<div class="page-break"></div>

<div class="attachment-heading">LAMPIRAN A</div>

<div class="attachment-subheading">
    RINGKASAN KEPUTUSAN KELULUSAN AKTIVITI PELAJAR
</div>

<div class="decision-box">
    <div class="decision-title">KEPUTUSAN: DILULUSKAN</div>

    Permohonan penganjuran
    <strong><?= h($application->program_title) ?></strong>
    oleh
    <strong><?= h($clubName) ?></strong>
    diluluskan tertakluk kepada syarat yang dinyatakan dalam surat kelulusan.

    <div class="approved-stamp">DILULUSKAN</div>
</div>

<table class="details-table">
    <tr>
        <th>Rujukan Permohonan</th>
        <td><?= h($letter['reference']) ?></td>
    </tr>
    <tr>
        <th>Nama Program</th>
        <td><?= h($application->program_title ?: '-') ?></td>
    </tr>
    <tr>
        <th>Penganjur</th>
        <td><?= h($clubName) ?></td>
    </tr>
    <tr>
        <th>Wakil Pelajar</th>
        <td><?= h($studentName) ?></td>
    </tr>
    <tr>
        <th>Kategori / Peringkat</th>
        <td>
            <?= h($application->program_category ?: '-') ?>
            /
            <?= h($application->program_level ?: '-') ?>
        </td>
    </tr>
    <tr>
        <th>Tarikh dan Masa</th>
        <td>
            <?= h($formatDateTime($application->start_datetime)) ?>
            hingga
            <?= h($formatDateTime($application->end_datetime)) ?>
        </td>
    </tr>
    <tr>
        <th>Tempat</th>
        <td><?= h($application->venue ?: '-') ?></td>
    </tr>
    <tr>
        <th>Kumpulan Sasaran</th>
        <td><?= h($application->target_group ?: '-') ?></td>
    </tr>
    <tr>
        <th>Jumlah Peserta</th>
        <td><?= h((string)($application->total_participants ?? 0)) ?></td>
    </tr>
    <tr>
        <th>Pegawai / Person In Charge</th>
        <td>
            <?= h($application->person_in_charge ?: '-') ?><br>
            <?= h($application->pic_phone ?: '-') ?><br>
            <?= h($application->pic_email ?: '-') ?>
        </td>
    </tr>
</table>

<table class="budget-table">
    <thead>
        <tr>
            <th>Perkara</th>
            <th class="amount">Jumlah (RM)</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>Anggaran keseluruhan program</td>
            <td class="amount">
                <?= h(number_format((float)($application->estimated_budget ?? 0), 2)) ?>
            </td>
        </tr>
        <tr>
            <td>Peruntukan yang dimohon</td>
            <td class="amount">
                <?= h(number_format((float)($application->requested_allocation ?? 0), 2)) ?>
            </td>
        </tr>
        <tr>
            <th>Peruntukan yang diluluskan</th>
            <th class="amount">
                <?= h(number_format((float)$approvedAmount, 2)) ?>
            </th>
        </tr>
    </tbody>
</table>

<?php if (!empty($application->admin_comment)): ?>
    <div class="decision-box" style="margin-top: 7mm;">
        <div class="decision-title">ULASAN HEP</div>
        <?= nl2br(h($application->admin_comment)) ?>
    </div>
<?php endif; ?>

<div class="keep-together" style="margin-top: 8mm;">
    Dokumen ini dijana melalui Sistem e-KAP pada
    <?= h($formatMalayDate($approvalDate)) ?>
    dan sah bagi tujuan rekod kelulusan aktiviti pelajar.
</div>