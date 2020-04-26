<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use http\Client\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Throwable;
use function GuzzleHttp\Psr7\_parse_request_uri;

class postController extends Controller
{

    public function insertPost(Request $request)
    {
        try {
            $timeStamp = Carbon::now();
            $result = DB::table('notes')->insertGetId(
                ['created_at' => $timeStamp, 'updated_at' => $timeStamp, 'content' => $request->input('content')]
            );

            if ($result) {
                return response()->json([
                    "error" => null,
                    "note" => [
                        "id" => $result,
                        "created_at" => $timeStamp,
                        "updated_at" => $timeStamp,
                        "content" => $request->input('content')
                    ]
                ]);
            } else {
                return response()->json([
                    "error" => $result
                ]);
            }
        } catch (Throwable $e) {
            return response()->json([
                "error" => $e
            ], 404);
        }

    }

    public function getPosts()
    {
        try {

            $result = DB::select("SELECT * FROM notes ORDER BY created_at DESC");

            if ($result) {
                return response()->json([
                    "error" => null,
                    "notes" =>
                        $result

                ]);
            } else {
                return response()->json([
                    "error" => $result
                ]);
            }
        } catch (Throwable $e) {
            return response()->json([
                "error" => $e
            ], 404);
        }
    }

    public function getPost($id)
    {
        try {
            $result = DB::select("SELECT * FROM notes WHERE id = " . $id);

            if (!empty($result)) {
                return response()->json([
                    "error" => null,
                    "notes" =>
                        $result

                ]);
            } else {
                return response()->json([
                    "error" => "Cet identifiant est inconnu"
                ], 404);
            }
        } catch (Throwable $e) {
            return response()->json([
                "error" => $e
            ], 404);
        }

    }

    public function updatePost(Request $request, $id)
    {
        try {
            $timeStamp = Carbon::now();
            $result = DB::table('notes')
                ->where('id', $id)
                ->update([
                    'content' => $request->input('content'),
                    'updated_at' => $timeStamp
                ]);

            $res = DB::table('notes')->where('id', $id)->first();

            if ($result) {

                return response()->json([
                    "error" => null,
                    "note" => [
                        "id" => $res->id,
                        "created_at" => $res->created_at,
                        "updated_at" => $res->updated_at,
                        "content" => $res->content
                    ]
                ]);
            } else {
                return response()->json([
                    "error" => "Cet identifiant est inconnu"
                ], 404);
            }

        } catch (Throwable $e) {
            return response()->json([
                "error" => $e
            ], 404);
        }

    }

    public function deletePost($id)
    {
        try {

            $result = DB::table('notes')->where('id', $id)->delete();

            if ($result) {
                return response()->json([
                    "error" => null
                ]);
            } else {
                return response()->json([
                    "error" => "Cet identifiant est inconnu"
                ], 404);
            }


        } catch (Throwable $e) {
            return response()->json([
                "error" => $e
            ], 404);
        }

    }
}
