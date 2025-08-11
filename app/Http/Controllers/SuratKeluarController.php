<?php

namespace App\Http\Controllers;

use App\Http\Requests\SuratKeluarRequest;
use App\Models\Log;
use App\Models\SuratKeluar;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use PhpOffice\PhpWord\IOFactory;
use PhpOffice\PhpWord\PhpWord;
use PhpOffice\PhpWord\Shared\Html;
use PhpOffice\PhpWord\TemplateProcessor;

class SuratKeluarController extends Controller
{
    public function index()
    {
        $title = 'Surat Keluar';
        $suratKeluars = SuratKeluar::latest()->paginate(10);
        return view('surat-keluar.modern-index', compact('title', 'suratKeluars'));
    }

    public function create()
    {
        $title = 'Tambah Surat Keluar';
        $penandatangan = User::all();
        return view('surat-keluar.create', compact('title', 'penandatangan'));
    }

    protected function fixBrTags($htmlContent)
    {
        // Replace all <br> tags with <br /> to make them self-closing
        return str_replace('<br>', '<br />', $htmlContent);
    }

    protected function generateDOCXFromScratch($request, $nomorSurat)
    {
        // Create a new PhpWord object
        $phpWord = new \PhpOffice\PhpWord\PhpWord();

        $sectionStyle = [
            'marginTop' => \PhpOffice\PhpWord\Shared\Converter::cmToTwip(1.5),
            'marginBottom' => \PhpOffice\PhpWord\Shared\Converter::cmToTwip(1.5),
            'marginLeft' => \PhpOffice\PhpWord\Shared\Converter::cmToTwip(1.5),
            'marginRight' => \PhpOffice\PhpWord\Shared\Converter::cmToTwip(1.5),
        ];

        $section = $phpWord->addSection($sectionStyle);
        $header = $section->addHeader();

        // Create a table for the header with vertical centering
        $tableStyle = [
            'borderTopSize' => 0,
            'borderBottomSize' => 0,
            'borderLeftSize' => 0,
            'borderRightSize' => 0,
            'cellMarginTop' => 0,
            'cellMarginBottom' => 0,
            'cellMarginLeft' => 0,
            'cellMarginRight' => 0,
            'borderSize' => 0,
            'borderColor' => 'ffffff',
            'cellMargin' => 0,
        ];
        $table = $header->addTable($tableStyle);
        $table->addRow(900); // Set a fixed height for the row

        // Logo cell
        $cell1 = $table->addCell(1000, ['valign' => 'center']);
        $cell1->addImage(asset('assets/undip-logo.png'), [
            'width' => 80,
            'height' => 80,
            'alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT,
        ]);

        // Text cell
        $cell2 = $table->addCell(6200, ['valign' => 'center']);
        // Define font styles with reduced line spacing
        $fontStyleBold = ['bold' => true, 'name' => 'Times New Roman', 'size' => 12, 'color' => '000080'];
        $fontStyleBoldUndip = ['bold' => true, 'name' => 'Times New Roman', 'size' => 14, 'color' => '000080'];
        $paragraphStyle = ['alignment' => 'left', 'lineHeight' => 1.0, 'spaceAfter' => 0.5]; // Reduced line height

        // Add text for the header
        $cell2->addText("KEMENTERIAN PENDIDIKAN, KEBUDAYAAN\n", $fontStyleBold, $paragraphStyle);
        $cell2->addText("RISET, DAN TEKNOLOGI\n ", $fontStyleBold, $paragraphStyle);
        $cell2->addText('UNIVERSITAS DIPONEGORO', $fontStyleBoldUndip, $paragraphStyle);

        $cell3 = $table->addCell(2800, ['valign' => 'center']);
        // Define font styles with reduced line spacing
        $fontStyleSmall = ['name' => 'Times New Roman', 'size' => 7, 'color' => '000080'];
        $paragraphStyleRight = ['alignment' => 'right', 'lineHeight' => 1.0, 'spaceAfter' => 0.5]; // Reduced line height

        $cell3->addText('Gedung Widya Puraya', $fontStyleSmall, $paragraphStyleRight);
        $cell3->addText('Jalan Prof. Sudarto, S.H.', $fontStyleSmall, $paragraphStyleRight);
        $cell3->addText('Tembalang Semarang Kode Pos 50275', $fontStyleSmall, $paragraphStyleRight);
        $cell3->addText('Telp. (024) 7460024 Faks. (024) 7460027', $fontStyleSmall, $paragraphStyleRight);
        $cell3->addText('www.undip.ac.id | email: humas[at]live.undip.ac.id', $fontStyleSmall, $paragraphStyleRight);

        // Define font styles for the document
        $fontStyleBold = ['bold' => true, 'size' => 12];
        $fontStyleRegular = ['size' => 12];
        $alignRight = ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::RIGHT];

