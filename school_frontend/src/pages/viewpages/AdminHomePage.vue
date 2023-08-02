<template>
  <base-layout>
  

      <!-- Show loading state if classes are being fetched -->
      <div v-if="isLoading" class="text-center">
        <p>Loading...</p>
      </div>

      <!-- Show error message if API call fails
      <div v-if="hasError" class="text-center">
        <p>An error occurred while fetching classes. Please try again later.</p>
      </div> -->
      <div>
        <h5 class="add_heading">Session: {{$globalData.sessionData.year}} {{$globalData.sessionData.term}}</h5>
        <ul class="nav nav-tabs" role="tablist">
          <li class="nav-item"  v-for="(classItem, index) in category" :key="index">
                                
            <router-link to=""  
              :class="['nav-link', categoryActiveTab === index ? 'active' : '']"
              @click="typeActiveTab(index)"
              role="tab"
            >{{classItem.type }}</router-link>
          </li>
        </ul>

      <div v-if="categoryActiveTab === 0">
      
        <h2>Staff Area</h2>
        
        <table class="table">
          <thead>
                  <tr>
                    <th>S/n</th>
                    <th>Image</th>
                    <th>First name</th>
                    <th>Last name</th>
                    <th>Status</th>
                   
                    <th>Action</th>
                  </tr>
                </thead>
                <tbody>
                  <tr v-for="(teacher, ind) in teachers" :key="ind">
                  
                  <td>{{ ind + 1 }}</td>
                  <td> <img :src="teacher.passport" alt="Passport Image" class="custom-img" /></td>
                  <td>{{teacher.first_name}}</td>
                  <td>{{teacher.last_name}}</td>
                  <td :class="getStatusClass(teacher)">{{ teacher.status }}</td>
                  <td><h4 class="btn btn-warning"><router-link to="#">Update Student</router-link></h4></td>
                  </tr>

                  
                </tbody>

        </table>
        
      </div><!-- enod of  staff content -->

      <!-- Show student content -->
      <div v-else>
          <div v-if="classes">
            <h2>Student Area ({{ className }})</h2>
        
        
              <ul class="nav nav-tabs" role="tablist">
                <li class="nav-item"  v-for="(classItem, index) in classes" :key="index">
                                      
                  <router-link to=""  
                    :class="['nav-link', activeTab === index ? 'active' : '']"
                    @click="changeActiveTab(index)"
                    role="tab"
                  >{{classItem.class_name }}</router-link>
                </li>
              </ul>
   
              <table class="table" v-if="activeClassSubjects">
                <thead>
                  <tr>
                    <th>S/n</th>
                    <th>Image</th>
                    <th>First name</th>
                    <th>Last name</th>
                    <th>Status</th>
                    <th>View Result</th>
                    <th>Action</th>
                  </tr>
                </thead>
                <tbody>
                <tr v-for="(subjectObj, index) in activeClassSubjects" :key="index">
                  <td>{{ index + 1 }}</td>
                  <td> <img :src="subjectObj.user.passport" alt="Passport Image" class="custom-img" /></td>
                  <td>{{ subjectObj.user.first_name}}</td>
                  <td>{{ subjectObj.user.last_name}}</td>
                  <td :class="getStatusClass(subjectObj)">{{ subjectObj.status }}</td>
                  <td><router-link to="/merge_subject" class="link"><i style="color:blue" class="fas fa-eye"></i></router-link></td>
                  <td><h4 class="btn btn-warning"><router-link to="#">Update Student</router-link></h4></td>

                  
                </tr>
              </tbody>
              </table>
  
  
            </div>

            <div v-else>No subjects available for this class.</div>
        </div>
      </div><!--end of teacher and student wrapper-->
 
  </base-layout> 
    
</template>

<script>
import { apiFunctionMixin } from '@/apiFunction.js';
import axios from 'axios';


export default {
  mixins: [apiFunctionMixin],
  data() {
    return {
      classes: [], // Assign the API response to this property
      isLoading: false, // Loading state flag
      hasError: '',
      activeTab: 0, // Index of the currently active tab
      categoryActiveTab:0,
      selectedSubjects: [], 
      session_id:'',
      selectedSessionId: null,
      category:[{'type':'Teacher'},{'type':'Student'}],
      teachers:[],
      className:''
    };
  },
  mounted() {
    //this.fetchClasses();
  
  },
  methods: {
    
    async fetchClasses() {
      try {
        this.isLoading = true;
        this.activeClassSubjects = '';
         [this.classes, this.teachers] = await axios.all([
      this.getMethodId(`/all_klass_student/${this.session_id}`),
      this.getMethodId(`/allteacher`)
      ]);
     // console.log(this.classes);

   

    // Process the responses as needed
    this.activeClassSubjects = this.classes[0].students;
     this.className=this.classes[0].class_name;
        //this.classes = await this.getMethodId(`/all_klass_student/${this.session_id}`);
        //this.teachers = await this.getMethodId(`/allteacher`);
        //console.log(this.classes[0].students);
        //this.activeClassSubjects =this.classes[0].students;
        this.isLoading = false;
        // Update activeClassSubjects with the subjects of the first class initially
        //this.activeClassSubjects = this.classes.length > 0 ? this.classes[0].students : [];
      } catch (error) {
        console.log(error);
        this.hasError = true;
        this.isLoading = false;
      }
    },
   
    changeActiveTab(index) {
      // Update activeClassSubjects with the subjects of the selected class
      this.activeTab = index;
      this.activeClassSubjects = this.classes[index].students;
      this.className=this.classes[index].class_name;
    },
    typeActiveTab(index) {
      // Update activeClassSubjects with the subjects of the selected class
      this.categoryActiveTab = index;
      //this.activeClassSubjects = this.classes[index].students;
    },
   
    
  },
  watch: {
  '$globalData.sessionData': {
    immediate: true,
    handler(value) {
      if (value && value.id) {
        this.session_id = value.id;
        console.log(this.session_id);
        this.fetchClasses();
      } else {
        console.log('Session data is not available yet');
      }
    }
  }
},
  computed: {
    activeClassSubjects() {
    
       return this.classes[this.activeTab].students
    
    },
    getStatusClass() {
    return (subjectObj) => {
      return subjectObj.status === 'active' ? 'btn btn-primary' : 'btn btn-danger';
    };
  },
  },

};
</script>

<style>
  .nav-link{
    color:black !important;
  }
  .custom-img {
  max-width: 100px; /* Ensure the image doesn't exceed its parent container's width */
  max-height: 100px; /* Set a maximum height for the image */
  width: auto; /* Let the image scale its width based on the maximum height */

  /* Additional styles for centering the image and preserving its aspect ratio */
  display: block;
  margin: 0 auto;
}
</style>