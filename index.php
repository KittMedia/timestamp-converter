<!DOCTYPE html>
<html lang="de">
<head>
<title>Unix-Zeitstempel-Konverter</title>

<meta charset="utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" />
<meta name="format-detection" content="telephone=no" />

<link rel="icon" href="images/favicon.ico" type="image/x-icon" />
<link rel="apple-touch-icon" href="/images/apple-touch-icon.png" />
<link rel="apple-touch-startup-image" href="/images/apple-touch-icon.png" />
<link rel="mask-icon" href="images/pinned_logo.svg" color="#186e9f" />

<link href="css/style.css" rel="stylesheet" type="text/css" />
</head>
<body>

<div id="page">
	<div id="content">
		<h1>Unix-Zeitstempel-Konverter</h1>
		
		<p>Bitte gib das Datum oder den Zeitstempel an, den du konvertieren möchtest. Bei Eingabe beider Felder wird nur der Zeitstempel beachtet.</p>
		
		<form action="index.php" method="post">
			<label><span class="columnLeft">Datum:</span> <span class="columnRight"><input class="dateTime" type="text" name="date" pattern="\d{2}.\d{2}.\d{4}\s{1}\d{2}:\d{2}:\d{2}" /></span></label><br />
			<label><span class="columnLeft">Unix-Zeitstempel:</span> <span class="columnRight"><input type="text" name="timestamp" pattern="\d{10}" /></span></label><br />
			
			<input type="submit" accesskey="s" />
			<input type="reset" accesskey="r" />
		</form>
		
		<?php
		date_default_timezone_set('Europe/Berlin');
		setlocale(LC_TIME, 'de_DE');
		
		$date = htmlspecialchars(filter_input(INPUT_POST, 'date'));
		$timestamp = intval(filter_input(INPUT_POST, 'timestamp'));
		
		if (!empty($timestamp) || !empty($date)) {
			echo '<div class="result">';
			
			// validate
			if (!empty($timestamp) && strlen($timestamp) !== 10) {
				echo '<p class="error">Der eingegebene Zeitstempel ist nicht korrekt.</p>';
				
				return;
			}
			if (!empty($date) && !preg_match('/\d{2}.\d{2}.\d{4}\s{1}\d{2}:\d{2}:\d{2}/', $date)) {
				echo '<p class="error">Das eingegebene Datumsformat ist nicht korrekt.</p>';
				
				return;
			}
			
			echo '<h3>Ergebnis:</h3>';
		}
		
		if (!empty($timestamp)) {
			echo '<span class="columnLeft">Datum:</span> <span class="columnRight"><input type="text" disabled="disabled" value="' . strftime('%d.%m.%Y %H:%M:%S', $timestamp) . '" /></span><br />';
			echo '<span class="columnLeft">Zeitstempel:</span> <span class="columnRight"><input type="text" disabled="disabled" value="' . $timestamp . '" /></span>';
		}
		else if (!empty($date)) {
			echo '<span class="columnLeft">Datum:</span> <span class="columnRight"><input type="text" disabled="disabled" value="' . $date . '" /></span><br />';
			echo '<span class="columnLeft">Zeitstempel:</span> <span class="columnRight"><input type="text" disabled="disabled" value="' . strtotime($date) . '" /></span>';
		}
		
		if (!empty($timestamp) || !empty($date)) {
			echo '</div>';
		}
		?>
		
		<div class="copyright">
			<a href="http://kittmedia.com">&copy; <?php echo date('Y'); ?> KittMedia Productions</a>
		</div>
	</div>
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/jquery-ui.min.js"></script>
<script src="js/jquery-ui-timepicker-addon.min.js"></script>

<script>
	//<![CDATA[
	$(function() {
		// datepicker
		$.datepicker.regional['de'] = {
			clearText: 'löschen',
			clearStatus: 'aktuelles Datum löschen',
			closeText: 'schließen',
			closeStatus: 'ohne Änderungen schließen',
			prevText: '&laquo;',
			prevStatus: 'letzten Monat zeigen',
			nextText: '&raquo;',
			nextStatus: 'nächsten Monat zeigen',
			currentText: 'heute',
			currentStatus: '',
			monthNames: ['Januar', 'Februar', 'März', 'April', 'Mai', 'Juni', 'Juli', 'August', 'September', 'Oktober', 'November', 'Dezember'],
			monthNamesShort: ['Jan', 'Feb', 'Mär', 'Apr', 'Mai', 'Jun', 'Jul', 'Aug', 'Sep', 'Okt', 'Nov', 'Dez'],
			monthStatus: 'anderen Monat anzeigen',
			yearStatus: 'anderes Jahr anzeigen',
			weekHeader: 'Wo',
			weekStatus: 'Woche des Monats',
			dayNames: ['Sonntag', 'Montag', 'Dienstag', 'Mittwoch', 'Donnerstag', 'Freitag', 'Samstag'],
			dayNamesShort: ['So', 'Mo', 'Di', 'Mi', 'Do', 'Fr', 'Sa'],
			dayNamesMin: ['So', 'Mo', 'Di', 'Mi', 'Do', 'Fr', 'Sa'],
			dayStatus: 'Setze DD als ersten Wochentag',
			dateStatus: 'Wähle D, M d',
			dateFormat: 'dd.mm.yy',
			firstDay: 1,
			initStatus: 'Wähle ein Datum',
			isRTL: true
		};
		$.datepicker.setDefaults($.datepicker.regional['de']);
		
			// timepicker
		$.timepicker.regional['de'] = {
			timeOnlyTitle: 'Zeit wählen',
			timeText: 'Zeit',
			hourText: 'Stunde',
			minuteText: 'Minute',
			secondText: 'Sekunde',
			millisecText: 'Millisekunde',
			timezoneText: 'Zeitzone',
			currentText: 'Jetzt',
			closeText: 'Fertig',
			timeFormat: 'HH:mm:ss',
			amNames: ['vorm.', 'AM', 'A'],
			pmNames: ['nachm.', 'PM', 'P'],
			ampm: false
		};
		$.timepicker.setDefaults($.timepicker.regional['de']);
		
		$('.dateTime').datetimepicker({
			showTimepicker: true,
			dateFormat: 'dd.mm.yy'
		});
	});
	//]]>
</script>
</body>
</html>