        // Set fields for the letter with proper alignment and styles
        $tanggalSurat = Carbon::parse($request->tanggal_surat)->translatedFormat('j F Y');

        // Align right for date and location
        $section->addText("Semarang, {$tanggalSurat}", $fontStyleRegular, $alignRight);

        // Add header information (No, Lampiran, Perihal)
        $section->addText("No\t\t: {$nomorSurat}", $fontStyleRegular);
        $section->addText("Lampiran\t:", $fontStyleRegular);
        $section->addText("Perihal\t: {$request->perihal}", $fontStyleRegular);

        // Add recipient information (Kepada, Yth. ...)
        $section->addTextBreak(); // Add a line break
        $section->addText('Kepada');
        $section->addText("Yth. {$request->tujuan}");
        $section->addText('di tempat', $fontStyleRegular);

        // Add body text from CKEditor content (after fixing <br> tags)
        $section->addTextBreak(2); // Space before the body
        $fixedBody = $this->fixBrTags($request->body);
        \PhpOffice\PhpWord\Shared\Html::addHtml($section, $fixedBody, false, false);

        // Add signature (aligned right)
        $section->addTextBreak(2); // Space before signature
        $section->addText("Rektor Universitas Diponegoro", $fontStyleBold, $alignRight);
        $section->addText("{$request->asal}", $fontStyleBold, $alignRight);

        // Save the document as a DOCX file
        $fileName = 'surat_keluar_' . $nomorSurat . time() . '.docx';
        $outputPath = storage_path('app/public/surat_keluar/' . $fileName);
        $objWriter = \PhpOffice\PhpWord\IOFactory::createWriter($phpWord, 'Word2007');
        $objWriter->save($outputPath);

        // Return the document for download
        return $fileName;
    }

    public function store(SuratKeluarRequest $request)
    {
        $content = $request->input('body');
        $nomorSurat = 'SK-' . time();
        $namaSurat = 'null';

        if ($request->hasFile('file_surat')) {
            $surat = $request->file('file_surat');
            $namaSurat = time() . '_' . $surat->getClientOriginalName();
            $surat->storeAs('/surat_keluar', $namaSurat, 'public');
        }

        if (!empty($request->body)) {
            // $this->generateDOCX($request, $nomorSurat);
            $namaSurat = $this->generateDOCXFromScratch($request, $nomorSurat);
        }

        // Simpan data surat
        $surat = SuratKeluar::create([
            'penulis_id' => auth()->id(),
            'nomor_surat' => $nomorSurat,
            'perihal' => $request->perihal,
            'asal' => $request->asal,
            'tujuan' => $request->tujuan,
            'alamat_surat' => $request->alamat,
            'penandatangan_id' => $request->penandatangan_id,
            'file_surat' => $namaSurat,
            'tanggal_dikirim' => $request->tanggal_surat,
            'status' => 'Dalam Proses',
        ]);

        Log::create([
            'pegawai_id' => auth()->id(),
            'kegiatan_id' => $surat->id,
            'bobot' => 30,
        ]);

        return redirect()->route('surat-keluar.index');
    }

    public function show(SuratKeluar $surat)
    {
        $title = 'Detail Surat Keluar';
        return view('surat-keluar.show', compact('title', 'surat'));
    }

    public function edit(SuratKeluar $surat)
    {
        $title = 'Edit Surat Keluar';
        return view('surat-keluar.edit', compact('title', 'surat'));
    }

    public function update(SuratKeluarRequest $request, SuratKeluar $surat)
    {
        // Cek kalo ada file baru di request
        if ($request->hasFile('file_surat')) {
            // Hapus file lama
            $fileLama = storage_path('app/surat_keluar/' . $surat->file_surat);
            if (file_exists($fileLama)) {
                unlink($fileLama);
            }

            // Upload file baru
            $surat = $request->file('file_surat');
            $namaSurat = time() . '_' . $surat->getClientOriginalName();
            $surat->storeAs('surat_keluar', $namaSurat, 'public');
        }

        // Update data surat
        $surat->update([
            'nomor_surat' => $request->nomor_surat,
            'perihal' => $request->perihal,
            'asal' => $request->asal,
            'tujuan' => $request->tujuan,
            'file_surat' => $namaSurat,
            'tanggal_surat' => $request->tanggal_surat,
        ]);

        return redirect()->route('surat-keluar.index');
    }

    public function destroy(SuratKeluar $surat)
    {
        $fileLama = storage_path('app/surat_keluar/' . $surat->file_surat);
        if (file_exists($fileLama)) {
            unlink($fileLama);
        }

        $surat->delete();
        return redirect()->route('surat-keluar.index');
    }
}
