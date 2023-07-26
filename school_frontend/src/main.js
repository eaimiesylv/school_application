import { createApp, reactive ,watchEffect} from 'vue';
import App from './App.vue';
import router from './router';
//import './axios';
import axios from 'axios'
import BaseLayout from './components/base/BaseLayout.vue';

axios.defaults.baseURL = "http://127.0.0.1:8000/api/";




// Create a reactive data object to store the token
const state = reactive({
  token: localStorage.getItem('token') || '',
});

// Watch for changes in the token and update the Authorization header
watchEffect(() => {
  if (state.token) {
    axios.defaults.headers.common['Authorization'] = 'Bearer ' + state.token;
  }
});

const app=createApp(App);
app.config.globalProperties.$globalData = reactive({
    sessionData:{},
    teacherData:{},
   
  });
app.use(router);
app.component('base-layout', BaseLayout);
app.mount('#app');
