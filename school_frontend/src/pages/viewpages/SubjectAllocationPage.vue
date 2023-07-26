<template>
  <base-layout>
  <h4 class="btn btn-primary">
        <router-link to="/subject_allocation/addsubjectallocation">Create Allocation</router-link>
      </h4>

      <!-- Show loading state if classes are being fetched -->
      <div v-if="isLoading" class="text-center">
        <p>Loading...</p>
      </div>

      <!-- Show error message if API call fails
      <div v-if="hasError" class="text-center">
        <p>An error occurred while fetching classes. Please try again later.</p>
      </div> -->
  <div v-if="classes && classes.length > 0">
    <h5 class="add_heading">Session: {{$globalData.sessionData.year}} {{$globalData.sessionData.term}}</h5>
        
        <ul class="nav nav-tabs" role="tablist">
          <li class="nav-item"  v-for="(classItem, index) in classes" :key="index">
                                
            <router-link to=""  
              :class="['nav-link', activeTab === index ? 'active' : '']"
              @click="changeActiveTab(index)"
              role="tab"
            >{{classItem.class_name }}</router-link>
          </li>
        </ul>
        
        <table class="table" v-if="activeClassSubjects.length > 0">
          <thead>
            <tr>
              <th>S/n</th>
              <th>Subject Name</th>
              <th>Teacher Name</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody>
          <tr v-for="(subjectObj, index) in activeClassSubjects" :key="index">
            <td>{{ index + 1 }}</td>
            <td>{{ subjectObj.subjects.subjects}}</td>
            <td>{{ subjectObj.users.first_name}} {{ subjectObj.users.last_name}}</td>
            
            <td><button class="btn btn-danger" @click="removeAllocation(subjectObj.id)">Remove</button></td>
            
          </tr>
        </tbody>
        </table>
       
       
   </div>
    <!-- Show a message if there are no subjects for the active class -->
    <div v-else>No subjects available for this class.</div>
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
      hasError: '',
      activeTab: 0, // Index of the currently active tab
      selectedSubjects: [], 
      teachers:'',
      session_id:'',
      selectedSessionId: null
    };
  },
  mounted() {
    
  
  },
  methods: {
    
    async fetchClasses() {
      try {
        this.isLoading = true;
        this.classes = await this.getMethodId(`/klass_subject_allocation/${this.session_id}`);
        //console.log(this.classes[0].subjectallocation);
        this.activeClassSubjects =this.classes[0].subjectallocation;
        this.isLoading = false;
        // Update activeClassSubjects with the subjects of the first class initially
        //this.activeClassSubjects = this.classes.length > 0 ? this.classes[0].subjectallocation : [];
      } catch (error) {
        console.log(error);
        this.hasError = true;
        this.isLoading = false;
      }
    },
   
    changeActiveTab(index) {
      // Update activeClassSubjects with the subjects of the selected class
      this.activeTab = index;
      this.activeClassSubjects = this.classes[index].subjectallocation;
     // console.log(index);
     // console.log( this.activeClassSubjects )
    },
    async removeAllocation(allocationId) {
       try{ 
        
        await this.deleteMethod(`/subject_allocation/${allocationId }`, '/subject_allocation');
        await this.fetchClasses();
                              
      } catch (error) {
        // Handle the error here
        console.error('Error performing POST request:', error);
      }
     
    }
    
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
    
       return this.classes[this.activeTab].subjectallocation
    
    },
  },

};
</script>

<style>
  .nav-link{
    color:black !important;
  }
</style>