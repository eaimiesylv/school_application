<template>
  <base-layout>
    <div>
      <h4 class="btn btn-primary"><router-link to="/session/addsession">Create Session</router-link></h4>

      <!-- Show loading state if classes are being fetched -->
      <div v-if="isLoading" class="text-center">
        <p>Loading...</p>
      </div>

      <!-- Show error message if API call fails -->
      <div v-if="hasError" class="text-center">
        <p>An error occurred while fetching classes. Please try again later.</p>
      </div>

      <!-- Show the table if classes are available -->
      <table v-if="sessions.length > 0" class="table">
        <thead>
          <tr>
            <th>Sn</th>
            <th>Academic session</th>
            <th>Term</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="(item, index) in sessions" :key="item.id">
            <td>{{ index + 1}}</td>
            <td>{{ item.year }}</td>
            <td>{{ item.term }}</td>
          </tr>
        </tbody>
      </table>

     
    </div>
  </base-layout>
</template>

<script>
import { apiFunctionMixin } from '@/apiFunction.js';

export default {
  mixins: [apiFunctionMixin],
  data() {
    return {
      sessions: [], // Assign the API response to this property
      isLoading: false, // Loading state flag
      hasError:'',
     
    };
  },
  mounted() {
    this.fetchSession();
  },
  methods: {
    async fetchSession() {
      try {
         this.isLoading = true;
         this.sessions=await this.getMethod('/session');
      } catch (error) {
        console.log(error);
        
      }
    },
  },
};
</script>
