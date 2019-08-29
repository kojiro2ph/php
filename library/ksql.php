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
#	�r�p�k��������������
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
#	�r�p�k�ɐڑ�����
########################################
function ConnectSQL() {

	global $link,$mysql_host,$mysql_user,$mysql_pass,$mysql_db;

   	$link = mysql_connect($mysql_host, $mysql_user, $mysql_pass);
	mysql_select_db($mysql_db);

}

########################################
#	�r�p�k��ؒf����
########################################
function DisconnectSQL() {

	global $link;

	mysql_close($link);
}

########################################
#	�c�a�z����擾����
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
#	�e�[�u���z����擾����
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
#	sth��TABLE���ɂ���
########################################

function MakeTableFromSTH($tname = "") {

	global $result;

	$tmp = "";
	$strline = "";
	
	#�t�B�[���h�����w�b�h�ɑ}��
	ExecSQL("DESC " . $tname); #�r�p�k�����s
	$fldname = MakeArrayBySpecCat("Field");

	for($i = 0; $i < sizeof($fldname); $i++) {

		if($fldname[$i] == "") {
			$fldname[$i] = "\&nbsp;";
		}
		$strline .= "<td><b>" . $fldname[$i] . "</b></td>\n";
	}

	$strline = "<tr bgcolor=\"pink\">\n" . $strline . "</tr>\n";


	ExecSQL("SELECT * FROM " . $tname); #�r�p�k�����s
	#$numRows 	= mysql_num_rows($result);	#�s��
	#$numFields 	= $sth->{'NUM_OF_FIELDS'};	#���ڐ�


	#���ڂɑ΂���o�C���h������
	$i = 0;
	$field = array();
	while($fld = mysql_fetch_field($result)) {
		#print $fld->name;
		array_push($field,$fld->name);
	}


	#���C���e�[�u�����쐬����
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


	#�e�[�u������
	$strline = "
		<table style=\"font-size:10pt\" border=\"1\">
		" . $strline . "
		</table>
		";

	return $strline;


}


########################################
#	�r�p�k���s
########################################

function ExecSQL($cmd = "") {

	global $link,$result;

	if($result = mysql_query($cmd)) {
		#�N�G���[�n�j
	} else {
		#�N�G���[���s
		Err_Admin("���s");
	}



}


########################################
#	�w��t�B�[���h��z��ɓ����
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
#	�t�@�C��to�e�[�u��
########################################

function MakeTableFromCSVFile($fname = "",$tname = "") {

	global $link,$result;

	$fld = "";
	$fdataarray = array();

	#�t�@�C���ǂݍ��݁i�^�u��؂�j
	$fdata = JE(ReadFileData($fname,3));


	#print $fdata;


	$fdataarray = split("\n",$fdata);


	#print $fdataarray[0];




	#��s�ڂ���菜��
	array_shift($fdataarray);
	$fldstat = array_shift($fdataarray);




	#���ڏ���
	$fldstat = preg_replace("/\t/",",",$fldstat);
	$fldstatarray = split(",",$fldstat);

	$query = "";
	#�e�[�u���쐬  --------------��������
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

	#�s���Ƃ̂h�m�r�d�q�s���[�v --------------��������
	for($i = 0; $i < sizeof($fdataarray); $i++) {
		$query = "";

		if($fdataarray[$i] == "") {
			continue;
		}

		$fdataarray[$i] = JE($fdataarray[$i]); #�T���ǉ��i�d�v�j

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
#�w��e�[�u������w��L�[�̎w�荀�ڂ��擾����
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

	#�t�B�[���h�����w�b�h�ɑ}��
	ExecSQL("DESC " . $tname); #�r�p�k�����s
	$fldname = MakeArrayBySpecCat("Field");

	ExecSQL("DESC " . $tname);
	$fldtype = MakeArrayBySpecCat("Type");

	for($i = 0; $i < sizeof($fldname); $i++) {

		if($fldname[$i] == "") {
			$fldname[$i] = "\&nbsp;";
		}

		$fldtype = GetFieldType(1,$tname,$fldname[$i]);
		# VARCHAR �̏ꍇ
		if(preg_match("/varchar/",$fldtype)) {
			preg_match("/varchar\((.*)\)/",$fldtype,$parts);
			$fldlabel = $fldname[$i] . "_vc:" . $parts[1];
		}
		#CAHR �̏ꍇ
		if(preg_match("/char/",$fldtype)) {
			preg_match("/char\((.*)\)/",$fldtype,$parts);
			$fldlabel = $fldname[$i] . "_vc:" . $parts[1];
		}
		# TEXT�̏ꍇ
		elseif(preg_match("/text/",$fldtype)) {
			$fldlabel = $fldname[$i] . "_txt";
		}

		array_push($tmparray,$fldlabel);
	}

	$strline .= (join("\t",$tmparray) . "\n");


	$tmparray = array();

	ExecSQL("SELECT * from " . $tname); #�r�p�k�����s

	#$numRows 	= $sth->rows;			#�s��
	#$numFields 	= $sth->{'NUM_OF_FIELDS'};	#���ڐ�

	#���ڂɑ΂���o�C���h������
	#for($i = 1; $i <= $numFields; $i++) {
	#	$sth->bind_col($i, \$field[$i], undef);
	#}

	#���ڂɑ΂���o�C���h������
	$i = 0;
	$field = array();
	while($fld = mysql_fetch_field($result)) {
		#print $fld->name;
		array_push($field,$fld->name);
	}




	#���C���e�[�u�����쐬����
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


	#�t�@�C����������
	RecordFileData($fname,4,JS($strline));

	return $strline;


}



########################################
#�w��e�[�u������w��L�[�̎w�荀�ڂ��擾����
########################################

function GetSpecFieldBySpecKeyFromSpecTable($mode,$tname,$key_fldname,$key_fldvalue,$fldname) {

	if($mode == 1) {
		ExecSQL("SELECT " . $fldname . " FROM " . $tname . " WHERE " . $key_fldname . " = '" . $key_fldvalue . "'");

		#�ϐ��i�[
		$row = mysql_fetch_assoc($result);
		$strtmp = $row[$fldname];
		mysql_free_result($result);

		return $strtmp;
	}

}



########################################
# �w�荀�ڂ̃t�B�[���h�^�C�v���擾����
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
# �w��t�B�[���h�^�C�v����o�C�g�����擾����
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
# �A�z�z��� SET ������ɂ���i�t�B���^�[���j
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
# �s�����擾����
########################################

function GetRows($q) {

	global $result;

	ExecSQL($q);
	$strtmp = mysql_num_rows($result);
	mysql_free_result($result);

	return $strtmp;
}


########################################
# ���ڂ��Ƃ�z�񉻂���
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
# �o�C�g���𒴂��ĂȂ����m�F
########################################

function IsOverString($tname = "") {

	global $pOverString;
	$fldname = array();

	#�t�B�[���h�����w�b�h�ɑ}��
	ExecSQL("DESC " . $tname); #�r�p�k�����s
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
# sth ����w�荀�ڂ̒l���擾
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
# form �ϐ����w��e�[�u���ɓo�^
########################################

function InsertFromHash($tname = "",$hash = "") {

	$qfld = array();

	#INSERT���쐬
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

	#�o�^���s --------------- ��������
	ExecSQL($q);
}


########################################
# form �ϐ����w��e�[�u���ɓo�^
########################################

function UpdateFromHash($tname = "",$hash = "",$where = "") {

	$qfld = array();

	#INSERT���쐬
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

	#�o�^���s --------------- ��������
	ExecSQL($q);
}


?>