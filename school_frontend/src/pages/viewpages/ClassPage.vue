<template>
  <base-layout>
    <div>
      <h4 class="btn btn-primary"><router-link to="/klass/addklass">Create Class</router-link></h4>

      <!-- Show loading state if classes are being fetched -->
      <div v-if="isLoading" class="text-center">
        <p>Loading...</p>
      </div>

      <!-- Show error message if API call fails -->
      <div v-if="hasError" class="text-center">
        <p>An error occurred while fetching classes. Please try again later.</p>
      </div>

      <!-- Show the table if classes are available -->
      <table v-if="classes.length > 0" class="table">
        <thead>
          <tr>
            <th>S/n</th>
            <th>Class Name</th>
            
          </tr>
        </thead>
        <tbody>
          <tr v-for="(classItem, index) in classes" :key="classItem.id">
            <td>{{ index + 1}}</td>
            <td>{{ classItem.class_name }}</td>
          
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
      classes: [], // Assign the API response to this property
      isLoading: false, // Loading state flag
      hasError:'',
     
    };
  },
  mounted() {
    this.fetchClasses();
  },
  methods: {
    async fetchClasses() {
      try {
         this.isLoading = true;
         this.classes=await this.getMethod('/klass');
      } catch (error) {
        console.log(error);
        
      }
    },
  },
};
</script>
