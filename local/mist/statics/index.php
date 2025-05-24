<?php
// This file is part of Moodle - http://moodle.org/
// Access Moodle's configuration and libraries.
require_once(__DIR__ . '/../../../config.php');
require_login();

// Set up the page.
$PAGE->set_url(new moodle_url('/local/mist/statics/index.php'));
$PAGE->set_context(context_system::instance());
$PAGE->set_title('Statistics');
$PAGE->set_heading('Statistics');

// Fetch course statistics.
global $DB;

// Get the total number of courses.
$total_courses = $DB->count_records('course');

// Get the total number of enrolments.
$total_enrolments = $DB->count_records('user_enrolments');

// Render the page.
echo $OUTPUT->header();
echo html_writer::tag('h2', 'Statistics');

// Get all courses with their completion percentage.
$courses = $DB->get_records('course', null, 'fullname ASC', '*');
foreach ($courses as &$course) {
    // Calculate completion percentage for each course.
    // Check if the course is online or not.
    $is_online = $DB->get_field('course_format_options', 'value', [
        'courseid' => $course->id,
        'name' => 'format'
    ]) === 'online';
    $course->category_name = $DB->get_field('course_categories', 'name', ['id' => $course->category]);

    if ($is_online) {
        // Calculate average completions for online courses.
        $completion_criteria = $DB->count_records('course_completion_criteria', ['course' => $course->id]);
        $completed_criteria = $DB->count_records_sql("
            SELECT COUNT(DISTINCT cc.userid)
            FROM {course_completion_crit_compl} cc
            JOIN {user} u ON cc.userid = u.id
            WHERE cc.course = :courseid AND u.deleted = 0
        ", ['courseid' => $course->id]);
    } else {
        // Calculate completion based on timeline for non-online courses.
        $completion_criteria = $DB->count_records('course_completion_criteria', ['course' => $course->id]);
        $completed_criteria = $DB->count_records_sql("
            SELECT COUNT(DISTINCT cc.userid)
            FROM {course_completion_crit_compl} cc
            JOIN {user} u ON cc.userid = u.id
            WHERE cc.course = :courseid AND u.deleted = 0 AND cc.timecompleted IS NOT NULL
        ", ['courseid' => $course->id]);
    }

    $course->completion_percentage = $completion_criteria > 0 ? round(($completed_criteria / $completion_criteria) * 100, 2) : 0;
    // Get enrolments for the last 4 months of the current year grouped by month.
    $current_year = date('Y');
    $start_date = strtotime("first day of -4 months", strtotime("$current_year-12-31"));
    $end_date = strtotime("$current_year-12-31");

    $course->recent_enrolments_by_month = $DB->get_records_sql("
        SELECT 
            FROM_UNIXTIME(ue.timecreated, '%Y-%m') AS enrol_month,
            COUNT(ue.id) AS enrol_count
        FROM {user_enrolments} ue
        JOIN {enrol} e ON ue.enrolid = e.id
        WHERE e.courseid = :courseid AND ue.timecreated BETWEEN :startdate AND :enddate
        GROUP BY enrol_month
        ORDER BY enrol_month ASC
    ", [
        'courseid' => $course->id,
        'startdate' => $start_date,
        'enddate' => $end_date
    ]);
    // Get the total number of users enrolled in each course.
    $course->total_users = $DB->count_records_sql("
        SELECT COUNT(DISTINCT ue.userid)
        FROM {user_enrolments} ue
        JOIN {enrol} e ON ue.enrolid = e.id
        WHERE e.courseid = :courseid
    ", ['courseid' => $course->id]);
    $course->price = $DB->get_field('enrol', 'cost', ['courseid' => $course->id]) ?? 0;
    // Calculate total revenue for each course.
    $course->total_revenue = $DB->get_record_sql("
        SELECT SUM(e.cost) AS total_revenue
        FROM {enrol} e
        WHERE e.courseid = :courseid
    ", ['courseid' => $course->id])->total_revenue ?? 0;
    // Calculate total sales for each course.
    $course->total_sales = $DB->count_records_sql("
        SELECT COUNT(ue.id)
        FROM {user_enrolments} ue
        JOIN {enrol} e ON ue.enrolid = e.id
        WHERE e.courseid = :courseid
    ", ['courseid' => $course->id]) * $course->price;
    
}

?>
<div class="row">
    <div class="col-6 card">
        <h4>Courses Completion Percentage</h4>
        <?php foreach ($courses as $course) { ?>
            <div class="row">
                <span>
                    <?=$course->fullname?>
                </span>
                <div style="width: <?=$course->completion_percentage + 1?>%;height:40%;margin:auto 4px;background:green"></div>
            </div>
        <?php
            }
        ?>
    </div>
    <div class="col-6">
        <h4>Recent Enrolments (Last 4 Months)</h4>
        <?php
        $months = [];
        $enrolments_by_month = [];

        // Collect enrolment data for all courses combined.
        foreach ($courses as $course) {
            if (!empty($course->recent_enrolments_by_month)) {
            foreach ($course->recent_enrolments_by_month as $enrolment) {
                $month = $enrolment->enrol_month;
                $enrolments_by_month[$month] = ($enrolments_by_month[$month] ?? 0) + $enrolment->enrol_count;
                if (!in_array($month, $months)) {
                $months[] = $month;
                }
            }
            }
        }

        // Sort months chronologically.
        sort($months);
        $max_enrolments = !empty($enrolments_by_month) ? max($enrolments_by_month) : 0;
        ?>

        <div style="width: 100%; height: 300px; position: relative;">
            <?php if (!empty($enrolments_by_month)) { ?>
            <?php foreach ($months as $month) {
                $bar_height = $max_enrolments > 0 ? ($enrolments_by_month[$month] / $max_enrolments) * 100 : 0;
                echo '<div style="
                display: inline-block;
                width: 20%;
                height: ' . $bar_height . '%;
                background-color: #007bff;
                margin: 0 2%;
                text-align: center;
                color: white;
                position: absolute;
                bottom: 0;
                " title="' . $month . ': ' . $enrolments_by_month[$month] . '">
                <span style="position: absolute; bottom: 100%; font-size: 12px;">' . $month . '</span>
                </div>';
            } ?>
            <?php } else { ?>
            <p>No enrolments found for the last 4 months.</p>
            <?php } ?>
        </div>
    </div>
</div>
<hr>
<div class="container">
    <div class="">
        <div class="row">
            <div class="col-4">
                <div class="card">
                    <div class="card-body">
                        <?php
                        $archived_courses = $DB->count_records('course', ['visible' => 0]);
                        echo html_writer::tag('h4', 'Total Archived Courses: ' . $archived_courses);
                        ?>
                    </div>
                </div>
            </div>
            <div class="col-4">
                <div class="card">
                    <div class="card-body">
                        <?php
                        $draft_courses = $DB->count_records('course', ['visible' => 2]);
                        echo html_writer::tag('h4', 'Total Draft Courses: ' . $draft_courses);
                        ?>
                    </div>
                </div>
            </div>
            <div class="col-4">
                <div class="card">
                    <div class="card-body">
                        <?php
                        $active_courses = $DB->count_records('course', ['visible' => 1]);
                        echo html_writer::tag('h4', 'Total Active Courses: ' . $active_courses);
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div>
        <div class="table">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Course Name</th>
                        <th>Course Category</th>
                        <th>Total Sales</th>
                        <th>Total Users</th>
                        <th>Completion Percentage</th>
                        <th>Total Revenue</th>
                        <th>Price</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($courses as $course) { ?>
                        <tr>
                            <td><?=$course->fullname?></td>
                            <td><?=$course->category_name?></td>
                            <td><?=$course->total_sales?></td>
                            <td><?=$course->total_users?></td>
                            <td><?=$course->completion_percentage?>%</td>
                            <td><?=$course->total_revenue?></td>
                            <td><?=$course->price?></td>
                            <td>
                                <a href="<?php echo new moodle_url('/local/mist/invoices.php', ['courseid' => $course->id]); ?>" class="btn btn-primary">View Invoices</a>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?php

echo $OUTPUT->footer();
?>