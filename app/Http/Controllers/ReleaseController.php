<?php

namespace App\Http\Controllers;

use App\Models\documenttype\DocumentType;
use App\Models\Release;
use App\Http\Requests\StoreReleaseRequest;
use App\Http\Requests\UpdateReleaseRequest;
use App\Models\studydepartament\DoneUserDocs;
use App\Models\studydepartament\UserDocuments;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Str;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Support\Facades\File;


class ReleaseController extends Controller
{
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $id = intval($request->release_id);
        $number = intval($request->number);

        $document = DoneUserDocs::where('userdocs_id', $id)->get();
        $users_ids = $document->pluck('user_id');

        $users = User::whereIn('id', $users_ids)
            ->select('id', 'firstname', 'lastname', 'middlename', 'position')
            ->get();

        if (auth()->user()) {
            $pdf_author = auth()->user()->id;
        }

        $userdocument = UserDocuments::find($id);



        $author = User::findOrFail($userdocument->user_id);

        $documenttype_id = $userdocument->documenttype_id;
        $documenttype = DocumentType::findOrFail($documenttype_id);


        $existingRelease = Release::where('document_id', $userdocument->id)
//            ->where('user_id', $pdf_author)
            ->where('documenttype_id', $documenttype_id)
            ->latest()
            ->first();

