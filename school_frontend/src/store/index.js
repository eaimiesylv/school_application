import { defineStore } from 'pinia'
export const useAuthStore = defineStore({
    id:'login_id',
    state(){ 
        const storedToken = localStorage.getItem('token');
        const storedUser = localStorage.getItem('user');
        const storedRole = localStorage.getItem('role');

        return {
            token: storedToken ? JSON.parse(storedToken) : null,
            user: storedUser ? JSON.parse(storedUser) : {},
            role: storedRole ? JSON.stringify(storedRole) : null,
        }
    },
    getters:{
        getUser(state) {
            return state.user
        }
    },
    actions: {
        login(response){
            //console.log(response);
            this.token = response.data[0]
            this.role = btoa(String(response.data[1]['role']));
            this.user = response.data[1]

            localStorage.setItem('token', JSON.stringify(this.token))
            localStorage.setItem('user',JSON.stringify(this.user))
            const encodedString = btoa(String(response.data[1]));
            localStorage.setItem('role',encodedString );
           
           /* for (const [key, value] of response.entries()) {
                console.log(key, value);
               }
            let p=data.get('password')*/
          
        },
        logout(){
            this.token=null
            this.user={}
            this.role=null
            
        }
    }
})
    