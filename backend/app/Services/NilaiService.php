<?php

namespace App\Services;

use App\Repositories\Interfaces\NilaiRepositoryInterface;

class NilaiService implements NilaiServiceInterface
{
    protected $nilaiRepository;

    public function __construct(NilaiRepositoryInterface $nilaiRepository)
    {
        $this->nilaiRepository = $nilaiRepository;
    }

    public function getNilaiRT()
    {
        $data = $this->nilaiRepository->getNilaiRT();

        // Grouping using Collection as permitted
        return $data->groupBy('nisn')->map(function ($items) {
            $student = $items->first();
            $nilaiRt = [];
            foreach ($items as $item) {
                // Determine key based on nama_pelajaran
                // Assuming nama_pelajaran matches keys: realistic, investigative, artistic, social, enterprising, conventional
                $key = strtolower($item->nama_pelajaran);
                $nilaiRt[$key] = $item->skor;
            }

            return [
                'nama' => $student->nama,
                'nilaiRt' => $nilaiRt,
                'nisn' => $student->nisn,
            ];
        })->values();
    }

    public function getNilaiST()
    {
        $data = $this->nilaiRepository->getNilaiST();

        $result = $data->groupBy('nisn')->map(function ($items) {
            $student = $items->first();
            $listNilai = [];
            $total = $student->total_score;

            foreach ($items as $item) {
                $key = strtolower($item->nama_pelajaran);
                $score = $item->calculated_score;
                $listNilai[$key] = $score;
            }

            return [
                'nama' => $student->nama,
                'listNilai' => $listNilai,
                'nisn' => $student->nisn,
                'total' => $total
            ];
        })->sortByDesc('total')->values();

        return $result;
    }
}
