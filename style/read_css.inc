<?php
/**
 * rep2 - �X�^�C���ݒ�
 * for read.php
 */

if (!isset($STYLE['respop_bgcolor']))    { $STYLE['respop_bgcolor'] = '#ffffcc'; }
if (!isset($STYLE['respop_background'])) { $STYLE['respop_background'] = ''; }
$respop_background = "background:{$STYLE['respop_bgcolor']} {$STYLE['respop_background']};";

if (!isset($STYLE['respop_b_style'])) { $STYLE['respop_b_style'] = 'solid'; }
if (!isset($STYLE['respop_b_width'])) { $STYLE['respop_b_width'] = '1px';   }
if (!isset($STYLE['respop_b_color'])) { $STYLE['respop_b_color'] = '#aa7'; }
$respop_border = "border:{$STYLE['respop_b_style']} {$STYLE['respop_b_width']} {$STYLE['respop_b_color']};";

if (isset($STYLE['respop_color']) && strlen($STYLE['respop_color']) > 0) {
    $respop_color = "color: {$STYLE['respop_color']};";
} else {
    $respop_color = '';
}

if (!empty($STYLE['fontfamily_bold'])) {
    $fontstyle_bold = empty($STYLE['fontstyle_bold']) ? 'normal' : $STYLE['fontstyle_bold'];
    $fontweight_bold = empty($STYLE['fontweight_bold']) ? 'normal' : $STYLE['fontweight_bold'];
    echo <<<EOSTYLE

h3, h4 {
	font-family:"{$STYLE['fontfamily_bold']}";
	font-style: {$fontstyle_bold};
	font-weight: {$fontweight_bold};
}

EOSTYLE;
}

echo <<<EOSTYLE

body{
	background:{$STYLE['read_bgcolor']} {$STYLE['read_background']};
	line-height:130%;
	color:{$STYLE['read_color']};
}
body, td{
	font-size:{$STYLE['read_fontsize']};
}

a:link{color:{$STYLE['read_acolor']};}
a:visited{color:{$STYLE['read_acolor_v']};}
a:hover{color:{$STYLE['read_acolor_h']};}

h3.thread_title {
	margin: 6px 0;
	line-height:120%;
	font-size: 18px;
	color: {$STYLE['read_thread_title_color']};
}
h4.thread_title {
	margin: 0 0 12px 0;
	line-height:100%;
	font-size: 14px;
	color: {$STYLE['read_thread_title_color']};
}

.thre_title{color:{$STYLE['read_thread_title_color']};}
.name{color:{$STYLE['read_name_color']};} /* ���e�҂̖��O */
.mail{color:{$STYLE['read_mail_color']};} /* ���e�҂�mail */
.sage{color:{$STYLE['read_mail_sage_color']};} /* ���e�҂�mail(sage) */

/* �摜URL�̐�ǂ݃T���l�C��*/
img.thumbnail {
	/*border-color: inherit;*/
	border-color: {$STYLE['read_color']};
	border-style: solid;
	border-width: 1px;
}
a img.thumbnail {
	border-color: {$STYLE['read_acolor']};
}

div.thread {
	margin: 0;
	padding: 1.0em 0 0 0;
}

/* ���X */
div.res {
	margin: 0 0 2.0em 0;
	padding: 0;
    width: 100%;
    /*\*//*/
    overflow: hidden;
    /**/

}
div.res:after {
    height: 0;
    visibility: hidden;
    content: ".";
    display: block;
    clear: both;
}

/* ���p���X�|�b�v�A�b�v */
div.respopup {
	position: absolute;
	visibility: hidden; /* ���i�͉B���Ă���*/
	{$respop_background}
	{$respop_border}
	{$respop_color}
	font-size:{$STYLE['respop_fontsize']};
	margin: 0;
	padding: 8px;
	line-height: 120%;
	top: 0px;
	-moz-box-shadow: 4px 4px 16px #555;
	-webkit-box-shadow: 4px 4px 16px #555;
	box-shadow: 4px 4px 16px #555;
}

