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
use Illuminate\Support\Str;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Support\Facades\File;


class ReleaseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
//        $id = $request->id;
//
//        // Fetch the document and associated users
//        $document = DoneUserDocs::where('userdocs_id', $id)->get();
//        $users_ids = $document->pluck('user_id');
//
//        $users = User::whereIn('id', $users_ids)
//            ->select('id', 'firstname', 'lastname', 'middlename')
//            ->get();
//
//        $pdf_author = auth()->user()->id;
//
//
//        $userdocument = UserDocuments::find($id);
//        $author = User::find($userdocument->user_id);
//
//        $documenttype_id = $userdocument->documenttype_id;
//        $documenttype = DocumentType::find($documenttype_id);
//
//
//        // Generate the URL with a query parameter
//        $fileUrl = route('release.pdf', ['id' => $id]);
//
//        // Encode the URL with base64
//        $shortenedUrl = url('/') . '/short/' . base64_encode($fileUrl);
//
//
//        $qrCode = QrCode::format('png')->size(200)->generate($shortenedUrl);
//
//
//        $hashedFileName = Str::random(32) . '-' . $id . '.png';
//
//
//        $qrCodePath = public_path('qr-codes/' . $hashedFileName);
//
//        if (!File::exists(public_path('qr-codes'))) {
//            File::makeDirectory(public_path('qr-codes'), 0775, true);
//        }
//
//
//        file_put_contents($qrCodePath, $qrCode);
//
//
//        $existingRelease = Release::where('document_id', $userdocument->id)
//            ->where('user_id', $pdf_author)
//            ->where('documenttype_id', $documenttype_id)
//            ->latest()
//            ->first();
//
//        // Generate the PDF
//        $pdf = PDF::loadView('release.userdocument', compact('userdocument', 'users', 'documenttype', 'qrCodePath', 'author'));
//
//        // Set author ID
//
//        // Generate a hashed file name for PDF
//        $hashedFileName = Str::random(32) . '-' . $id . '.pdf'; // or you can use md5($id)
//        $pdfPath = storage_path('app/pdfs/' . $hashedFileName);
//
//        // Ensure the pdfs directory exists
//        if (!File::exists(storage_path('app/pdfs'))) {
//            File::makeDirectory(storage_path('app/pdfs'), 0775, true);
//        }
//
//        // Save the PDF to storage
//        $pdf->save($pdfPath);
//
//        // Read PDF content and encode it in base64
//        $pdfContent = file_get_contents($pdfPath);
//        $base64Pdf = base64_encode($pdfContent);
//
//
//        if (!$existingRelease) {
//            // If no record exists, create a new release document
//            $releaseDocument = new Release();
//            $releaseDocument->document_id = $userdocument->id;
//            $releaseDocument->user_id = $pdf_author;
//            $releaseDocument->documenttype_id = $documenttype->id;
//            $releaseDocument->file = $base64Pdf;
//            $releaseDocument->qrcode = 'qr-codes/qr-code-' . $id . '.png'; // QR code path
//            $releaseDocument->save();
//        }
//
//        // Return PDF for download
//        return $this->getDownload($id);
    }

//    public function redirectShortUrl($encodedUrl)
//    {
//        // Decode the URL
//        $decodedUrl = base64_decode($encodedUrl);
//
//        // Check if URL is valid
//        if ($decodedUrl === false) {
//            return response()->json(['error' => 'Invalid URL encoding'], 400);
//        }
//
//        if (!filter_var($decodedUrl, FILTER_VALIDATE_URL)) {
//            return response()->json(['error' => 'Invalid URL'], 400);
//        }
//
//        // Parse the URL and check if it's for a PDF download
//        $parsedUrl = parse_url($decodedUrl);
//
//        if (isset($parsedUrl['path']) && strpos($parsedUrl['path'], 'release.pdf') !== false) {
//            // You can extract the ID from the URL and then return the PDF file
//
//            // Assuming you are passing the 'id' as a query parameter
//            $query = [];
//            parse_str($parsedUrl['query'], $query);
//
//            if (isset($query['id'])) {
//                $id = $query['id'];
//
//                // Call the logic to generate or serve the PDF
//                return $this->getDownload($id); // Assuming 'getDownload' takes the ID
//            }
//        }
//
////    return redirect($decodedUrl);
//    }
//
//
//    public function getDownload($id)
//    {
//        // Fetch the release document based on the document ID
//        $releaseDocument = Release::where('document_id', $id)->first();
//
//        // Check if the document exists
//        if (!$releaseDocument) {
//            abort(404, 'Document not found');
//        }
//
//        // Decode the base64 PDF content stored in the 'file' attribute
//        $pdfContent = base64_decode($releaseDocument->file);
//
//        // Generate a unique file name based on the document ID
//        $hashedFileName = Str::random(32) . '-' . $id . '.pdf';  // Generate a random name for the PDF
//        $pdfPath = storage_path('app/pdfs/' . $hashedFileName);
//
//        // Save the decoded PDF content to a temporary file in storage
//        if (!file_put_contents($pdfPath, $pdfContent)) {
//            abort(500, 'Error saving the file');
//        }
//
//        // Set headers for the PDF response
//        $headers = [
//            'Content-Type' => 'application/pdf',
//            'Content-Disposition' => 'inline; filename="' . $hashedFileName . '"',
//        ];
//
//        return response()->file($pdfPath, $headers);
//    }


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
        //
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {

        $document = DoneUserDocs::where('userdocs_id', $id)->get();
        $users_ids = $document->pluck('user_id');

        $users = User::whereIn('id', $users_ids)
            ->select('id', 'firstname', 'lastname', 'middlename')
            ->get();

        $pdf_author = auth()->user()->id;

        $userdocument = UserDocuments::findOrFail($id);
        $author = User::findOrFail($userdocument->user_id);

        $documenttype_id = $userdocument->documenttype_id;
        $documenttype = DocumentType::findOrFail($documenttype_id);

        $existingRelease = Release::where('document_id', $userdocument->id)
            ->where('user_id', $pdf_author)
            ->where('documenttype_id', $documenttype_id)
            ->latest()
            ->first();

        if ($existingRelease) {
            return $this->getDownload($id);
        }
        else {

            $fileUrl = route('release.pdf', ['id' => $id]);
            $shortenedUrl = url('/') . '/short/' . urlencode(base64_encode($fileUrl));

            $qrCode = QrCode::format('png')->size(200)->generate($shortenedUrl);

            $hashedFileName = hash('sha256', $id . 'qrcode') . '.png';
            $qrCodePath = public_path('qr-codes/' . $hashedFileName);

            if (!File::exists(public_path('qr-codes'))) {
                File::makeDirectory(public_path('qr-codes'), 0775, true);
            }

            file_put_contents($qrCodePath, $qrCode);


            $pdf = PDF::loadView('release.userdocument', compact('userdocument', 'users', 'documenttype', 'qrCodePath', 'author'));

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
                $releaseDocument->user_id = $pdf_author;
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
