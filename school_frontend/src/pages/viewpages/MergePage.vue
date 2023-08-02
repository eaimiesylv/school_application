<template>
  <base-layout>
  <h4 class="btn btn-primary">
        <router-link to="/merge_subject/addmergeresult">Merge Subject</router-link>
      </h4>

      <!-- Show loading state if classes are being fetched -->
      <div v-if="isLoading" class="text-center">
        <p>Loading...</p>
      </div>

      <!-- Show error message if API call fails
      <div v-if="hasError" class="text-center">
        <p>An error occurred while fetching classes. Please try again later.</p>
      </div> -->
    <div v-if="classes && classKeys.length > 0">
    <h5 class="add_heading">Session: {{$globalData.sessionData.year}} {{$globalData.sessionData.term}}</h5>
    <ul class="nav nav-tabs" role="tablist">
          <li class="nav-item"  v-for="(classItem, index) in classKeys" :key="index">
                                
            <router-link to=""  
              :class="['nav-link', activeTab === index ? 'active' : '']"
              @click="changeActiveTab(classItem)"
              role="tab"
            >{{classItem}}</router-link>
          </li>
        </ul>
     <!--<ul v-for="(classItem, index) in classes" :key="index">   
      
       <ul class="nav nav-tabs" role="tablist">
          <li class="nav-item" v-for="(classItem2, index2) in classItem" :key="index2">
            <router-link to=""  
            
              :class="['nav-link', activeTab === index2 ? 'active' : '']"
              @click="changeActiveTab(index2)"
              role="tab"
            >
              {{ classItem2.class_name }}
            </router-link>
          </li>
       </ul>
    </ul>-->


   
         <table class="table" v-if="activeClassSubjects">
          <thead>
            <tr>
              <th>S/n</th>
              <th>Merge Name</th>
              <th>Subject</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody>
          <tr v-for="(subjectObj, index) in activeClassSubjects" :key="index">
          
        
            <td>{{ index +1}}</td>
            <td>{{  activeClassSubjects[index]['merge_name']}}</td>
            <td> {{  activeClassSubjects[index]['subject']['subjects']}} </td>
         
            
            <td><button class="btn btn-danger" @click="removeMergedSubject(activeClassSubjects[index]['rowId'])">Remove</button></td>
            
          </tr>
        </tbody>
        </table>
       
       
   </div>
    <!-- Show a message if there are no subjects for the active class -->
    <div v-else>No subjects has been merged.</div>
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
      activeTab:0, // Index of the currently active tab
      selectedSubjects: [], 
      teachers:'',
      session_id:'',
      selectedSessionId: null,
      classKeys:[]
    };
  },
  mounted() {
    
  
  },
  methods: {
    
    async fetchClasses() {
      try {
        this.isLoading = true;
        this.classes = await this.getMethodId(`/klass_subject_merge/${this.session_id}`);
        this.classKeys = Object.keys(this.classes);
        this.activeTab =this.classKeys[0]
        console.log(this.classes)
        this.activeTab = 'J.s.s 3';
        this.activeClassSubjects =this.classes[this.activeTab ]
       // this.activeClassSubjects =this.classes["m0"]
        console.log(this.activeClassSubjects)
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
      this.activeTab = index
      console.log(index);
      this.activeClassSubjects =this.classes[this.activeTab]
      console.log(this.activeClassSubjects)
      //this.activeClassSubjects = this.classes[index].subjectallocation;
    },
    async removeMergedSubject(rowId) {
       try{ 
        console.log(rowId);
       await this.deleteMethod(`/merge_subject/${rowId }`, '/subject_allocation');
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
        //console.log(this.session_id);
        this.fetchClasses();
      } else {
        console.log('Session data is not available yet');
      }
    }
  }
},
computed: {
  activeClassSubjects() {
    
    console.log(this.activeTab)
    
    
      return this.classes[this.activeTab];
    
  },
},


};
</script>

<style>
  .nav-link{
    color:black !important;
  }
</style>