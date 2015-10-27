/**
 *
 * @miniProject: Get Info Zing Mp3 & NCT
 * @author Del Huỳnh - fb.com/huynhducuduy
 *
 */

$(document).ready(function() {
	var player = document.getElementById('playerSource'),
	playPause = document.getElementById('playPause'),
	currentTime = document.getElementById('currentTime'),
	seek = document.getElementById('seek'),
	durationTime = document.getElementById('durationTime'),
	muted = document.getElementById('muted'),
	timeInterval,
	i;

	window.onload = function() {
		playPause.addEventListener('click', playPauseMusic, false);
		muted.addEventListener('click', mutedMusic, false);
		player.addEventListener('ended', endedMusic, false);
	};

	function playPauseMusic() {
		if (player.paused) {
			player.play();
			timeInterval = setInterval(timeUpdateMusic, 100);
			seek.addEventListener('change', seekMusic, false);
			playPause.classList.remove('icon-play');
			playPause.classList.add('icon-pause');
		} else {
			player.pause();
			clearInterval(timeInterval);
			playPause.classList.remove('icon-pause');
			playPause.classList.add('icon-play');
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
										$('#resultTitle').text(result['title']);
										$('#resultTitleLink').attr('href',result['link']);
										$('#resultArtist').text(result['artist']);
										if (result['artistLink'] != null) { 
											$('#resultArtist').attr('href',result['artistLink']);
										} else {
											$('#resultArtist').removeAttr('href');
										}
										
										if (result['artistLink'] != null) {
											$('#resultArtistLink').attr('href',result['artistLink']);
											if (result['artistImage'] != null) {
												$('#resultArtistImage').attr('src',result['artistImage']);
											} else {
												$('#resultArtistImage').attr('src','noimage.jpg');
											}
											$('#resultArtistImage').show();
										} else {
											$('#resultArtistImage').hide();
										}
										
										if (result['videoLink'] != null) {
											$('#resultVideoLink').attr('href',result['videoLink']);
											if (result['videoImage'] != null) {
												$('#resultVideoImage').attr('src',result['videoImage']);
											} else {
												$('#resultVideoImage').attr('src','noimage.jpg');
											}
											$('#resultVideoImage').show();
										} else {
											$('#resultVideoImage').hide();
										}
										
										if (result['albumLink'] != null) {
											$('#resultAlbumLink').attr('href',result['albumLink']);
											if (result['albumImage'] != null) {
												$('#resultAlbumImage').attr('src',result['albumImage']);
											} else {
												$('#resultAlbumImage').attr('src','noimage.jpg');
											}
											$('#resultAlbumImage').show();
										} else {
											$('#resultAlbumImage').hide();
										}
										
										$('#playerSource').attr('src',result['download128']);
										
										$('#result128').val(result['download128']);
										$('#a128').attr('href',result['download128']);
										
										if (result['download320'] != '')
										{
											$('#a320').attr('href',result['download320']);
											$('#result320').val(result['download320']);
											$('#form320').show();
										} else {
											$('#form320').hide();
										}
										
										if (result['downloadLl'] != '')
										{
											$('#aLl').attr('href',result['downloadLl']);
											$('#resultLl').val(result['downloadLl']);
											$('#formLl').show();
										} else{
											$('#formLl').hide();
										}
										
										if (result['lyricFile'] != '' && result['lyricFile'] != 'http://lrc.nct.nixcdn.com/null')
										{
											$('#resultLyricFile').val(result['lyricFile']);
											$('#aLyricFile').attr('href',result['lyricFile']);
											$('#formLyricFile').show();
										}
										else
										{
											$('#formLyricFile').hide();
										}

										if (result['lyricText'] != '')
										{
											$('#resultlyricText').html(result['lyricText']);
											$('#lyricTextDiv').show();
										} else{
											$('#lyricTextDiv').hide();
										}

										$('#resultEmbed').val(result['embed']);
										$('#resultContainer').show();
										$('#playPause').click(); // Play music
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
