<template>
  <base-layout>
    <div class="container mt-4">
       <!-- Show error message if API call fails -->
       <div v-if="hasError" class="text-center">
        <p>An error occurred while fetching classes. Please try again later.</p>
      </div>
      <h3 class="add_heading">Add Class</h3>
      <form @submit.prevent="submitForm">
        <div class="form-group">
          <label for="class_level">Select Class Level</label>
          <select class="form-control" v-model="selectedClassLevel" id="class_level" required>
            <option v-for="level in 6" :value="level" :key="level">{{ level }}</option>
          </select>
        </div>
        
        <div class="form-group">
          <label for="class_name">Enter Class Name</label>
          <input type="text" class="form-control" placeholder="Select class name" v-model="form.class_name" id="class_name" required>
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
        class_name: '',
      },
      isLoading: false,
      error: '',
      hasError: '',
      classes: '',
      selectedClassLevel: 1, // Default selected class level is 1
    };
  },
  methods: {
    async submitForm() {
      this.isLoading = true; // Start the loading indicator
      this.error = ''; // Reset the error message
      try {
        await this.postMethod('/klass', {
          class_value: this.selectedClassLevel, // Include selected class level in the data
          class_name: this.form.class_name,
        }, '/klass');
        // Redirect to the desired route upon successful POST request (if needed)
        // this.$router.push('/success-route');
      } catch (error) {
        // Handle the error here
        console.error('Error performing POST request:', error);
      } finally {
        this.isLoading = false; // Set isLoading to false after the request is completed
      }
    },
    async fetchClasses() {
      try {
        this.isLoading = true;
        this.error = '';
        this.classes = await this.getMethod('/klass');
      } catch (error) {
        console.log(error);
      } finally {
        this.isLoading = false; // Set isLoading to false after the request is completed
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
