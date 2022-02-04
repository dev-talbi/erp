/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */

// any CSS you import will output into a single css file (app.css in this case)
const $ = require('jquery');
require('@fortawesome/fontawesome-free/css/all.min.css');
require('@fortawesome/fontawesome-free/js/all.js');
require('jquery-ui/ui/widgets/droppable');
require('jquery-ui/ui/widgets/sortable');
require('jquery-ui/ui/widgets/selectable');
require('bootstrap');
import './styles/app.scss';
import './styles/global.scss';
// start the Stimulus application
import './js/ajax /sevices/addServiceAjax'
import './js/ajax /sevices/deleteServiceAjax'
import './js/ajax /sevices/editService'
import './js/ajax /quote/addQuote'
import * as select2 from "select2";
import "select2/dist/css/select2.css";
import "select2-bootstrap-theme/dist/select2-bootstrap.css";
import { Tooltip, Toast, Popover } from 'bootstrap'
import './bootstrap';
select2($);
$(document).ready(function() {
    $('[data-toggle="popover"]').popover();
});