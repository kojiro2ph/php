<?php

#�@@(f)
#
#�@�@�\�@	�F	�u���E�U���������R�[�h�ϊ�����
#
#�@�����@	�F	�ϊ������R�[�h
#
#�@�Ԃ�l	�F	�Ȃ�
#
#�@�@�\�����@	�F	�u���E�U����̕����������������
#
#�@���l�@	�F	����ɂȂ�܂���(^^ ;

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

#�@@(f)
#
#�@�@�\�@	�F	�t�@�C���Ǎ�����
#
#�@�����@	�F	$fname	---	�t�@�C�����i�p�X�����j
#			$way	---	�I�v�V���� 
#					(1)������ŕԂ�
#					(2)�z��ŕԂ�
#
#�@�Ԃ�l	�F	�t�@�C���̕�����
#
#�@�@�\�����@	�F	�t�@�C���f�[�^��ǂݍ���ŕԂ�
#
#�@���l�@	�F	�����R�[�h�ϊ������Ȃ��ŕԂ�

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

#�@@(f)
#
#�@�@�\�@	�F	�t�@�C����������
#
#�@�����@	�F	$fname		---	�t�@�C�����i�p�X�����j
#			$way		---	�I�v�V���� 
#						(1)�e������z��ɉ��s��t�����ď������� 
#						(2)�e������z������̂܂܏������� 
#						(3)����������̂܂܏������� 
#			$strline 	---	������ϐ�
#			$strArray	---	������z�� 
#
#�@�Ԃ�l	�F	�Ȃ�
#
#�@�@�\�����@	�F	�t�@�C���f�[�^�Ɉ����̕�����܂��͕�����z�����������
#
#�@���l�@	�F	�����R�[�h�ϊ������Ȃ��ŏ�������

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


#�@@(f)
#
#�@�@�\�@	�F	�T�[�o�[�������擾����
#
#�@�����@	�F	�Ȃ�
#
#�@�Ԃ�l	�F	�N���������b������
#
#�@�@�\�����@	�F	���݂̓��t�E���Ԃ�":"������ŕԂ�
#
#�@���l�@	�F	���{�ƊC�O�ł͎��Ԃ��Ⴄ�̂ŗv����

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

#�@@(f)
#
#�@�@�\�@	�F	�w�b�_�[������쐬����
#
#�@�����@	�F	�Ȃ�
#
#�@�Ԃ�l	�F	�g�s�l�k�w�b�_������
#
#�@�@�\�����@	�F	�g�s�l�k�w�b�_�̕������Ԃ�
#
#�@���l�@	�F	������ text/html �ȊO�ɂ����\��

function PH() {
	return "Content-Type: text/html\n\n";
}

#�@@(f)
#
#�@�@�\�@	�F	�X�V�y�[�W������쐬����
#
#�@�����@	�F	$url	--- 	�W�����v��t�q�k�ihttp:// ����L���j
#			$sec	--- 	�X�V�A�N�V�����̊ԁ@�i$sec�b)
#			$str 	--- 	�y�[�W�ɕ\�����镶����
#
#�@�Ԃ�l	�F	�g�s�l�k������
#
#�@�@�\�����@	�F	�g�s�l�k�̕������Ԃ�
#
#�@���l�@	�F	���ɂȂ�

function MakeRefresh($url = "",$sec = "",$str = "") {

	$strline = "<html><head><title>�X�V���E�E�E</title><META HTTP-EQUIV='Content-Type' Content=\"text/html; charset=x-euc-jp\"><META HTTP-EQUIV='Refresh' Content=\"$sec ; url='$url'\"></head><body>$str</body></html>";
	
	return $strline;
}

#�@@(f)
#
#�@�@�\�@	�F	�g�s�l�k�p������ϊ�����
#
#�@�����@	�F	$strtmp	--- 	�ϊ����镶����
#
#�@�Ԃ�l	�F	�g�s�l�k������
#
#�@�@�\�����@	�F	��ʕ�������g�s�l�k�p������ɕϊ�����
#
#�@���l�@	�F	���ɂȂ�

function ConvHTMLTag($strtmp = "") {

	return htmlspecialchars($strtmp);
}

#�@@(f)
#
#�@�@�\�@	�F	����������ϊ�����
#
#�@�����@	�F	$strtmp	--- 	�ϊ����镶����
#			$way	---	�I�v�V����
#					(1)�N�������ŕԂ�
#					(2) 
#					(3)
#
#�@�Ԃ�l	�F	����������
#
#�@�@�\�����@	�F	�f�[�^���̈Í����������������������K���̕�����ɕϊ�����
#
#�@���l�@	�F	���ɂȂ�

