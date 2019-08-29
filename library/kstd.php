<?php

#　@(f)
#
#　機能　	：	ブラウザ引数文字コード変換処理
#
#　引数　	：	変換文字コード
#
#　返り値	：	なし
#
#　機能説明　	：	ブラウザからの文字列を初期化する
#
#　備考　	：	自作になりました(^^ ;

function Init_Form($charcode = "") {

	$method = getenv("REQUEST_METHOD");
	$OBJ = array();

	if($method == "GET") {
		$OBJ = $_GET;
	} elseif($method == "POST") {
		$OBJ = $_POST;
	}

	while(list($key,$val) = each($OBJ)) {

		if($charcode == "euc") {
			$val = JE($val);
		}

		$GLOBALS[$key] = $val;

	}

}

#　@(f)
#
#　機能　	：	ファイル読込処理
#
#　引数　	：	$fname	---	ファイル名（パス抜き）
#			$way	---	オプション 
#					(1)文字列で返す
#					(2)配列で返す
#
#　返り値	：	ファイルの文字列
#
#　機能説明　	：	ファイルデータを読み込んで返す
#
#　備考　	：	文字コード変換をしないで返す

function ReadFileData($fname,$way) {

	if(!file_exists($fname)) {
		return "";
	}

	if($way == 1) {
		return join('',file($fname));
	} else if($way == 2) {
		$x = array();
		$x = file($fname,"r");
		return $x;
	} else if($way == 3) {
		return join('',file($fname));
	}


}

#　@(f)
#
#　機能　	：	ファイル書込処理
#
#　引数　	：	$fname		---	ファイル名（パス抜き）
#			$way		---	オプション 
#						(1)各文字列配列に改行を付加して書き込む 
#						(2)各文字列配列をそのまま書き込む 
#						(3)文字列をそのまま書き込む 
#			$strline 	---	文字列変数
#			$strArray	---	文字列配列 
#
#　返り値	：	なし
#
#　機能説明　	：	ファイルデータに引数の文字列または文字列配列を書き込む
#
#　備考　	：	文字コード変換をしないで書き込む

function RecordFileData($fname = "",$way = "",$strline = "",$strArray = "") {
	
	if($way == 1) {

		for($i = 0; $i < sizeof(); $i++) {
			$strtmp .= $strArray[$i] . "\n";
		}

		$fp = fopen($fname, "w");
		fputs($fp,$strtmp);
		fclose($fp);
	} elseif($way == 2) {
		$fp = fopen($fname, "w");
		$strtmp = join("",$strArray);
		fputs($fp,$strtmp);
		fclose($fp);
	} elseif($way == 3) {
		$fp = fopen($fname, "w");
		fputs($fp,$strline);
		fclose($fp);
	} elseif($way == 4) {
		$fp = fopen($fname, "a");
		fputs($fp,$strline);
		fclose($fp);
	}

	return;
}


#　@(f)
#
#　機能　	：	サーバー時刻を取得する
#
#　引数　	：	なし
#
#　返り値	：	年月日時分秒文字列
#
#　機能説明　	：	現在の日付・時間を":"くぎりで返す
#
#　備考　	：	日本と海外では時間が違うので要注意

function GetDateString() {
	$d = getdate();

	$sec 	= $d["seconds"];
	$min 	= $d["minutes"];
	$hour 	= $d["hours"];
	$mday 	= $d["mday"];
	$wday 	= $d["wday"];
	$mon 	= $d["mon"];
	$year 	= $d["year"];
	$yday 	= $d["yday"];
	$weekday = $d["weekday"];
	$month 	= $d["month"];
	$mon++;
		
	if($sec < 10) {$sec = "0$sec";};
	if($min < 10) {$min = "0$min";};
	if($hour < 10) {$hour = "0$hour";};
	if($mday < 10) {$mday = "0$mday";};
	if($mon < 10) {$mon = "0$mon";};

	$datestr = "$year:$mon:$mday:$hour:$min:$sec";

	return $datestr;
}

#　@(f)
#
#　機能　	：	ヘッダー文字列作成処理
#
#　引数　	：	なし
#
#　返り値	：	ＨＴＭＬヘッダ文字列
#
#　機能説明　	：	ＨＴＭＬヘッダの文字列を返す
#
#　備考　	：	将来は text/html 以外にもやる予定

function PH() {
	return "Content-Type: text/html\n\n";
}

#　@(f)
#
#　機能　	：	更新ページ文字列作成処理
#
#　引数　	：	$url	--- 	ジャンプ先ＵＲＬ（http:// から記入）
#			$sec	--- 	更新アクションの間　（$sec秒)
#			$str 	--- 	ページに表示する文字列
#
#　返り値	：	ＨＴＭＬ文字列
#
#　機能説明　	：	ＨＴＭＬの文字列を返す
#
#　備考　	：	特になし

function MakeRefresh($url = "",$sec = "",$str = "") {

	$strline = "<html><head><title>更新中・・・</title><META HTTP-EQUIV='Content-Type' Content=\"text/html; charset=x-euc-jp\"><META HTTP-EQUIV='Refresh' Content=\"$sec ; url='$url'\"></head><body>$str</body></html>";
	
	return $strline;
}

#　@(f)
#
#　機能　	：	ＨＴＭＬ用文字列変換処理
#
#　引数　	：	$strtmp	--- 	変換する文字列
#
#　返り値	：	ＨＴＭＬ文字列
#
#　機能説明　	：	一般文字列をＨＴＭＬ用文字列に変換する
#
#　備考　	：	特になし

function ConvHTMLTag($strtmp = "") {

	return htmlspecialchars($strtmp);
}

#　@(f)
#
#　機能　	：	時刻文字列変換処理
#
#　引数　	：	$strtmp	--- 	変換する文字列
#			$way	---	オプション
#					(1)年月日時で返す
#					(2) 
#					(3)
#
#　返り値	：	時刻文字列
#
#　機能説明　	：	データ等の暗号化した時刻文字列をある規則の文字列に変換する
#
#　備考　	：	特になし

function ConvDateString($strtmp = "",$way = "",$sp = "") {

	if($sp == "") $sp = "_" ;

	if($way == 1) {
		list($year,$mon,$date,$hour,$min,$sec) = split("$sp",$strtmp);
		$strtmp = $year . "年" . $mon . "月" . $date . "日" . $hour . "時";
		return $strtmp;
	} elseif($way == 2) {
		list($year,$mon,$date,$hour,$min,$sec) = split("$sp",$strtmp);
		$strtmp = $year . "年" . $mon . "月" . $date . "日" . $hour . "時" . $min . "分";
		return $strtmp;
	}
}

