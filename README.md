# サイト概要

MacroStock：http://ec2-54-250-176-179.ap-northeast-1.compute.amazonaws.com

MacroStock(マクロストック)はマクロ写真を専門としたフォトストックサイトです。

マクロ写真とは、植物や虫などの小さい物をカメラの機能を使って一枚の写真に大きく写し出す写真のことです。

普段、ブライダル写真を中心にプロのフォトグラファーとして仕事をしています。

あまり撮影することのないマクロ写真という領域の作品を残したいと思いこのサイトを作成しました。
![](https://github.com/webyoshinobu/macrostock_laravel_vue/blob/5a769de6d02711b8a0ae4adfd5d0cbcad267ec21/top_screenshot.png)

# 使用技術

## フロントエンド

・HTML

・CSS

・SCSS

・JavaScript

・Vue.js

・TypeScript

・Pinia

## バックエンド

・PHP

・Laravel

・SQL

・MySQL

## インフラ

・AWS

## 開発環境

・Docker/Docker-compose

・GitHub

# インフラ構成図

![](https://github.com/webyoshinobu/macrostock_laravel_vue/blob/753c7e01dc20de7369e185c1899fbc77b67e4f13/aws_diagram.png)

# ER 図

![](https://github.com/webyoshinobu/macrostock_laravel_vue/blob/3d3a02385e8d3de1949d42f902a5bd2f2c9ebfaa/er.png)

# 機能一覧

## 基本機能

・ギャラリー（販売画像一覧）

・ギャリーのページネーション機能

・販売画像個別画面

・利用規約

・画像をカートに追加（ユーザーのみ追加可能で、ログイン時のみ追加可能）

・カート内の確認

・画像の購入（ポートフォリオのため決済機能なし）

・画像を zip 形式でダウンロード（ユーザーのみダウンロード可能で、ログイン時のみダウンロード可能）

## ユーザー

・会員登録（ポートフォリオのためメール認証は未実装）

・ログイン/ログアウト

・マイページ

・メールアドレス変更（ポートフォリオのためメール認証は未実装）

・パスワード変更（ポートフォリオのためメール認証は未実装）

・注文履歴の確認

・領収証のダウンロード

・会員アカウント削除（退会）

## 管理者

・ログイン/ログアウト

・マイページ

・メールアドレス変更（ポートフォリオのためメール認証は未実装）

・パスワード変更（ポートフォリオのためメール認証は未実装）

・画像のアップロード

・アップロードした画像の一覧

・アップロードした画像の削除

・管理者アカウント削除（退会）
