YUI.add('moodle-availability_enrol-form', function (Y, NAME) {

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
 * Version info.
 *
 * @package availability_enrol
 * @copyright 2018 Christian Glahn
 * @license http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

var TEMPLATE =
  '<div>' +
  '<label>{{ get_string "userenrolment" "availability_enrol" }}' +
  '<select name="mode" class="custom-select" style="margin-left: .5rem">' +
  '<option value="{{ MODE_ACTIVE }}">{{get_string "isactive" "availability_enrol"}}</option>' +
  '<option value="{{ MODE_SUSPENDED }}">{{get_string "issuspended" "availability_enrol"}}</option>' +
  '<option value="{{ MODE_ANY }}">{{get_string "existsactiveornot" "availability_enrol"}}</option>' +
  '</select>' +
  '</label>' +
  '</div>';

var MODE_ACTIVE = 0;
var MODE_SUSPENDED = 1;
var MODE_ANY = 2;

M.availability_enrol = M.availability_enrol || {}; // eslint-disable-line

M.availability_enrol.form = Y.merge(M.core_availability.plugin, {
    _node: null,

    getNode: function(json) {
        var template, node, mode;

        if (!this._node) {
            template = Y.Handlebars.compile(TEMPLATE);
            this._node = Y.Node.create(
                template({
                    MODE_ACTIVE: MODE_ACTIVE,
                    MODE_SUSPENDED: MODE_SUSPENDED,
                    MODE_ANY: MODE_ANY,
                })
            );

            // When select changes.
            Y.one('#fitem_id_availabilityconditionsjson, .availability-field').delegate(
                'change',
                function() {
                    M.core_availability.form.update();
                },
                '.availability_enrol select'
            );
        }

        node = this._node.cloneNode(true);

        // Select relevant option.
        mode = typeof json.mode === 'undefined' ? MODE_ACTIVE : json.mode;
        node.one('[name="mode"]').set('value', mode);

        return node;
    },

    fillValue: function(value, node) {
        var modeselect = node.one('[name="mode"]'),
            mode = modeselect.get('value');
        value.mode = parseInt(mode, 10) || MODE_ACTIVE;
    },

});


}, '@VERSION@', {"requires": ["base", "node", "event", "moodle-core_availability-form"]});
