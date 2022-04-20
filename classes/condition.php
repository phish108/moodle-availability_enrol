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
 * @package availability_enrol
 * @copyright 2018 Christian Glahn
 * @license http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class condition extends \core_availability\condition {

    /** Enrolled, and active. */
    const MODE_ACTIVE = 0;
    /** Enrolled, and suspended. */
    const MODE_SUSPENDED = 1;
    /** Enrolled, active or inactive, it doesn't matter. */
    const MODE_ANY = 2;

    /** @var int Constant MODE_* */
    protected $mode = self::MODE_ACTIVE;

    /**
     * @inheritDoc
     */
    public function __construct($structure) {
        if (isset($structure->mode)) {
            $this->mode = (int) $structure->mode;
        }
    }

    /**
     * @inheritDoc
     */
    public function save() {
        return ['mode' => $this->mode];
    }

    /**
     * @inheritDoc
     */
    public function is_available($not, \core_availability\info $info, $grabthelot, $userid) {
        $course = $info->get_course();
        $context = \context_course::instance($course->id);

        $allow = null;
        if ($this->mode === static::MODE_SUSPENDED) {
            $allow = is_enrolled($context, $userid, '', false) && !is_enrolled($context, $userid, '', true);
        } else if ($this->mode === static::MODE_ANY) {
            $allow = is_enrolled($context, $userid, '', false);
        } else {
            $allow = is_enrolled($context, $userid, '', true);
        }

        if ($not) {
            $allow = !$allow;
        }
        return $allow;
    }

    /**
     * @inheritDoc
     */
    public function get_description($full, $not, \core_availability\info $info) {
        if ($this->mode === static::MODE_SUSPENDED) {
            return get_string($not ? 'requiresnotsuspended' : 'requiressuspended', 'availability_enrol');
        } else if ($this->mode === static::MODE_ANY) {
            return get_string($not ? 'requiresnotenrolled' : 'requiresenrolled', 'availability_enrol');
        }
        // Keep it simple and do not mention "active" enrolment in positive description.
        return get_string($not ? 'requiresnotactiveenrolment' : 'requiresenrolled', 'availability_enrol');
    }

    /**
     * @inheritDoc
     */
    protected function get_debug_string() {
        return "{$this->mode}";
    }
}
