<template>
  <div>
    <!-- Your template content -->
  </div>
</template>

<script>
export default {
  data() {
    return {
      counter: 0,
    };
  },
  mounted() {
    // Initialize the "counter" data property with the value from local storage
    const storedCounter = localStorage.getItem('counter');
    if (storedCounter) {
      this.counter = parseInt(storedCounter);

    }else{
      localStorage.setItem('counter', this.counter);
    }
  },
  watch: {
    // Watch for changes to the "counter" data property and update the local storage
    counter(newValue) {
      localStorage.setItem('counter', newValue.toString());
    },
  },
};
</script>
