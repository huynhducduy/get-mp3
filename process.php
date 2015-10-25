<?php
	/**
	*
 	* @miniProject: Get Info Zing Mp3 & NCT
	* @author Del Huỳnh - fb.com/huynhducuduy
	* @param [GET]title,[GET]artist?,[GET]type
	*
	*/

	error_reporting(E_ALL & ~E_NOTICE & ~E_DEPRECATED);

	////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

	function getStr($string,$start,$end){
		$str = explode($start,$string,2);
		$str = explode($end,$str[1],2);
		return $str[0];
	}

	////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

	function goCurl($url)
	{
		$options = array(
			CURLOPT_URL			   => $url,
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_ENCODING       => "",
			CURLOPT_FOLLOWLOCATION    => true,
		);
		$ch = curl_init();
		curl_setopt_array($ch,$options);
		$content = curl_exec($ch);
		return $content;
		curl_close($ch);
	}

	////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

	$title = $_GET['title'];
	$artist = $_GET['artist'];
	$hostType = $_GET['type'];
	switch ($hostType) {
		case '1': // Zing Mp3
			if ($title == '')
			{
				$mp3['error'] = 1;
			}
			else
			{
				$mp3['error'] = 0;

				$url = 'http://mp3.zing.vn/tim-kiem/bai-hat.html?q='.rawurlencode($title);

				if ($artist != '') {
					$url .= rawurlencode(' - '.$artist);
				}
				//$url .= "&filter=hq";

				$mp3SearchContent = goCurl($url);
				$mp3Id = getStr($mp3SearchContent,'<div class="item-song" id="song','"');
				if ($mp3Id != '')
				{
					$mp3Content = goCurl('http://m.mp3.zing.vn/bai-hat/a/'.$mp3Id.'.html');
					$mp3XmlId = getStr($mp3Content,'<div id="mp3Player" loop="true" xml="http://m.mp3.zing.vn/xml/song/','"');
					$mp3XmlContent = goCurl('http://mp3.zing.vn/xml/song-xml/'.$mp3XmlId);
					$mp3mXmlContent = goCurl('http://m.mp3.zing.vn/xml/song/'.$mp3XmlId);

					////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

					$mp3['image'] = getStr($mp3Content,'<img width="72" height="72" src="','"');
					$mp3['lyricText'] = getStr($mp3Content,'<p id="conLyrics" class="row-5">','</p>');
					$mp3['link'] = getStr($mp3XmlContent,'<data page="','"');
					$mp3['artistLink'] = getStr($mp3XmlContent,'<link><![CDATA[ ',']]></link>');
					$mp3['title'] = getStr($mp3XmlContent,'<title><![CDATA[ ',']]></title>');
					$mp3['artist'] = getStr($mp3XmlContent,'<performer><![CDATA[',']]></performer>');
					$mp3['download'] = str_replace('\/','/',getStr($mp3mXmlContent,'"source":"','"'));
					$mp3['lyric'] = getStr($mp3XmlContent,'<lyric><![CDATA[',']]></lyric>');
					$mp3['embed'] = '<iframe width="600" height="168" src="http://mp3.zing.vn/embed/song/'.$mp3Id.'" frameborder="0" allowfullscreen="true"></iframe>';

					////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

					$mp3GetLinkFsContent = goCurl('http://getlinkfs.com/getfile/zingmp3.php?id='.$mp3Id);
					$mp3['downloadHq'] = getStr($mp3GetLinkFsContent,'128kbps </strong></a>hay <a style="text-decoration: none" href="','"');
					if ($mp3['downloadHq'] == '') { $mp3['downloadHq'] = getStr($mp3GetLinkFsContent,'128kbps </strong></a> hay<a style="text-decoration: none" href="','"'); }
				}
				else
				{
					$mp3['error'] = 3;
				}
			}
		break;

		case '2': // NCT
			if ($title == '')
			{
				$mp3['error']=1;
			}
			else
			{
				$mp3['error'] = 0;

				$url = 'http://www.nhaccuatui.com/tim-nang-cao?title='.rawurlencode($title);

				if ($artist != '') {
					$url .= '&singer='.rawurlencode($artist);
				}
				$mp3SearchContent = goCurl($url);
				$mp3Id = getStr($mp3SearchContent,'<a href="javascript:;" id="btnShowBoxPlaylist_','"');
				if ($mp3Id != '')
				{
					$mp3Content = goCurl('http://www.nhaccuatui.com/bai-hat/a.'.$mp3Id.'.html');
					$mp3XmlId = getStr($mp3Content,'http://www.nhaccuatui.com/flash/xml?html5=true&key1=','";');
					$mp3XmlContent = goCurl('http://www.nhaccuatui.com/flash/xml?html5=true&key1='.$mp3XmlId);

					////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

					$mp3['link'] = getStr(getStr($mp3XmlContent,'<info>','</info>'),'<![CDATA[',']]>');
					$mp3['lyricText'] = getStr($mp3Content,'<p id="divLyric" class="pd_lyric trans" style="height:auto;max-height:255px;overflow:hidden;">','</p>');
					$mp3['artistLink'] = getStr(getStr($mp3XmlContent,'<newtab>','</newtab>'),'<![CDATA[',']]>');
					$mp3['title'] = getStr(getStr($mp3XmlContent,'<title>','</title>'),'<![CDATA[',']]>');
					$mp3['artist'] = getStr(getStr($mp3XmlContent,'<creator>','</creator>'),'<![CDATA[',']]>');
					$mp3['download'] = getStr(getStr($mp3XmlContent,'<location>','</location>'),'<![CDATA[',']]>');
					$mp3['lyric'] = getStr(getStr($mp3XmlContent,'<lyric>','</lyric>'),'<![CDATA[',']]>');
					$mp3['image'] = getStr(getStr($mp3XmlContent,'<avatar>','</avatar>'),'<![CDATA[',']]>');
					$mp3['embed'] = '<iframe src="http://www.nhaccuatui.com/mh/auto/'.$mp3Id.'" width="316" height="382" frameborder="0" allowfullscreen></iframe>';

					////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

					$mp3HqJsonContent = goCurl('http://www.nhaccuatui.com/download/song/'.$mp3Id);
					$mp3['downloadHq'] = str_replace('\/','/',getStr($mp3HqJsonContent,'"stream_url":"','"'));
				}
				else
				{
					$mp3['error'] = 3;
				}
			}

		break;
		default:
			$mp3['error']=2;
		break;
	}

	////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	//sleep(1);
	die (json_encode($mp3));
?>
