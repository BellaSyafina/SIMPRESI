<?php

namespace App\Exports;

use App\Models\Absensi;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class LaporanExport implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    protected $rekap;

    public function __construct($rekap)
    {
        $this->rekap = $rekap;
    }

    public function collection()
    {
        return collect($this->rekap)->map(function ($item) {
            return [
                'NIS' => $item['nis'],
                'Nama Siswa' => $item['nama'],
                'Hadir' => $item['hadir'],
                'Izin' => $item['izin'],
                'Sakit' => $item['sakit'],
                'Alpa' => $item['alpa'],
                'Persentase Kehadiran' => $item['persen'] . '%',
            ];
        });
    }

    public function headings(): array
    {
        return [
            'NIS',
            'Nama Siswa',
            'Hadir',
            'Izin',
            'Sakit',
            'Alpa',
            '% Kehadiran',
        ];
    }
}
