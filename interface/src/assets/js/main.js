/**
 * by theWhK - 2018
 */

var detectChange = false;

$(document).ready(function() {
    $('select').change(function() {
        $('.form-filtros').submit();
    });
});