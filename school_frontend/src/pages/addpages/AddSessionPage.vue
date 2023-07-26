<template>
  <base-layout>
    <div class="container mt-4">
       <!-- Show error message if API call fails -->
       <div v-if="hasError" class="text-center">
        <p>An error occurred while fetching classes. Please try again later.</p>
      </div>
      <h3 class="add_heading">Add Session</h3>
      <form @submit.prevent="submitForm">
        
        <div class="form-group">
          <label for="session">Enter Session</label>
          <input type="text" class="form-control" placeholder="2019/2023" v-model="form.year" id="session" required>
        </div>
          <div class="form-group">
          <label for="term">Select type</label>
          <select v-model="form.term" class="form-control"  required>
            <option>First Term</option>
            <option>Second Term</option>
            <option>Third Term</option>
          </select>
        </div>
        
       
       
        <button type="submit" class="btn btn-primary" :disabled="isLoading">
          <span v-if="isLoading">Submitting...</span>
          <span v-else>Submit</span>
        </button>
        <p v-if="error" class="error-message">{{ error }}</p>
      </form>
    </div>
  </base-layout>
</template>

<script>
import { apiFunctionMixin } from '@/apiFunction.js';

export default {
  mixins: [apiFunctionMixin],
  data() {
    return {
      form: {
       year:'',
        term:'',
        
       
      },
      isLoading: false,
      error: '',
      hasError:'',
      classes:''
    };
  },
  methods: {
   async submitForm() {
      this.isLoading = true; // Start the loading indicator
      this.error = ''; // Reset the error message
      try {
        //endpoint, form data, redirect route
        await this.postMethod('/session',
                              { 
                                year: this.form.year,
                                term: this.form.term,
                               

                              },'/session');
      } catch (error) {
        // Handle the error here
        console.error('Error performing POST request:', error);
      }
     
    },
    async fetchClasses() {
      try {
         this.isLoading = true;
         this.error = '';
         this.classes=await this.getMethod('/klass');
        
        
      } catch (error) {
        console.log(error);
        
      }
    },
  },
  mounted() {
    this.fetchClasses();
  },
};
</script>

<style>
.add_heading {
  color: orange;
}

.error-message {
  color: red;
}
</style>
