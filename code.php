<?php	##################
	#
	#	rah_test_php-plugin for Textpattern
	#	version 0.1
	#	by Jukka Svahn
	#	http://rahforum.biz
	#
	###################

	if (@txpinterface == 'admin') {
		add_privs('rah_test_php', '1,2');
		register_tab("extensions", "rah_test_php", "Test PHP");
		register_callback("rah_test_php", "rah_test_php");
	}

	function rah_test_php() {
		pagetop('rah_test_php');
		include_once txpath.'/publish.php';
		echo 
			'<form method="post" action="index.php" style="width:800px;margin:0 auto;">'.n.
			'	<h1>rah_test_php: Test PHP scripts</h1>'.n.
			'	<input type="hidden" name="event" value="rah_test_php" />'.n.
			'	<input type="hidden" name="test_do" value="1" />'.n.
			'	<label for="php">PHP code:</label>'.n.
			'	<textarea id="php" name="php" rows="10" cols="30" style="width:790px;"></textarea>'.n.
			'	<button type="submit" style="margin: 10px;">Run PHP code</button>'.n.
			((ps('php') && ps('test_do')) ? '<hr /><p>PHP returned:</p><pre>'.parse('<txp:php> '.ps('php'). ' </txp:php>').'</pre>'.n : '').
			'</form>';
	}?>