#　@(f)
#
#　機能　	：	METAタグ文字列作成処理
#
#　引数　	：	$way ---	オプション
#					(euc)charset を ＥＵＣコードにする
#
#　返り値	：	METAタグ文字列
#
#　機能説明　	：	METAタグ文字列を返す
#
#　備考　	：	

function PrintMETA($way = "") {

	if($way == "euc") {
		$strtmp = "<META HTTP-EQUIV=\"Content-Type\" CONTENT=\"text/html; charset=x-euc-jp\">";
		return $strtmp;
	}
}


#　@(f)
#
#　機能　	：	設定ファイル初期化処理
#
#　引数　	：	$mode ---	オプション
#					(1)標準モード
#					(2)セクション内の文字列を返す
#			$fname ---	ファイル名
#			$section ---	セクション
#　返り値	：	なし、文字列
#
#　機能説明　	：	[SECTION] KEY = VAL のフォーマットを%hash{SECTION-KEY} に格納する
#
#　備考　	：	

function InitINIData($mode,$fname,$section = "") {

	$INIData = array();

	#------------------------
	#	標準モード
	#------------------------

	if($mode == 1) {
		$strline = ReadFileData($fname, 1);	#設定ファイルの読み込み
		$strline = JE($strline);
		$strline = preg_replace("/\r/","",$strline);
		$strarray = array();
		$strarray = split("\n",$strline);	#改行ごとに区切る

		#設定ファイル文字列を 連想配列 INIData に格納するループ　--- 開始 ---
		for($i = 0; $i < sizeof($strarray); $i++) {
			#セクション初期化・及び変更
			if(preg_match("/\[.*\]/",$strarray[$i])) {	
				#print "Section:$strarray[$i]<br>\n";	#デバグ用
				$strarray[$i] = preg_replace("/(\[|\])/","",$strarray[$i]);#中括弧をはずす				
				$StrCurSection = $strarray[$i];		#カレントセクション変数の格納する
				#print $StrCurSection . "<br>";
				continue;
			#キーと値のの初期化
			} elseif(preg_match("/.*=.*/",$strarray[$i])) {
				$strarray[$i] = preg_replace("/(\t|;.*|\/\*.*\*\/)/","",$strarray[$i]); #タブ・スペース・コメントを除去する

				list($StrCurKey,$StrCurVal) = split("=",$strarray[$i],2);	#キーと値に分ける
				#print "Key:$StrCurKey Value:$StrCurVal<br>\n";		#デバグ用
				$StrCurSecKey = $StrCurSection . "-" . $StrCurKey;	#文字列 -> "キー-値"を作る
				#print "MainKey:$StrCurSecKey<br>\n";		#デバグ用
				$StrCurVal = trim($StrCurVal);	#NEW

				$StrCurVal = preg_replace("/(^\"|\"$)/","",$StrCurVal);#両恥に " があった場合取り除く

				#print $StrCurVal . "<br>";

				$GLOBALS[$StrCurKey] = $StrCurVal;
				$INIData[$StrCurSecKey] = $StrCurVal;	#連想配列に格納する
			}
		}
		#設定ファイル文字列を 連想配列 INIData に格納するループ　--- 終了 ---

		return $INIData;

	#------------------------
	#	ＨＴＭＬモード
	#------------------------
	} elseif($mode == 2) {

		$MatchFlag = 0;
		$strtmp = "";

		$strline = ReadFileData($fname, 1);	#設定ファイルの読み込み
		$strline = JE($strline);
		$strline = preg_replace("/\r/","",$strline);
		$strarray = array();
		$strarray = split("\n",$strline);		#改行ごとに区切る

		#設定ファイル文字列を 連想配列 INIData に格納するループ　--- 開始 ---
		for($i = 0; $i < sizeof($strarray); $i++) {
			if($MatchFlag == 0) {
				#セクション初期化・及び変更
				if(preg_match("/\[.*\]/",$strarray[$i])) {
					#print "Section:$strarray[$i]<br>\n";	#デバグ用
					$strarray[$i] = preg_replace("(\[|\])","",$strarray[$i]);#中括弧をはずす	
					#print "$strarray[$i] $section<br>";	#デバグ用
					if($strarray[$i] == $section) {
						$MatchFlag = 1;
						#print "match";	#デバグ用
					}
				}
				
				continue;
			} elseif($MatchFlag == 1) {
				if(preg_match("/^\[.*\]/",$strarray[$i])) {
					break;
				} else {
					$strtmp = $strtmp . $strarray[$i] . "\n";
				}
			}
		}
		#設定ファイル文字列を 連想配列 INIData に格納するループ　--- 終了 ---


		return $strtmp;
	}
}


#　@(f)
#
#　機能　	：	指定数値フォーマット変換処理
#
#　引数　	：	$mode ---	オプション
#					(1)４桁数字文字列の数字化 (例：0234 -> 234) 
#					(2)数字文字列を指定した桁の文字列に変換
#			$str ---	数字
#			$cmd01 ---	コマンド１
#			$cmd02 ---	コマンド２
#
#　返り値	：	数字
#
#　機能説明　	：	
#
#　備考　	：	

function Sprint($mode = "",$str = "",$cmd01 = "",$cmd02 = "") {

	# ４桁数字文字列の数字化 (例：0234 -> 234) 
	if($mode == 1) {
		$strtmp = $str + 0;
	}
	# 数字文字列を指定した桁の文字列に変換
	elseif($mode == 2) {
		$strtmp = sprintf("%0" . $cmd01 . "d",$str);
	}

	return $strtmp;
}


#　@(f)
#
#　機能　	：	ＣＳＶファイル読み込み
#
#　引数　	：	$mode ---	オプション
#					(1)連想配列に格納する
#			$fname ---	ファイル名
#
#
#　返り値	：	連想配列
#
#　機能説明　	：	
#
#　備考　	：	

