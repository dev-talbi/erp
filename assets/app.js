/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */

// any CSS you import will output into a single css file (app.css in this case)
require('@fortawesome/fontawesome-free/css/all.min.css');
require('@fortawesome/fontawesome-free/js/all.js');
import './styles/app.scss';
import './styles/global.scss';
// start the Stimulus application
import './bootstrap';
import './js/ajax /sevices/addServiceAjax'
import './js/ajax /sevices/deleteServiceAjax'
import './js/ajax /sevices/editService'

import $ from 'jquery';
