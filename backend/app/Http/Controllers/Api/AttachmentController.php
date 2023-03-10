<?php

// namespace App\Http\Controllers\Api;

// use App\Http\Controllers\Controller;
// use Illuminate\Http\Request;

// class AttachmentController extends Controller
// {
//     //
// }

// <?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Attachment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class AttachmentController extends Controller
{
    public function storeAttachmentFile(Request $request, string $uuid)
    {
        $attachment = DB::transaction(function () use ($request, $uuid) {
            $savedPath = $request->file->store("channels/{$uuid}/attachments");

            try {
                $attachment = Attachment::create([
                    'path' => $savedPath,
                    'original_filename' => $request->file->getClientOriginalName(),
                ]);
                return $attachment;
            } catch (\Exception $e) {
                // DBでのエラーが起きた場合は、保存したファイルを削除
                Storage::delete($savedPath);
                throw $e;
            }
        });

        return response()->json($attachment);
    }
}

