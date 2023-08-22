
import axios from 'axios';
import { useAuthStore } from '@/store';

export const apiFunctionMixin = {
    methods: {
        /*handles all post request*/
      async postMethod(endpoint,postObject,redirectUrl) {
        try{
           
            
            const response=await axios.post(`${endpoint}`,postObject)
             
            if(endpoint == '/login'){
              //const authStore = useAuthStore();

               useAuthStore().login(response);
              //useAuthStore().login(response.data);
              console.log(response);
              //localStorage.setItem('token',response.data[0]);
              
               //localStorage.setItem('user',response.data[1]);
            }else{
              console.log(response.data);
              alert(response.data);
            }
            this.$router.push(`${redirectUrl}`);
        }catch(error){
          //alert(error.response.data.message);
          //console.log(error.response);
        }finally{
          this.isLoading = false; // Stop the loading indicator
        }
      },
      /* handles all get request'*/
      async getMethod(endpoint) {
        try {
         
            const response = await axios.get(endpoint);
            return response.data; // Return the response data
          } catch (error) {
            console.log(error);
            this.hasError = true;
            throw error; // Re-throw the error to be handled in the component
          } finally {
            this.isLoading = false; // Stop the loading indicator
          }
      },
      /* handles all get request by id'*/
     async getMethodId(endpoint) {
      try {
          //console.log(endpoint)
          const response = await axios.get(endpoint);
          //console.log(response.data)
          return response.data; // Return the response data
        } catch (error) {
          console.log(error);
          this.hasError = true;
          throw error; // Re-throw the error to be handled in the component
        } finally {
          this.isLoading = false; // Stop the loading indicator
        }
      },

      async deleteMethod(endpoint) {
        try {
          
            const response = await axios.delete(endpoint);
            alert(response.data);
            return response.data; // Return the response data
          } catch (error) {
            console.log(error);
            this.hasError = true;
            throw error; // Re-throw the error to be handled in the component
          } finally {
            this.isLoading = false; // Stop the loading indicator
          }
        },
    },
     
  
  };
  