<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
// use setasign\Fpdi\TcpdfFpdi;
use setasign\Fpdi\Tcpdf\Fpdi;
use TCPDF_FONTS;
use Illuminate\Support\Facades\Log;

class PdfController extends Controller
{
    public function createPdf(Request $request)
    {
        //all()で通信情報の取得（URLやHTTP動詞など）以外の注文情報のみ取得
        $data = $request->all();

        // $pdf = new TcpdfFpdi();
        $pdf = new Fpdi();

        $pdf->setPrintHeader(false);
        $pdf->setPrintFooter(false);
        $pdf->SetAutoPageBreak(false);
        $pdf->SetMargins(0, 0, 0);
        $pdf->addPage();

        // テンプレートを読み込む
        $template_path = resource_path('pdf/macrostock_receipt.pdf');
        $pdf->setSourceFile($template_path);
        $page = $pdf->importPage(1);
        $pdf->useTemplate($page);

        // フォントを設定（MS明朝）
        // $tcpdf_fonts = new TCPDF_FONTS();
        // $font = $tcpdf_fonts->addTTFfont(resource_path('fonts/msmincho.ttf'));
        // $pdf->SetFont('kozgopromedium', '', 24);

        // テキストを出力
        // $pdf->SetXY(100, 50);
        // $pdf->Write(0, 'テスト');

        $y = 165;
        $x = 37;

        //-----------------
        //共通部分
        //-----------------
        foreach($data as $obj) {
            $order_date = $obj['created_at'];
            $receipt_no = $obj['id'];
            $user_name = $obj['user_name'];
            $total_amount = $obj['orders_table_total_amount'];
        }

        //領収書No.
        $pdf->SetFont('kozminproregular', '', 10);
        $order_date = date('Ymd',  strtotime($order_date));
        $pdf->text(170, 47, $order_date.'-'.$receipt_no);

        //発行日
        $today = date('Y/m/d');
        $pdf->SetFont('kozminproregular', '', 10);
        $pdf->text(170, 53.3, $today);

        //合計金額
        $pdf->SetFont('kozminproregular', '', 22);
        $pdf->text(70, 94, '￥'.htmlspecialchars(number_format($total_amount)));

        //御中
        $pdf->SetFont('kozminproregular', '', 24);
        $pdf->text(26, 67, $user_name);

        //但し書き
        $pdf->SetFont('kozminproregular', '', 10);
        $pdf->Text(40, 106, '写真代として' );

        //----------------
        //発行者
        //----------------
        //郵便番号
        $pdf->SetFont('kozminproregular', '', 11);
        $pdf->Text(134, 85, '000-0000' );
        //住所1
        $pdf->SetFont('kozminproregular', '', 11);
        $pdf->Text(134, 91, '北海道札幌市中央区' );
        //住所2
        $pdf->SetFont('kozminproregular', '', 11);
        $pdf->Text(134, 97, '南○条○丁目〇〇-〇〇' );
        //会社名
        $pdf->SetFont('kozminproregular', '', 20);
        $pdf->Text(134, 106, 'Macro Stock' );
        //電話番号
        $pdf->SetFont('kozminproregular', '', 11);
        $pdf->Text(136, 138.4, '011-123-4567' );

        //-----------------
        // 明細箇所
        //-----------------
        $y = 165;
        $x = 37;
        foreach($data as $i => $row) {
            $pdf->SetXY($x, $y);
            $pdf->Text($x, $y, $row['filename']);
            $pdf->Text($x+77.5, $y, htmlspecialchars($row['orders_details_table_total_number']));
            $pdf->Text($x+87, $y, '枚');
            $pdf->Text($x+105, $y, htmlspecialchars(number_format($row['price'])));
            $pdf->Text($x+142, $y, number_format($row['price']));

            $y += 6.5;
        }

        $subtotal = 0;
        foreach($data as $item){
            $subtotal += $item['price'];
            $order_total_amount = $item['orders_table_total_amount'];
        }
        $tax = $subtotal * 0.1;

        // 小計
        $pdf->SetFont('kozminproregular', '', 10);
        $pdf->Text(179, 244, htmlspecialchars( number_format($subtotal) ) );

        // 消費税
        $pdf->SetFont('kozminproregular', '', 10);
        $pdf->Text(182, 257, htmlspecialchars( number_format($tax) ) );

        //合計金額
        $pdf->SetFont('kozminproregular', '', 10);
        $pdf->Text(179, 264, htmlspecialchars( number_format($order_total_amount)));

        ob_end_clean();
        // PDFをS3に保存←とりあえず保存しないように実装中
        // $content = $pdf->Output('test.pdf', 'I');
        return $pdf->Output('test.pdf', 'I');
        // Storage::disk('s3')->put('test.pdf', $content, 'private');
    }
}
