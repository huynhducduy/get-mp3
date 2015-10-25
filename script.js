/**
 *
 * @miniProject: Get Info Zing Mp3 & NCT
 * @author Del Huỳnh - fb.com/huynhducuduy
 *
 */

$(document).ready(function() {
	var player = document.getElementById('player__source'),
	playLoading = document.querySelectorAll('.player__loading span'),
	playPause = document.getElementById('playPause'),
	currentTime = document.getElementById('currentTime'),
	seek = document.getElementById('seek'),
	durationTime = document.getElementById('durationTime'),
	muted = document.getElementById('muted'),
	timeInterval,
	i,
	len = playLoading.length;

	window.onload = function() {
		playPause.addEventListener('click', playPauseMusic, false);
		muted.addEventListener('click', mutedMusic, false);
		player.addEventListener('ended', endedMusic, false);
	};

	function playPauseMusic() {
		var i, len = playLoading.length;
		if (player.paused) {
			player.play();
			timeInterval = setInterval(timeUpdateMusic, 100);
			seek.addEventListener('change', seekMusic, false);
			playPause.classList.remove('icon-play');
			playPause.classList.add('icon-pause');
			for (i = 0; i < len; i++) {
				playLoading[i].classList.add('active');
			}
		} else {
			player.pause();
			clearInterval(timeInterval);
			playPause.classList.remove('icon-pause');
			playPause.classList.add('icon-play');
			for (i = 0; i < len; i++) {
				playLoading[i].classList.remove('active');
			}
		}
	}

	function seekMusic() {
		player.currentTime = seek.value;
	}

	function mutedMusic() {
		if (player.muted) {
			player.muted = false;
			muted.classList.remove('icon-volume-mute');
			muted.classList.add('icon-volume-high');
		} else {
			player.muted = true;
			muted.classList.remove('icon-volume-high');
			muted.classList.add('icon-volume-mute');
		}
	}

	function timeUpdateMusic() {
		durationTime.innerHTML = secondToMinutes(player.duration);
		currentTime.innerHTML = secondToMinutes(player.currentTime);
		seek.max = player.duration;
		seek.value = player.currentTime;
	}

	function secondToMinutes(seconds) {
		var numMinutes = Math.floor((((seconds % 31536000) % 86400) % 3600) / 60),
		numSeconds = (((seconds % 3153600) % 86400) % 3600) % 60;

		numMinutes = numMinutes >= 10 ? numMinutes : ('0' + numMinutes);

		if (numSeconds >= 10) {
			return numMinutes + ':' + Math.round(numSeconds);
		} else {
			return numMinutes + ':0' + Math.round(numSeconds);
		}
	}

	function endedMusic() {
		player.pause();
		player.currentTime = 0;
		playPause.classList.remove('icon-pause');
		playPause.classList.add('icon-play');
		for (i = 0; i < len; i++) {
			playLoading[i].classList.remove('active');
		}
	}
});

	function getInfo()
	{
		$('#result').fadeIn('fast', function () {
			$('#errorAlert').fadeOut('fast', function () {
				$('#resultContainer').fadeOut('fast', function () {
					$('#loading').fadeIn('fast', function () {
						$.ajax({
							url : 'process.php',
							type : 'get',
							dataType : 'json',
							data : {
								title : $('#title').val(),
								artist: $('#artist').val(),
								type: $('#type').val()
							},
							success : function (result)
							{
								$('#loading').fadeOut('fast',function () {
									if (result['error'] != 0)
									{
										if (result['error'] == 1) {
											$('#errorContent').text('Chưa nhập tên bài hát');
										} else if (result['error'] == 2) {
											$('#errorContent').text('Phương thức không đúng');
										} else if (result['error'] == 3) {
											$('#errorContent').text('Không tìm thấy bài hát nào');
										}
										$('#errorAlert').show();
									} else
									{
										$('#resultTitleLink').attr('href',result['link']);
										$('#resultTitle').text(result['title']);
										$('#resultImage').attr('src',result['image']);
										$('#resultArtist').text(result['artist']).attr('href',result['artistLink']);
										$('#resultDownload').val(result['download']);
										$('#player__source').attr('src',result['download']);
										$('#btnDownload').attr('href',result['download']);
										if (result['lyric'] != '' && result['lyric'] != 'http://lrc.nct.nixcdn.com/null')
										{
											$('#resultLyric').val(result['lyric']);
											$('#btnLyric').removeAttr('disabled');
											$('#btnDownloadLyric').attr('href',result['lyric']);
										}
										else
										{
											$('#resultLyric').val('Không có');
											$('#btnLyric').attr('disabled','disabled');
										}

										if (result['lyricText'] != '')
										{
											$('#lyricText').html(result['lyricText']);
										} else{
											$('#lyricText').text('Không có');
										}

										if (result['downloadHq'] != '')
										{
											$('#btnDownloadHq').attr('href',result['downloadHq']);
											$('#resultDownloadHq').val(result['downloadHq']);
											$('#btnHq').removeAttr('disabled');
										} else{
											$('#resultDownloadHq').val('Không có');
											$('#btnHq').attr('disabled','disabled');
										}

										$('#resultEmbed').val(result['embed']);
										$('#resultContainer').show();
										$('#playPause').click();
									}
								});
							}
						});
					});
				});
			});
		});
		return false;
	}
    function copyEmbed() {
        $('#resultEmbed').focus();
        $('#resultEmbed').select();
        alert("Nhấn Ctrl + C để Copy");
    }