function ConvDateString($strtmp = "",$way = "",$sp = "") {

	if($sp == "") $sp = "_" ;

	if($way == 1) {
		list($year,$mon,$date,$hour,$min,$sec) = split("$sp",$strtmp);
		$strtmp = $year . "�N" . $mon . "��" . $date . "��" . $hour . "��";
		return $strtmp;
	} elseif($way == 2) {
		list($year,$mon,$date,$hour,$min,$sec) = split("$sp",$strtmp);
		$strtmp = $year . "�N" . $mon . "��" . $date . "��" . $hour . "��" . $min . "��";
		return $strtmp;
	}
}

#�@@(f)
#
#�@�@�\�@	�F	META�^�O������쐬����
#
#�@�����@	�F	$way ---	�I�v�V����
#					(euc)charset �� �d�t�b�R�[�h�ɂ���
#
#�@�Ԃ�l	�F	META�^�O������
#
#�@�@�\�����@	�F	META�^�O�������Ԃ�
#
#�@���l�@	�F	

function PrintMETA($way = "") {

	if($way == "euc") {
		$strtmp = "<META HTTP-EQUIV=\"Content-Type\" CONTENT=\"text/html; charset=x-euc-jp\">";
		return $strtmp;
	}
}


#�@@(f)
#
#�@�@�\�@	�F	�ݒ�t�@�C������������
#
#�@�����@	�F	$mode ---	�I�v�V����
#					(1)�W�����[�h
#					(2)�Z�N�V�������̕������Ԃ�
#			$fname ---	�t�@�C����
#			$section ---	�Z�N�V����
#�@�Ԃ�l	�F	�Ȃ��A������
#
#�@�@�\�����@	�F	[SECTION] KEY = VAL �̃t�H�[�}�b�g��%hash{SECTION-KEY} �Ɋi�[����
#
#�@���l�@	�F	