function ReadCSVFile($mode,$fname) {

	if($mode == 1) {

		$InValFlag = 0;

		$strline = ReadFileData($fname,1);
		#ＥＵＣに変換する
		$strline = JE($strline);

		$strarray = split("\n",$strline);
	
		for($i = 0;$i < sizeof($strarray); $i++) {
			$strarray[$i] = preg_replace(";.*","",$strarray[$i]);
			$strarray[$i] = preg_replace("\"\"","_DBLAP_",$strarray[$i]);

			$chararray = split("",$strarray[$i]);

			for($j = 0; $j < sizeof($chararray); $j++) {
				if($chararray[$j] == "\"") {
					if($InValFlag == 0) {
						$InValFlag = 1;
					} elseif($InValFlag == 1) {
						$InValFlag = 0;
					}
					continue;
				} else {
					if($chararray[$j] == ",") {
						#区切りカンマの場合
						if($InValFlag == 0) {
						#値カンマの場合
						} elseif($InValFlag == 1) {
							$chararray[$j] = preg_replace($chararray[$j],"_VALKAM_",$chararray[$j]);
						}
					}
				}
			}

			$strarray[$i] = join("",$chararray);
			$strarray[$i] = preg_replace("\"","",$strarray[$i]);

			#デバグ用
			if($strarray[$i] != "") {
				#print "$f2<b>$strarray[$i]</b>$fc<br>";
			}


			$valarray = split(",",$strarray[$i]);

			for($k = 0;$k <= sizeof($valarray); $k++) {
				$strCSVKey = $i . "_" . $k;
				$valarray[$k] = preg_replace("_DBLAP_","\"",$valarray[$k]);
				$valarray[$k] = preg_replace("_VALKAM_",",",$valarray[$k]);

				#print "CSVKey : $strCSVKey CSVVal : $valarray[$k]<br>";

				$CSVData[$strCSVKey] = $valarray[$k];
			}

			$strCSVKey = "MAX" . "_" . $i;
			$CSVData[$strCSVKey] = sizeof($valarray);
			
		}

		$strCSVKey = "MAXRECORD";
		$CSVData[$strCSVKey] = sizeof($strarray);

		return $CSVData;
	}
}


#　@(f)
#
#　機能　	：	指定文字カウント処理
#
#　引数　	：	$mode ---	オプション
#					(1)標準
#			$str ---	探すところの文字列
#			$charF ---	カウントする文字
#
#　返り値	：	一致数
#
#　機能説明　	：	
#
#　備考　	：	

function CountChar($mode,$str,$charF) {

	if($mode == 1) {
		$cnt = 0;
		$strarray = split("",$str);

		for($i = 0; $i <= sizeof($strarray); $i++) {
			if($strarray[$i] == $charF) {
				$cnt++;
			}
		}

		$strtmp = $cnt;
	}

	return $strtmp;
}


#　@(f)
#
#　機能　	：	頭の空白を削除する
#
#　引数　	：	$strtmp ---	文字列
#
#　返り値	：	削除した文字列
#
#　機能説明　	：	
#
#　備考　	：	

function TrimL($strtmp) {

	$strtmp = preg_replace("^\s+","",$strtmp);

	return $strtmp;
}

#　@(f)
#
#　機能　	：	文字をはさむ
#
#　引数　	：	$mode ---	オプション
#					(1)標準
#			$str ---	中央の文字
#			#substr ---	端の文字
#
#　返り値	：	文字列
#
#　機能説明　	：	
#
#　備考　	：	

function SandWitch($mode,$str,$substr) {

	if($mode == 1) {
		$strtmp = $substr . $str . $substr;
	}

	return $strtmp;
}


#　@(f)
#
#　機能　	：	ＥＵＣコード変換
#
#　引数　	：	$strtmp ---	文字列
#
#　返り値	：	文字列
#
#　機能説明　	：	
#
#　備考　	：	

function JE($strtmp = "") {

	if(function_exists("i18n_convert")) {
		$strtmp = i18n_convert($strtmp,"EUC",i18n_discover_encoding($strtmp));
	} else {
		$strtmp = $strtmp;
	}

		return $strtmp;

}

#　@(f)
#
#　機能　	：	ＥＵＣコード変換
#
#　引数　	：	$strtmp ---	文字列
#
#　返り値	：	文字列
#
#　機能説明　	：	
#
#　備考　	：	

function JJ($strtmp = "") {

	if(function_exists("i18n_convert")) {
		$strtmp = i18n_convert($strtmp,"JIS",i18n_discover_encoding($strtmp));
	} else {
		$strtmp = $strtmp;
	}

		return $strtmp;

}


#　@(f)
#
#　機能　	：	ＳＨＩＦＴ－ＪＩＳコード変換
#
#　引数　	：	$strtmp ---	文字列
#
#　返り値	：	文字列
#
#　機能説明　	：	
#
#　備考　	：	
	
function JS($strtmp = "") {

	return $strtmp;

}

#ＨＴＭＬタグ変数初期化

#　@(f)
#
#　機能　	：	
#
#　引数　	：	
#
#　返り値	：	
#
#　機能説明　	：	
#
#　備考　	：	

function Init_Tag() {

	global $f1,$f2,$f3,$f4,$f5,$f6,$f7,$f8,$fred,$fpink,$fblue,$fwhite,$fblack,$flblue,$fb,$fi,$fc,$al,$ar,$am,$ac,$vab,$vat,$vam,$t,$tc,$htdoc,$wper,$wpix,$cp,$cs;

	$f1 				= "<font size=\"1\">";
	$f2 				= "<font size=\"2\">";
	$f3 				= "<font size=\"3\">";
	$f4 				= "<font size=\"4\">";
	$f5 				= "<font size=\"5\">";
	$f6 				= "<font size=\"6\">";
	$f7 				= "<font size=\"7\">";
	$f8 				= "<font size=\"8\">";
	$fred  				= "<font color=\"red\">";
	$fpink  			= "<font color=\"pink\">";
	$fblue  			= "<font color=\"blue\">";
	$fwhite  			= "<font color=\"white\">";
	$fblack  			= "<font color=\"black\">";
	$flblue  			= "<font color=\"lblue\">";
	$fb  				= "<b>";
	$fi  				= "<i>";
	$fc  				= "</font>";

	$al  				= "align=\"left\"";
	$ar  				= "align=\"right\"";
	$am  				= "align=\"center\"";
	$ac  				= "align=\"center\"";
	$vab 				= "valign=\"bottom\"";
	$vat 				= "valign=\"top\"";
	$vam 				= "valign=\"middle\"";


	$t				= "<table>";
	$tc 				= "</table>";

	$htdoc				= "<!DOCTYPE HTML PUBLIC \"-//W3C//DTD HTML 3.2 Final//EN\">";

	$wper	= array(
		10 => "width=\"10%\"",
		20 => "width=\"20%\"",
		30 => "width=\"30%\"",
		40 => "width=\"40%\"",
		50 => "width=\"50%\"",
		60 => "width=\"60%\"",
		70 => "width=\"70%\"",
		80 => "width=\"80%\"",
		90 => "width=\"90%\"",
		100 => "width=\"100%\""
	);

	$wpix	= array(
		10 => "width=\"10\"",
		20 => "width=\"20\"",
		30 => "width=\"30\"",
		40 => "width=\"40\"",
		50 => "width=\"50\"",
		60 => "width=\"60\"",
		70 => "width=\"70\"",
		80 => "width=\"80\"",
		90 => "width=\"90\"",
		100 => "width=\"100\""
	);


	$cp	= array(
		0 => "cellpadding=\"0\"",
		1 => "cellpadding=\"1\"",
		2 => "cellpadding=\"2\"",
		3 => "cellpadding=\"3\"",
		4 => "cellpadding=\"4\"",
		5 => "cellpadding=\"5\"",
		6 => "cellpadding=\"6\"",
		7 => "cellpadding=\"7\"",
		8 => "cellpadding=\"8\"",
		9 => "cellpadding=\"9\"",
		10 => "cellpadding=\"10\""
	);

	$cs	= array(
		0 => "cellspacing=\"0\"",
		1 => "cellspacing=\"1\"",
		2 => "cellspacing=\"2\"",
		3 => "cellspacing=\"3\"",
		4 => "cellspacing=\"4\"",
		5 => "cellspacing=\"5\"",
		6 => "cellspacing=\"6\"",
		7 => "cellspacing=\"7\"",
		8 => "cellspacing=\"8\"",
		9 => "cellspacing=\"9\"",
		10 => "cellspacing=\"10\""
	);

}


