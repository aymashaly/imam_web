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
 * Training Areas Block Edit Form
 *
 * @package   block_training_areas
 * @copyright 2024 Your Name
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

require_once($CFG->dirroot . '/blocks/edit_form.php');

class block_training_areas_edit_form extends block_edit_form {
    
    protected function specific_definition($mform) {
        global $CFG;
        
        // Section header
        $mform->addElement('header', 'configheader', get_string('blocksettings', 'block'));
        
        // Block title
        $mform->addElement('text', 'config_title', get_string('configtitle', 'block_training_areas'));
        $mform->setType('config_title', PARAM_TEXT);
        $mform->setDefault('config_title', get_string('newtrainingareasblock', 'block_training_areas'));
        
        // Section title
        $mform->addElement('text', 'config_section_title', get_string('configsectiontitle', 'block_training_areas'));
        $mform->setType('config_section_title', PARAM_TEXT);
        $mform->setDefault('config_section_title', 'مجالات التدريب');
        $mform->addHelpButton('config_section_title', 'configsectiontitle', 'block_training_areas');
        
        // Section description
        $mform->addElement('textarea', 'config_section_description', get_string('configsectiondescription', 'block_training_areas'));
        $mform->setType('config_section_description', PARAM_TEXT);
        $mform->setDefault('config_section_description', 'نسعى لتمكينك بأحدث المعارف والمهارات التي تُحدث فارقًا في مسارك المهني والأكاديمي');
        $mform->addHelpButton('config_section_description', 'configsectiondescription', 'block_training_areas');
        
        // Training areas configuration
        $mform->addElement('header', 'trainingareasheader', 'إعدادات مجالات التدريب');
        
        // Number of training areas
        $mform->addElement('select', 'config_training_areas_count', 'عدد مجالات التدريب', array(
            1 => '1',
            2 => '2', 
            3 => '3',
            4 => '4',
            5 => '5',
            6 => '6',
            7 => '7',
            8 => '8',
            9 => '9',
            10 => '10'
        ));
        $mform->setDefault('config_training_areas_count', 8);
        $mform->addHelpButton('config_training_areas_count', 'configtrainingareascount', 'block_training_areas');
        
        // Dynamic training areas fields
        for ($i = 0; $i < 10; $i++) {
            $mform->addElement('header', 'trainingarea' . $i . 'header', 'مجال التدريب ' . ($i + 1));
            
            // Training area title
            $mform->addElement('text', 'config_training_area_' . $i . '_title', 'عنوان مجال التدريب');
            $mform->setType('config_training_area_' . $i . '_title', PARAM_TEXT);
            $mform->setDefault('config_training_area_' . $i . '_title', '');
            
            // Training area subtitle
            $mform->addElement('text', 'config_training_area_' . $i . '_subtitle', 'النص الفرعي');
            $mform->setType('config_training_area_' . $i . '_subtitle', PARAM_TEXT);
            $mform->setDefault('config_training_area_' . $i . '_subtitle', 'دورات معتمدة');
            
            // Training area image URL
            $mform->addElement('text', 'config_training_area_' . $i . '_image_url', 'رابط صورة مجال التدريب');
            $mform->setType('config_training_area_' . $i . '_image_url', PARAM_URL);
            $mform->setDefault('config_training_area_' . $i . '_image_url', '');
            $mform->addHelpButton('config_training_area_' . $i . '_image_url', 'configtrainingareaimageurl', 'block_training_areas');
            
            // Training area alt text
            $mform->addElement('text', 'config_training_area_' . $i . '_alt_text', 'النص البديل للصورة');
            $mform->setType('config_training_area_' . $i . '_alt_text', PARAM_TEXT);
            $mform->setDefault('config_training_area_' . $i . '_alt_text', '');
            
            // Hide fields by default (will be shown via JavaScript)
            $mform->hideIf('config_training_area_' . $i . '_title', 'config_training_areas_count', 'neq', $i + 1);
            $mform->hideIf('config_training_area_' . $i . '_subtitle', 'config_training_areas_count', 'neq', $i + 1);
            $mform->hideIf('config_training_area_' . $i . '_image_url', 'config_training_areas_count', 'neq', $i + 1);
            $mform->hideIf('config_training_area_' . $i . '_alt_text', 'config_training_areas_count', 'neq', $i + 1);
            $mform->hideIf('trainingarea' . $i . 'header', 'config_training_areas_count', 'neq', $i + 1);
        }
        
        // Add JavaScript to show/hide fields based on count
        $mform->addElement('html', '
        <script>
        document.addEventListener("DOMContentLoaded", function() {
            const countSelect = document.getElementById("id_config_training_areas_count");
            const trainingAreaFields = document.querySelectorAll("[id^=\'id_config_training_area_\']");
            const trainingAreaHeaders = document.querySelectorAll("[id^=\'id_trainingarea\']");
            
            function updateTrainingAreaFields() {
                const count = parseInt(countSelect.value);
                
                trainingAreaFields.forEach(function(field, index) {
                    const areaIndex = Math.floor(index / 4); // 4 fields per training area
                    if (areaIndex < count) {
                        field.closest(".fitem").style.display = "block";
                    } else {
                        field.closest(".fitem").style.display = "none";
                    }
                });
                
                trainingAreaHeaders.forEach(function(header, index) {
                    if (index < count) {
                        header.closest(".fitem").style.display = "block";
                    } else {
                        header.closest(".fitem").style.display = "none";
                    }
                });
            }
            
            countSelect.addEventListener("change", updateTrainingAreaFields);
            updateTrainingAreaFields();
        });
        </script>
        ');
    }
}