function InitINIData($mode,$fname,$section = "") {

	$INIData = array();

	#------------------------
	#	�W�����[�h
	#------------------------

	if($mode == 1) {
		$strline = ReadFileData($fname, 1);	#�ݒ�t�@�C���̓ǂݍ���
		$strline = JE($strline);
		$strline = preg_replace("/\r/","",$strline);
		$strarray = array();
		$strarray = split("\n",$strline);	#���s���Ƃɋ�؂�

		#�ݒ�t�@�C��������� �A�z�z�� INIData �Ɋi�[���郋�[�v�@--- �J�n ---
		for($i = 0; $i < sizeof($strarray); $i++) {
			#�Z�N�V�����������E�y�ѕύX
			if(preg_match("/\[.*\]/",$strarray[$i])) {	
				#print "Section:$strarray[$i]<br>\n";	#�f�o�O�p
				$strarray[$i] = preg_replace("/(\[|\])/","",$strarray[$i]);#�����ʂ��͂���				
				$StrCurSection = $strarray[$i];		#�J�����g�Z�N�V�����ϐ��̊i�[����
				#print $StrCurSection . "<br>";
				continue;
			#�L�[�ƒl�̂̏�����
			} elseif(preg_match("/.*=.*/",$strarray[$i])) {
				$strarray[$i] = preg_replace("/(\t|;.*|\/\*.*\*\/)/","",$strarray[$i]); #�^�u�E�X�y�[�X�E�R�����g����������

				list($StrCurKey,$StrCurVal) = split("=",$strarray[$i],2);	#�L�[�ƒl�ɕ�����
				#print "Key:$StrCurKey Value:$StrCurVal<br>\n";		#�f�o�O�p
				$StrCurSecKey = $StrCurSection . "-" . $StrCurKey;	#������ -> "�L�[-�l"�����
				#print "MainKey:$StrCurSecKey<br>\n";		#�f�o�O�p
				$StrCurVal = trim($StrCurVal);	#NEW

				$StrCurVal = preg_replace("/(^\"|\"$)/","",$StrCurVal);#���p�� " ���������ꍇ��菜��

				#print $StrCurVal . "<br>";

				$GLOBALS[$StrCurKey] = $StrCurVal;
				$INIData[$StrCurSecKey] = $StrCurVal;	#�A�z�z��Ɋi�[����
			}
		}
		#�ݒ�t�@�C��������� �A�z�z�� INIData �Ɋi�[���郋�[�v�@--- �I�� ---

		return $INIData;

	#------------------------
	#	�g�s�l�k���[�h
	#------------------------
	} elseif($mode == 2) {

		$MatchFlag = 0;
		$strtmp = "";

		$strline = ReadFileData($fname, 1);	#�ݒ�t�@�C���̓ǂݍ���
		$strline = JE($strline);
		$strline = preg_replace("/\r/","",$strline);
		$strarray = array();
		$strarray = split("\n",$strline);		#���s���Ƃɋ�؂�

		#�ݒ�t�@�C��������� �A�z�z�� INIData �Ɋi�[���郋�[�v�@--- �J�n ---
		for($i = 0; $i < sizeof($strarray); $i++) {
			if($MatchFlag == 0) {
				#�Z�N�V�����������E�y�ѕύX
				if(preg_match("/\[.*\]/",$strarray[$i])) {
					#print "Section:$strarray[$i]<br>\n";	#�f�o�O�p
					$strarray[$i] = preg_replace("(\[|\])","",$strarray[$i]);#�����ʂ��͂���	
					#print "$strarray[$i] $section<br>";	#�f�o�O�p
					if($strarray[$i] == $section) {
						$MatchFlag = 1;
						#print "match";	#�f�o�O�p
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
		#�ݒ�t�@�C��������� �A�z�z�� INIData �Ɋi�[���郋�[�v�@--- �I�� ---


		return $strtmp;
	}
}


#�@@(f)
#
#�@�@�\�@	�F	�w�萔�l�t�H�[�}�b�g�ϊ�����
#
#�@�����@	�F	$mode ---	�I�v�V����
#					(1)�S������������̐����� (��F0234 -> 234) 
#					(2)������������w�肵�����̕�����ɕϊ�
#			$str ---	����
#			$cmd01 ---	�R�}���h�P
#			$cmd02 ---	�R�}���h�Q
#
#�@�Ԃ�l	�F	����
#
#�@�@�\�����@	�F	
#
#�@���l�@	�F	

function Sprint($mode = "",$str = "",$cmd01 = "",$cmd02 = "") {

	# �S������������̐����� (��F0234 -> 234) 
	if($mode == 1) {
		$strtmp = $str + 0;
	}
	# ������������w�肵�����̕�����ɕϊ�
	elseif($mode == 2) {
		$strtmp = sprintf("%0" . $cmd01 . "d",$str);
	}

	return $strtmp;
}


#�@@(f)
#
#�@�@�\�@	�F	�b�r�u�t�@�C���ǂݍ���
#
#�@�����@	�F	$mode ---	�I�v�V����
#					(1)�A�z�z��Ɋi�[����
#			$fname ---	�t�@�C����
#
#
#�@�Ԃ�l	�F	�A�z�z��
#
#�@�@�\�����@	�F	
#
#�@���l�@	�F	

function ReadCSVFile($mode,$fname) {

	if($mode == 1) {

		$InValFlag = 0;

		$strline = ReadFileData($fname,1);
		#�d�t�b�ɕϊ�����
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
						#��؂�J���}�̏ꍇ
						if($InValFlag == 0) {
						#�l�J���}�̏ꍇ
						} elseif($InValFlag == 1) {
							$chararray[$j] = preg_replace($chararray[$j],"_VALKAM_",$chararray[$j]);
						}
					}
				}
			}

			$strarray[$i] = join("",$chararray);
			$strarray[$i] = preg_replace("\"","",$strarray[$i]);

			#�f�o�O�p
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


#�@@(f)
#
#�@�@�\�@	�F	�w�蕶���J�E���g����
#
#�@�����@	�F	$mode ---	�I�v�V����
#					(1)�W��
#			$str ---	�T���Ƃ���̕�����
#			$charF ---	�J�E���g���镶��
#
#�@�Ԃ�l	�F	��v��
#
#�@�@�\�����@	�F	
#
#�@���l�@	�F	

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


#�@@(f)
#
#�@�@�\�@	�F	���̋󔒂��폜����
#
#�@�����@	�F	$strtmp ---	������
#
#�@�Ԃ�l	�F	�폜����������
#
#�@�@�\�����@	�F	
#
#�@���l�@	�F	

function TrimL($strtmp) {

	$strtmp = preg_replace("^\s+","",$strtmp);

	return $strtmp;
}

#�@@(f)
#
#�@�@�\�@	�F	�������͂���
#
#�@�����@	�F	$mode ---	�I�v�V����
#					(1)�W��
#			$str ---	�����̕���
#			#substr ---	�[�̕���
#
#�@�Ԃ�l	�F	������
#
#�@�@�\�����@	�F	
#
#�@���l�@	�F	

function SandWitch($mode,$str,$substr) {

	if($mode == 1) {
		$strtmp = $substr . $str . $substr;
	}

	return $strtmp;
}


#�@@(f)
#
#�@�@�\�@	�F	�d�t�b�R�[�h�ϊ�
#
#�@�����@	�F	$strtmp ---	������
#
#�@�Ԃ�l	�F	������
#
#�@�@�\�����@	�F	
#
#�@���l�@	�F	

function JE($strtmp = "") {

	if(function_exists("i18n_convert")) {
		$strtmp = i18n_convert($strtmp,"EUC",i18n_discover_encoding($strtmp));
	} else {
		$strtmp = $strtmp;
	}

		return $strtmp;

}

#�@@(f)
#
#�@�@�\�@	�F	�d�t�b�R�[�h�ϊ�
#
#�@�����@	�F	$strtmp ---	������
#
#�@�Ԃ�l	�F	������
#
#�@�@�\�����@	�F	
#
#�@���l�@	�F	

function JJ($strtmp = "") {

	if(function_exists("i18n_convert")) {
		$strtmp = i18n_convert($strtmp,"JIS",i18n_discover_encoding($strtmp));
	} else {
		$strtmp = $strtmp;
	}

		return $strtmp;

}


#�@@(f)
#
#�@�@�\�@	�F	�r�g�h�e�s�|�i�h�r�R�[�h�ϊ�
#
#�@�����@	�F	$strtmp ---	������
#
#�@�Ԃ�l	�F	������
#
#�@�@�\�����@	�F	
#
#�@���l�@	�F	
	
function JS($strtmp = "") {

	return $strtmp;

}

#�g�s�l�k�^�O�ϐ�������

#�@@(f)
#
#�@�@�\�@	�F	
#
#�@�����@	�F	
#
#�@�Ԃ�l	�F	
#
#�@�@�\�����@	�F	
#
#�@���l�@	�F	

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

#�@@(f)
#
#�@�@�\�@	�F	
#
#�@�����@	�F	
#
#�@�Ԃ�l	�F	
#
#�@�@�\�����@	�F	
#
#�@���l�@	�F	

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

#�@@(f)
#
#�@�@�\�@	�F	
#
#�@�����@	�F	
#
#�@�Ԃ�l	�F	
#
#�@�@�\�����@	�F	
#
#�@���l�@	�F	

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

#�@@(f)
#
#�@�@�\�@	�F	
#
#�@�����@	�F	
#
#�@�Ԃ�l	�F	
#
#�@�@�\�����@	�F	
#
#�@���l�@	�F	

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

#�@@(f)
#
#�@�@�\�@	�F	
#
#�@�����@	�F	
#
#�@�Ԃ�l	�F	
#
#�@�@�\�����@	�F	
#
#�@���l�@	�F	

function ConvCSVString($strtmp) {

	$strtmp = preg_replace("\"","\"\"",$strtmp);

	if(preg_match("/,/",$strtmp)) {
		$strtmp = SandWitch(1,$strtmp,"\"");
	}

	$strtmp = preg_replace("\r\n","\n",$strtmp);
	$strtmp = preg_replace("\n","_N_",$strtmp);

	return $strtmp;
}

#�@@(f)
#
#�@�@�\�@	�F	
#
#�@�����@	�F	
#
#�@�Ԃ�l	�F	
#
#�@�@�\�����@	�F	
#
#�@���l�@	�F	

function ConvInputString($strtmp) {

	$strtmp = preg_replace("_N_","\n",$strtmp);

	return $strtmp;
}

#�@@(f)
#
#�@�@�\�@	�F	
#
#�@�����@	�F	
#
#�@�Ԃ�l	�F	
#
#�@�@�\�����@	�F	
#
#�@���l�@	�F	

function UpdateINIFile($mode,$fname,$section,$strFkey,$strCval) {
	

	$strline = ReadFileData($fname, 1);	#�ݒ�t�@�C���̓ǂݍ���
	$strline = JE($strline);
	$strarray = split("\n",$strline);		#���s���Ƃɋ�؂�


	for($i = 0; $i < sizeof($strarray); $i++) {
		#�Z�N�V�����������E�y�ѕύX
		if(preg_match("/\[.*\]/",$strarray[$i])) {
			#print "Section:$strarray[$i]<br>\n";	#�f�o�O�p
			
			$StrCurSection = $strarray[$i];		#�J�����g�Z�N�V�����ϐ��̊i�[����
			$StrCurSection = preg_replace("(\[|\])","",$StrCurSection);#�����ʂ��͂���

			continue;
		#�L�[�ƒl�̂̏�����
		} elseif((preg_match("/^$strFkey/",$strarray[$i])) && ($StrCurSection == $section)) {
			$strFval = $section . "-" . $strFkey;
			$strarray[$i] = preg_replace("= $INI{$strFval}","= $strCval",$strarray[$i]);
		}
	}

	$strline = join("\n",$strarray);
	#jcode'convert(*strline, $INI{'GROBAL-DecodeINITo'});
	RecordFileData($fname, 3, $strline, $strarray);



}

#�@@(f)
#
#�@�@�\�@	�F	
#
#�@�����@	�F	
#
#�@�Ԃ�l	�F	
#
#�@�@�\�����@	�F	
#
#�@���l�@	�F	

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

#�@@(f)
#
#�@�@�\�@	�F	
#
#�@�����@	�F	
#
#�@�Ԃ�l	�F	
#
#�@�@�\�����@	�F	
#
#�@���l�@	�F	

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

#�@@(f)
#
#�@�@�\�@	�F	
#
#�@�����@	�F	
#
#�@�Ԃ�l	�F	
#
#�@�@�\�����@	�F	
#
#�@���l�@	�F	

function StringMatchToArray($strF,$strarray) {

	for($i = 0;$i < sizeof($strarray); $i++) {
		$TMP = $strarray[$i];
		if(($TMP == $strF) && ($strF != "")) {
			return "1";
		}
	}

	return "0";
}

#�@@(f)
#
#�@�@�\�@	�F	
#
#�@�����@	�F	
#
#�@�Ԃ�l	�F	
#
#�@�@�\�����@	�F	
#
#�@���l�@	�F	

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

#�@@(f)
#
#�@�@�\�@	�F	
#
#�@�����@	�F	
#
#�@�Ԃ�l	�F	
#
#�@�@�\�����@	�F	
#
#�@���l�@	�F	

function OpenBinaryFileData($fname) {


}

#�@@(f)
#
#�@�@�\�@	�F	
#
#�@�����@	�F	
#
#�@�Ԃ�l	�F	
#
#�@�@�\�����@	�F	
#
#�@���l�@	�F	

function RecordBinaryFileData($fname,$fdata) {

}

#�@@(f)
#
#�@�@�\�@	�F	
#
#�@�����@	�F	
#
#�@�Ԃ�l	�F	
#
#�@�@�\�����@	�F	
#
#�@���l�@	�F	

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

#�@@(f)
#
#�@�@�\�@	�F	
#
#�@�����@	�F	
#
#�@�Ԃ�l	�F	
#
#�@�@�\�����@	�F	
#
#�@���l�@	�F	

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

#�@@(f)
#
#�@�@�\�@	�F	
#
#�@�����@	�F	
#
#�@�Ԃ�l	�F	
#
#�@�@�\�����@	�F	
#
#�@���l�@	�F	

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

#�@@(f)
#
#�@�@�\�@	�F	
#
#�@�����@	�F	
#
#�@�Ԃ�l	�F	
#
#�@�@�\�����@	�F	
#
#�@���l�@	�F	

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

#�@@(f)
#
#�@�@�\�@	�F	
#
#�@�����@	�F	
#
#�@�Ԃ�l	�F	
#
#�@�@�\�����@	�F	
#
#�@���l�@	�F	

function ConvPrice($strtmp) {

	$strtmp = preg_replace("�P","1",$strtmp);
	$strtmp = preg_replace("�Q","2",$strtmp);
	$strtmp = preg_replace("�R","3",$strtmp);
	$strtmp = preg_replace("�S","4",$strtmp);
	$strtmp = preg_replace("�T","5",$strtmp);
	$strtmp = preg_replace("�U","6",$strtmp);
	$strtmp = preg_replace("�V","7",$strtmp);
	$strtmp = preg_replace("�W","8",$strtmp);
	$strtmp = preg_replace("�X","9",$strtmp);
	$strtmp = preg_replace("�O","9",$strtmp);
	$strtmp = preg_replace("\D","",$strtmp);

	if($strtmp == "") {
		$strtmp = "0";
	}

	return $strtmp;
}

#�@@(f)
#
#�@�@�\�@	�F	
#
#�@�����@	�F	
#
#�@�Ԃ�l	�F	
#
#�@�@�\�����@	�F	
#
#�@���l�@	�F	

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

#�@@(f)
#
#�@�@�\�@	�F	
#
#�@�����@	�F	
#
#�@�Ԃ�l	�F	
#
#�@�@�\�����@	�F	
#
#�@���l�@	�F	

function StopWatchVer1($flag) {

	if($flag == "start") {
		$SW_START = time;
	} elseif($flag == "stop") {
		$SW_STOP = time;
		$strtmp = $SW_STOP - $SW_START;
		return $strtmp;
	}
	
}

#�@@(f)
#
#�@�@�\�@	�F	
#
#�@�����@	�F	
#
#�@�Ԃ�l	�F	
#
#�@�@�\�����@	�F	
#
#�@���l�@	�F	

function StockFileData($fname) {

	$CurFileData = ReadFileData($fname,1);
}

#�@@(f)
#
#�@�@�\�@	�F	
#
#�@�����@	�F	
#
#�@�Ԃ�l	�F	
#
#�@�@�\�����@	�F	
#
#�@���l�@	�F	

function ListArray($mode,$strarray) {

	if($mode == "1") {
		for($i = 0;$i < sizeof($strarray); $i++) {
			$strtmp = $strarray[$i];
			print "$strtmp<br>\n";
		}
	}
}


#�t�H���_�y�уt�@�C�����݊m�F->�Ȃ���΍��

#�@@(f)
#
#�@�@�\�@	�F	
#
#�@�����@	�F	
#
#�@�Ԃ�l	�F	
#
#�@�@�\�����@	�F	
#
#�@���l�@	�F	

function CheckAndMakeFile($fpath,$fperm) {

	if(file_exists($fpath)) {
		return "1";
	} else {
		#�Ȃ���΍��
		mkdir($fpath,$fperm);
		return "0";
	}
}

#�@@(f)
#
#�@�@�\�@	�F	�A�J�E���g������쐬
#
#�@�����@	�F	
#
#�@�Ԃ�l	�F	
#
#�@�@�\�����@	�F	
#
#�@���l�@	�F	

function MakeAccountStr($Id,$Pwd,$sp) {

	$Pwd = crypt($Pwd,substr($Pwd,0,2));

	$Id = ConvCSVString($Id);
	$Pwd = ConvCSVString($Pwd);
	$strline = join($sp,$Id,$Pwd);

	$strline = crypt($strline,substr($strline,0,2));

	$strline = ReverseString($strline);

	return $strline;

}

#�@@(f)
#
#�@�@�\�@	�F	
#
#�@�����@	�F	
#
#�@�Ԃ�l	�F	
#
#�@�@�\�����@	�F	
#
#�@���l�@	�F	

function ReverseString($strtmp) {

	$strarray = split("",$strtmp);
	$strarray = reverse($strarray);
	$strtmp = join("",$strarray);

	return $strtmp;
}

#�@@(f)
#
#�@�@�\�@	�F	
#
#�@�����@	�F	
#
#�@�Ԃ�l	�F	
#
#�@�@�\�����@	�F	
#
#�@���l�@	�F	

function ConvVal($strtmp) {
	$strtmp = preg_replace("/_(\w+)_/e","GetVal('\\1')",$strtmp);
	return $strtmp;
}

#�@@(f)
#
#�@�@�\�@	�F	
#
#�@�����@	�F	
#
#�@�Ԃ�l	�F	
#
#�@�@�\�����@	�F	
#
#�@���l�@	�F	

function GetVal($vn) {
	if(isset($GLOBALS[$vn])) {
		return $GLOBALS[$vn];
	} else {
		return "";
	}
}

# End 2000/11/29

#�@@(f)
#
#�@�@�\�@	�F	
#
#�@�����@	�F	
#
#�@�Ԃ�l	�F	
#
#�@�@�\�����@	�F	
#
#�@���l�@	�F	

#function URLEncode($strtmp) {
#	$strtmp = preg_replace("(\W)","'%'.unpack(\"H2\", $1)",$strtmp);
#	return $strtmp;
#}

#�@@(f)
#
#�@�@�\�@	�F	
#
#�@�����@	�F	
#
#�@�Ԃ�l	�F	
#
#�@�@�\�����@	�F	
#
#�@���l�@	�F	

#function URLDecode($strtmp) {
#	$strtmp = preg_replace("%([0-9a-f][0-9a-f])","pack(\"C\",hex($1))",$strtmp);
#	return $strtmp;
#}



#----------------

# End 2000/12/13

#�@@(f)
#
#�@�@�\�@	�F	
#
#�@�����@	�F	
#
#�@�Ԃ�l	�F	
#
#�@�@�\�����@	�F	
#
#�@���l�@	�F	

function ListHash($mode,$hash) {

	if($mode == "1") {
		while(list($k,$v) = each($hash)) {
			push($strarray,"$k=$v");
		}

		return $strarray;
	}

}

########################################
#	�N�b�L�[���擾����
########################################

#�@@(f)
#
#�@�@�\�@	�F	
#
#�@�����@	�F	
#
#�@�Ԃ�l	�F	
#
#�@�@�\�����@	�F	
#
#�@���l�@	�F	

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
#	�N�b�L�[�𖄂ߍ���
########################################

#�@@(f)
#
#�@�@�\�@	�F	
#
#�@�����@	�F	
#
#�@�Ԃ�l	�F	
#
#�@�@�\�����@	�F	
#
#�@���l�@	�F	

function PutCookie($c_name,$c_value,$c_time) {

	$c_year = $c_year + 1900; #�d�v�I ����� c_year �� "2000" �ɂȂ�
	if ($c_year < 10)  { $c_year = "0$c_year"; }
	if ($c_sec < 10)   { $c_sec  = "0$c_sec";  }
	if ($c_min < 10)   { $c_min  = "0$c_min";  }
	if ($c_hour < 10)  { $c_hour = "0$c_hour"; }
	if ($c_mday < 10)  { $c_mday = "0$c_mday"; }

	#�j���z��쐬
	#$day = qw(		Sun		Mon		Tue		Wed		Thu		Fri		Sat	);
	#���z��쐬
	#$month = qw(		Jan Feb Mar Apr May Jun Jul Aug Sep Oct Nov Dec	);

	#�j���ݒ�
	$c_day = $day[$c_wday];
	#���ݒ�
	$c_month = $month[$c_mon];

	#����������쐬
	$c_expires = "$c_day, $c_mday\-$c_month\-$c_year $c_hour:$c_min:$c_sec GMT";

	#�l��Ԃ�
	return "Set-Cookie: $c_name=$c_value; expires=$c_expires\n";
}

########################################
#	�w��̕b��������t���擾����
########################################

#�@@(f)
#
#�@�@�\�@	�F	
#
#�@�����@	�F	
#
#�@�Ԃ�l	�F	
#
#�@�@�\�����@	�F	
#
#�@���l�@	�F	

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
#	�t�@�C�������擾����
########################################

#�@@(f)
#
#�@�@�\�@	�F	
#
#�@�����@	�F	
#
#�@�Ԃ�l	�F	
#
#�@�@�\�����@	�F	
#
#�@���l�@	�F	

function GetSpecFileInfo($fpath,$key) {

	return ${$key};
}


########################################
#	�z�񂩂� Select ���쐬����
########################################

#�@@(f)
#
#�@�@�\�@	�F	
#
#�@�����@	�F	
#
#�@�Ԃ�l	�F	
#
#�@�@�\�����@	�F	
#
#�@���l�@	�F	

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
#	�z�񂩂� Hash ���쐬����
########################################

#�@@(f)
#
#�@�@�\�@	�F	
#
#�@�����@	�F	
#
#�@�Ԃ�l	�F	
#
#�@�@�\�����@	�F	
#
#�@���l�@	�F	

function MakeHashFromStrArray($strarray) {

	for($i = 0; $i < sizeof($strarray); $i++) {
		list($k,$v) = split("=",$strarray[$i]);
		$hash[$k] = $v;
	}

	return $hash;
}


#�@@(f)
#
#�@�@�\�@	�F	
#
#�@�����@	�F	
#
#�@�Ԃ�l	�F	
#
#�@�@�\�����@	�F	
#
#�@���l�@	�F	

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

#�@@(f)
#
#�@�@�\�@	�F	
#
#�@�����@	�F	
#
#�@�Ԃ�l	�F	
#
#�@�@�\�����@	�F	
#
#�@���l�@	�F	

function ImportHash($hash) {

	while(list($k,$v) = each($hash)) {
		#�f�o�O�p
		#print "$k = $v<br>\n";
		$GLOBALS[$k] = $v;
	}
}

#�@@(f)
#
#�@�@�\�@	�F	
#
#�@�����@	�F	
#
#�@�Ԃ�l	�F	
#
#�@�@�\�����@	�F	
#
#�@���l�@	�F	

function ExportHash($hash) {

	#print PH;

	while(list($k,$v) = each($hash)) {
		#�f�o�O�p
		#print "$k = $v<br>\n";
		$hash[$k] = $v;
		#print "$k<BR>";
	}
}

#�@@(f)
#
#�@�@�\�@	�F	
#
#�@�����@	�F	
#
#�@�Ԃ�l	�F	
#
#�@�@�\�����@	�F	
#
#�@���l�@	�F	

function CheckFileDateAndDelete($mode,$fpath,$v) {

	#�G���[����
	if(!(file_exists($fpath))) {
		return "0";
	}

	if($mode == "hour") {
		#�f�o�O�p
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

#�@@(f)
#
#�@�@�\�@	�F	
#
#�@�����@	�F	
#
#�@�Ԃ�l	�F	
#
#�@�@�\�����@	�F	
#
#�@���l�@	�F	

function MakeTempLabel($strtmp) {

	$strtmp = "<br> <br> <center> $f4<b>$strtmp</b>$fc </center>";

	return $strtmp;
}

#�@@(f)
#
#�@�@�\�@	�F	
#
#�@�����@	�F	
#
#�@�Ԃ�l	�F	
#
#�@�@�\�����@	�F	
#
#�@���l�@	�F	

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

#�@@(f)
#
#�@�@�\�@	�F	
#
#�@�����@	�F	
#
#�@�Ԃ�l	�F	
#
#�@�@�\�����@	�F	
#
#�@���l�@	�F	

function KstdSendMail($mode,$mailprog,$from,$to,$subject,$content) {

	if($mode == 1) {
	}
	#�Y�t�t�@�C���t�� -------------
	elseif($mode == 2) {
	}

}


#�@@(f)
#
#�@�@�\�@	�F	
#
#�@�����@	�F	
#
#�@�Ԃ�l	�F	
#
#�@�@�\�����@	�F	
#
#�@���l�@	�F	

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

#�@@(f)
#
#�@�@�\�@	�F	
#
#�@�����@	�F	
#
#�@�Ԃ�l	�F	
#
#�@�@�\�����@	�F	
#
#�@���l�@	�F	

function ConvPriceComma($strtmp) {

	while(preg_match("(.*\d)(\d\d\d)","$1,$2",$strtmp)) {
	}

	return $strtmp;
}

#�@@(f)
#
#�@�@�\�@	�F	
#
#�@�����@	�F	
#
#�@�Ԃ�l	�F	
#
#�@�@�\�����@	�F	
#
#�@���l�@	�F	

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

#�@@(f)
#
#�@�@�\�@	�F	�l�̌ܓ�����
#
#�@�����@	�F	$num ---	����
#			$decimals ---	�l�̌ܓ����錅
#
#�@�Ԃ�l	�F	����
#
#�@�@�\�����@	�F	
#
#�@���l�@	�F	�؂蕨

function pRound($num, $decimals) {
  $format = '%.' . $decimals . 'f';
  $magic = ($num > 0) ? 0.5 : -0.5;
  #sprintf($format, int(($num * (10 ** $decimals)) + $magic)) / (10 ** $decimals));
}

#�@@(f)
#
#�@�@�\�@	�F	���t�t�H�[�}�b�g����������
#
#�@�����@	�F	$strtmp ---	�F������
#
#�@�Ԃ�l	�F	YYYY/MM/DD������
#
#�@�@�\�����@	�F	
#
#�@���l�@	�F	

function GetDltDateString($strtmp) {

	$strtmp = GetDateString;
	$strtmp = preg_replace(":","\/",$strtmp);
	#($strtmp,$dum) = $strtmp =~ /(..........)(......)/;

	return $strtmp;

}

#�@@(f)
#
#�@�@�\�@	�F	���w����
#
#�@�����@	�F	�P���O
#
#�@�Ԃ�l	�F	���A�w
#
#�@�@�\�����@	�F	
#
#�@���l�@	�F	

function MaruBatu($q) {

	if($q) {
		return "��";
	} else {
		return "�~";
	}
}

#�@@(f)
#
#�@�@�\�@	�F	�P�ƂO����������
#
#�@�����@	�F	�P���O
#
#�@�Ԃ�l	�F	�P���O
#
#�@�@�\�����@	�F	
#
#�@���l�@	�F	

function IchiZero($q) {

	if($q) {
		return "0";
	} else {
		return "1";
	}
}

#�@@(f)
#
#�@�@�\�@	�F	�z���������
#
#�@�����@	�F	$old ---	�z��
#
#�@�Ԃ�l	�F	�z��
#
#�@�@�\�����@	�F	
#
#�@���l�@	�F	

function SuffleArray($old) {

	while ($old) {
		#push($new, splice($old, int(rand() * $#old), 1));
	}

	return $new;

}

#�@@(f)
#
#�@�@�\�@	�F	�t�@�C���^�C�v����
#
#�@�����@	�F	$strtmp ---	�t�@�C�����{�g���q
#
#�@�Ԃ�l	�F	�g���q������
#
#�@�@�\�����@	�F	
#
#�@���l�@	�F	

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
# �b�r�u���������ʕ�����ɂ��Ĕz��ɂ��ĕԂ�
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
				#��؂�J���}�̏ꍇ
				if($InValFlag == 0) {
				#�l�J���}�̏ꍇ
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

