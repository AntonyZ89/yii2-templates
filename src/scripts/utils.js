/**
 * Some Utils
 *
 * @type {jQuery}
 */

const pathname = window.location.pathname;
const body = $('body');
const lang = $('html').attr('lang');
const modal = $('#modal');

function loadMasks() {
    const datepicker = $('input[data-krajee-kvdatepicker]');
    const dateRangePicker = $('input[data-krajee-daterangepicker]');

    datepicker.length && datepicker.inputmask({mask: '99/99/9999'});
    dateRangePicker.length && dateRangePicker.inputmask({mask: '99/99/9999 - 99/99/9999'});

    body.on('blur', 'input[data-krajee-datecontrol]', function () {
        $(this).data('datecontrol').validate();
    });
}

function randomInt(min, max) {
    return Math.floor(Math.random() * (max - min + 1) + min);
}

function randomColor() {
    const letters = '0123456789ABCDEF';
    let color = '#';
    for (let i = 0; i < 6; i++) {
        color += letters[randomInt(0, letters.length)];
    }
    return color;
}

function getSelectedRows() {
    return $('.grid-view').yiiGridView('getSelectedRows');
}

/**
 * serialize form
 *
 * @param form_element {jQuery}
 * @returns {{}}
 */
function parseFormToYii(form_element) {
    const obj = {};
    for (let _ of form_element.serializeArray()) {
        let columns = _.name.match(/\[[^[\]]+]/g);
        let _key = _.name.replace(/\[.+]/, '');

        if (columns) {
            if (columns.length > 1) {
                let column, ref;
                ref = (_key in obj ? obj[_key] : (obj[_key] = {}));
                while (columns.length) {
                    column = removeBrackets(columns.shift());
                    if (columns.length) {
                        if (!(column in ref)) {
                            ref = ref[column] = {};
                        } else {
                            ref = ref[column];
                        }
                    } else {
                        ref[column] = _.value;
                    }
                }
            } else {
                (columns = removeBrackets(columns[0])) && (_key in obj || (obj[_key] = {})) && (obj[_key][columns] = _.value);
            }
        } else {
            obj[_.name] = _.value;
        }
    }
    return obj;
}

function removeBrackets(str) {
    return str.replace(/[[\]]/g, '');
}

/*
BLOCK SPECIAL CHARACTERS IN INPUT

$('input').on('input', function() {
    let c = this.selectionStart,
        r = /[^a-z0-9_]/gi,
        v = $(this).val();
    if(r.test(v)) {
        $(this).val(v.replace(r, ''));
        c--;
    }
    this.setSelectionRange(c, c);
});
*/

loadMasks();
