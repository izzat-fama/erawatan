<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Individu;
use App\Dokumen;

/********************created by zainora
//kegunaan scheduler
//semak umur individu. 
//sekiranya cukup 18 tahun pada tarikh lahir
//semak status 24=bekerja, 25=pelajar 
//dan semak dokumen sokongan 3=KADPELAJAR, 4=SURAT TAWARAN
//maka akan automatik set status=TIDAK AKTIF
//hanya set set status=TIDAK AKTIF, untuk set=AKTIF perlu semakan pengurusan*********************/

class SetStatusAktif18 extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:SetStatusAktif18';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Set individu statusindividu_id= TIDAK AKTIF apabila capai umur 18 tahun ';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $dataIndividu = Individu::select(['id','individutarikhlahir','statuspekerjaan_id', 'individudaif','individuoku','hubungan_id'])->get();

        \Log::info($dataIndividu);
        foreach($dataIndividu as $individu)
        {
            $tkhLahir = strtotime($individu->individutarikhlahir);
            $hariLahir = date('d-m', $tkhLahir);
            $tahunLahir = date("Y", $tkhLahir);

            if(((date('Y') - $tahunLahir) == 18 && $individu->individudaif == 'T' && $individu->individuoku == 'T' && $individu->hubungan_id == 3 ))
            {
                if($hariLahir <= date('d-m'))
                {
                    if($individu->statuspekerjaan_id == 25)
                    {
                        $docExist = Dokumen::where('individu_id','=',$individu->id)
                        ->whereIn('jenisdokumen_id', [3,4])
                        ->first();

                        if(!$docExist)
                        {
                            $data['statusindividu_id'] = 27;
                            $data['idpenggunakmskini'] = 'SetStatusAktif18';
                            $individu->update($data);
                            $statusAktif = 'TIDAK AKTIF';
                            \Log::info($data['statusindividu_id']);
                            
                        }
                        else
                        {
                            $statusAktif = 'AKTIF';
                        }
                        \Log::info($statusAktif);
                    }
                } 
                //var_dump($statusAktif);
            }         
        }
    }
}
