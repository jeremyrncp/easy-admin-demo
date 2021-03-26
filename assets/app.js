/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */
import { startStimulusApp } from '@symfony/stimulus-bridge';

// any CSS you import will output into a single css file (app.css in this case)
import './styles/app.scss';

import jquery from 'jquery';

// start the Stimulus application
import './bootstrap';


$("#changeLanguage").change((event) => {
    const params = new URLSearchParams(window.location.search)
    params.set("locale", event.target.value)

    window.location.replace(window.location.pathname + "?" + params)
})

export const app = startStimulusApp(require.context(
    '@symfony/stimulus-bridge/lazy-controller-loader!./controllers',
    true,
    /\.(j|t)sx?$/
));