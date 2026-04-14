# shogaisha.

> この星で障害者（それに類するもの、handicappedなど）とよばれる人たちの声のサイト

https://shogaisha.wiki

24時間テレビ的な「感動する障害者」像へのカウンター。当事者が怒り・皮肉・暴露・ぼやきをフラットに書ける場所。

---

## 機能

- **記事投稿・編集** — Tiptapリッチテキストエディタ
- **追記（entry）** — 記事末尾にぼやき・反論・共感を書き足せる
- **AI代筆** — 断片的なメモをClaude APIで自然な文章に整形
- **音声入力** — Web Speech APIで話しかけて入力
- **ふりがな切り替え** — MeCabで自動ルビ付与、トグルで表示/非表示
- **マジックリンク認証** — パスワード不要、メールアドレスだけで登録

## 技術スタック

| カテゴリ | 使用技術 |
|---|---|
| バックエンド | Laravel |
| フロントエンド | Tailwind CSS, Vanilla JS |
| エディタ | Tiptap |
| フォント | BIZ UDGothic |
| ルビ | MeCab |
| AI | Claude Sonnet API (Anthropic) |
| 認証 | 自前マジックリンク実装 |
| DB | SQLite |

## セットアップ

```bash
composer install
npm install && npm run build
cp .env.example .env
php artisan key:generate
php artisan migrate
```

`.env` に以下を設定：

```
ANTHROPIC_API_KEY=
RESEND_API_KEY=
MAIL_FROM_ADDRESS=
APP_URL=
```

## 認証について

Sanctumではなくトークンテーブルによるマジックリンクを自前実装しています。
登録・ログインはメールアドレスのみ、パスワード不要です。

登録できるのは障害者・家族・支援者・医療福祉従事者に限ります（自己申告）。

## コンテンツポリシー

**削除しない：** 優生思想批判・怒り・暴露・汚い言葉

**削除する：** 特定個人の個人情報・児童性的表現・スパム
