<!DOCTYPE html>
<html lang="de">
<head>
<title>Unix-Zeitstempel-Konverter</title>

<meta charset="utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" />
<meta name="format-detection" content="telephone=no" />

<link rel="icon" href="data:image/x-icon;base64,iVBORw0KGgoAAAANSUhEUgAAACAAAAAgCAMAAABEpIrGAAAA7VBMVEX////+//gl0zn37AbU5e39+roecqIHZJhw43tZ3Wj68UQc0TH8/f6cwNdfm70QaZz36wDo8fbB2OW1z+LG9NOz8L8idaP///zz9/r//+7M3+o2gavZ5+94qsf8+rVHi7Mxfqr8+KMAXpb57yv37RTk7/Tf6/L9+8+t7rdNj7RAh7ACYJb681z68kv4+vz5//fs8/e60+Ozz9+ty97E8839+8m88cOz8LsseqcWbZ8LZppi4HAX0Cz//+rt/+qfwth6q8hmn79al7qm7K44gqyd66qc66b8+KT7+J/795ts4nhV3WT57zL57y4RzydhsiL/AAABBklEQVQ4y9XQ6VaCQBjG8QcMTURAK7KpoKiIKNxzb98Xvf/L0cHXgyNzAz5ff//DYV5s21gb6PUBV5N74BSqKE560O17mV+dDbwhe/xTuw/Ty2uZO0Hds5hSVPePLqgQ/QSoeVZLXgSJ86KwR4XwHzsO96R4XRU5bc3zA3LAMKn4Twry4wqwWSg6FeSZorsqWD5qAkLxMuo0xmqoxDkXQNW6qUPc820Zu5MP3NlfWBY1wU+5l8KFnwNpkbrP/YCciqiy6YcxORXvVBj8+9x1chqjpxqmT84fQEuPwU/wRK4BmaKJxYmkTkVkjtqN31JfIc8UQ7+D8SxEbLuQrlUG3j6Bn29s2eYQAB0eu33jlQAAAABJRU5ErkJggg==" type="image/x-icon" />
<link rel="apple-touch-icon" href="/images/apple-touch-icon.png" />
<link rel="apple-touch-startup-image" href="/images/apple-touch-icon.png" />
<link rel="mask-icon" href="images/pinned_logo.svg" color="#186e9f" />

<link href="css/style.css" rel="stylesheet" type="text/css" />
<link href="css/flatpickr.min.css" rel="stylesheet" type="text/css" />
</head>
<body>

<div id="page">
	<div id="content">
		<h1>Unix-Zeitstempel-Konverter</h1>
		
		<p>Bitte gib das Datum oder den Zeitstempel an, den du konvertieren möchtest. Bei Eingabe beider Felder wird nur der Zeitstempel beachtet.</p>
		
		<form action="index.php" method="post">
			<label><span class="columnLeft">Datum:</span> <span class="columnRight"><input id="dateTime" type="text" name="date" pattern="\d{2}.\d{2}.\d{4}\s{1}\d{2}:\d{2}:\d{2}" /></span></label><br />
			<label><span class="columnLeft">Unix-Zeitstempel:</span> <span class="columnRight"><input id="timestamp" type="text" name="timestamp" pattern="\d{10}" autofocus /></span></label><br />
			
			<input type="submit" accesskey="s" />
			<input type="reset" accesskey="r" />
		</form>
		
		<?php
		date_default_timezone_set('Europe/Berlin');
		setlocale(LC_TIME, 'de_DE');
		
		$date = htmlspecialchars(filter_input(INPUT_POST, 'date'));
		$isError = false;
		$timestamp = intval(filter_input(INPUT_POST, 'timestamp'));
		
		if (!empty($timestamp) || !empty($date)) {
			echo '<div class="result">';
			echo '<h3>Ergebnis:</h3>';
			
			// validate
			if (!empty($timestamp) && strlen($timestamp) !== 10) {
				echo '<p class="error">Der eingegebene Zeitstempel ist nicht korrekt.</p>';
				
				$isError = true;
			}
			
			if (!empty($date) && !preg_match('/\d{2}.\d{2}.\d{4}\s{1}\d{2}:\d{2}:\d{2}/', $date)) {
				echo '<p class="error">Das eingegebene Datumsformat ist nicht korrekt.</p>';
				
				$isError = true;
			}
		}
		
		if (!$isError) {
			if ( ! empty( $timestamp ) ) {
				echo '<span class="columnLeft">Datum:</span> <span class="columnRight"><input type="text" readonly="readonly" onclick="select(this);" value="' . strftime( '%d.%m.%Y %H:%M:%S', $timestamp ) . '" /></span><br />';
				echo '<span class="columnLeft">Zeitstempel:</span> <span class="columnRight"><input type="text" readonly="readonly" onclick="select(this);" value="' . $timestamp . '" /></span>';
			}
			else if ( ! empty( $date ) ) {
				echo '<span class="columnLeft">Datum:</span> <span class="columnRight"><input type="text" readonly="readonly" onclick="select(this);" value="' . $date . '" /></span><br />';
				echo '<span class="columnLeft">Zeitstempel:</span> <span class="columnRight"><input type="text" readonly="readonly" onclick="select(this);" value="' . strtotime( $date ) . '" /></span>';
			}
		}
		
		if ( ! empty( $timestamp ) || ! empty( $date ) ) {
			echo '</div>';
		}
		?>
		
		<div class="copyright">
			<a href="http://kittmedia.com">&copy; <?php echo date('Y'); ?> KittMedia</a>
		</div>
	</div>
</div>

<script src="js/flatpickr.min.js"></script>
<script>
	document.addEventListener('DOMContentLoaded', function() {
		var picker = flatpickr(document.getElementById('dateTime'), {
			dateFormat: 'd.m.Y H:i:S',
			enableSeconds: true,
			enableTime: true,
			minuteIncrement: 1,
			time_24hr: true
		});
	});
</script>
</body>
</html>