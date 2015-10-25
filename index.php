<?php
	/**
	*
 	* @miniProject: Get Info Zing Mp3 & NCT
	* @author Del Huỳnh - fb.com/huynhducuduy
	*
	*/
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>Get Mp3 Full Info</title>
	<link rel="stylesheet" media="screen" href="bootstrap.min.css">
	<link rel="stylesheet" media="screen" href="style.css">
	<script src="jquery.min.js"></script>
	<script src="bootstrap.min.js"></script>
	<script src="script.js"></script>
</head>
<body>
	<div class="container">
		<div class="row">
			<div class="page-header">
			  <h1>Get Mp3 Full Info <small>Lấy thông tin bài hát từ Mp3 Zing và NhacCuaTui</small></h1>
			</div>
		</div>
		<div class="row">
			<div class="jumbotron" style="padding: 15px 0">
				<div class="container">
					<form class="navbar-form" onsubmit="return getInfo()">
						<div class="form-group">
							<input type="text" placeholder="Bài hát" class="form-control" id="title" name="title">
						</div>
						<div class="form-group">
							<input type="text" placeholder="Nghệ sĩ" class="form-control" id="artist" name="artist">
						</div>
						<select class="form-control" id="type" name="type">
							<option value="1" selected>Zing Mp3</option>
							<option value="2">NhacCuaTui</option>
						</select>
						<button type="submit" class="btn btn-primary" id="submit" name="submit">Tìm</button>
					</form>
				</div>
			</div>
		</div>
		<div class="row" style='display: none;' id='result'>
			<div class="jumbotron" style="padding: 15px 0;">
				<div id='loading' style='display: none'>
					<center>
						<img src="loading.gif"/>
					</center>
				</div>
				<div class="container">
					<div class="alert alert-danger" role="alert" style='margin-bottom: 0;display: none' id='errorAlert'><b>Lỗi!</b> <span id='errorContent'></span></div>
				</div>
				<div class="container" id='resultContainer' style='display: none;text-align: center;'>
					<div style='text-align: center'><img src="" class="img-circle" witdh="140px" height="140px" id='resultImage'></div>
					<h2 style='text-align: center'><a href='' target="_blank" style='text-decoration: none;color:#000' id='resultTitleLink'><b id='resultTitle'></b/></a> - <a href='' target="_blank" style='text-decoration: none;color:#000' id='resultArtist'></a></h2>
					<div class="player">
						<audio id="player__source" src="" preload="auto" controls loop>
							<p>Trình duyệt của bạn không hỗ trợ HTML5 Audio</p>
						</audio>
						<div class="player__control">
							<button id="playPause" class="player--play icon-play"></button>
							<span id="currentTime">00:00</span>
							<input id="seek" class="player--seek" type="range" min="0" value="0">
							<span id="durationTime">00:00</span>
							<button id="muted" class="player--volumn icon-volume-high"></button>
						</div>
					</div>
					<form class="form-horizontal">
						<div class="form-group">
							<label for="download" class="col-sm-2 control-label" style='font-weight: normal'>Download 128kbps</label>
							<div class="col-sm-9">
								<div class="input-group">
									<input type="text" class="form-control" id='resultDownload'>
									<span class="input-group-btn">
										<a href="" id="btnDownload"><button class="btn btn-default" type="button">Download</button></a>
									</span>
								</div>
							</div>
						</div>
						<div class="form-group">
							<label for="download" class="col-sm-2 control-label" style='font-weight: normal'>Download 320kbps</label>
							<div class="col-sm-9">
								<div class="input-group">
									<input type="text" class="form-control" id='resultDownloadHq'>
									<span class="input-group-btn">
										<a href="" id="btnDownloadHq"><button class="btn btn-default" type="button" id='btnHq'>Download</button></a>
									</span>
								</div>
							</div>
						</div>
						<div class="form-group">
							<label for="download" class="col-sm-2 control-label" style='font-weight: normal'>Lyric</label>
							<div class="col-sm-9">
								<div class="input-group">
									<input type="text" class="form-control" id='resultLyric'>
									<span class="input-group-btn">
										<a href="" download id="btnDownloadLyric"><button class="btn btn-default" type="button" id='btnLyric'>Download</button></a>
									</span>
								</div>
							</div>
						</div>
						<div class="form-group">
							<label for="download" class="col-sm-2 control-label" style='font-weight: normal'>Embed</label>
							<div class="col-sm-9">
								<div class="input-group">
									<input type="text" class="form-control" id='resultEmbed'>
									<span class="input-group-btn">
										<button class="btn btn-default" type="button" id='btnCopy' onclick='copyEmbed()'>Copy</button>
									</span>
								</div>
							</div>
						</div>
					</form>
					<h2 style="margin-top: 10px;margin-bottom: 10px;">Lời bài hát</h2>
					<div class="lyric" id="_divLyricHtml" style="background-color: #fff;">
                    	<p id="lyricText" class="pd_lyric" style="max-height:none;margin-bottom:5px"></p>
                	</div>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="jumbotron" style="padding: 15px 0">
				<div class="container" style="text-align: right">
					Copyright by <a href="http://fb.com/huynhducuduy" style="color: #000; text-decoration: none;"><b>Del Huỳnh</b></a>
				</div>
			</div>
		</div>
	</div>
</body>
</html>
