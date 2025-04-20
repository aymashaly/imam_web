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
 * No authentication plugin upgrade code
 *
 * @package    auth_coupsign
 * @copyright  2017 Stephen Bourget
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

/**
 * Function to upgrade auth_coupsign.
 * @param int $oldversion the version we are upgrading from
 * @return bool result
 */
function xmldb_auth_coupsign_upgrade($oldversion) {
    global $DB;

    $dbman = $DB->get_manager();

    if ($oldversion < 2024021202) { // Replace 2024030404 with your new version number

        // Define the new table structure
        $table = new xmldb_table('auth_coupon');

        $field = new xmldb_field('start_date', XMLDB_TYPE_INTEGER, '10', null, null, null, '1');


        // Create the table if it doesn't exist
        if (!$dbman->field_exists($table, $field)) {
            $dbman->add_field($table, $field);
        }

        // Incremental upgrade step
        upgrade_plugin_savepoint(true, 2024021202, 'auth', 'coupsign');
    }
    
    if ($oldversion < 2024111206) { // Replace 2024030404 with your new version number

        // Define the new table structure
        $table = new xmldb_table('auth_coupon');

        $field = new xmldb_field('delete_code', XMLDB_TYPE_INTEGER, '10', null, XMLDB_NOTNULL, null, 0);


        // Create the table if it doesn't exist
        if (!$dbman->field_exists($table, $field)) {
            $dbman->change_field_default($table, $field);
        }

        // Incremental upgrade step
        upgrade_plugin_savepoint(true, 2024111206, 'auth', 'coupsign');
    }
    if ($oldversion < 2025041901) { // Replace 2024030404 with your new version number

        // Define the new table structure
        $table = new xmldb_table('auth_coupon');

        $field = new xmldb_field('delete_date', XMLDB_TYPE_INTEGER, '10', null, XMLDB_NOTNULL, null, 0);

        // 1. Add email_pattern (nullable)
        $field = new xmldb_field('email_pattern', XMLDB_TYPE_CHAR, '30', null, null, null, null);
        if (!$dbman->field_exists($table, $field)) {
            $dbman->add_field($table, $field);
        }

        // 2. Add discount_type (not null, default set in code)
        $field = new xmldb_field('discount_type', XMLDB_TYPE_CHAR, '10', null, XMLDB_NOTNULL, null, null);
        if (!$dbman->field_exists($table, $field)) {
            $dbman->add_field($table, $field);
        }

        // Set default manually via SQL after the field is added
        $DB->execute("UPDATE {auth_coupon} SET discount_type = 'fixed' WHERE discount_type IS NULL");

        // 3. Add price (not null, default 0)
        $field = new xmldb_field('price', XMLDB_TYPE_FLOAT, '10', null, XMLDB_NOTNULL, null, 0);
        if (!$dbman->field_exists($table, $field)) {
            $dbman->add_field($table, $field);
        }
        // Create the table if it doesn't exist
        if (!$dbman->field_exists($table, $field)) {
            $dbman->add_field($table, $field);
        }

        // Incremental upgrade step
        upgrade_plugin_savepoint(true, 2025041901, 'auth', 'coupsign');
    }

    return true;
}
