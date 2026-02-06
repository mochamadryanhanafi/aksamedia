<?php

namespace App\Repositories\Eloquents;

use App\Repositories\Interfaces\NilaiRepositoryInterface;
use Illuminate\Support\Facades\DB;

class NilaiRepository implements NilaiRepositoryInterface
{
    public function getNilaiRT()
    {
        return DB::table('nilai')
            ->select('nama', 'nisn', 'nama_pelajaran', 'skor')
            ->where('materi_uji_id', 7)
            ->where('nama_pelajaran', '!=', 'Pelajaran Khusus')
            ->get();
    }

    public function getNilaiST()
    {
        return DB::table('nilai')
            ->select(
                'nama', 
                'nisn', 
                'nama_pelajaran',
                DB::raw('
                    CASE 
                        WHEN pelajaran_id = 44 THEN skor * 41.67
                        WHEN pelajaran_id = 45 THEN skor * 29.67
                        WHEN pelajaran_id = 46 THEN skor * 100
                        WHEN pelajaran_id = 47 THEN skor * 23.81
                        ELSE 0
                    END as calculated_score
                '),
                DB::raw('sum(CASE 
                        WHEN pelajaran_id = 44 THEN skor * 41.67
                        WHEN pelajaran_id = 45 THEN skor * 29.67
                        WHEN pelajaran_id = 46 THEN skor * 100
                        WHEN pelajaran_id = 47 THEN skor * 23.81
                        ELSE 0
                    END) over (partition by nisn) as total_score')
            )
            ->where('materi_uji_id', 4)
            ->get();
    }
}
