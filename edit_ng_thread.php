<?php
/*
    p2 - NGスレッドインタフェース
*/

include_once './conf/conf.inc.php';
require_once P2_LIB_DIR . '/wiki/NgThreadCtl.php';

$_login->authorize(); // ユーザ認証

if (!empty($_POST['submit_save']) || !empty($_POST['submit_default'])) {
    if (!isset($_POST['csrfid']) || $_POST['csrfid'] != P2Util::getCsrfId()) {
        die('p2 error: 不正なポストです');
    }
}

$ngThreadCtl = new NgThreadCtl();

//=====================================================================
// 前処理
//=====================================================================

// {{{ ■保存ボタンが押されていたら、設定を保存

if (!empty($_POST['submit_save'])) {

    if ($ngThreadCtl->save($POST['nga']) != false) {
        $_info_msg_ht .= '<p>○設定を更新保存しました</p>';
    } else {
        $_info_msg_ht .= '<p>×設定を更新保存できませんでした</p>';
    }

// }}}
// {{{ ■デフォルトに戻すボタンが押されていたら

} elseif (!empty($_POST['submit_default'])) {
    if ($ngThreadCtl->clear()) {
        $_info_msg_ht .= '<p>○リストを空にしました</p>';
    } else {
        $_info_msg_ht .= '<p>×リストを空にできませんでした</p>';
    }
}

// }}}
// {{{ リスト読み込み

$formdata = $ngThreadCtl->load();

// }}}

//=====================================================================
// プリント設定
//=====================================================================
$ptitle_top = 'NGスレッド編集';
$ptitle = strip_tags($ptitle_top);

$csrfid = P2Util::getCsrfId();

//=====================================================================
// プリント
//=====================================================================
// ヘッダHTMLをプリント
P2Util::header_nocache();
echo $_conf['doctype'];
echo <<<EOP
<html lang="ja">
<head>
    {$_conf['meta_charset_ht']}
    <meta name="ROBOTS" content="NOINDEX, NOFOLLOW">
    <meta http-equiv="Content-Style-Type" content="text/css">
    <meta http-equiv="Content-Script-Type" content="text/javascript">
    <title>{$ptitle}</title>\n
EOP;

if (!$_conf['ktai']) {
    echo <<<EOP
    <script type="text/javascript" src="js/basic.js?{$_conf['p2expack']}"></script>
    <link rel="stylesheet" href="css.php?css=style&amp;skin={$skin_en}" type="text/css">
    <link rel="stylesheet" href="css.php?css=edit_conf_user&amp;skin={$skin_en}" type="text/css">
    <link rel="shortcut icon" href="favicon.ico" type="image/x-icon">\n
EOP;
}

$body_at = ($_conf['ktai']) ? $_conf['k_colors'] : ' onLoad="top.document.title=self.document.title;"';
echo <<<EOP
</head>
<body{$body_at}>\n
EOP;

// PC用表示
if (!$_conf['ktai']) {
    echo <<<EOP
<p id="pan_menu"><a href="editpref.php">設定管理</a> &gt; {$ptitle_top}</p>\n
EOP;
} else {
    echo basename($path) . "<br>";
}

// PC用表示
if (!$_conf['ktai']) {
    $htm['form_submit'] = <<<EOP
        <tr class="group">
            <td colspan="7" align="center">
                <input type="submit" name="submit_save" value="変更を保存する">
                <input type="submit" name="submit_default" value="リストを空にする" onClick="if (!window.confirm('リストを空にしてもよろしいですか？（やり直しはできません）')) {return false;}"><br>
            </td>
        </tr>\n
EOP;
// 携帯用表示
} else {
    $htm['form_submit'] = <<<EOP
<input type="submit" name="submit_save" value="変更を保存する"><br>\n
EOP;
}

// 情報メッセージ表示
if (!empty($_info_msg_ht)) {
    echo $_info_msg_ht;
    $_info_msg_ht = "";
}

