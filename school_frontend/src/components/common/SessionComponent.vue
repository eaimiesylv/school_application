<template>
  <form>
    <div class="form-group">
      <select v-model="selectedSession" @change="onSessionChange" class="form-control">
        <option v-for="session in sessions" :value="session" :key="session.id">
          {{ session.year }} {{ session.term }}
        </option>
      </select>
    </div>
  </form>
</template>

<script>
import axios from 'axios';
export default {
  data() {
    return {
      sessions: null,
      selectedSession: null,
      selectedSessionId: null
    };
  },
  methods: {
    onSessionChange() {
      this.$globalData.sessionData = this.selectedSession;
      
    },
    async fetchAllSession() {
      try {
        this.isLoading = true;
        const response = await axios.get('/session');
        this.sessions = response.data;
        this.selectedSession = this.sessions[0];
        // declare in main.js
        this.$globalData.sessionData = this.sessions[0];
      } catch (error) {
        console.log(error);
      }
    },
  },
  mounted() {
    this.fetchAllSession();
  },
};
</script>

<style>
/* Add your styles here if needed */
</style>
