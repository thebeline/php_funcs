<?php

if (!function_exists('generate_admin_record_nav')) {

// assume there is no records nav, try to build it.  set previous, next, etc.
function generate_admin_record_nav($current_recordnum, $link, $primary_key, &$record, $filters = NULL, $sort = NULL) {
	$record_nav = FALSE;
	$record_lo = $record->get_list_object();

	if (is_array($filters)) {
		$record_lo->set_filters($filters);
	}

	if ($sort) {
		$record_lo->set_orderby($sort);
	}

	// we only need the primary key, so just grab that.  was grabbing too much data on large works tables.
	$record_lo->set_fields(array($primary_key));

	$records = $record_lo->get_list();

	// renumber by offset
	$records = array_values($records);

	// create offset map
	$record_offsets = array();
	foreach ($records as $offset => $vals) {
		$id = $vals[$primary_key];
		$record_offsets[$id] = $offset;
	}

	// if the current work has an offset
	if (isset($record_offsets[$current_recordnum])) {
		$record_count = count($record_offsets);
		$current_offset = $record_offsets[$current_recordnum];
		$next_offset = ($record_offsets[$current_recordnum] + 1) % $record_count;
		$prev_offset = ($record_offsets[$current_recordnum] - 1 + $record_count) % $record_count;

		$next_record = $records[$next_offset][$primary_key];
		$next_record = ($next_record !== NULL) ? $link . $next_record : NULL;

		$prev_record = $records[$prev_offset][$primary_key];
		$prev_record = ($prev_record !== NULL) ? $link . $prev_record : NULL;

		$record_nav = array(
					'next' => $next_record,
					'previous' => $prev_record,
					'current' => (isset($current_offset)) ? $current_offset + 1 : NULL,
					'total' => $record_count
					  );
	}

	return $record_nav;

}
}