$usage = <<<EOP
<ul>
<li>×: 削除</li>
<li>ワード: NG/あぼーんワード (空にすると登録解除)</li>
<li>i: 大文字小文字を無視</li>
<li>re: 正規表現</li>
<li>板: newsplus,software 等 (完全一致, カンマ区切り)</li>
</ul>
EOP;
if ($_conf['ktai']) {
    $usage = mb_convert_kana($usage, 'k');
}
echo <<<EOP
{$usage}
<form method="POST" action="{$_SERVER['SCRIPT_NAME']}" target="_self" accept-charset="{$_conf['accept_charset']}">
    {$_conf['k_input_ht']}
    <input type="hidden" name="detect_hint" value="◎◇　◇◎">
    <input type="hidden" name="path" value="{$path_ht}">
    <input type="hidden" name="csrfid" value="{$csrfid}">\n
EOP;

// PC用表示（table）
if (!$_conf['ktai']) {
    echo <<<EOP
    <table class="edit_conf_user" cellspacing="0">
        <tr>
            <td align="center">×</td>
            <td align="center">ワード</td>
            <td align="center">i</td>
            <td align="center">re</td>
            <td align="center">板</td>
            <td align="center">最終ヒット日時と回数</td>
        </tr>
        <tr class="group">
            <td colspan="6">新規登録</td>
        </tr>\n
EOP;
    $row_format = <<<EOP
        <tr>
            <td><input type="checkbox" name="nga[%1\$d][del]" value="1"></td>
            <td><input type="text" size="35" name="nga[%1\$d][word]" value="%2\$s"></td>
            <td><input type="checkbox" name="nga[%1\$d][ignorecase]" value="1"%3\$s></td>
            <td><input type="checkbox" name="nga[%1\$d][regex]" value="1"%4\$s></td>
            <td><input type="text" size="10" name="nga[%1\$d][bbs]" value="%5\$s"></td>
            <td align="right">
                <input type="hidden" name="nga[%1\$d][hits]" value="%6\$s">%6\$s
                <input type="hidden" name="nga[%1\$d][lasttime]" value="%7\$d">(%7\$d)
            </td>
        </tr>\n
EOP;
// 携帯用表示
} else {
    echo "新規登録<br>\n";
    $row_format = <<<EOP
<input type="text" name="nga[%1\$d][word]" value="%2\$s"><br>
板:<input type="text" size="5" name="nga[%1\$d][bbs]" value="%5\$s">
<input type="checkbox" name="nga[%1\$d][ignorecase]" value="1"%3\$s>i
<input type="checkbox" name="nga[%1\$d][regex]" value="1"%4\$s>re
<input type="text" name="nga[%1\$d][del]" value="1">×<br>
<input type="hidden" name="nga[%1\$d][lasttime]" value="%6\$s">
<input type="hidden" name="nga[%1\$d][hits]" value="%7\$d">(%6\$d)<br>\n
EOP;
}

printf($row_format, -1, '', '', '', '', '--', 0);

echo $htm['form_submit'];
if (!empty($formdata)) {
    foreach ($formdata as $k => $v) {
        printf($row_format,
            $k,
            p2h($v['word']),
            $v['ignorecase'],
            $v['regex'],
            p2h($v['bbs']),
            p2h($v['lasttime']),
            p2h($v['hits'])
        );
    }
    echo $htm['form_submit'];
}

// PCなら
if (!$_conf['ktai']) {
    echo '</table>'."\n";
}

echo '</form>'."\n";

// 携帯なら
if ($_conf['ktai']) {
    echo <<<EOP
<hr>
<a {$_conf['accesskey']}="{$_conf['k_accesskey']['up']}" href="editpref.php{$_conf['k_at_q']}">{$_conf['k_accesskey']['up']}.設定編集</a>
{$_conf['k_to_index_ht']}
EOP;
}

echo '</body></html>';

// ここまで
exit;
