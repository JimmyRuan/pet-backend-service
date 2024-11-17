<template>
  <div>
    <form @submit.prevent="savePet" class="bg-white p-6 rounded-lg shadow-lg">
      <h2 class="text-xl font-bold text-gray-800 mb-4">Register Your Pet</h2>

      <!-- Pet's Name -->
      <div class="mb-4">
        <label for="name" class="block text-gray-700 font-medium">Pet's Name</label>
        <input
            type="text"
            id="name"
            v-model="pet.name"
            placeholder="Enter your pet's name"
            class="w-full border rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500"
            required
        />
      </div>

      <!-- Pet Type -->
      <div class="mb-4">
        <label for="type" class="block text-gray-700 font-medium">Pet Type</label>
        <select
            id="type"
            v-model="pet.type"
            @change="updateType"
            class="w-full border rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500"
            required
        >
          <option value="" disabled>Select Pet Type</option>
          <option v-for="type in petTypes" :key="type" :value="type">{{ type }}</option>
        </select>
      </div>

      <!-- Breed -->
      <div v-if="pet.type" class="mb-4">
        <label for="breed" class="block text-gray-700 font-medium">Breed</label>
        <select
            id="breed"
            v-model="pet.breed"
            class="w-full border rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500"
            required
        >
          <option value="" disabled>Choose One</option>
          <option v-for="breed in breeds" :key="breed" :value="breed">{{ breed }}</option>
        </select>
        <p class="text-sm text-gray-500 mt-1">
          Can't find it?
          <span
              class="text-blue-500 cursor-pointer hover:underline"
              @click="setBreed('I don’t know')"
          >
            I don’t know
          </span>
          /
          <span
              class="text-blue-500 cursor-pointer hover:underline"
              @click="setBreed('It’s a mix')"
          >
            It’s a mix
          </span>
        </p>
      </div>

      <!-- Pet's Age or Date of Birth -->
      <div class="mb-4">
        <label class="block text-gray-700 font-medium">Do you know their date of birth?</label>
        <div class="mt-2 flex items-center space-x-4">
          <label class="flex items-center">
            <input
                type="radio"
                name="dobOrAge"
                value="age"
                v-model="dobOrAge"
                @change="clearDob"
                class="focus:ring-blue-500"
            />
            <span class="ml-2">No</span>
          </label>
          <label class="flex items-center">
            <input
                type="radio"
                name="dobOrAge"
                value="dob"
                v-model="dobOrAge"
                @change="clearAgeOption"
                class="focus:ring-blue-500"
            />
            <span class="ml-2">Yes</span>
          </label>
        </div>
      </div>

      <div v-if="dobOrAge === 'age'" class="mb-4">
        <label for="ageOption" class="block text-gray-700 font-medium">Approximate Age</label>
        <select
            id="ageOption"
            v-model="pet.ageOption"
            class="w-full border rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500"
            required
        >
          <option value="" disabled>Select Age</option>
          <option v-for="age in ageOptions" :key="age" :value="age">{{ age }}</option>
        </select>
      </div>

      <div v-if="dobOrAge === 'dob'" class="mb-4">
        <label for="dob" class="block text-gray-700 font-medium">Date of Birth</label>
        <input
            type="date"
            id="dob"
            v-model="pet.dob"
            class="w-full border rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500"
            required
        />
      </div>

      <!-- Gender -->
      <div class="mb-4">
        <label for="gender" class="block text-gray-700 font-medium">Gender</label>
        <select
            id="gender"
            v-model="pet.gender"
            class="w-full border rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500"
            required
        >
          <option value="" disabled>Select Gender</option>
          <option value="Male">Male</option>
          <option value="Female">Female</option>
        </select>
      </div>

      <!-- Submit Button -->
      <div class="flex justify-end">
        <button
            type="submit"
            class="bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600"
        >
          Save Pet
        </button>
      </div>
    </form>
  </div>
</template>

<script>
import { mapState, mapActions, mapGetters } from 'vuex';

export default {
  data() {
    return {
      dobOrAge: '', // Tracks if the user knows DOB or prefers Age
    };
  },
  computed: {
    ...mapState(['pet', 'petTypes', 'ageOptions']),
    ...mapGetters(['getBreeds']),
    breeds() {
      return this.getBreeds(this.pet.type);
    },
  },
  methods: {
    ...mapActions(['updatePetField']),
    updateType() {
      this.updatePetField({ field: 'type', value: this.pet.type });
    },
    setBreed(breed) {
      this.updatePetField({ field: 'breed', value: breed });
    },
    clearDob() {
      this.updatePetField({ field: 'dob', value: null });
    },
    clearAgeOption() {
      this.updatePetField({ field: 'ageOption', value: '' });
    },
    savePet() {
      console.log('Saved Pet:', this.pet);
      alert('Pet details saved successfully!');
    },
  },
};
</script>

<style scoped>
/* Additional responsive styling if needed */
</style>
