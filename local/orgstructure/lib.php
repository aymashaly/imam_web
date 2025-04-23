<?php

function render_breadcrumb($items) {
    echo html_writer::start_div('breadcrumb');
    $count = count($items);
    $i = 0;
    foreach ($items as $item) {
        $i++;
        $label = get_string($item['label'], $item['component'] ?? 'local_orgstructure');
        if ($i < $count && isset($item['url'])) {
            echo html_writer::link($item['url'], $label) . ' / ';
        } else {
            echo html_writer::span($label);
        }
    }
    echo html_writer::end_div();
}
