<template>
  <base-layout>
    <div class="container mt-4">
       <!-- Show error message if API call fails -->
       <div v-if="hasError" class="text-center">
        <p>An error occurred while fetching classes. Please try again later.</p>
      </div>
      <h3 class="add_heading">Add subject</h3>
      <form @submit.prevent="submitForm">
        <div class="form-group">
          <label for="class_name">Select class name</label>
          <select v-model="form.class_id" class="form-control" required>
            <option v-for="classItem in classes" :value="classItem.id" :key="classItem.id">
              {{ classItem.class_name }}
            </option>
          </select>
        </div>
        <div class="form-group">
          <label for="subject_name">Enter subject name</label>
          <input type="text" placeholder ="Subject name" class="form-control" v-model="form.subject_name" id="subject_name" required>
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
        class_id:'',
        subject_name:'',
        subject_label:'null'
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
        await this.postMethod('/subject',
                              { 
                                subjects: this.form.subject_name,
                                //subject_label: this.form.subject_label,
                                class_id: this.form.class_id

                              },'/subject');
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
