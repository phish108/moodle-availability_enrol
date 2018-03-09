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
 * Condition main class.
 *
 * @package availability_enrol
 * @copyright 2018 Christian Glahn
 * @license http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

namespace availability_enrol;

defined('MOODLE_INTERNAL') || die();

/**
 * Condition main class.
 *
 * @package availability_enroll
 * @copyright 2018 Christian Glahn
 * @license http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class condition extends \core_availability\condition {
    /**
     * Constructor.
     *
     * @param \stdClass $structure Data structure from JSON decode
     * @throws \coding_exception If invalid data structure.
     */
    public function __construct($structure) {
        // nothing to do here, there are no options for this condition
    }

    public function save() {
        $result = (object)array('type' => 'enroll');
        return $result;
    }

    public function is_available($not, \core_availability\info $info, $grabthelot, $userid) {
        $course = $info->get_course();
        $context = \context_course::instance($course->id);
        $allow = is_enrolled($context, $userid, '', true);

            // The NOT condition applies before accessallgroups (i.e. if you
            // set something to be available to those NOT in group X,
            // people with accessallgroups can still access it even if
            // they are in group X).
            if ($not) {
                $allow = !$allow;
            }
        return $allow;
    }

    public function get_description($full, $not, \core_availability\info $info) {
        global $DB;

        return get_string($not ? 'requires_notunenrolled' : 'requires_notenrolled',
                'availability_enrol');
    }

    protected function get_debug_string() {
        return 'Enrollment';
    }
}
