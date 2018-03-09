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
 * Front-end class.
 *
 * @package availability_enroll
 * @copyright 2018 Christian Glahn
 * @license http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

namespace availability_enrol;

defined('MOODLE_INTERNAL') || die();

/**
 * Front-end class.
 *
 * @package availability_enrol
 * @copyright 2018 Christian Glahn
 * @license http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class frontend extends \core_availability\frontend {
    /**
     * returns frontend strings
     */
    protected function get_javascript_strings() {
        return array('requires_enrolled');
    }

    /**
     * dummy function to make moodle happy
     */
    protected function get_javascript_init_params($course, \cm_info $cm = null,
            \section_info $section = null) {

        return array();
    }

    /**
     * Test if the course has the guest access activated.
     *
     * @param $course
     * @param \cm_info $cm - unused
     * @param \section_info $section - unused
     */
    protected function allow_add($course, \cm_info $cm = null,
            \section_info $section = null) {

        // This condition is only availavble if guest access is active
        $instances = enrol_get_instances($course->id, false);

        foreach ($instances as $instance) {
            if ($instance->enrol === "guest") {
              return true;
            }
        }

        return false;
    }
}
