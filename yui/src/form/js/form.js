/**
 * JavaScript for form editing group conditions.
 *
 * @module moodle-availability_enrol-form
 */
M.availability_enrol = M.availability_enrol || {};

/**
 * @class M.availability_enrol.form
 * @extends M.core_availability.plugin
 */
M.availability_enrol.form = Y.Object(M.core_availability.plugin);

/**
 * Groups available for selection (alphabetical order).
 *
 * @property groups
 * @type Array
 */
M.availability_enrol.form.groups = null;

/**
 * Initialises this plugin.
 *
 * @method initInner
 */
M.availability_enrol.form.initInner = function() {
  // nothing to initialize
};

M.availability_enrol.form.getNode = function(json) {
    // Create HTML structure.
    var html = '<span class="form-inline"><label><span class="p-r-1">' + M.util.get_string('title', 'availability_enrol') + '</span></label></span>';
    var node = Y.Node.create(html);
    return node;
};

M.availability_enrol.form.fillValue = function(value, node) {
    // no fills
};

M.availability_enrol.form.fillErrors = function(errors, node) {
// no errors possible
};
