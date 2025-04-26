<?php

defined('MOODLE_INTERNAL') || die();

function xmldb_local_orgstructure_upgrade($oldversion) {
    global $DB;

    $dbman = $DB->get_manager();

    if ($oldversion < 2025042700) {

        // Define table local_org_jobrole_competencies to be created.
        $table = new xmldb_table('local_org_jobrole_competencies');

        $table->add_field('id', XMLDB_TYPE_INTEGER, '10', null, XMLDB_NOTNULL, XMLDB_SEQUENCE, null);
        $table->add_field('jobroleid', XMLDB_TYPE_INTEGER, '10', null, XMLDB_NOTNULL, null, null);
        $table->add_field('competencyid', XMLDB_TYPE_INTEGER, '10', null, XMLDB_NOTNULL, null, null);
        $table->add_field('timecreated', XMLDB_TYPE_INTEGER, '10', null, XMLDB_NOTNULL, null, null);
        $table->add_field('timemodified', XMLDB_TYPE_INTEGER, '10', null, null, null, null);

        $table->add_key('primary', XMLDB_KEY_PRIMARY, ['id']);
        $table->add_index('uniq_jobrole_competency', XMLDB_INDEX_UNIQUE, ['jobroleid', 'competencyid']);

        // Conditionally launch create table.
        if (!$dbman->table_exists($table)) {
            $dbman->create_table($table);
        }

        // Orgstructure savepoint reached.
        upgrade_plugin_savepoint(true, 2025042700, 'local', 'orgstructure');
    }

    return true;
}
