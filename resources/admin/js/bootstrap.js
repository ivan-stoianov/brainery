import axios from 'axios';
import * as bootstrap from 'bootstrap';

class Application {
    static registerAxios() {
        window.axios = axios;
        window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

        window.token = document.head.querySelector('meta[name="csrf-token"]');
        if (window.token) {
            window.axios.defaults.headers.common['X-CSRF-TOKEN'] = window.token.content;
        }
    }

    static registerBootstrap() {
        window.bootstrap = bootstrap;
    }
}

Application.registerAxios();
Application.registerBootstrap();
