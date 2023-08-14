import { createApp, reactive} from 'vue';
import App from './App.vue';
import router from './router';

import { createPinia } from "pinia"

//import './axios';
import axios from 'axios'
import BaseLayout from './components/base/BaseLayout.vue';

axios.defaults.baseURL = "http://127.0.0.1:8000/api/";


const app=createApp(App);
app.config.globalProperties.$globalData = reactive({
    sessionData:{},
    teacherData:{},
   
  });
app.use(router);
app.use(createPinia());
app.component('base-layout', BaseLayout);
app.mount('#app');
