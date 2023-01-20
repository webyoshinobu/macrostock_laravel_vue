<!DOCTYPE html>
<html lang="ja">
<head>
    <!-- ①基本的metaタグ -->
    <meta charset="UTF-8">
    <!-- IEで常に標準モードで表示させる -->
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- ↓ 公開前は検索エンジンにインデックスさせず、他のページの巡回を促す。-->
    <meta name="robots" content="noindex,nofollow">
    <!-- 電話番号の自動リンク化を無効 -->
    <meta name="format-detection" content="telephone=no">

    <!-- ②SEO対策の補助的措置 -->
    <!-- サイトのタイトル -->
    <title>MacroStock</title>
    <!-- キーワード -->
    <meta name="keywords" content="ストックフォトサイト,マクロ写真,画像素材">
    <!-- サイトの説明 -->
    <meta name="description" content="マクロ写真専門ストックフォトサイト。高画質のマクロ写真のみを画像素材として販売しているストックフォトサイトです。">
    <!-- 重複するURLを一本化 -->
    <!-- ↓ URL確定したら修正 -->
    <link rel="canonical" href="正規化するURL">

    <!-- ③SNS対策 -->
    <!-- ↓ URL確定したら修正 -->
    <meta property="og:url" content="ページのURLを書きます。">
    <meta property="og:title" content="MacroStock">
    <meta property="og:type" content="website">
    <meta property="og:description" content="マクロ写真専門ストックフォトサイト。高画質のマクロ写真のみを画像素材として販売しているストックフォトサイトです。">
    <!-- ↓仮の画像を設置中 -->
    <meta property="og:image" content="img/20210623-2.jpg">
    <meta name="twitter:card" content="summary_large_image">
    <link rel="icon" href="../../images/favicon.png">

    <!-- <script src="{{ asset('js/app.js') }}" defer></script>
    <script src="{{ mix('js/swiper.js') }}"></script> -->

    <!-- vueでcsrfを使うためのcsrf-token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>MacroStock</title>
</head>
<body>
    <div id="app"></div>
    <script src="{{ asset('js/app.js') }}" defer></script>
    <script src="{{ mix('js/swiper.js') }}"></script>
</body>
</html>
