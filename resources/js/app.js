
// Bootstrap & vue
require('./bootstrap');

require('./home');

window.Vue = require('vue');


const app = new Vue({
    el: '#app'
});
