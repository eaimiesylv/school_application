<template>
  <base-layout>
      
  <p v-if="loginDetail !== null">
    <!-- Email is set, display it -->
    {{ loginDetail}}
  </p>
  <p v-else>
    <!-- Email is not set, display a message or alternative content -->
    Email is not set.
  </p>
  </base-layout>
</template>

<script>
import { useAuthStore } from '@/store';
export default {
  data() {
    return {};
  },
  computed:{
          loginDetail(){
          return useAuthStore().user
          // return localStorage.getItem('user')
          
        }
    },
  created() {
    if (!localStorage.getItem('visitedBefore')) {
      localStorage.setItem('visitedBefore', 'true');
      window.location.reload();
    }
  },
};
</script>
