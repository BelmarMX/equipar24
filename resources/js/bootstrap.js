import axios from 'axios';
import tippy from "tippy.js";
window.axios = axios;
window.tippy = tippy;

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';


