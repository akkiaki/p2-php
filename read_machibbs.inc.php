<?php
/*
    p2 - �܂�BBS�p�̊֐�
*/

require_once './p2util.class.php'; // p2�p�̃��[�e�B���e�B�N���X
require_once './filectl.class.php';

/**
 * �܂�BBS�� read.pl ��ǂ�� dat�ɕۑ�����
 */
function machiDownload()
{
    global $aThread;

    $GLOBALS['machi_latest_num'] = '';

    // {{{ ����dat�̎擾���X�����K�����ǂ�����O�̂��߃`�F�b�N
    if (file_exists($aThread->keydat)) {
        $dls = @file($aThread->keydat);
        if (sizeof($dls) != $aThread->gotnum) {
            // echo 'bad size!<br>';
            unlink($aThread->keydat);
            $aThread->gotnum = 0;
        }
    } else {
        $aThread->gotnum = 0;
    }
    // }}}
    
    if ($aThread->gotnum == 0) {
        $mode = 'wb';
        $START = 1;
    } else {
        $mode = 'ab';
        $START = $aThread->gotnum + 1;
    }

    // �܂�BBS
    $machiurl = "http://{$aThread->host}/bbs/read.pl?BBS={$aThread->bbs}&KEY={$aThread->key}&START={$START}";

    $tempfile = $aThread->keydat.'.html.temp';
    
    FileCtl::mkdir_for($tempfile);
    $machiurl_res = P2Util::fileDownload($machiurl, $tempfile);
    
    if ($machiurl_res->is_error()) {
        $aThread->diedat = true;
        return false;
    }
    
    $mlines = @file($tempfile);
    
    // �ꎞ�t�@�C�����폜����
    if (file_exists($tempfile)) {
        unlink($tempfile);
    }

    // �i�܂�BBS�j<html>error</html>
    if (trim($mlines[0]) == '<html>error</html>') {
        $aThread->getdat_error_msg_ht .= 'error';
        $aThread->diedat = true;
        return false;
    }
    
    // {{{ DAT����������
    if ($mdatlines =& machiHtmltoDatLines($mlines)) {
        
        $fp = @fopen($aThread->keydat, $mode) or die("Error: $aThread->keydat ���X�V�ł��܂���ł���");
        @flock($fp, LOCK_EX);
        for ($i = $START; $i <= $GLOBALS['machi_latest_num']; $i++) {
            if ($mdatlines[$i]) {
                fputs($fp, $mdatlines[$i]);
            } else {
                fputs($fp, "���ځ[��<>���ځ[��<>���ځ[��<>���ځ[��<>\n");
            }
        }
        @flock($fp, LOCK_UN);
        fclose($fp);
    }
    // }}}
    
    $aThread->isonline = true;
    
    return true;
}


/**
 * �܂�BBS��read.pl�œǂݍ���HTML��dat�ɕϊ�����
 *
 * @see machiDownload()
 */
function &machiHtmltoDatLines(&$mlines)
{
    if (!$mlines) {
        return false;
    }
    $mdatlines = "";
    
    foreach ($mlines as $ml) {
        $ml = rtrim($ml);
        if (!$tuduku) {
            unset($order, $mail, $name, $date, $ip, $body);
        }

        if ($tuduku) {
            if (preg_match("/^ \]<\/font><br><dd>(.*) <br><br>$/i", $ml, $matches)) {
                $body = $matches[1];
            } else {
                unset($tuduku);
                continue;
            }
        } elseif (preg_match("/^<dt>(?:<a[^>]+?>)?(\d+)(?:<\/a>)? ���O�F(<font color=\"#.+?\">|<a href=\"mailto:(.*)\">)<b> (.+) <\/b>(<\/font>|<\/a>) ���e���F (.+)<br><dd>(.*) <br><br>$/i", $ml, $matches)) {
            $order = $matches[1];
            $mail = $matches[3];
            $name = preg_replace("/<font color=\"?#.+?\"?>(.+)<\/font>/i", "\\1", $matches[4]);
            $date = $matches[6];
            $body = $matches[7];
        } elseif (preg_match('{<title>(.*)</title>}i', $ml, $matches)) {
            $mtitle = $matches[1];
            continue;
        } elseif (preg_match("/^<dt>(?:<a[^>]+?>)?(\d+)(?:<\/a>)? ���O�F(<font color=\"#.+?\">|<a href=\"mailto:(.*)\">)<b> (.+) <\/b>(<\/font>|<\/a>) ���e���F (.+) <font size=1>\[ (.+)$/i", $ml, $matches)) {
            $order = $matches[1];
            $mail = $matches[3];
            $name = preg_replace('{<font color="?#.+?"?>(.+)</font>}i', '$1', $matches[4]);
            $date = $matches[6];
            $ip = $matches[7];
            $tuduku = true;
            continue;
        }
        
        if ($ip) {
            $date = "$date [$ip]";
        }

        // �����N�O��
        $body = preg_replace('{<a href="(https?://[-_.!~*\'()a-zA-Z0-9;/?:@&=+\$,%#]+)" target="_blank">(https?://[-_.!~*\'()a-zA-Z0-9;/?:@&=+\$,%#]+)</a>}i', '$1', $body);

        if ($order == 1) {
            $datline = $name.'<>'.$mail.'<>'.$date.'<>'.$body.'<>'.$mtitle."\n";
        } else {
            $datline = $name.'<>'.$mail.'<>'.$date.'<>'.$body.'<>'."\n";
        }
        $mdatlines[$order] = $datline;
        if ($order > $GLOBALS['machi_latest_num']) {
            $GLOBALS['machi_latest_num'] = $order;
        }
        unset($tuduku);
    }
    
    return $mdatlines;
}

?>