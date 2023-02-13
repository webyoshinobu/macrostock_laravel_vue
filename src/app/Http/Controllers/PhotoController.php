<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\StorePhoto;
use App\Models\Photo;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use ZipArchive;
use Aws\CommandPool;
use Aws\S3\S3Client;

class PhotoController extends Controller
{
    public function __construct()
    {
        // 認証が必要
        // $this->middleware('auth')->except(['index', 'download']);
    }

    /**
     * 写真投稿
     * @param StorePhoto $request
     * @return \Illuminate\Http\Response
     */
    public function create(StorePhoto $request)
    {
        // 投稿写真の拡張子を取得する
        $extension = $request->photo->extension();

        $photo = new Photo();

        // インスタンス生成時に割り振られたランダムなID値と
        // 本来の拡張子を組み合わせてファイル名とする
        $photo->filename = $photo->id . '.' . $extension;
        $photo->price = 3000;

        // S3にファイルを保存する
        // 第三引数の'public'はファイルを公開状態で保存するため
        Storage::cloud()
            ->putFileAs('', $request->photo, $photo->filename, 'public');

        // データベースエラー時にファイル削除を行うため
        // トランザクションを利用する
        DB::beginTransaction();

        try {
            // Auth::user()->photos()->save($photo);
            Auth::guard('admin')->user()->photos()->save($photo);
            DB::commit();
        } catch (\Exception $exception) {
            DB::rollBack();
            // DBとの不整合を避けるためアップロードしたファイルを削除
            Storage::cloud()->delete($photo->filename);
            throw $exception;
        }

        // リソースの新規作成なので
        // レスポンスコードは201(CREATED)を返却する
        return response($photo, 201);
    }

    /**
    * 写真一覧
    */
    public function index()
    {
        $photos = Photo::with(['owner'])
            ->orderBy(Photo::CREATED_AT, 'desc')->paginate();

        return $photos;
    }

    // /**
    // * 写真ダウンロード
    // * @param Photo $photo
    // * @return \Illuminate\Http\Response
    // */
    // public function download(Photo $photo)
    // {
    //     Log::debug(print_r($photo, true));
    //     // 写真の存在チェック
    //     if (! Storage::cloud()->exists($photo->filename)) {
    //         abort(404);
    //     }

    //     $disposition = 'attachment; filename="' . $photo->filename . '"';
    //     $headers = [
    //         'Content-Type' => 'application/octet-stream',
    //         'Content-Disposition' => $disposition,
    //     ];

    //     // return response(Storage::cloud()->get($photo->filename), 200, $headers);
    //     return response(Storage::cloud()->get($photo->filename), 200, $headers);
    // }

    public function zipDownLoad(ZipArchive $zip)
    {
        // バケット
        $bucket = config('filesystems.disks.s3.bucket');
        // $imgDir = 'imgs'; //←恐らくs3上のバケットにフォルダ分けしていた場合の指定っぽい
        Log::debug(print_r($bucket, true));
        // Log::debug(print_r($imgDir, true));

        // 画像ファイル名
        $imgs = [
            'UW7wGfEa90ji.jpg',
            '627kl8iPOAHg.jpg',
            'cmxr2v1shLVU.jpg',
            // public_path().'/images/top_slide1.jpg',
            // public_path().'/images/top_slide2.jpg',
            // public_path().'/images/top_slide3.jpg',
        ];

        // S3Client
        $s3Client = new S3Client(
            [
                'version' => 'latest',
                'region' => config('filesystems.disks.s3.region'),
                'credentials' => [
                    'secret' => config('filesystems.disks.s3.secret'),
                    'key' => config('filesystems.disks.s3.key'),
                ],
            ]
        );
        // Log::debug(print_r($s3Client, true));

        // zipの保存先(あとで削除する)
        // $tmp = public_path() . '/tmp/';
        $tmp = storage_path() . '/app/tmp/';

        if(!file_exists($tmp)){
            if (!mkdir($tmp, 0777, true)){
                Log::info("{$tmp}ファイルの作成に失敗しました。");
                exit();
            }
        }

        try {
            // 現在の日付を取得
            $now = date('Ymd');
            $zipFileName = 'macrostock_'.$now.'.zip';
            $zipFilePath = $tmp . $zipFileName;
            $downloadPath = '/tmp/' . $zipFileName;
            Log::debug(print_r($zipFilePath, true));

            // 画像取得
            $commands = [];
            foreach ($imgs as $img) {
                // $key = $imgDir . $img;
                $key = $img;
                $commands[] = $s3Client->getCommand(
                    'GetObject',
                    [
                        'Bucket' => $bucket,
                        'Key' => $key,
                    ]
                );
            }

            $contents = CommandPool::batch($s3Client, $commands);

            // Log::debug(print_r($contents, true));

            if(!file_exists($zipFilePath)){
                Log::info('zipファイルの作成を開始');
                $zip = new ZipArchive();
                $res = $zip->open($zipFilePath, ZipArchive::CREATE);
                Log::debug(print_r($res, true));
                if ($res != TRUE) {
                    throw new Exception("open FALSE code:{$res}");
                    Log::info('zipファイルの作成に失敗しました。');
                }
                // $zip_content = [];
                // foreach($imgs as $img) {
                //     $zip->addFile($img);
                //     Log::info('zipファイルに画像を追加中');
                // }
                // Log::debug(print_r($zip, true));

                foreach ($contents as $i => $content) {
                    // 取得できなかったらS3Exceptionが格納されてる。
                    if (strpos(get_class($content), 'S3Exception') !== false) {
                        continue;
                    }

                    header("Content-Type: {$content['ContentType']}");

                    $zip->addFromString($imgs[$i], $content['Body']);
                }
                Log::debug(print_r($zip, true));

                if (!$zip->close()) {
                    Log::info('zipファイルの作成に失敗しました。');
                }
                // $zip->close();

                // レスポンスヘッダー
                mb_http_output("pass");

                // header("Content-Type: application/zip");
                // header("Content-Transfer-Encoding: Binary");
                // header('X-Content-Type-Options: nosniff');
                // header('Content-Disposition: attachment; filename="'.$zipFileName.'"');
                // header("Content-Disposition: ".rawurlencode($zipFileName));

                // $mimeType = Storage::mimeType($downloadPath);

                // 出力バッファを破棄
                ob_end_clean();

                $headers = [
                    'Content-Type' => 'application/zip',
                    // 'Content-Type' => $mimeType,
                    'Content-Transfer-Encoding' => 'Binary',
                    // 'Content-Disposition' => 'attachment; filename="'.$zipFileName.'"',
                    // 'Content-Disposition' => 'attachment'
                ];

                // readfile($zipFilePath);
                // unlink($zipFilePath);
                // exit;

                Log::debug(print_r($zipFilePath, true));
                Log::debug(print_r($zipFileName, true));
                Log::debug(print_r($headers, true));

                // 返却
                return response()
                    ->download($zipFilePath, $zipFileName, $headers)
                    ->deleteFileAfterSend(true);
            }
        }catch (Exception $e) {
            Log::error("zipの作成に失敗しました\n");
            exit;
        }
    }
}