################################################################
################################################################
################################################################
################################################################
################################################################
################################################################

#　@(f)
#
#　機能　	：	
#
#　引数　	：	
#
#　返り値	：	
#
#　機能説明　	：	
#
#　備考　	：	

function MakeCSVHtmlTable($mode,$csv) {

	if($mode == 1) {
		$strtmp .= "<table border='1'>";
		for($i = 0;$i <= $csv["MAXRECORD"]; $i++) {
			$tmp01 = join("",MAX,"_",$i);
			$strtmp .= "<tr>";	
			for($j = 0; $j <= $csv[$tmp01]; $j++) {
				$tmp02 = join("",$i,"_",$j);
				$csv[$tmp02] = ConvHTMLTag($csv[$tmp02]);
				$strtmp .= "<td>$csv{$tmp02}</td>";
			}
			$strtmp .= "</tr>";
		}
		$strtmp .= "</table>";
		return $strtmp;
	}
}

#　@(f)
#
#　機能　	：	
#
#　引数　	：	
#
#　返り値	：	
#
#　機能説明　	：	
#
#　備考　	：	

function MakeSelectionBySectionArray($mode, $section, $selname) {


	if($mode == 1) {
		for($i = 0;$i <= 1000; $i++) {
			$tmp01 = join("",$section,"-",$i);
			if($INI[$tmp01] == "") {
				break;
			}
			$strtmp .= "<option value='$i'>$INI{$tmp01}</option>\n";
		}

		$strtmp	= join("","<select name='$selname'>\n",$strtmp,"</select>\n");

		return $strtmp;
	}

}

#　@(f)
#
#　機能　	：	
#
#　引数　	：	
#
#　返り値	：	
#
#　機能説明　	：	
#
#　備考　	：	

function MakeCSVLineFromHash($mode, $strJ, $hash) {

	$i = 0;
	$max_i = -1;

	while(list($key, $val) = each($hash)) {
		if(preg_match("/$strJ/",$key)) {
			$max_i++;
		}
	}


	for($i = 0; $i <= $max_i; $i++) {
		$strHname = $strJ . $i;
		$hash[$strHname] = ConvCSVString($hash[$strHname]);
		print "$strHname = $hash{$strHname}<br>";
		array_push($strarray,$hash[$strHname]);
	}


	$strtmp = join(",",$strarray);

	return $strtmp;

}

#　@(f)
#
#　機能　	：	
#
#　引数　	：	
#
#　返り値	：	
#
#　機能説明　	：	
#
#　備考　	：	

function ConvCSVString($strtmp) {

	$strtmp = preg_replace("\"","\"\"",$strtmp);

	if(preg_match("/,/",$strtmp)) {
		$strtmp = SandWitch(1,$strtmp,"\"");
	}

	$strtmp = preg_replace("\r\n","\n",$strtmp);
	$strtmp = preg_replace("\n","_N_",$strtmp);

	return $strtmp;
}

#　@(f)
#
#　機能　	：	
#
#　引数　	：	
#
#　返り値	：	
#
#　機能説明　	：	
#
#　備考　	：	

function ConvInputString($strtmp) {

	$strtmp = preg_replace("_N_","\n",$strtmp);

	return $strtmp;
}

#　@(f)
#
#　機能　	：	
#
#　引数　	：	
#
#　返り値	：	
#
#　機能説明　	：	
#
#　備考　	：	

function UpdateINIFile($mode,$fname,$section,$strFkey,$strCval) {
	

	$strline = ReadFileData($fname, 1);	#設定ファイルの読み込み
	$strline = JE($strline);
	$strarray = split("\n",$strline);		#改行ごとに区切る


	for($i = 0; $i < sizeof($strarray); $i++) {
		#セクション初期化・及び変更
		if(preg_match("/\[.*\]/",$strarray[$i])) {
			#print "Section:$strarray[$i]<br>\n";	#デバグ用
			
			$StrCurSection = $strarray[$i];		#カレントセクション変数の格納する
			$StrCurSection = preg_replace("(\[|\])","",$StrCurSection);#中括弧をはずす

			continue;
		#キーと値のの初期化
		} elseif((preg_match("/^$strFkey/",$strarray[$i])) && ($StrCurSection == $section)) {
			$strFval = $section . "-" . $strFkey;
			$strarray[$i] = preg_replace("= $INI{$strFval}","= $strCval",$strarray[$i]);
		}
	}

	$strline = join("\n",$strarray);
	#jcode'convert(*strline, $INI{'GROBAL-DecodeINITo'});
	RecordFileData($fname, 3, $strline, $strarray);



}

#　@(f)
#
#　機能　	：	
#
#　引数　	：	
#
#　返り値	：	
#
#　機能説明　	：	
#
#　備考　	：	

function GetFileArray($mode,$path) {

	if($mode == 1) {
		opendir(DIR,"$path");
		$tmparray = readdir(DIR);
		closedir(DIR);

		return $tmparray;
	} elseif($mode == 2) {
		opendir(DIR,"$path");
		#$tmparray = grep(!/^(\.|\.\.)$/,readdir(DIR));
		closedir(DIR);

		return $tmparray;
	} elseif($mode == 3) {
		opendir(DIR,"$path");
		#$tmparray = grep { (-d "$path$_") && (!/^(\.|\.\.)$/) } readdir(DIR);
		closedir(DIR);

		return $tmparray;
	}
	
}

#　@(f)
#
#　機能　	：	
#
#　引数　	：	
#
#　返り値	：	
#
#　機能説明　	：	
#
#　備考　	：	

function Parapara($color) {

	global $Parapara_i;

	if($Parapara_i == "") {
		$Parapara_i = 1;
	}

	if($Parapara_i == "1") {
		$color = "#FFFFFF";
		$Parapara_i = "0";
	} else {
		$Parapara_i = "1";		
	}

	return $color;
}

#　@(f)
#
#　機能　	：	
#
#　引数　	：	
#
#　返り値	：	
#
#　機能説明　	：	
#
#　備考　	：	

function StringMatchToArray($strF,$strarray) {

	for($i = 0;$i < sizeof($strarray); $i++) {
		$TMP = $strarray[$i];
		if(($TMP == $strF) && ($strF != "")) {
			return "1";
		}
	}

	return "0";
}

#　@(f)
#
#　機能　	：	
#
#　引数　	：	
#
#　返り値	：	
#
#　機能説明　	：	
#
#　備考　	：	

function ConvNumMon($strtmp) {

	if($strtmp == "Jan") {$strtmp = "1";}
	elseif($strtmp == "Feb") {$strtmp = "2";}
	elseif($strtmp == "Mar") {$strtmp = "3";}
	elseif($strtmp == "Apr") {$strtmp = "4";}
	elseif($strtmp == "May") {$strtmp = "5";}
	elseif($strtmp == "Jun") {$strtmp = "6";}
	elseif($strtmp == "Jul") {$strtmp = "7";}
	elseif($strtmp == "Aug") {$strtmp = "8";}
	elseif($strtmp == "Sep") {$strtmp = "9";}
	elseif($strtmp == "Oct") {$strtmp = "10";}
	elseif($strtmp == "Nov") {$strtmp = "11";}
	elseif($strtmp == "Dec") {$strtmp = "12";}

	return $strtmp;
}

#　@(f)
#
#　機能　	：	
#
#　引数　	：	
#
#　返り値	：	
#
#　機能説明　	：	
#
#　備考　	：	

function OpenBinaryFileData($fname) {


}

#　@(f)
#
#　機能　	：	
#
#　引数　	：	
#
#　返り値	：	
#
#　機能説明　	：	
#
#　備考　	：	

function RecordBinaryFileData($fname,$fdata) {

}

#　@(f)
#
#　機能　	：	
#
#　引数　	：	
#
#　返り値	：	
#
#　機能説明　	：	
#
#　備考　	：	

function InitFromString($strtmp) {

	list($dum,$q) = split("\?",$strtmp, 2);
	$qs = split("&", $q);
	for($i = 0;$i < sizeof($qs); $i++) {
		$tmp = $qs[$i];
		list($k,$v) = split("=", $tmp);
		#$v =~ s/%([A-Fa-f0-9][A-Fa-f0-9])/pack("C", hex($1))/eg;
		$form[$k] = $v;
	}
}

#　@(f)
#
#　機能　	：	
#
#　引数　	：	
#
#　返り値	：	
#
#　機能説明　	：	
#
#　備考　	：	

function GetMaxNumberFromINIHash($mode, $section, $hash) {

	if($mode == 1) {
		for($i = 1;$i <= 1000; $i++) {
			$tmp01 = join("",$section,"-",$i);
			if($hash[$tmp01] == "") {
				$strtmp = $i - 1;
				break;
			}
		}

		return $strtmp;
	}
}

#　@(f)
#
#　機能　	：	
#
#　引数　	：	
#
#　返り値	：	
#
#　機能説明　	：	
#
#　備考　	：	

function GetArrayFromINIHash($mode, $section, $hash) {

	if($mode == 1) {
		for($i = 1;$i <= 1000; $i++) {
			$tmp01 = join("",$section,"-",$i);
			if($hash[$tmp01] == "") {
				break;
			} else {
				array_push($tmparray,$hash[$tmp01]);
			}
		}

		return $tmparray;
	}

}

#　@(f)
#
#　機能　	：	
#
#　引数　	：	
#
#　返り値	：	
#
#　機能説明　	：	
#
#　備考　	：	

function FunnySQL($mode,$fname,$lsp,$dsp,$id,$idx) {

	if($mode == "1") {
		if($fname == "") {
			$fdata = $CurFileData;
		} else {
			$fdata = ReadFileData($fname,1);
		}

		$flines = split("$lsp",$fdata);

		for($i = 0; $i <= sizeof($flines); $i++) {
			$dlines = split("$dsp",$flines[$i]);
			if($dlines[0] == $id) {
				$strtmp = $dlines[$idx];
				break;
			}
		}

		return $strtmp;
	}
	elseif($mode == "2") {
		if($fname == "") {
			$fdata = $CurFileData;
		} else {
			$fdata = ReadFileData($fname,1);
		}

		$flines = split("$lsp",$fdata);

		for($i = 0; $i <= sizeof($flines); $i++) {
			$dlines = split("$dsp",$flines[$i]);
			array_push($strarray,$dlines[$idx]);
		}

		return $strarray;
	}


}

#　@(f)
#
#　機能　	：	
#
#　引数　	：	
#
#　返り値	：	
#
#　機能説明　	：	
#
#　備考　	：	

function ConvPrice($strtmp) {

	$strtmp = preg_replace("１","1",$strtmp);
	$strtmp = preg_replace("２","2",$strtmp);
	$strtmp = preg_replace("３","3",$strtmp);
	$strtmp = preg_replace("４","4",$strtmp);
	$strtmp = preg_replace("５","5",$strtmp);
	$strtmp = preg_replace("６","6",$strtmp);
	$strtmp = preg_replace("７","7",$strtmp);
	$strtmp = preg_replace("８","8",$strtmp);
	$strtmp = preg_replace("９","9",$strtmp);
	$strtmp = preg_replace("０","9",$strtmp);
	$strtmp = preg_replace("\D","",$strtmp);

	if($strtmp == "") {
		$strtmp = "0";
	}

	return $strtmp;
}

#　@(f)
#
#　機能　	：	
#
#　引数　	：	
#
#　返り値	：	
#
#　機能説明　	：	
#
#　備考　	：	

function MakeHiddenValueWithFilter($remove, $hash) {

	$removes = split(":", $remove);

	while(list($key, $value) = each($hash)) {

		$rem_flag = 0;

		for($i = 0;$i < sizeof($removes); $i++) {
			$tmp = $removes[$i];
			if($tmp == $key) {
				$rem_flag = 1;
				continue;
			}
		}

		if($rem_flag != 1) {
			$strtmp = $strtmp . "<input type=\"hidden\" name=\"$key\" value=\"$value\">\n";
		}
	}


	return $strtmp;
}

#　@(f)
#
#　機能　	：	
#
#　引数　	：	
#
#　返り値	：	
#
#　機能説明　	：	
#
#　備考　	：	

function StopWatchVer1($flag) {

	if($flag == "start") {
		$SW_START = time;
	} elseif($flag == "stop") {
		$SW_STOP = time;
		$strtmp = $SW_STOP - $SW_START;
		return $strtmp;
	}
	
}

#　@(f)
#
#　機能　	：	
#
#　引数　	：	
#
#　返り値	：	
#
#　機能説明　	：	
#
#　備考　	：	

function StockFileData($fname) {

	$CurFileData = ReadFileData($fname,1);
}

#　@(f)
#
#　機能　	：	
#
#　引数　	：	
#
#　返り値	：	
#
#　機能説明　	：	
#
#　備考　	：	

function ListArray($mode,$strarray) {

	if($mode == "1") {
		for($i = 0;$i < sizeof($strarray); $i++) {
			$strtmp = $strarray[$i];
			print "$strtmp<br>\n";
		}
	}
}


#フォルダ及びファイル存在確認->なければ作る

#　@(f)
#
#　機能　	：	
#
#　引数　	：	
#
#　返り値	：	
#
#　機能説明　	：	
#
#　備考　	：	

function CheckAndMakeFile($fpath,$fperm) {

	if(file_exists($fpath)) {
		return "1";
	} else {
		#なければ作る
		mkdir($fpath,$fperm);
		return "0";
	}
}

#　@(f)
#
#　機能　	：	アカウント文字列作成
#
#　引数　	：	
#
#　返り値	：	
#
#　機能説明　	：	
#
#　備考　	：	

function MakeAccountStr($Id,$Pwd,$sp) {

	$Pwd = crypt($Pwd,substr($Pwd,0,2));

	$Id = ConvCSVString($Id);
	$Pwd = ConvCSVString($Pwd);
	$strline = join($sp,$Id,$Pwd);

	$strline = crypt($strline,substr($strline,0,2));

	$strline = ReverseString($strline);

	return $strline;

}

#　@(f)
#
#　機能　	：	
#
#　引数　	：	
#
#　返り値	：	
#
#　機能説明　	：	
#
#　備考　	：	

function ReverseString($strtmp) {

	$strarray = split("",$strtmp);
	$strarray = reverse($strarray);
	$strtmp = join("",$strarray);

	return $strtmp;
}

#　@(f)
#
#　機能　	：	
#
#　引数　	：	
#
#　返り値	：	
#
#　機能説明　	：	
#
#　備考　	：	

function ConvVal($strtmp) {
	$strtmp = preg_replace("/_(\w+)_/e","GetVal('\\1')",$strtmp);
	return $strtmp;
}

#　@(f)
#
#　機能　	：	
#
#　引数　	：	
#
#　返り値	：	
#
#　機能説明　	：	
#
#　備考　	：	

function GetVal($vn) {
	if(isset($GLOBALS[$vn])) {
		return $GLOBALS[$vn];
	} else {
		return "";
	}
}

# End 2000/11/29

#　@(f)
#
#　機能　	：	
#
#　引数　	：	
#
#　返り値	：	
#
#　機能説明　	：	
#
#　備考　	：	

#function URLEncode($strtmp) {
#	$strtmp = preg_replace("(\W)","'%'.unpack(\"H2\", $1)",$strtmp);
#	return $strtmp;
#}

#　@(f)
#
#　機能　	：	
#
#　引数　	：	
#
#　返り値	：	
#
#　機能説明　	：	
#
#　備考　	：	

#function URLDecode($strtmp) {
#	$strtmp = preg_replace("%([0-9a-f][0-9a-f])","pack(\"C\",hex($1))",$strtmp);
#	return $strtmp;
#}



#----------------

# End 2000/12/13

#　@(f)
#
#　機能　	：	
#
#　引数　	：	
#
#　返り値	：	
#
#　機能説明　	：	
#
#　備考　	：	

function ListHash($mode,$hash) {

	if($mode == "1") {
		while(list($k,$v) = each($hash)) {
			push($strarray,"$k=$v");
		}

		return $strarray;
	}

}

########################################
#	クッキーを取得する
########################################

#　@(f)
#
#　機能　	：	
#
#　引数　	：	
#
#　返り値	：	
#
#　機能説明　	：	
#
#　備考　	：	

function GetCookie() {

	$c = $HTTP_COOKIE;
	$parray = split(";",$c);

	for($i = 0;$i < sizeof($parray); $i++) {
		$p = $parray[$i];
		list($n,$v) = split("=",$p);
		$n =~ s/ //g;
		$varray = split(",",$v);
		for($j = 0;$j < sizeof($varray); $j++) {
			$v = $varray[$j];
			list($vn,$vv) = split(":",$v);
			$strtmp = $n . "x" . $vn;

			$tmp = $n . "-" . $vn;
			$GLOBALS[$strtmp] = $COOKIE[$tmp] = $vv;
		}
	}
}

########################################
#	クッキーを埋め込む
########################################

#　@(f)
#
#　機能　	：	
#
#　引数　	：	
#
#　返り値	：	
#
#　機能説明　	：	
#
#　備考　	：	

function PutCookie($c_name,$c_value,$c_time) {

	$c_year = $c_year + 1900; #重要！ これで c_year は "2000" になる
	if ($c_year < 10)  { $c_year = "0$c_year"; }
	if ($c_sec < 10)   { $c_sec  = "0$c_sec";  }
	if ($c_min < 10)   { $c_min  = "0$c_min";  }
	if ($c_hour < 10)  { $c_hour = "0$c_hour"; }
	if ($c_mday < 10)  { $c_mday = "0$c_mday"; }

	#曜日配列作成
	#$day = qw(		Sun		Mon		Tue		Wed		Thu		Fri		Sat	);
	#月配列作成
	#$month = qw(		Jan Feb Mar Apr May Jun Jul Aug Sep Oct Nov Dec	);

	#曜日設定
	$c_day = $day[$c_wday];
	#月設定
	$c_month = $month[$c_mon];

	#期限文字列作成
	$c_expires = "$c_day, $c_mday\-$c_month\-$c_year $c_hour:$c_min:$c_sec GMT";

	#値を返す
	return "Set-Cookie: $c_name=$c_value; expires=$c_expires\n";
}

########################################
#	指定の秒数から日付を取得する
########################################

#　@(f)
#
#　機能　	：	
#
#　引数　	：	
#
#　返り値	：	
#
#　機能説明　	：	
#
#　備考　	：	

function GetSpecDateString($time,$key) {

	$mon++;

	if($sec < 10) {$sec = "0$sec";};
	if($min < 10) {$min = "0$min";};
	if($hour < 10) {$hour = "0$hour";};
	if($mday < 10) {$mday = "0$mday";};
	if($mon < 10) {$mon = "0$mon";};


	$datestr = "$year:$mon:$mday:$hour:$min:$sec";

	if($key == "") {
		return $datestr;
	} else {
		return ${$key};
	}
}

########################################
#	ファイル情報を取得する
########################################

#　@(f)
#
#　機能　	：	
#
#　引数　	：	
#
#　返り値	：	
#
#　機能説明　	：	
#
#　備考　	：	

function GetSpecFileInfo($fpath,$key) {

	return ${$key};
}


########################################
#	配列から Select を作成する
########################################

#　@(f)
#
#　機能　	：	
#
#　引数　	：	
#
#　返り値	：	
#
#　機能説明　	：	
#
#　備考　	：	

function MakeSelectionByStrArray($mode, $selname, $strarray,$strarray02) {

	$strtmp = "";



	if($mode == 1) {
		for($i = 0;$i <= sizeof($strarray); $i++) {
			if($pselected == $i) {
				$selected = "selected";
			} else {
				$selected = "";
			}

			$strtmp .= "<option value='$i' $selected>$strarray[$i]</option>\n";
		}

		$strtmp	= join("","<select name='$selname'>\n",$strtmp,"</select>\n");

		return $strtmp;
	}
	elseif($mode == 2) {

		$pselected = GetVal("pselected");

		for($i = 0;$i < sizeof($strarray); $i++) {

			if($pselected == $strarray[$i]) {
				$selected = "selected";
			} else {
				$selected = "";
			}

			$strtmp .= "<option value='$strarray[$i]' $selected>$strarray02[$i]</option>\n";
		}

		$strtmp	= "<select name='$selname'>\n" . $strtmp . "</select>\n";

		return $strtmp;
	}

}

########################################
#	配列から Hash を作成する
########################################

#　@(f)
#
#　機能　	：	
#
#　引数　	：	
#
#　返り値	：	
#
#　機能説明　	：	
#
#　備考　	：	

function MakeHashFromStrArray($strarray) {

	for($i = 0; $i < sizeof($strarray); $i++) {
		list($k,$v) = split("=",$strarray[$i]);
		$hash[$k] = $v;
	}

	return $hash;
}


#　@(f)
#
#　機能　	：	
#
#　引数　	：	
#
#　返り値	：	
#
#　機能説明　	：	
#
#　備考　	：	

function MakeDateSelection($mode,$date,$sname) {

	$cur_y = GetSpecDateString($date,"year");
	$cur_m = GetSpecDateString($date,"mon");
	$cur_d = GetSpecDateString($date,"mday");

	$y_max = $cur_y + 1;
	$m_max = 12;
	$d_max = 31;

	if($pselecteddate == "") {
		$selecteddate = "$cur_y$cur_m$cur_d";
	} else {
		$selecteddate = "$pselecteddate";
	}

	if($mode == 1) {
		for($y_i = $cur_y; $y_i <= $y_max; $y_i++) {
			for($m_i = 1; $m_i <= $m_max; $m_i++) {
				for($d_i = 1; $d_i <= $d_max; $d_i++) {

					$py = sprintf("%04d",$y_i);
					$pm = sprintf("%02d",$m_i);
					$pd = sprintf("%02d",$d_i);

					if($selecteddate == "$py$pm$pd") {
						$selected = " selected";
					} else {
						$selected = "";
					}

					$pdate = join("/",$py,$pm,$pd);
					$strtmp .= "<option value=\"$pdate\"$selected>$pdate</option>\n";
				}
			}
		}

		$strtmp = "<select name=\"$sname\"> $strtmp </select>";

		return $strtmp;
	}
}

#　@(f)
#
#　機能　	：	
#
#　引数　	：	
#
#　返り値	：	
#
#　機能説明　	：	
#
#　備考　	：	

function ImportHash($hash) {

	while(list($k,$v) = each($hash)) {
		#デバグ用
		#print "$k = $v<br>\n";
		$GLOBALS[$k] = $v;
	}
}

#　@(f)
#
#　機能　	：	
#
#　引数　	：	
#
#　返り値	：	
#
#　機能説明　	：	
#
#　備考　	：	

function ExportHash($hash) {

	#print PH;

	while(list($k,$v) = each($hash)) {
		#デバグ用
		#print "$k = $v<br>\n";
		$hash[$k] = $v;
		#print "$k<BR>";
	}
}

#　@(f)
#
#　機能　	：	
#
#　引数　	：	
#
#　返り値	：	
#
#　機能説明　	：	
#
#　備考　	：	

function CheckFileDateAndDelete($mode,$fpath,$v) {

	#エラー処理
	if(!(file_exists($fpath))) {
		return "0";
	}

	if($mode == "hour") {
		#デバグ用
		#print PH;
		#print GetSpecDateString(time + $v * 60 * 60); 
		#print "<br>";

		$ctime = time;
		$ftime = GetSpecFileInfo($fpath,"mtime");

		$ltime = $ctime - $ftime;

		#print GetSpecDateString($ftime) . "<br>";
		#print GetSpecDateString($ctime) . "<br>";
		#print $v * 60 * 60 . "<br>";

		if($ltime < $v * 60 * 60) {
			return "0";
		} else {
			#unlink $fpath;
			return "1";
		}
	}
}

#　@(f)
#
#　機能　	：	
#
#　引数　	：	
#
#　返り値	：	
#
#　機能説明　	：	
#
#　備考　	：	

function MakeTempLabel($strtmp) {

	$strtmp = "<br> <br> <center> $f4<b>$strtmp</b>$fc </center>";

	return $strtmp;
}

#　@(f)
#
#　機能　	：	
#
#　引数　	：	
#
#　返り値	：	
#
#　機能説明　	：	
#
#　備考　	：	

function SortInOne($strArray) {

	$flag = 0;
	# $pcnt = 0;

		for($i = 0; $i < sizeof($strArray); $i++) {
			$flag = 0;	
			if($tmpArray == "") {
				$tmpArray[0] = $strArray[$i];
			} else {
				for($j = 0; $j < sizeof($tmpArray); $j++) {
					if($strArray[$i] == $tmpArray[$j]) {
						$flag = 1;
						break;
					}
				}

				if($flag == 0) {
					$tmpArray[sizeof($tmpArray) + 1] = $strArray[$i];
				}
			}
		}

	return $tmpArray;
}

#　@(f)
#
#　機能　	：	
#
#　引数　	：	
#
#　返り値	：	
#
#　機能説明　	：	
#
#　備考　	：	

function KstdSendMail($mode,$mailprog,$from,$to,$subject,$content) {

	if($mode == 1) {
	}
	#添付ファイル付き -------------
	elseif($mode == 2) {
	}

}


#　@(f)
#
#　機能　	：	
#
#　引数　	：	
#
#　返り値	：	
#
#　機能説明　	：	
#
#　備考　	：	

function CheckIsNULLInHashWithFilter($remove,$hash) {

	while(list($k,$v) = each($hash)) {
		if((StringMatchToArray($k,$remove)) != 1) {
			if($v == "") {
				$pNULL = $k;
				return 1;
			}
		}
	}
}

#　@(f)
#
#　機能　	：	
#
#　引数　	：	
#
#　返り値	：	
#
#　機能説明　	：	
#
#　備考　	：	

function ConvPriceComma($strtmp) {

	while(preg_match("(.*\d)(\d\d\d)","$1,$2",$strtmp)) {
	}

	return $strtmp;
}

#　@(f)
#
#　機能　	：	
#
#　引数　	：	
#
#　返り値	：	
#
#　機能説明　	：	
#
#　備考　	：	

function MakeHashFromString($mode,$strtmp,$sp,$sp2,$hn) {

	if($mode == 1) {
		$qs = split("$sp", $strtmp);
		for($i = 0;$i < sizeof($qs); $i++) {
			$tmp = $qs[$i];
			list($k,$v) = split("$sp2", $tmp);
			$v = preg_replace("%([A-Fa-f0-9][A-Fa-f0-9])","pack(\"C\", hex($1))",$v);
			$hash[$k] = $v;
		}

		return $hash;
	} elseif($mode == 2) {

		$qs = split("$sp", $strtmp);
		for($i = 0;$i < sizeof($qs); $i++) {
			$tmp = $qs[$i];
			list($k,$v) = split("$sp2", $tmp);
			$v = preg_replace("%([A-Fa-f0-9][A-Fa-f0-9])","pack(\"C\", hex($1))",$v);
			$tmp = $hn . "x" . $k;
			$v = preg_replace("_N_","\n",$v);
			$GLOBALS[$tmp] = $v;
		}	
	}

}

#　@(f)
#
#　機能　	：	四捨五入する
#
#　引数　	：	$num ---	数字
#			$decimals ---	四捨五入する桁
#
#　返り値	：	数字
#
#　機能説明　	：	
#
#　備考　	：	借り物

function pRound($num, $decimals) {
  $format = '%.' . $decimals . 'f';
  $magic = ($num > 0) ? 0.5 : -0.5;
  #sprintf($format, int(($num * (10 ** $decimals)) + $magic)) / (10 ** $decimals));
}

#　@(f)
#
#　機能　	：	日付フォーマットを所得する
#
#　引数　	：	$strtmp ---	：つき時間
#
#　返り値	：	YYYY/MM/DD文字列
#
#　機能説明　	：	
#
#　備考　	：	

function GetDltDateString($strtmp) {

	$strtmp = GetDateString;
	$strtmp = preg_replace(":","\/",$strtmp);
	#($strtmp,$dum) = $strtmp =~ /(..........)(......)/;

	return $strtmp;

}

#　@(f)
#
#　機能　	：	○Ｘ判定
#
#　引数　	：	１か０
#
#　返り値	：	○、Ｘ
#
#　機能説明　	：	
#
#　備考　	：	

function MaruBatu($q) {

	if($q) {
		return "○";
	} else {
		return "×";
	}
}

#　@(f)
#
#　機能　	：	１と０を交換する
#
#　引数　	：	１か０
#
#　返り値	：	１か０
#
#　機能説明　	：	
#
#　備考　	：	

function IchiZero($q) {

	if($q) {
		return "0";
	} else {
		return "1";
	}
}

#　@(f)
#
#　機能　	：	配列を混ぜる
#
#　引数　	：	$old ---	配列
#
#　返り値	：	配列
#
#　機能説明　	：	
#
#　備考　	：	

function SuffleArray($old) {

	while ($old) {
		#push($new, splice($old, int(rand() * $#old), 1));
	}

	return $new;

}

#　@(f)
#
#　機能　	：	ファイルタイプ判別
#
#　引数　	：	$strtmp ---	ファイル名＋拡張子
#
#　返り値	：	拡張子文字列
#
#　機能説明　	：	
#
#　備考　	：	

function DetectFileType($strtmp) {

	list($fname,$fext) = split(".",$strtmp);

	if($fext == 'gif'){
		$strline = 'image/gif';
	}
	elseif(($fext == 'jpeg') or ($f_type == 'jpg')){
		$strline = 'image/jpeg';
	}
	elseif($fext == 'bmp'){
		$strline = 'image/bmp';
	}
	else{
		$strline = 'application/octet-stream';
	}

	return $strline;
}



###


#--------------------------------------------------------------------------
# ＣＳＶ文字列を一般文字列にして配列にして返す
#--------------------------------------------------------------------------

function ConvCSVtoNormal($strtmp) {

	$InValFlag = 0;

	$strtmp = preg_replace(";.*","",$strtmp);
	$strtmp = preg_replace("\"\"","_DBLAP_",$strtmp);

	$chararray = split("",$strtmp);



	for($j = 0; $j <= sizeof($chararray); $j++) {
		if($chararray[$j] == "\"") {
			if($InValFlag == 0) {
				$InValFlag = 1;
			} elseif($InValFlag == 1) {
				$InValFlag = 0;
			}
			continue;
		} else {
			if($chararray[$j] == ",") {
				#区切りカンマの場合
				if($InValFlag == 0) {
				#値カンマの場合
				} elseif($InValFlag == 1) {
					$chararray[$j] =~ s/$chararray[$j]/_VALKAM_/g;
				}
			}
		}
	}
	$strtmp = join("",$chararray);
	$strtmp = preg_replace("\"","",$strtmp);

	#print "<br> ato $strtmp<br>";

	$valarray = split(",",$strtmp);
	for($k = 0;$k <= sizeof($valarray); $k++) {
		$valarray[$k] = preg_replace("_DBLAP_","\"",$valarray[$k]);
		$valarray[$k] = preg_replace("_VALKAM_",",",$valarray[$k]);
		$strarray[$k] = $valarray[$k];
		#print $strarray[$k] . ":";
	}


	#print "\n<br>test " . $strarray;

	return $strarray;
}


function Impact($strtmp) {

	global $fred,$fc;

	return "$fred<b> $strtmp </b>$fc";
}


















?>

