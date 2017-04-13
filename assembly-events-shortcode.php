<?php

add_shortcode( 'events', 'event_func' );
function event_func( $atts ) {
	$a = shortcode_atts( array(
		'header' => 'Upcoming Events'
	), $atts );

	global $wpdb;
	$table_name = $wpdb->prefix . 'assembly_events';
	$events     = $wpdb->get_results( "SELECT * FROM $table_name ORDER BY event_date" );


	foreach ( $events as $event ) {
		if ( date( "Y-m-d H:i:s" ) > date( "Y-m-d H:i:s", strtotime( $event->event_date ) ) ) {
			$wpdb->delete( $table_name, array( 'event_id' => $event->event_id ) );
		}
	}


	?>

	<ul id="events">
		<h2 id="events-header"><?php echo $a['header'] ?></h2>
		<?php

		foreach ( $events as $event ) {
			$eMonth = date( "M", strtotime( $event->event_date ) );
			$eDay   = date( "d", strtotime( $event->event_date ) );
			$eTime  = date( "g:i a", strtotime( $event->event_date ) );
			?>

			<li class="event-item">
				<div class="event">
					<div class="cal-date">
						<span class="date-month"><?php echo $eMonth; ?></span>
						<span class="date-day"><?php echo $eDay; ?></span>
					</div>
					<div class="details">
						<p class="event-title"><?php echo $event->event_title; ?></p>
						<p class="event-time-loc"><?php echo $eTime . ' | ' . $event->event_location; ?></p>
					</div>
					<a href="<?php echo $event->event_link; ?>" class="event-button" target="_blank">Details</a>
				</div>
			</li>

			<?php
		}

		?>

	</ul>


	<?php
}

?>