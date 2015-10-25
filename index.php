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
			<div class="jumbotron">
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
		<div class="row" id='result'>
			<div class="jumbotron">
				<div id='loading'>
					<center>
						<img src="loading.gif"/>
					</center>
				</div>
				<div class="container">
					<div class="alert alert-danger" role="alert" id='errorAlert'><b>Lỗi!</b> <span id='errorContent'></span></div>
				</div>
				<div class="container" id='resultContainer'>
					<div id="imageContainer">
						<a href="" id="resultVideoLink" target="_blank"><img src="" class="img-circle" width="100px" height="100px" id='resultVideoImage'></a>&nbsp;
						<a href="" id="resultArtistLink" target="_blank"><img src="" class="img-circle" width="140px" height="140px" id='resultArtistImage'></a>&nbsp;
						<a href="" id="resultAlbumLink" target="_blank"><img src="" class="img-circle" width="100px" height="100px" id='resultAlbumImage'></a>
					</div>
					<h2 id='mainInfo'><a href='' class='noStyle' target="_blank"  id='resultTitleLink'><b id='resultTitle'></b/></a> - <a href='' target="_blank"  class='noStyle' id='resultArtist'></a></h2>
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
					<form class="form-horizontal" id="form128">
						<div class="form-group">
							<label for="download" class="col-sm-2 control-label">Download 128kbps</label>
							<div class="col-sm-9">
								<div class="input-group">
									<input type="text" class="form-control" id='result128'>
									<span class="input-group-btn">
										<a download id="a128" class="btn btn-default">Download</a>
									</span>
								</div>
							</div>
						</div>
						<div class="form-group" id="form320">
							<label for="download" class="col-sm-2 control-label">Download 320kbps</label>
							<div class="col-sm-9">
								<div class="input-group">
									<input type="text" class="form-control" id='result320'>
									<span class="input-group-btn">
										<a download id="a320" class="btn btn-default">Download</button></a>
									</span>
								</div>
							</div>
						</div>
						<div class="form-group" id="formLl">
							<label for="download" class="col-sm-2 control-label">Download LossLess</label>
							<div class="col-sm-9">
								<div class="input-group">
									<input type="text" class="form-control" id='resultLl'>
									<span class="input-group-btn">
										<a download id="aLl" class="btn btn-default">Download</button></a>
									</span>
								</div>
							</div>
						</div>
						<div class="form-group" id="formLyricFile">
							<label for="lyric" class="col-sm-2 control-label">Lyric File</label>
							<div class="col-sm-9">
								<div class="input-group">
									<input type="text" class="form-control" id='resultLyricFile'>
									<span class="input-group-btn">
										<a download id="aLyricFile" class="btn btn-default">Download</button></a>
									</span>
								</div>
							</div>
						</div>
						<div class="form-group" id='formEmbed'>
							<label for="embed" class="col-sm-2 control-label">Embed</label>
							<div class="col-sm-9">
								<div class="input-group">
									<input type="text" class="form-control" id='resultEmbed'>
									<span class="input-group-btn">
										<button class="btn btn-default" type="button" id='btnEmbed' onclick='copyEmbed()'>Copy</button>
									</span>
								</div>
							</div>
						</div>
					</form>
					<div id='lyricTextDiv'>
					<h2 id='4lyric'>Lời bài hát</h2>
					<div class="lyric" id="_divLyricHtml" >
                    	<p id="resultlyricText" class="pd_lyric"></p>
                	</div>
					</div>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="jumbotron">
				<div class="container" style="text-align: right">
					Copyright by <a href="http://fb.com/huynhducuduy" class='noStyle'><b>Del Huỳnh</b></a>
				</div>
			</div>
		</div>
	</div>
</body>
</html>