/* ���ځ[�񃌃X */
div.res.aborned {
	margin: 0;
	padding: 0;
	font-size: xx-small;
	line-height: 100%;
}

div.res.aborned * {
	display: none;
}

/* ���X�w�b�_ */
div.res-header {
	margin: 0;
	padding: 0;
}

/* ���X�{�f�B (�ʏ�) */
div.res div.message {
	margin: 0 0 0 2.5em;
	padding: 2px 0 0 0;
}

/* ���X�{�f�B (���p���X�|�b�v�A�b�v) */
div.respopup div.message {
	margin: 0 0 0 2.5em;
	padding: 2px 0 0 0;
}

/* ���X�{�f�B�������N�̐܂�Ԃ� */
div.message a {
	word-wrap: break-word;
	word-break: break-all;
}

.onthefly{ /* on the fly */
	color:#0a0;
	border:1px #0a0 solid;
	padding:2px;
	font-size:11px;
}
.ontheflyresorder{
	color:#0a0;
}

.ngword, .stripped {
	text-decoration: line-through;
	color: {$STYLE['read_ngword']};
}

span.ngword {
	cursor: pointer;
}

div.ngmsg {
	display: none;
}

.nganchor {
	text-decoration: line-through;
}

.abornanchor {
	text-decoration: line-through;
	color: {$STYLE['read_ngword']};
}

span.abornanchor {
	cursor: pointer;
}

#iframespace{ /* HTML�|�b�v�A�b�v�X�y�[�X */
	position:absolute;
	z-index:100;
	/*border:solid 1px;*/
}

#closebox{
	width:14px;
	height:14px;
	position:absolute;
	z-index:101;
	border:solid 2px;
	padding:1px;
	line-height:100%;
	background-color:#ceddf7;
}

div#kakiko{
	display:none;
}

/* ���X�̂��΂₳ */
span.spd{
	font-size:8pt;
	color:#777;
}

a.resnum:link, a.resnum:visited, a.resnum:hover, a.resnum:active{ /* ���X�ԍ� */
	color: {$STYLE['read_color']};
	text-decoration: none;
}

a.newres:link, a.newres:visited, a.newres:hover, a.newres:active{ /* �V�����X */
	color: {$STYLE['read_newres_color']};
	text-decoration: none;
}

/* {{{ �A�N�e�B�u���i�[ */

.aMonaSW {
	cursor: pointer;
}

.ActiveMona {
	white-space: nowrap;
	line-height: 100%;
	font-family: "{$_conf['expack.am.fontfamily']}";
	font-size: {$_conf['expack.am.fontsize']};
}

.NoMona {
	white-space: normal;
	line-height: 130%;
	font-family: "{$STYLE['fontfamily']}";
	font-size: {$STYLE['read_fontsize']};
}

.NoMonaQ {
	white-space: normal;
	line-height: 120%;
	font-family: "{$STYLE['fontfamily']}";
	font-size: {$STYLE['respop_fontsize']};
}

/* }}}*/
/* {{{ �X�}�[�g�|�b�v�A�b�v���j���[ */

.spmSW {
	cursor: pointer;
}

.spm {
	position: absolute;
	visibility: hidden; /* ���i�͉B���Ă���*/
	{$respop_background}
	{$respop_border}
	{$respop_color}
	font-size: {$STYLE['respop_fontsize']};
	line-height: 150%;
	width: 8.5em;
	margin: 0px;
	padding: 2px 4px;
	-moz-box-shadow: 4px 4px 16px #555;
	-webkit-box-shadow: 4px 4px 16px #555;
	box-shadow: 4px 4px 16px #555;
}

