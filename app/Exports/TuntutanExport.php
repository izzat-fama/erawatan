<?php

namespace App\Exports;

use App\Tuntutan;
//use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;

class TuntutanExport implements FromQuery, WithMapping, WithHeadings
{
    use Exportable;

    public $entiti;

    public function __construct($entiti)
    {
        $this->entiti = $entiti;
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function query()
    {
        if (!is_null($this->entiti))
        {
            $sql = Tuntutan::query()->where('entiti_id', '=', $this->entiti);
        }
        else
        {
            $sql = Tuntutan::query();
        }

        return $sql;

        // return !is_null($this->entiti) ? Tuntutan::query()->where('entiti_id', '=', $this->entiti) : Tuntutan::query();
    }

    public function map($tuntutan): array
    {
        return [
            $tuntutan->id,
            $tuntutan->ertuntutantarikhrawat,
            $tuntutan->individu->individunama ?? null,
            $tuntutan->entiti->entitinama ?? null,
            $tuntutan->ertuntutanamaun,
            $tuntutan->statusAkhir->refStatus->status ?? null
        ];
    }

    public function headings(): array
    {
        return [
            'ID',
            'TARIKH RAWAT',
            'PESAKIT',
            'NAMA ENTITI',
            'AMAUN TUNTUTAN',
            'STATUS BAYARAN'
        ];
    }
}
