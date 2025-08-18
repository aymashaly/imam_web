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
 * Language switching script for EDMA theme
 *
 * @package   theme_edma
 * @copyright 2024 Your Name
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

require_once(__DIR__.'/../../config.php');
require_once($CFG->libdir.'/adminlib.php');

// Get the language code from the request
$lang = optional_param('lang', '', PARAM_SAFEDIR);
$returnurl = optional_param('returnurl', '', PARAM_URL);

// Validate language code
if (!in_array($lang, ['ar', 'en'])) {
    $lang = 'ar'; // Default to Arabic
}

// Set return URL - use referer if not provided
if (empty($returnurl)) {
    $returnurl = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : $CFG->wwwroot;
}

// Clean the return URL to prevent open redirects
$returnurl = clean_param($returnurl, PARAM_URL);
if (empty($returnurl) || !preg_match('/^' . preg_quote($CFG->wwwroot, '/') . '/', $returnurl)) {
    $returnurl = $CFG->wwwroot;
}

// Check if the language translation exists
if (!get_string_manager()->translation_exists($lang)) {
    // Redirect back with error
    redirect($returnurl . '?error=invalidlanguage', get_string('invalidlanguage', 'error'), 3);
}

// Handle language switching based on user status
if (isloggedin() && !isguestuser()) {
    // Logged in user - update their language preference in database
    global $DB, $USER;
    
    try {
        // Update user's language preference in database
        $DB->set_field('user', 'lang', $lang, ['id' => $USER->id]);
        
        // Update user object in session
        $USER->lang = $lang;
        
        // Set session language
        $SESSION->lang = $lang;
        
        // Set current language for this session
        current_language($lang);
        
        // Log the language change
        $event = \core\event\user_updated::create([
            'objectid' => $USER->id,
            'relateduserid' => $USER->id,
            'context' => context_user::instance($USER->id),
            'other' => ['lang' => $lang]
        ]);
        $event->trigger();
        
    } catch (Exception $e) {
        // Log error and redirect with error message
        debugging('Language switch failed: ' . $e->getMessage());
        redirect($returnurl . '?error=languageupdatefailed', get_string('error'), 3);
    }
} else {
    // Guest user or not logged in - set session language only
    $SESSION->lang = $lang;
    current_language($lang);
}

// Set a cookie to remember the language preference
setcookie('moodle_lang', $lang, time() + (86400 * 365), '/'); // 1 year

// Redirect back to the original page
redirect($returnurl, get_string('languageswitchsuccess', 'theme_edma', $lang), 1);
