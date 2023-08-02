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
              <th>Assessment</th>
              
            </tr>
          </thead>
          <tbody>
          <tr v-for="(subjectObj, index) in activeClassSubjects" :key="index">
            <td>{{ index + 1 }}</td>
            <td>{{ subjectObj.subjects.subjects}}</td>
            <td>{{ subjectObj.users.first_name}} {{ subjectObj.users.last_name}}</td>
            <td v-for="(subjectObj2, index) in subjectObj.assessment" :key="index">
            
              <h4 class="btn btn-primary">
                <router-link :to="getRoutePath(subjectObj.subjects.id,
                                                subjectObj.subjects.subjects, 
                                                subjectObj2.id,
                                                subjectObj2.assessname,
                                                activeClassName,
                                                activeClassId,
                                                session_id
                                                
                                                )">
                  {{ subjectObj2.assessname }}
                </router-link>
               </h4>
             
              </td>  
             
         
            
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
      selectedSessionId: null,
      activeClassName:'',
      activeClassId:''
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
        this.classes = await this.getMethodId(`/klass_subject_allocated_teacher/${this.session_id}`);
        //console.log(this.classes[0].subjectallocation);
        this.activeClassSubjects =this.classes[0].subjectallocation;
        this.activeClassName = this.classes[0].class_name; 
        this.activeClassId = this.classes[0].id; 
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
      this.activeClassName = this.classes[index].class_name; 
      this.activeClassId = this.classes[index].id; 
    },
    getRoutePath(subjectId,subjectName,assessId, assessname, classname, classId,session_id) {
    // Here, we are passing the subjectId and assessname as route parameters
    return `/score/addscore/${subjectId}/${subjectName}/${assessId}/${assessname}/${classname}/${classId}/${session_id}`;
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