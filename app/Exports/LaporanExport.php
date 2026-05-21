<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithDrawings;
use Maatwebsite\Excel\Concerns\WithCustomStartCell;

use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;

class LaporanExport implements FromArray, WithHeadings, WithStyles, ShouldAutoSize, WithDrawings, WithCustomStartCell
{
    protected $rekap;
    protected $kelas;
    protected $bulan;
    protected $tahun;

    public function __construct($rekap, $kelas, $bulan, $tahun)
    {
        $this->rekap = $rekap;
        $this->kelas = $kelas;
        $this->bulan = $bulan;
        $this->tahun = $tahun;
    }

    // DATA MULAI DARI BARIS 5
    public function startCell(): string
    {
        return 'A5';
    }

    // DATA
    public function array(): array
    {
        $data = [];

        foreach ($this->rekap as $index => $item) {
            $data[] = [$index + 1, $item['nis'], $item['nama'], $item['hadir'], $item['izin'], $item['sakit'], $item['alpa'], $item['persen'] . '%'];
        }

        return $data;
    }

    // HEADER TABEL
    public function headings(): array
    {
        return [['No', 'NIS', 'Nama Siswa', 'Hadir', 'Izin', 'Sakit', 'Alpa', '% Kehadiran']];
    }

    // STYLE
    public function styles(Worksheet $sheet)
    {
        // =========================
        // JUDUL
        // =========================

        $sheet->mergeCells('A1:H1');
        $sheet->setCellValue('A1', 'SMP NEGERI 2 SARONGGI');

        $sheet->mergeCells('A2:H2');
        $sheet->setCellValue('A2', 'LAPORAN KEHADIRAN SISWA');

        $sheet->mergeCells('A3:H3');

        $sheet->setCellValue('A3', 'Kelas : ' . ($this->kelas->nama_kelas ?? '-') . ' | Bulan : ' . $this->bulan . ' | Tahun : ' . $this->tahun);

        // STYLE JUDUL
        $sheet->getStyle('A1:H3')->applyFromArray([
            'font' => [
                'bold' => true,
                'size' => 14,
            ],

            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
            ],
        ]);

        // =========================
        // HEADER TABEL
        // =========================

        $sheet->getStyle('A5:H5')->applyFromArray([
            'font' => [
                'bold' => true,
                'color' => [
                    'rgb' => 'FFFFFF',
                ],
            ],

            'fill' => [
                'fillType' => 'solid',
                'startColor' => [
                    'rgb' => '4472C4',
                ],
            ],

            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
            ],
        ]);

        // =========================
        // TOTAL BARIS
        // =========================

        $lastRow = count($this->rekap) + 5;

        // =========================
        // BORDER
        // =========================

        $sheet->getStyle("A5:H{$lastRow}")->applyFromArray([
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                ],
            ],
        ]);

        // =========================
        // ALIGNMENT
        // =========================

        $sheet
            ->getStyle("A5:H{$lastRow}")
            ->getAlignment()
            ->setVertical(Alignment::VERTICAL_CENTER);

        // Nama siswa rata kiri
        $sheet
            ->getStyle("C6:C{$lastRow}")
            ->getAlignment()
            ->setHorizontal(Alignment::HORIZONTAL_LEFT);

        // Kolom lain rata tengah
        $sheet
            ->getStyle("A5:H{$lastRow}")
            ->getAlignment()
            ->setHorizontal(Alignment::HORIZONTAL_CENTER);

        // =========================
        // TANDA TANGAN
        // =========================

        $ttdRow = $lastRow + 4;

        // Mengetahui
        $sheet->mergeCells("F{$ttdRow}:H{$ttdRow}");
        $sheet->setCellValue("F{$ttdRow}", 'Mengetahui,');

        // Wali kelas
        $sheet->mergeCells('F' . ($ttdRow + 1) . ':H' . ($ttdRow + 1));
        $sheet->setCellValue('F' . ($ttdRow + 1), 'Wali Kelas');

        // Nama wali kelas
        $sheet->mergeCells('F' . ($ttdRow + 5) . ':H' . ($ttdRow + 5));

        $sheet->setCellValue('F' . ($ttdRow + 5), $this->kelas->guru->nama_guru ?? '________________');

        // NIP
        $sheet->mergeCells('F' . ($ttdRow + 6) . ':H' . ($ttdRow + 6));

        $sheet->setCellValue('F' . ($ttdRow + 6), 'NIP. ' . ($this->kelas->guru->nip ?? '-'));

        // STYLE TTD
        $sheet
            ->getStyle("F{$ttdRow}:H" . ($ttdRow + 6))
            ->getAlignment()
            ->setHorizontal(Alignment::HORIZONTAL_CENTER);

        return [];
    }

    // LOGO
    public function drawings()
    {
        $drawing = new Drawing();

        $drawing->setName('Logo');
        $drawing->setDescription('Logo SMPN');

        $drawing->setPath(public_path('assets/images/logo/smpn.png'));

        $drawing->setHeight(60);

        $drawing->setCoordinates('A1');

        return $drawing;
    }
}
