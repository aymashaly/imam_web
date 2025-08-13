<?php
// This file is part of Moodle - http://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 or later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.

/**
 * Language switcher for the edma theme
 *
 * @package    theme_edma
 * @copyright  2024 Your Name
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

require_once('../../config.php');
require_once($CFG->libdir . '/moodlelib.php');

// Check if user is logged in
require_login();

// Get parameters
$lang = required_param('lang', PARAM_SAFEDIR);
$returnurl = optional_param('returnurl', '', PARAM_URL);

// Check if language exists
if (!get_string_manager()->translation_exists($lang, false)) {
    throw new moodle_exception('invalidlanguage');
}

// Update user's language preference using the correct Moodle function
global $USER, $DB;

// Update the user record in the database using direct SQL to avoid include issues
$sql = "UPDATE {user} SET lang = ? WHERE id = ?";
$DB->execute($sql, array($lang, $USER->id));

// Update the current user object
$USER->lang = $lang;

// Set session language - this is the key to making it work
$SESSION->lang = $lang;

// Force the language to persist by setting it in multiple places
if (isset($CFG->lang)) {
    $CFG->lang = $lang;
}

// Set a cookie to help persist the language choice
setcookie('MOODLEID_'.$CFG->sessioncookie, $lang, time() + 60*60*24*365, '/');

// Also set a custom session variable that we can check
$SESSION->edma_forced_lang = $lang;

// Use forcelang parameter instead of lang for more persistent language switching
$forcelang_param = 'forcelang=' . $lang;

// Redirect back to the original page with forcelang parameter to ensure it sticks
if (!empty($returnurl)) {
    $separator = (strpos($returnurl, '?') !== false) ? '&' : '?';
    redirect($returnurl . $separator . $forcelang_param);
} else {
    redirect($CFG->wwwroot . '?' . $forcelang_param);
}