.spm p {	/* �X�}�[�g�|�b�v�A�b�v���j���[�F�w�b�_ */
	white-space: nowrap;
	margin: 2px;
	padding: 0px;
	border-bottom: {$STYLE['respop_b_width']} {$STYLE['respop_b_color']} {$STYLE['respop_b_style']};
	vertical-align: middle;
}

.spm a {	/* �X�}�[�g�|�b�v�A�b�v���j���[�F�����N */
	display: block;
	white-space: nowrap;
	margin: 2px -4px;
	padding: 0px 4px;
	vertical-align: middle;
	text-decoration: none;
}
.spm a:hover {
	background: {$STYLE['read_bgcolor']} {$STYLE['read_background']};
}
.spm a.closemenu {
	text-align: right;
}

.spm a.closebox {	/* �X�}�[�g�|�b�v�A�b�v���j���[�F�N���[�Y�{�b�N�X */
	position: absolute;
	top: 0;
	right: 0;
	width: 14px;
	height: 14px;
	margin: {$STYLE['respop_b_width']};
	padding: 1px;
	border: {$STYLE['respop_b_style']} 1px {$STYLE['respop_b_color']};
}

.highlight {
    background-color: {$STYLE['respop_bgcolor']};
}

/* }}} */

/* �t�Q�ƃ��X�g �c�z�u (�ʏ�) */
div.res div.v_reslist {
    float: left;
    width: 3.5em;
    font-size:70%;
    padding: 0.2em 0 0 0;
    margin: 0;
}
div.res div.v_reslist ul {
    list-style-type: none;
    line-height: 0.75;
    margin: 0;
    padding: 0;
}
div.res div.v_reslist ul li:first-letter {
    color: #777;
}

/* �t�Q�ƃ��X�g �c�z�u (���p���X�|�b�v�A�b�v) */
div.respopup div.v_reslist {
    float: left;
    width: 3.5em;
    font-size:70%;
    padding: 0.2em 0 0 0;
    margin: 0;
}
div.respopup div.v_reslist ul {
    list-style-type: none;
    line-height: 0.75;
    margin: 0;
    padding: 0;
}
div.respopup div.v_reslist ul li:first-letter {
    color: #777;
}

/* �t�Q�ƃ��X�g �����z�u(�ʏ�) */
div.res div.reslist {
	position:relative;
    margin : 0 0 0 1.5em;
}

/* �t�Q�ƃ��X�g �����z�u(���p���X�|�b�v�A�b�v)  */
div.respopup div.reslist {
}

.preview-video-switch {
	cursor: pointer;
}

/* �c�[���o�[ */
table.toolbar {
	width: 100%;
	margin: 0;
	padding: 0 10px 0 0;
}

table.toolbar td.lblock {
	text-align: left;
} 

table.toolbar td.cblock {
	text-align: center;
} 

table.toolbar td.rblock {
	text-align: right;
} 

div.reslist_inner {
	position:relative;
//	margin:0 0 0 17px;
	
}

blockquote.folding_container{
	margin:0;
	padding: 8px;
}

blockquote.folding_container:after {
	height: 0;
	visibility: hidden;
	content: ".";
	display: block;
	clear: both;
}

div.resblock {
    margin: 0.5em 0 0 0;
}

div.resblock div.resblock_inner {
	margin: 0 0 0 2em;
	line-height: 120%;
	{$respop_background}
	{$respop_border}
	{$respop_color}
	font-size:{$STYLE['respop_fontsize']};
	-moz-box-shadow: 2px 2px 2px #999;
	-webkit-box-shadow: 2px 2px 2px #999;
	box-shadow: 2px 2px 2px #999;
}

.readmessage {
	color: #606060;
	font-style: italic;
}

EOSTYLE;

/*
 * Local Variables:
 * mode: php
 * coding: cp932
 * tab-width: 4
 * c-basic-offset: 4
 * indent-tabs-mode: nil
 * End:
 */
// vim: set syn=php fenc=cp932 ai et ts=4 sw=4 sts=4 fdm=marker: