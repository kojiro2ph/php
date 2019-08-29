<?php

#
#
#
#
#
#
#
#
#


########################################
#	ＳＱＬ環境を初期化する
########################################

function Init_SQL() {

	global $link,$mysql_host,$mysql_user,$mysql_pass,$mysql_db,$IsLocal;

	if(!isset($HTTP_HOST)) {
		$HTTP_HOST = getenv("HTTP_HOST");
	}

	$IsLocal = 0;

	if($HTTP_HOST == "www.gurume.net") {
		$mysql_host	= "www.gurume.net";
		$mysql_user	= "gurumene";
		$mysql_pass	= "mmNp7mj7";
	}
	elseif($HTTP_HOST == "www.itsolution.co.jp" or $HTTP_HOST == "www.hamada-r.com") {
		$mysql_host	= "www.opengate1.com";
		$mysql_user	= "gurumene";
		$mysql_pass	= "mmNp7mj7";
		$mysql_db	= "hamada_r";
	}
	else {
		$IsLocal	= 1;

		$mysql_host	= "localhost";
		$mysql_user	= "kojiro";
		$mysql_pass	= "koji410";
		$mysql_db	= "hamada_r";
	}

}

########################################
#	ＳＱＬに接続する
########################################
function ConnectSQL() {

	global $link,$mysql_host,$mysql_user,$mysql_pass,$mysql_db;

   	$link = mysql_connect($mysql_host, $mysql_user, $mysql_pass);
	mysql_select_db($mysql_db);

}

########################################
#	ＳＱＬを切断する
########################################
function DisconnectSQL() {

	global $link;

	mysql_close($link);
}

########################################
#	ＤＢ配列を取得する
########################################

function GetDBNameArray() {

	$i = 0;
	$cnt = 0;
	$strarray = array();

	$db_list = mysql_list_dbs();

	$cnt = mysql_num_rows($db_list);
	while ($i < $cnt) {
	    $strarray[$i] = mysql_db_name($db_list, $i);
	    $i++;
	}

	return $strarray;

}


########################################
#	テーブル配列を取得する
########################################

function GetTableNameArray() {

	global $mysql_db;

	$strarray = array();

	$result = mysql_list_tables ($mysql_db);
	$i = 0;
	while ($i < mysql_num_rows ($result)) {
	    array_push($strarray,mysql_tablename($result, $i));
	    $i++;
	}

	return $strarray;

}

########################################
#	sthをTABLE化にする
########################################

function MakeTableFromSTH($tname = "") {

	global $result;

	$tmp = "";
	$strline = "";
	
	#フィールド名をヘッドに挿入
	ExecSQL("DESC " . $tname); #ＳＱＬ文実行
	$fldname = MakeArrayBySpecCat("Field");

	for($i = 0; $i < sizeof($fldname); $i++) {

		if($fldname[$i] == "") {
			$fldname[$i] = "\&nbsp;";
		}
		$strline .= "<td><b>" . $fldname[$i] . "</b></td>\n";
	}

	$strline = "<tr bgcolor=\"pink\">\n" . $strline . "</tr>\n";


	ExecSQL("SELECT * FROM " . $tname); #ＳＱＬ文実行
	#$numRows 	= mysql_num_rows($result);	#行数
	#$numFields 	= $sth->{'NUM_OF_FIELDS'};	#項目数


	#項目に対するバインドをする
	$i = 0;
	$field = array();
	while($fld = mysql_fetch_field($result)) {
		#print $fld->name;
		array_push($field,$fld->name);
	}


	#メインテーブルを作成する
	while ($row = mysql_fetch_assoc($result)) {
		$strline .= "<tr>\n";
		for($i = 0; $i < sizeof($field); $i++) {

			$tmp = $row[$field[$i]];

			$tmp = ConvHTMLTag($tmp);

			if($tmp == "") {
				$tmp = "&nbsp;";
			}

			$strline .= "<td nowrap>" . $tmp . "</td>\n";
		}
		$strline .= "</tr>\n";
	}


	#テーブル整理
	$strline = "
		<table style=\"font-size:10pt\" border=\"1\">
		" . $strline . "
		</table>
		";

	return $strline;


}


########################################
#	ＳＱＬ実行
########################################

function ExecSQL($cmd = "") {

	global $link,$result;

	if($result = mysql_query($cmd)) {
		#クエリーＯＫ
	} else {
		#クエリー失敗
		Err_Admin("失敗");
	}



}


########################################
#	指定フィールドを配列に入れる
########################################

function MakeArrayBySpecCat($name = "") {

	global $link,$result;
	$strarray = array();

	while ($row = mysql_fetch_assoc($result)) {
		array_push($strarray,$row[$name]);
	}
	mysql_free_result($result);

	return $strarray;

}

########################################
#	ファイルtoテーブル
########################################

function MakeTableFromCSVFile($fname = "",$tname = "") {

	global $link,$result;

	$fld = "";
	$fdataarray = array();

	#ファイル読み込み（タブ区切り）
	$fdata = JE(ReadFileData($fname,3));


	#print $fdata;


	$fdataarray = split("\n",$fdata);


	#print $fdataarray[0];




	#一行目を取り除く
	array_shift($fdataarray);
	$fldstat = array_shift($fdataarray);




	#項目処理
	$fldstat = preg_replace("/\t/",",",$fldstat);
	$fldstatarray = split(",",$fldstat);

	$query = "";
	#テーブル作成  --------------ここから
	for($i = 0; $i < sizeof($fldstatarray); $i++) {

		$fldname 	= "";
		$fldtype 	= "";
		$typename 	= "";
		$typebyte 	= "";

		list($fldname,$fldtype) = split("_",$fldstatarray[$i],2);
		list($typename,$typebyte) = split(":",$fldtype,2);

		$typename = preg_replace("/vc/","VARCHAR",$typename);
		$typename = preg_replace("/txt/","TEXT",$typename);

		if($typename == "VARCHAR") {
			$fldtype = $typename . "(" . $typebyte . ")";
		} else {
			$fldtype = $typename;
		}
		
		$query .= $fldname . " " . $fldtype . ",";
		$fld .= $fldname . ",";
	}


	$query = substr($query,0,strlen($query) - 1);
	$fld = substr($fld,0,strlen($fld) - 1);

	#print $query;
	#print $fld;

	ExecSQL("CREATE TABLE " . $tname . "(" . $query . ")");
	#print "CREATE TABLE " . $tname . "(" . $query . ")" . "<br>";

	#行ごとのＩＮＳＥＲＴループ --------------ここから
	for($i = 0; $i < sizeof($fdataarray); $i++) {
		$query = "";

		if($fdataarray[$i] == "") {
			continue;
		}

		$fdataarray[$i] = JE($fdataarray[$i]); #５月追加（重要）

		$tmp = split("\t",$fdataarray[$i],sizeof($fldstatarray) + 1);



		for($j = 0; $j < sizeof($tmp); $j++) {

			#$tmp[$j] = preg_replace("/_T_/","\t",$tmp[$j]);
			#$tmp[$j] = preg_replace("/_N_/","\n",$tmp[$j]);

			$query .= "'" . $tmp[$j] . "',";
		}

		$query = substr($query,0,strlen($query) - 1);

		ExecSQL("INSERT INTO " . $tname . "(" . $fld . ") VALUES (" . $query . ")");
		#print "INSERT INTO " . $tname . "(" . $fld . ") VALUES (" . $query . ")" . "<br>";
	}


}

########################################
#指定テーブルから指定キーの指定項目を取得する
########################################

function MakeCSVFileFromTable($fname,$tname) {

	global $result;

	$br = 0;
	$fldlabel = "";
	$strline = "";
	$tmparray = array();
	$fldname = array();
	$fldtype = array();
	$parts = array();

	#フィールド名をヘッドに挿入
	ExecSQL("DESC " . $tname); #ＳＱＬ文実行
	$fldname = MakeArrayBySpecCat("Field");

	ExecSQL("DESC " . $tname);
	$fldtype = MakeArrayBySpecCat("Type");

	for($i = 0; $i < sizeof($fldname); $i++) {

		if($fldname[$i] == "") {
			$fldname[$i] = "\&nbsp;";
		}

		$fldtype = GetFieldType(1,$tname,$fldname[$i]);
		# VARCHAR の場合
		if(preg_match("/varchar/",$fldtype)) {
			preg_match("/varchar\((.*)\)/",$fldtype,$parts);
			$fldlabel = $fldname[$i] . "_vc:" . $parts[1];
		}
		#CAHR の場合
		if(preg_match("/char/",$fldtype)) {
			preg_match("/char\((.*)\)/",$fldtype,$parts);
			$fldlabel = $fldname[$i] . "_vc:" . $parts[1];
		}
		# TEXTの場合
		elseif(preg_match("/text/",$fldtype)) {
			$fldlabel = $fldname[$i] . "_txt";
		}

		array_push($tmparray,$fldlabel);
	}

	$strline .= (join("\t",$tmparray) . "\n");


	$tmparray = array();

	ExecSQL("SELECT * from " . $tname); #ＳＱＬ文実行

	#$numRows 	= $sth->rows;			#行数
	#$numFields 	= $sth->{'NUM_OF_FIELDS'};	#項目数

	#項目に対するバインドをする
	#for($i = 1; $i <= $numFields; $i++) {
	#	$sth->bind_col($i, \$field[$i], undef);
	#}

	#項目に対するバインドをする
	$i = 0;
	$field = array();
	while($fld = mysql_fetch_field($result)) {
		#print $fld->name;
		array_push($field,$fld->name);
	}




	#メインテーブルを作成する
	while ($row = mysql_fetch_assoc($result)) {

		for($i = 0; $i < sizeof($field); $i++) {
			#if($field[$i] == "") {
			#	$field[$i] = "\&nbsp;";
			#}
			#$field[$i] = ConvHTMLTag($field[$i]);
			preg_replace("/\r/","",$row[$field[$i]]);
			preg_replace("/\n/","_N_",$row[$field[$i]]);
			preg_replace("/\t/","_T_",$row[$field[$i]]);

			array_push($tmparray,$row[$field[$i]]);
		}

		$strline = $strline . join("\t",$tmparray);
		$strline = $strline . "\n";
		$tmparray = array();

		print "|";
		$len = strlen($strline);

		if($br++ % 100 == 0) {
			print " " . $len . "<BR>\n";
		}


		if($len > 30000) {
			RecordFileData($fname,4,JS($strline));
			$strline = "";
		}

	}


	#ファイル書き込み
	RecordFileData($fname,4,JS($strline));

	return $strline;


}



########################################
#指定テーブルから指定キーの指定項目を取得する
########################################

function GetSpecFieldBySpecKeyFromSpecTable($mode,$tname,$key_fldname,$key_fldvalue,$fldname) {

	if($mode == 1) {
		ExecSQL("SELECT " . $fldname . " FROM " . $tname . " WHERE " . $key_fldname . " = '" . $key_fldvalue . "'");

		#変数格納
		$row = mysql_fetch_assoc($result);
		$strtmp = $row[$fldname];
		mysql_free_result($result);

		return $strtmp;
	}

}



########################################
# 指定項目のフィールドタイプを取得する
########################################

function GetFieldType($mode,$tname,$fldn) {

	if($mode == 1) {

		$fldname = array();
		$fldtype = array();

		ExecSQL("DESC " . $tname);
		$fldname = MakeArrayBySpecCat("Field");
		ExecSQL("DESC " . $tname);
		$fldtype = MakeArrayBySpecCat("Type");

		for($i = 0; $i < sizeof($fldname); $i++) {
			if($fldname[$i] == $fldn) {
				return $fldtype[$i];
			}
		}

		return "0";
	}
}

########################################
# 指定フィールドタイプからバイト数を取得する
########################################

function GetByteFromFieldType($fldtype) {

	$parts = array();

	if(preg_match("/varchar/",$fldtype)) {
		preg_match("/varchar\((.*)\)/",$fldtype,$parts);
		$strtmp = $parts[1];
	}
	elseif(preg_match("/text/",$fldtype)) {
		$strtmp = 5000;
	}

	return $strtmp;
}

########################################
# 連想配列を SET 文字列にする（フィルターつき）
########################################

function MakeStrSETFromHashWithFilter($mode = "",$remove = "",$hash = "") {

	while(list($k,$v) = each($hash)) {
		if(StringMatchToArray($k,$remove) == "0") {
			$strtmp .= " " . $k . " = '" . $v . "',";
		}
	}

	$strtmp = substr($strtmp,0,strlen($strtmp) - 1);

	$strtmp = "SET " . $strtmp;
	return $strtmp;
}



########################################
# 行数を取得する
########################################

function GetRows($q) {

	global $result;

	ExecSQL($q);
	$strtmp = mysql_num_rows($result);
	mysql_free_result($result);

	return $strtmp;
}


########################################
# 項目ごとを配列化する
########################################

function SetFieldToArray($strarray = "") {

	global $result;

	for($i = 0; $i < sizeof($strarray); $i++) {
		$GLOBALS[$strarray[$i]] = array();
	}

	while ($row = mysql_fetch_assoc($result)) {
		for($i = 0; $i < sizeof($strarray); $i++) {
			$TMP = $strarray[$i];
			array_push($GLOBALS[$TMP],$row[$TMP]);
		}
	}
}

########################################
# バイト数を超えてないか確認
########################################

function IsOverString($tname = "") {

	global $pOverString;
	$fldname = array();

	#フィールド名をヘッドに挿入
	ExecSQL("DESC " . $tname); #ＳＱＬ文実行
	$fldname = MakeArrayBySpecCat("Field");
		
	for($i = 0; $i < sizeof($fldname); $i++) {
		if(length($form[$fldname[$i]]) > GetByteFromFieldType(GetFieldType(1,$tname,$fldname[$i]))) {
			$pOverString = $fldname[$i];
			return 1;
		}
	}

	return 0;
}

########################################
# sth から指定項目の値を取得
########################################

function GetValueFromSTH($mode = "",$q = "",$strarray = "",$hash = "") {

	global $result;

	if($mode == 1) {
		$row = mysql_fetch_assoc($result);
		$strtmp = $row[$q];
		mysql_free_result($result);

		return $strtmp;
	} elseif($mode == 2) {
		$row = mysql_fetch_assoc($result);
		for($i = 0; $i < sizeof($strarray); $i++) {
			$tmp = $strarray[$i];
			$GLOBALS[$tmp] = $row[$tmp];
		}
		mysql_free_result($result);	
	} elseif($mode == 3) {
		$row = mysql_fetch_assoc($result);
		for($i = 0; $i < sizeof($strarray); $i++) {
			$tmp = $strarray[$i];
			$hash[$tmp] = $row[$tmp];
		}
		mysql_free_result($result);	
	}
}

########################################
# form 変数を指定テーブルに登録
########################################

function InsertFromHash($tname = "",$hash = "") {

	$qfld = array();

	#INSERT文作成
	ExecSQL("DESC " . $tname);
	$qfld = MakeArrayBySpecCat("Field");

	$StrSET = "";
	for($i = 0; $i < sizeof($qfld); $i++) {
		$TMP = $qfld[$i];

		if(!isset($hash[$TMP])) {
			$hash[$TMP] = "";
		}

		$StrSET .= $TMP . " = '" . $hash[$TMP] . "',";
	}

	$StrSET = substr($StrSET,0,strlen($StrSET) - 1);

	$q = "
		INSERT INTO " . $tname . " SET 
			" . $StrSET . "
	";

	#Err_Admin($q);

	#登録実行 --------------- ここから
	ExecSQL($q);
}


########################################
# form 変数を指定テーブルに登録
########################################

function UpdateFromHash($tname = "",$hash = "",$where = "") {

	$qfld = array();

	#INSERT文作成
	ExecSQL("DESC " . $tname);
	$qfld = MakeArrayBySpecCat("Field");

	$StrSET = "";
	for($i = 0; $i < sizeof($qfld); $i++) {
		$TMP = $qfld[$i];

		if(!isset($hash[$TMP])) {
			$hash[$TMP] = "";
		}

		$StrSET .= $TMP . " = '" . $hash[$TMP] . "',";
	}

	$StrSET = substr($StrSET,0,strlen($StrSET) - 1);

	$q = "
		UPDATE " . $tname . " SET 
			" . $StrSET . " " . $where;

	#登録実行 --------------- ここから
	ExecSQL($q);
}


?>