<template>
  <base-layout>
    <div>
      <h4 class="btn btn-primary">
        <router-link to="/assessment/addassessment">Create Assessment</router-link>
      </h4>

      <!-- Show loading state if classes are being fetched -->
      <div v-if="isLoading" class="text-center">
        <p>Loading...</p>
      </div>

      <!-- Show error message if API call fails -->
      <div v-if="hasError" class="text-center">
        <p>An error occurred while fetching classes. Please try again later.</p>
      </div>

      <!-- Show the table if classes are available -->
      <div class="border-box" v-for="sessionItem in session_assessment" :key="sessionItem.id">
        <h2>{{ sessionItem.year}}  {{ sessionItem.term}}</h2>

        <table v-if="sessionItem.assessment.length > 0" class="table">
          <thead>
            <tr>
              <th>Assessment name</th>
              <th>Minimum mark</th>
              <th>Maxmimum mark</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="assessmentItem in sessionItem.assessment" :key="assessmentItem.id">
              <td>{{ assessmentItem.assessname }}</td>
              <td>{{ assessmentItem.min }}</td>
              <td>{{ assessmentItem.max }}</td>
            </tr>
          </tbody>
        </table>

        <p v-else>No assessment available for this class.</p>
      </div>
    </div>
  </base-layout>
</template>


<script>
import { apiFunctionMixin } from '@/apiFunction.js';

export default {
  mixins: [apiFunctionMixin],
  data() {
    return {
      session_assessment: [], // Assign the API response to this property
      isLoading: false, // Loading state flag
      hasError:'',
     
    };
  },
  mounted() {
    this.fetchSessionAssessment();
    
  },
  methods: {
    async fetchSessionAssessment() {
      try {
         this.isLoading = true;
         this.session_assessment=await this.getMethod('/session_assessment');
      } catch (error) {
        console.log(error);
        
      }
    },
  },
};
</script>
<style>
.border-box {
  background-color: #fff;
  box-shadow: 0px 2px 4px rgba(0, 0, 0, 0.2);
}

</style>
