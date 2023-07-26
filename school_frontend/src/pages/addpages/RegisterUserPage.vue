<template>
  <base-layout>
    <div class="container mt-4">
      <h4 class="add_heading">Register Student</h4>
      <h5 class="add_heading">Session: {{$globalData.sessionData.year}} {{$globalData.sessionData.term}}</h5>
      <form @submit.prevent="submitForm">
        <div class="form-group">
          <label for="first_name">First Name</label>
          <input type="text" class="form-control" v-model="form.first_name" id="first_name" required>
        </div>
        <div class="form-group">
          <label for="last_name">Last name</label>
          <input type="text" class="form-control" v-model="form.last_name" id="last_name" required>
        </div>
        <div class="form-group">
          <label for="email">Email</label>
          <input type="text" class="form-control" v-model="form.email" id="email" required>
        </div>
        <div class="form-group">
          <label>Sex</label><br>
          <div class="form-check form-check-inline">
              <input class="form-check-input" type="radio" v-model="form.sex" id="male" value="m">
              <label class="form-check-label" for="male">Male</label>
          </div>
          <div class="form-check form-check-inline">
              <input class="form-check-input" type="radio" v-model="form.sex" id="female" value="f">
              <label class="form-check-label" for="female">Female</label>
          </div>
      </div>

        <div class="form-group">
          <label for="dob">DOB</label>
          <input type="date" class="form-control" v-model="form.dob" id="dob">
        </div>
        <div class="form-group">
          <label for="passport">Passport</label>
          <input type="file" class="form-control" @change="handleFileChange" id="passport">
        </div>

        <div class="form-group">
          <label>Category</label><br>
          <div class="form-check form-check-inline">
              <input class="form-check-input" type="radio" v-model="form.category" id="staff" value="1">
              <label class="form-check-label" for="staff">Staff</label>
          </div>
          <div class="form-check form-check-inline">
              <input class="form-check-input" type="radio" v-model="form.category" id="student" value="0">
              <label class="form-check-label" for="student">Student</label>
          </div>
      </div>
      <div class="form-group"  v-if="form.category === '0'">
          <label for="class_name">Select class name</label>
          <select v-model="form.class_id" class="form-control" required>
            <option v-for="classItem in classes" :value="classItem.id" :key="classItem.id">
              {{ classItem.class_name }}
            </option>
          </select>
        </div>
      <div class="form-group">
          <label for="password">Password</label>
          <input type="password" class="form-control" v-model="form.password" id="password" required>
      </div><!--
      <div class="form-group">
          <label for="password_confirmation">Password Confirmation</label>
          <input type="password" class="form-control" v-model="password_confirmation" id="password_confirmation" required>
      </div>-->
       
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
        first_name: 'test name',
        last_name: 'last test',
        email: 'okomemmanuel1@gmail.com',
        sex: 'm',
        dob: '',
        passport: null, // Updated to hold the uploaded passport file
        category: '',
        password:'',
        class_id:'',
        
       // password_confirmation:''
      },
      isLoading: false,
      error: '',
      classes:'',
      session_id:''
     
    };
  },
  methods: {
    async submitForm() {
      this.isLoading = true; // Start the loading indicator
      this.error = ''; // Reset the error message
      try {
        const formData = new FormData(); // Create a new FormData object
        formData.append('first_name', this.form.first_name);
        formData.append('last_name', this.form.last_name);
        formData.append('email', this.form.email);
        formData.append('sex', this.form.sex);
        formData.append('dob', this.form.dob);
        formData.append('passport', this.form.passport); // 
        formData.append('category', this.form.category); // 
        formData.append('password', this.form.password); // 
        formData.append('class_id', this.form.class_id); // 
        formData.append('session_id', this.$globalData.sessionData.id
); // 
        //formData.append('password_confirmation', this.form.password_confirmation);
       
        // endpoint, form data, redirect route
        await this.postMethod('/register', formData, '/login');
      } catch (error) {
        // Handle the error here
        console.error('Error performing POST request:', error);
      }
    },
    handleFileChange(event) {
      const file = event.target.files[0];
      this.form.passport = file; // Update the form's passport property with the selected file
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