        if ($existingRelease) {
            return $this->getDownload($id);
        } else {

            $fileUrl = route('release.pdf', ['id' => $id]);
            $shortenedUrl = url('/') . '/short/' . urlencode(base64_encode($fileUrl));

            $qrCode = QrCode::format('png')->size(200)->generate($shortenedUrl);

            $hashedFileName = hash('sha256', $id . 'qrcode') . '.png';
            $qrCodePath = public_path('qr-codes/' . $hashedFileName);

            if (!File::exists(public_path('qr-codes'))) {
                File::makeDirectory(public_path('qr-codes'), 0775, true);
            }

            file_put_contents($qrCodePath, $qrCode);


//            $pdf = PDF::loadView('release.userdocument', compact('userdocument', 'users', 'documenttype', 'qrCodePath', 'author'))->setPaper('A4', 'portrait')
//                ->setOptions([
//                    'defaultFont' => 'times'
//                ]);

            $users = $users->map(function ($user) {
                return (object)[
                    'id' => $user->id,
                    'position' => str_replace(['`', 'ʻ', 'Oʻ', 'oʻ'], ["'", "'", "O'", "o'"], mb_convert_encoding($user->position, 'UTF-8', 'auto')),
                    'firstname' => str_replace(['`', 'ʻ', 'Oʻ', 'oʻ'], ["'", "'", "O'", "o'"], mb_convert_encoding($user->firstname, 'UTF-8', 'auto')),
                    'middlename' => str_replace(['`', 'ʻ', 'Oʻ', 'oʻ'], ["'", "'", "O'", "o'"], mb_convert_encoding($user->middlename, 'UTF-8', 'auto')),
                    'lastname' => str_replace(['`', 'ʻ', 'Oʻ', 'oʻ'], ["'", "'", "O'", "o'"], mb_convert_encoding($user->lastname, 'UTF-8', 'auto')),
                ];
            });


            $pdf = PDF::loadView('release.userdocument', compact('userdocument', 'users', 'documenttype', 'qrCodePath', 'author','number'))
                ->setPaper('A4', 'portrait')
                ->setOptions([
                    'defaultFont' => 'Times New Roman' // Shu yerni o'zgartiramiz
                ]);

            $pdf->getDomPDF()->set_option('defaultFont', 'Times New Roman');


            $pdf->setPaper('A4', 'portrait');
//            $pdf->getDomPDF()->set_option('defaultFont', 'DejaVu Sans');

            $pdfFileName = hash('sha256', $id . 'hujjat') . '.pdf';

            $pdfPath = storage_path('app/pdfs/' . $pdfFileName);

            if (!File::exists(storage_path('app/pdfs'))) {
                File::makeDirectory(storage_path('app/pdfs'), 0775, true);
            }

            $pdf->save($pdfPath);


            if (!File::exists($pdfPath)) {
                abort(404, 'PDF fayl topilmadi');
            }

            $pdfContent = file_get_contents($pdfPath);

            if (!$existingRelease) {
                $releaseDocument = new Release();
                $releaseDocument->document_id = $userdocument->id;
                $releaseDocument->user_id = $pdf_author ?? 0;
                $releaseDocument->documenttype_id = $documenttype->id;
                $releaseDocument->file = $pdfFileName;
                $releaseDocument->qrcode = 'qr-codes/' . $hashedFileName;
                $releaseDocument->save();
            }

            return $this->getDownload($id);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {

        $document = DoneUserDocs::where('userdocs_id', $id)->get();
        $users_ids = $document->pluck('user_id');

        $users = User::whereIn('id', $users_ids)
            ->select('id', 'firstname', 'lastname', 'middlename', 'position')
            ->get();

        if (auth()->user()) {

            $pdf_author = auth()->user()->id;
        }

        $userdocument = UserDocuments::findOrFail($id);
        $author = User::findOrFail($userdocument->user_id);

        $documenttype_id = $userdocument->documenttype_id;
        $documenttype = DocumentType::findOrFail($documenttype_id);


        $existingRelease = Release::where('document_id', $userdocument->id)
//            ->where('user_id', $pdf_author)
            ->where('documenttype_id', $documenttype_id)
            ->latest()
            ->first();

        if ($existingRelease) {
            return $this->getDownload($id);
        } else {

            $fileUrl = route('release.pdf', ['id' => $id]);
            $shortenedUrl = url('/') . '/short/' . urlencode(base64_encode($fileUrl));

            $qrCode = QrCode::format('png')->size(200)->generate($shortenedUrl);

            $hashedFileName = hash('sha256', $id . 'qrcode') . '.png';
            $qrCodePath = public_path('qr-codes/' . $hashedFileName);

            if (!File::exists(public_path('qr-codes'))) {
                File::makeDirectory(public_path('qr-codes'), 0775, true);
            }

            file_put_contents($qrCodePath, $qrCode);


//            $pdf = PDF::loadView('release.userdocument', compact('userdocument', 'users', 'documenttype', 'qrCodePath', 'author'))->setPaper('A4', 'portrait')
//                ->setOptions([
//                    'defaultFont' => 'times'
//                ]);

            $users = $users->map(function ($user) {
                return (object)[
                    'id' => $user->id,
                    'position' => str_replace(['`', 'ʻ', 'Oʻ', 'oʻ'], ["'", "'", "O'", "o'"], mb_convert_encoding($user->position, 'UTF-8', 'auto')),
                    'firstname' => str_replace(['`', 'ʻ', 'Oʻ', 'oʻ'], ["'", "'", "O'", "o'"], mb_convert_encoding($user->firstname, 'UTF-8', 'auto')),
                    'middlename' => str_replace(['`', 'ʻ', 'Oʻ', 'oʻ'], ["'", "'", "O'", "o'"], mb_convert_encoding($user->middlename, 'UTF-8', 'auto')),
                    'lastname' => str_replace(['`', 'ʻ', 'Oʻ', 'oʻ'], ["'", "'", "O'", "o'"], mb_convert_encoding($user->lastname, 'UTF-8', 'auto')),
                ];
            });


            $pdf = PDF::loadView('release.userdocument', compact('userdocument', 'users', 'documenttype', 'qrCodePath', 'author'))
                ->setPaper('A4', 'portrait')
                ->setOptions([
                    'defaultFont' => 'Times New Roman' // Shu yerni o'zgartiramiz
                ]);

            $pdf->getDomPDF()->set_option('defaultFont', 'Times New Roman');


            $pdf->setPaper('A4', 'portrait');
//            $pdf->getDomPDF()->set_option('defaultFont', 'DejaVu Sans');

            $pdfFileName = hash('sha256', $id . 'hujjat') . '.pdf';

            $pdfPath = storage_path('app/pdfs/' . $pdfFileName);

            if (!File::exists(storage_path('app/pdfs'))) {
                File::makeDirectory(storage_path('app/pdfs'), 0775, true);
            }

            $pdf->save($pdfPath);

            if (!File::exists($pdfPath)) {
                abort(404, 'PDF fayl topilmadi');
            }

            $pdfContent = file_get_contents($pdfPath);

            if (!$existingRelease) {
                $releaseDocument = new Release();
                $releaseDocument->document_id = $userdocument->id;
                $releaseDocument->user_id = $pdf_author ?? 0;
                $releaseDocument->documenttype_id = $documenttype->id;
                $releaseDocument->file = $pdfFileName;
                $releaseDocument->qrcode = 'qr-codes/' . $hashedFileName;
                $releaseDocument->save();
            }

            return $this->getDownload($id);
        }

    }

    public function redirectShortUrl($encodedUrl)
    {
        // URLni dekodlash
        $decodedUrl = base64_decode($encodedUrl);

        if ($decodedUrl === false || !filter_var($decodedUrl, FILTER_VALIDATE_URL)) {
            return response()->json(['error' => 'Noto‘g‘ri URL'], 400);
        }

        // URL tarkibiy qismlarini ajratish
        $parsedUrl = parse_url($decodedUrl);

        if (isset($parsedUrl['path']) && strpos($parsedUrl['path'], 'release.pdf') !== false) {
            $query = [];
            parse_str($parsedUrl['query'], $query);

            if (isset($query['id'])) {
                return $this->getDownload($query['id']);
            }
        }

        return redirect($decodedUrl);
    }

    public function getDownload($id)
    {

        $releaseDocument = Release::where('document_id', $id)->first();

        if (!$releaseDocument) {
            abort(404, 'Hujjat topilmadi');
        }

        // PDFni dekodlash
        $pdfContent = $releaseDocument->file;
        $pdfFileName = $releaseDocument->file;
        $pdfPath = storage_path('app/pdfs/' . $pdfFileName);

//
//        if (!File::exists(storage_path('app/pdfs'))) {
//            File::makeDirectory(storage_path('app/pdfs'), 0775, true);
//        }
//
//        // PDFni fayl sifatida saqlash
//        if (!file_put_contents($pdfPath, $pdfContent)) {
//            abort(500, 'Faylni saqlashda xatolik yuz berdi');
//        }

        return response()->file($pdfPath, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="' . $pdfFileName . '"',
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public
    function edit(Release $release)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public
    function update(UpdateReleaseRequest $request, Release $release)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public
    function destroy(Release $release)
    {
        //
    }
}
