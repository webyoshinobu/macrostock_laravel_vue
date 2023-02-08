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
        $imgDir = 'imgs';

        // 画像ファイル名
        $imgs = [
            'UW7wGfEa90ji.jpg',
            '627kl8iPOAHg.jpg',
            'cmxr2v1shLVU.jpg',
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

        // zipファイル名と保存先(あとで削除する)
        $zipFileName = 'test.zip';
        $zipFilePath = public_path() . '/' . $zipFileName;

        // レスポンスヘッダー
        $headers = ['Content-Type' => 'application/zip'];

        // 画像取得
        $commands = [];
        foreach ($imgs as $img) {
            $key = $imgDir . $img;
            $commands[] = $s3Client->getCommand(
                'GetObject',
                [
                    'Bucket' => $bucket,
                    'Key' => $key,
                ]
            );
        }

        $contents = CommandPool::batch($s3Client, $commands);

        // zipファイル作成
        $zip->open($zipFilePath, ZipArchive::CREATE | ZipArchive::OVERWRITE);

        foreach ($contents as $i => $content) {
            // 取得できなかったらS3Exceptionが格納されてる。
            if (strpos(get_class($content), 'S3Exception') !== false) {
                continue;
            }

            $zip->addFromString($imgs[$i], $content['Body']);
        }

        $zip->close();

        // おまじない
        ob_end_clean();

        // 返却
        return response()
                ->download($zipFilePath, $zipFileName, $headers)
                ->deleteFileAfterSend(true);
    }
}
