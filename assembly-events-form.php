<?php

function formSubmit( $sqlStmt, $table_name, $wpdb ) {
	$id       = $_POST[ $sqlStmt . '_id' ];
	$time     = current_time( 'mysql' );
	$year     = $_POST[ $sqlStmt . '_year' ];
	$month    = $_POST[ $sqlStmt . '_month' ];
	$day      = $_POST[ $sqlStmt . '_day' ];
	$hour     = $_POST[ $sqlStmt . '_hour' ];
	$minute   = $_POST[ $sqlStmt . '_minute' ];
	$meridian = $_POST[ $sqlStmt . '_meridian' ];
	if ( $meridian == "pm" ) {
		if ( $hour != 12 ) {
			$hour = $hour + 12;
		}
	} else {
		if ( $hour == 12 ) {
			$hour = 0;
		}
	}
	$date     = date( $year . "-" . $month . "-" . $day . " " . $hour . ":" . $minute . ":00" );
	$title    = stripslashes( $_POST[ $sqlStmt . '_title' ] );
	$location = stripslashes( $_POST[ $sqlStmt . '_location' ] );
	$link     = $_POST[ $sqlStmt . '_link' ];

	if ( isset( $_POST[ $sqlStmt ] ) ) {
		switch ( $sqlStmt ) {
			case "insert" :
				$wpdb->insert(
					$table_name,
					array(
						'date_created'   => $time,
						'event_date'     => $date,
						'event_title'    => $title,
						'event_location' => $location,
						'event_link'     => $link
					)
				);
				echo '<p>Your event ' . $title . ' has been added!</p>';
				break;

			case "update" :
				$wpdb->update(
					$table_name,
					array(
						'date_created'   => $time,
						'event_date'     => $date,
						'event_title'    => $title,
						'event_location' => $location,
						'event_link'     => $link
					),
					array(
						'event_id' => $id
					)
				);
				echo '<p>Your event ' . $title . ' has been updated!</p>';
				break;

			case "delete" :
				$wpdb->delete(
					$table_name,
					array(
						'event_id' => $id
					)
				);
				echo '<p>Your event ' . $title . ' has been deleted!</p>';
				echo '<p>' . $date . '</p>';
				break;
		}
	}
}

function createForm( $sqlStmt ) {
	?>
	<form id="<?php echo $sqlStmt; ?>-form" class="edit-form" method="post" action="">
		<input type="text" id="<?php echo $sqlStmt ?>_id" name="<?php echo $sqlStmt ?>_id" class="hidden" readonly/>
		<label for="<?php echo $sqlStmt; ?>_title">Event title: </label>
		<input type="text" id="<?php echo $sqlStmt; ?>_title" name="<?php echo $sqlStmt; ?>_title"/>
		<br/>
		<label for="<?php echo $sqlStmt; ?>_month">Event month: </label>
		<select id="<?php echo $sqlStmt; ?>_month" name="<?php echo $sqlStmt; ?>_month">
			<?php
			$months = array( 'Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec' );
			for ( $i = 0; $i < 12; $i ++ ) {
				$val = $i + 1;
				if ( strlen( $val ) != 2 ) {
					$val = "0" . $val;
				}
				$selected = "";
				if ( date( 'm' ) == $val ) {
					$selected = "selected";
				}
				echo '<option value="' . $val . '" ' . $selected . '>' . $months[ $i ] . '</option>';
			}
			?>

		</select>
		<br/>
		<label for="<?php echo $sqlStmt; ?>_day">Event day: </label>
		<select id="<?php echo $sqlStmt; ?>_day" name="<?php echo $sqlStmt; ?>_day">
			<?php
			for ( $i = 0; $i < 31; $i ++ ) {
				$val = $i + 1;
				if ( strlen( $val ) != 2 ) {
					$val = "0" . $val;
				}
				$selected = "";
				if ( date( 'd' ) == $val ) {
					$selected = "selected";
				}
				echo '<option value="' . $val . '" ' . $selected . '>' . $val . '</option>';
			}
			?>
		</select>
		<br/>
		<label for="<?php echo $sqlStmt; ?>_year">Event year: </label>
		<input type="text" id="<?php echo $sqlStmt; ?>_year" name="<?php echo $sqlStmt; ?>_year"
		       value="<?php echo date( "Y" ); ?>"/>
		<br/>
		<label for="<?php echo $sqlStmt; ?>_hour">Event time: </label>
		<select id="<?php echo $sqlStmt; ?>_hour" name="<?php echo $sqlStmt; ?>_hour">
			<?php
			for ( $i = 0; $i < 12; $i ++ ) {
				$val = $i + 1;
				if ( strlen( $val ) != 2 ) {
					$val = "0" . $val;
				}
				echo '<option value="' . $val . '">' . $val . '</option>';
			}
			?>
		</select>
		<span>:</span>
		<select id="<?php echo $sqlStmt; ?>_minute" name="<?php echo $sqlStmt; ?>_minute">
			<?php
			for ( $i = 0; $i < 12; $i ++ ) {
				$val = $i * 5;
				if ( strlen( $val ) != 2 ) {
					$val = "0" . $val;
				}
				echo '<option value="' . $val . '">' . $val . '</option>';
			}
			?>
		</select>
		<select id="<?php echo $sqlStmt; ?>_meridian" name="<?php echo $sqlStmt; ?>_meridian">
			<option value="am">am</option>
			<option value="pm" selected>pm</option>
		</select>
		<br/>
		<label for="<?php echo $sqlStmt; ?>_location">Event location: </label>
		<input type="text" id="<?php echo $sqlStmt; ?>_location" name="<?php echo $sqlStmt; ?>_location"/>
		<br/>
		<label for="<?php echo $sqlStmt; ?>_link">Link to event details: </label>
		<input type="text" id="<?php echo $sqlStmt; ?>_link" name="<?php echo $sqlStmt; ?>_link"/>
		<br/>
		<input type="submit" id="<?php echo $sqlStmt; ?>_submit" name="<?php echo $sqlStmt; ?>"/>
		<button id="<?php echo $sqlStmt; ?>_cancel" class="cancel-form">Cancel</button>
	</form>
	<?php
}

?>