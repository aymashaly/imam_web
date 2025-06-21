<?php
namespace local_mist\forms;

defined('MOODLE_INTERNAL') || die();

require_once($CFG->libdir.'/formslib.php');

class invoice_filter_form extends \moodleform {
    public function definition() {
        global $DB;
        $mform = $this->_form;
        
        // Disable change detection to prevent "unsaved changes" warnings
        $mform->disable_form_change_checker();
        
        // Status filter
        $statusoptions = [
            '' => get_string('allstatuses', 'local_mist'),
            'pending' => get_string('status_pending', 'local_mist'),
            'paid' => get_string('status_paid', 'local_mist'),
            'overdue' => get_string('status_overdue', 'local_mist'),
            'cancelled' => get_string('status_cancelled', 'local_mist')
        ];
        $mform->addElement('select', 'status', get_string('status'), $statusoptions);
        $mform->setType('status', PARAM_ALPHA);
        
        // User filter
        $mform->addElement('text', 'user', get_string('user'));
        $mform->setType('user', PARAM_TEXT);
        // $mform->setAttribute('user', 'placeholder', get_string('searchuser', 'local_mist'));
        
        // Date range filters
        $mform->addElement('date_selector', 'fromdate', get_string('fromdate', 'local_mist'), [
            'optional' => true,
            'startyear' => 2000,
            'stopyear' => date('Y') + 5
        ]);
        $mform->setType('fromdate', PARAM_INT);
        
        $mform->addElement('date_selector', 'todate', get_string('todate', 'local_mist'), [
            'optional' => true,
            'startyear' => 2000,
            'stopyear' => date('Y') + 5
        ]);
        $mform->setType('todate', PARAM_INT);
        
        // Action buttons
        $buttonarray = [];
        $buttonarray[] = $mform->createElement('submit', 'submitbutton', get_string('applyfilter', 'local_mist'), 
            ['class' => '']);
        $buttonarray[] = $mform->createElement('cancel', 'reset', get_string('clearfilter', 'local_mist'), 
            ['class' => '']);
        $mform->addGroup($buttonarray, 'buttonar', '', [' '], false);
        $mform->closeHeaderBefore('buttonar');
    }
    
    public function validation($data, $files) {
        $errors = [];
        
        // Validate date range
        if (!empty($data['fromdate']) && !empty($data['todate']) && $data['fromdate'] > $data['todate']) {
            $errors['fromdate'] = get_string('fromdatetodateerror', 'local_mist');
        }
        
        return $errors;
    }
}