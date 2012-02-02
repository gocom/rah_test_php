<?php	##################
	#	Rah_test_php-plugin for Textpattern
	#	version 0.2
	#	by Jukka Svahn
	#	http://rahforum.biz
	#
	#	Copyright (C) 2011 Jukka Svahn <http://rahforum.biz>
	#	Licensed under GNU Genral Public License version 2
	#	http://www.gnu.org/licenses/gpl-2.0.html
	#
	##################

	if(@txpinterface == 'admin') {
		add_privs('rah_test_php','1,2');
		add_privs('plugin_prefs.rah_test_php','1,2');
		register_callback('rah_test_php_prefs','plugin_prefs.rah_test_php');
		register_tab('extensions','rah_test_php',gTxt('rah_test_php') == 'rah_test_php' ? 'Execute PHP' : gTxt('rah_test_php'));
		register_callback('rah_test_php','rah_test_php');
		register_callback('rah_test_php_head','admin_side','head_end');
	}

/**
	The pain and main function
*/

	function rah_test_php() {
		
		require_privs('rah_test_php');
		
		global $event, $textarray;

		/*
			Make sure language strings are set
		*/
		
		foreach(
			array(
				'rah_test_php' => 'Execute PHP',
				'rah_test_php_code' => 'PHP code',
				'rah_test_php_run' => 'Run the PHP',
				'rah_test_php_returned' => 'Returned'
			) as $string => $translation
		)
			if(!isset($textarray[$string]))
				$textarray[$string] = $translation;
		
		pagetop(gTxt('rah_test_php'));
		
		echo
			'<form method="post" action="index.php" id="rah_test_php_container" class="rah_ui_container">'.n.
			'	<input type="hidden" name="event" value="'.$event.'" />'.n.
			'	<p>'.n.
			'		<label>'.n.
			'			'.gTxt('rah_test_php_code').'<br />'.n.
			'			<textarea class="code" name="php" rows="10" cols="50">'.htmlspecialchars(ps('php')).'</textarea>'.n.
			'		</label>'.n.
			'	</p>'.n.
			'	<p>'.n.
			'		<input type="submit" value="'.gTxt('rah_test_php_run').'" class="publish" />'.n.
			'	</p>'.n;

		if(ps('php')) {
			
			ob_start();
			eval(ps('php'));
			$returned = ob_get_clean();
			
			echo
				'	<p><strong>'.gTxt('rah_test_php_returned').'</strong></p>'.n.
				'	<pre id="rah_test_php_pre">'.htmlspecialchars($returned).'</pre>'.n;
		}
		
		echo
			'</form>';
		
	}

/**
	Adds styles and JavaScript to the <head>
*/

	function rah_test_php_head() {
		
		global $event;
		
		if($event != 'rah_test_php')
			return;
		
		$string = gTxt('are_you_sure');
		
		echo <<<EOF
			<style type="text/css">
				#rah_test_php_container {
					width: 650px;
					margin: 0 auto;
				}
				#rah_test_php_container textarea {
					width: 100%;
				}
				#rah_test_php_pre {
					white-space: pre;
					overflow: auto;
				}
			</style>
			<script type="text/javascript">
				<!--
				$(document).ready(function(){
					$('form#rah_test_php_container').submit(
						function() {
							return verify('{$string}');
						}
					)
				});
				-->
			</script>
EOF;
	}

/**
	Redirect to the prefs pane
*/

	function rah_test_php_prefs() {
		header('Location: ?event=rah_test_php');
		echo 
			'<p>'.n.
			'	<a href="?event=rah_test_php">'.gTxt('continue').'</a>'.n.
			'</p>';
	}
?>