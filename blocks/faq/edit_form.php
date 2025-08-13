<?php
// This file is part of Moodle - http://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.

/**
 * FAQ Block Edit Form
 *
 * @package   block_faq
 * @copyright 2024 Your Name
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

require_once($CFG->dirroot . '/blocks/edit_form.php');

class block_faq_edit_form extends block_edit_form {
    
    protected function specific_definition($mform) {
        global $CFG;
        
        // Section header
        $mform->addElement('header', 'configheader', get_string('blocksettings', 'block'));
        
        // Block title
        $mform->addElement('text', 'config_title', get_string('configtitle', 'block_faq'));
        $mform->setType('config_title', PARAM_TEXT);
        $mform->setDefault('config_title', get_string('newfaqblock', 'block_faq'));
        
        // Section title
        $mform->addElement('text', 'config_section_title', get_string('configsectiontitle', 'block_faq'));
        $mform->setType('config_section_title', PARAM_TEXT);
        $mform->setDefault('config_section_title', 'الأسئلة الشائعة');
        $mform->addHelpButton('config_section_title', 'configsectiontitle', 'block_faq');
    }
}
