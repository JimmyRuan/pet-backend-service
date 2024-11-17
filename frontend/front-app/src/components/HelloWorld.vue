<template>
  <div class="text-center py-10">
    <h1 class="text-4xl font-bold text-blue-600">{{ message }}</h1>
    <div class="mt-6">
      <input
          v-model="newMessage"
          class="border border-gray-300 rounded-md px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
          placeholder="Type a new message"
      />
      <button
          @click="updateMessage"
          class="ml-4 bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600"
      >
        Update Message
      </button>
    </div>
  </div>
</template>

<script>
import { mapGetters, mapActions } from 'vuex';

export default {
  name: 'HelloWorld',
  data() {
    return {
      newMessage: '',
    };
  },
  computed: {
    ...mapGetters(['getMessage']),
    message() {
      return this.getMessage;
    },
  },
  methods: {
    ...mapActions(['setMessage']),
    updateMessage() {
      if (this.newMessage.trim()) {
        this.setMessage(this.newMessage);
        this.newMessage = '';
      }
    },
  },
};
</script>

<style scoped>
/* No additional styles needed; Tailwind CSS handles styling */
</style>
