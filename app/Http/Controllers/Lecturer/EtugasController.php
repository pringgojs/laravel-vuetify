<?php

namespace App\Http\Controllers\Lecturer;

use App\Helpers\DateHelper;
use App\Helpers\FileHelper;
use Illuminate\Http\Request;
use Ixudra\Curl\Facades\Curl;
use App\Helpers\ResponseHelper;
use App\Http\Controllers\Controller;

class EtugasController extends Controller
{
    public function index()
    {
        $url = config('api.url').'/lecturer/e-tugas';
        $data = array('user' => ResponseHelper::user());
        $response = Curl::to($url)
            ->withData($data)
            ->post();

        return $response;
    }

    public function edit($id)
    {
        $url = config('api.url').'/lecturer/e-tugas/edit/'.$id;
        $data = array('user' => ResponseHelper::user());
        $response = Curl::to($url)
            ->withData($data)
            ->post();
        return $response;
    }

    public function store(Request $request)
    {
        $file = FileHelper::upload($request->file('file'), 'uploads/e-tugas/');
        $url = config('api.url').'/lecturer/e-tugas/store';
        $data = array('user' => ResponseHelper::user(), 'request' => $request->toArray(), 'file' => $file);
        $response = Curl::to($url)
            ->withData($data)
            ->post();
        return $response;
    }

    public function update(Request $request, $id)
    {
        $file = FileHelper::upload($request->file('file'), 'uploads/e-tugas/');
        $url = config('api.url').'/lecturer/e-tugas/update/'.$id;
        $data = array('user' => ResponseHelper::user(), 'request' => $request->toArray(), 'file' => $file);
        $response = Curl::to($url)
            ->withData($data)
            ->post();
        return $response;
    }

    public function delete($id)
    {
        $url = config('api.url').'/lecturer/e-tugas/delete/'.$id;
        $data = array('user' => ResponseHelper::user());
        $response = Curl::to($url)
            ->withData($data)
            ->post();

        $response = json_decode($response);
        if (file_exists($response->url)) {
            try {
                \File::delete($response->url);
            } catch (\Exception $e) {
            }
        }
        return 1;
    }

    public function filter(Request $request)
    {
        $url = config('api.url').'/lecturer/e-tugas/filter';
        $data = array('user' => ResponseHelper::user(), 'request' => $request->toArray());
        $response = Curl::to($url)
            ->withData($data)
            ->post();

        return $response;
    }

    public function detail($id)
    {
        $url = config('api.url').'/lecturer/e-tugas/detail/'.$id;
        $data = array('user' => ResponseHelper::user());
        $response = Curl::to($url)
            ->withData($data)
            ->post();
        return $response;
    }

    public function download($id)
    {
        $url = config('api.url').'/lecturer/e-tugas/detail/'.$id;
        $data = array('user' => ResponseHelper::user());
        $response = Curl::to($url)
            ->withData($data)
            ->post();
        $response = json_decode($response);
        $content = array(array('No','NIM', 'NAMA', 'KETERANGAN TUGAS', 'TGL UNGGAH', 'FILE TUGAS', 'NILAI'));
        $i = 1;
        foreach ($response->etugas_kelas_mahasiswa as $mahasiswa) {
            $updated_at = $mahasiswa->nilai ? DateHelper::formatView($mahasiswa->nilai->updated_at) : '0';
            array_push($content, [$i, $mahasiswa->nrp,  $mahasiswa->nama, $mahasiswa->nilai ? $mahasiswa->nilai->keterangan : '', 
                $updated_at, $mahasiswa->nilai ? $mahasiswa->nilai->file_url : '', $mahasiswa->nilai ? $mahasiswa->nilai->nilai : '']);
            $i++;
        }

        $file_name = 'LAPORAN TUGAS ' .date('YmdHis');
        $header = 'LAPORAN TUGAS '.$response->etugas->judul;
        self::excel($file_name, $content, $header);

        $response = array(
            'link' => url('download/nilai-permodul/'.$file_name.'.xls'),
        );

        return response()->json($response);
    }

    public function setNilai(Request $request)
    {
        $url = config('api.url').'/lecturer/e-tugas/set-nilai';
        $data = array('user' => ResponseHelper::user(), 'request' => $request->toArray());
        $response = Curl::to($url)
            ->withData($data)
            ->post();
        return $response;
    }

    public static function excel($file_name, $data, $header) 
    {
        $storage = storage_path('app/public/nilai-permodul/');
        \Excel::create($file_name, function ($excel) use ($data, $header)  {
            # Sheet Tim
            $excel->sheet('DATA', function ($sheet) use ($data, $header)  {
                $sheet->setWidth(array(
                    'A' => 25,
                    'B' => 25
                ));

                // MERGER COLUMN
                $sheet->mergeCells('A1:G1', 'center');
                $sheet->cell('A1:J2', function ($cell) {
                    // Set font
                    $cell->setFont(array(
                        'family'     => 'Times New Roman',
                        'size'       => '12',
                    ));
                });
                $sheet->cell('A1', function ($cell) use ($header) {
                    $cell->setValue(strtoupper($header));
                });
                
                $sheet->fromArray($data, null, 'A2', false, false);
            });
        })->store('xls', $storage);
    }
}
