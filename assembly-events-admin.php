<?php
include( 'assembly-events-form.php' );

global $wpdb;
$table_name = $wpdb->prefix . 'assembly_events';
formSubmit( 'insert', $table_name, $wpdb );
formSubmit( 'update', $table_name, $wpdb );
formSubmit( 'delete', $table_name, $wpdb );

$events     = $wpdb->get_results( "SELECT * FROM $table_name ORDER BY event_date" );
$eventsJSON = str_replace( "'", "\\'", json_encode( $events ) );

?>
<script type="text/javascript">
	var eventObj = JSON.parse('<?php echo $eventsJSON; ?>');
</script>

<h1>Assembly Events</h1>
<button id="ae_add-event">Add Event</button>
<?php
createForm( 'insert' );
createForm( 'update' );
?>
<form id="delete-form" class="edit-form" method="post" action="">
	<input type="text" id="delete_id" name="delete_id" class="hidden" readonly/>
	<h2>Are you sure you want to delete the event "<span id="delete-field"></span>"?</h2>
	<input type="submit" id="delete_submit" name="delete" value="Delete"/>
	<button id="delete_cancel" class="cancel-form">Cancel</button>
</form>


<p><strong>Upcoming events</strong> <i>(Click any row to edit it).</i></p>
<table border="1">
	<tr>
		<th></th>
		<th>Event</th>
		<th>Date</th>
		<th>Time</th>
		<th>Location</th>
		<th>Link</th>
	</tr>
	<?php

	$eventCount = 0;
	foreach ( $events as $event ) {

		?>
		<tr id="<?php echo $eventCount; ?>" class="ae_edit-row">
			<td>
				<button class="ae_delete-record"></button>
			</td>
			<td class="ae_edit-event"><?php echo $event->event_title; ?></td>
			<td class="ae_edit-event"><?php echo date( "M d, Y", strtotime( $event->event_date ) ); ?></td>
			<td class="ae_edit-event"><?php echo date( "g:i a", strtotime( $event->event_date ) ); ?></td>
			<td class="ae_edit-event"><?php echo $event->event_location; ?></td>
			<td class="ae_edit-event"><?php echo $event->event_link; ?></td>
		</tr>

		<?php
		$eventCount ++;
	}
	?>

</table>

<p></p>