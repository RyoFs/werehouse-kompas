<?php

namespace App\Http\Controllers;

use App\Models\Alat;
use Illuminate\Http\Request;
use App\Imports\AlatImport;
use App\Exports\AlatExport;
use App\Exports\AlatTemplateExport;
use Maatwebsite\Excel\Facades\Excel;
use App\Helpers\ActivityLog;

class AlatController extends Controller
{
    public function index(Request $request)
    {
        $query = Alat::query();

        if ($request->filled('search')) {
            $query->where('nama_alat', 'like', '%' . $request->search . '%')
                ->orWhere('kode_alat', 'like', '%' . $request->search . '%');
        }

        if ($request->filled('jenis')) {
            $query->where('jenis_alat', $request->jenis);
        }

        $alats = $query->orderBy('nama_alat')->paginate(50)->appends($request->all());
        $jenisList = Alat::select('jenis_alat')->distinct()->pluck('jenis_alat');

        return view('alats.index', compact('alats', 'jenisList'));
    }


    public function store(Request $request)
    {
        $request->validate([
            'kode_alat' => 'required',
            'jenis_alat' => 'required',
            'nama_alat' => 'required',
            'persediaan_awal' => 'required|numeric',
            'persediaan_gudang' => 'required|numeric',
        ]);

        Alat::create([
            'kode_alat' => $request->kode_alat,
            'jenis_alat' => $request->jenis_alat,
            'nama_alat' => $request->nama_alat,
            'persediaan_awal' => $request->persediaan_awal,
            'persediaan_gudang' => $request->persediaan_gudang,
        ]);
        
        ActivityLog::add(
            "Menambahkan alat baru: {$request->nama_alat} ({$request->kode_alat})"
        );

        return back()->with('success', 'Alat berhasil ditambahkan!');
    }

    public function update(Request $request, $id)
    {
        $alat = Alat::findOrFail($id);

        $request->validate([
            'kode_alat' => 'required|unique:alats,kode_alat,' . $alat->id,
            'jenis_alat' => 'required',
            'nama_alat' => 'required',
            'persediaan_awal' => 'required|numeric',
            'persediaan_gudang' => 'required|numeric',
        ]);

        $alat->update($request->only([
            'kode_alat', 'jenis_alat', 'nama_alat',
            'persediaan_awal', 'persediaan_gudang'
        ]));

        ActivityLog::add(
            "Memperbarui alat: {$alat->nama_alat} ({$alat->kode_alat})"
        );

        return back()->with('success', 'Data alat berhasil diperbarui!');
    }



    public function destroy($id)
    {
        Alat::findOrFail($id)->delete();
        ActivityLog::add(
            "Menghapus alat dengan ID: {$id}"
        );
        return back()->with('success', 'Alat berhasil dihapus!');
    }

    public function import(Request $request)
    {
        $request->validate(['file' => 'required|mimes:csv,xlsx']);
        Excel::import(new AlatImport, $request->file('file'));

        ActivityLog::add("Mengimpor data alat dari file Excel/CSV");

        return back()->with('success', 'Data alat berhasil diimpor!');
    }


    public function downloadTemplate()
    {
        return Excel::download(
            new AlatTemplateExport,
            'template-import-alat.xlsx'
        );
    }

    public function backup()
    {
        return view('alats.backup');
    }

    public function export(Request $request)
    {
        $format = $request->get('format', 'xlsx');

        $filename = 'backup-data-alat-' . now()->format('Y-m-d_H-i-s');

        if ($format === 'csv') {
            return Excel::download(new AlatExport, $filename . '.csv');
        }

        ActivityLog::add(
            "Melakukan backup data alat (format: {$format})"
        );

        return Excel::download(new AlatExport, $filename . '.xlsx');
    }

}
