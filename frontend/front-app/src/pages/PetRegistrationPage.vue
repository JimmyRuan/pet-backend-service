<template>
  <div class="flex items-center justify-center min-h-screen bg-gray-100">
    <div class="bg-white shadow-md rounded-lg p-6 w-full max-w-md">
      <h1 class="text-xl font-semibold custom-blue-text mb-6 text-left">Register Your Pet</h1>
      <form @submit.prevent="savePet" class="space-y-6">
        <!-- Pet's Name -->
        <div>
          <label for="name" class="block text-gray-700 font-medium text-left mb-2">What is your pet's name?</label>
          <input
              v-model="pet.name"
              id="name"
              type="text"
              placeholder="Enter your pet's name"
              class="w-full border rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500"
              required
          />
        </div>xxxxx

        <!-- Pet Type -->
        <div>
          <label for="type" class="block text-gray-700 font-medium text-left mb-2">Pet Type</label>
          <div class="flex items-center">
            <button
                type="button"
                :class="{
                  'custom-blue-bg text-white custom-blue-border': pet.type === 'Cat',
                  'bg-white text-blue-500 custom-blue-border': pet.type !== 'Cat',
                }"
                class="border rounded-l-lg px-6 py-2 w-1/4 focus:outline-none"
                @click="selectPetType('Cat')"
            >
              Cat
            </button>
            <button
                type="button"
                :class="{
                  'custom-blue-bg text-white custom-blue-border': pet.type === 'Dog',
                  'bg-white text-blue-500 custom-blue-border': pet.type !== 'Dog',
                }"
                class="border rounded-r-lg px-6 py-2 w-1/4 focus:outline-none"
                @click="selectPetType('Dog')"
            >
              Dog
            </button>
          </div>
        </div>

        <!-- Breed -->
        <div v-if="pet.type">
          <label for="breed" class="block text-gray-700 font-medium text-left mb-2">What breed are they?</label>
          <select
              v-model="pet.breed"
              id="breed"
              @change="handleBreedSelection"
              class="w-full border rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500"
              required
          >
            <option value="" disabled>Choose One</option>
            <option v-for="breed in breeds" :key="breed" :value="breed">{{ breed }}</option>
            <option value="CantFindIt">Can't find it?</option>
          </select>
        </div>

        <!-- Buttons for "I don’t know" or "It’s a mix" -->
        <!-- Buttons for "I don’t know" or "It’s a mix" -->
        <div v-if="pet.breed === 'CantFindIt'" class="mt-4 ml-6">
          <p class="text-sm text-gray-500 mb-2 text-left font-bold">Choose One</p>
          <div class="flex flex-col space-y-4">
            <!-- "I don't know" Option -->
            <label class="flex items-center space-x-2">
              <input
                  type="radio"
                  name="cantFindBreed"
                  value="I don’t know"
                  v-model="cantFindBreedOption"
                  @change="setCantFindBreedOption"
                  class="focus:ring-blue-500"
              />
              <span class="text-gray-700">I don’t know</span>
            </label>

            <!-- "It's a mix" Option -->
            <label class="flex items-center space-x-2">
              <input
                  type="radio"
                  name="cantFindBreed"
                  value="It’s a mix"
                  v-model="cantFindBreedOption"
                  @change="setCantFindBreedOption"
                  class="focus:ring-blue-500"
              />
              <span class="text-gray-700">It’s a mix</span>
            </label>

            <!-- Text Input for Mix Breed -->
            <div v-if="cantFindBreedOption === 'It’s a mix'" class="ml-6 mt-2">
              <label for="mixBreed" class="block text-gray-700 font-medium text-left mb-2">Mix Breed Details</label>
              <input
                  id="mixBreed"
                  v-model="mixBreedDetails"
                  type="text"
                  placeholder="Enter mix breed details"
                  class="w-full border rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500"
              />
            </div>
          </div>
        </div>


        <div>
          <label class="block text-gray-700 font-medium text-left mb-2">Do you know their date of birth?</label>
          <div class="flex items-center">
            <button
                type="button"
                :class="{
                    'custom-blue-bg text-white custom-blue-border': dobOrAge === 'dob',
                    'bg-white text-blue-500 custom-blue-border': dobOrAge !== 'dob',
                  }"
                class="border rounded-l-lg px-6 py-2 w-1/4 focus:outline-none"
                @click="selectDobOrAge('dob')"
            >
              Yes
            </button>
          <button
              type="button"
              :class="{
                'custom-blue-bg text-white custom-blue-border': dobOrAge === 'age',
                'bg-white text-blue-500 custom-blue-border': dobOrAge !== 'age',
              }"
              class="border rounded-r-lg px-6 py-2 w-1/4 focus:outline-none"
              @click="selectDobOrAge('age')"
          >
            No
          </button>
          </div>

        </div>

        <div v-if="dobOrAge === 'age'" class="mb-4">
          <label for="ageOption" class="block text-gray-700 font-medium text-left mb-2">Approximate Age</label>
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
          <label class="block text-gray-700 font-medium text-left mb-2">Date of Birth</label>
          <div class="flex space-x-4">
            <!-- Month Dropdown -->
            <div class="w-1/3">
              <label for="month" class="block text-gray-700 text-sm font-medium mb-1">Month</label>
              <select
                  id="month"
                  v-model="dobMonth"
                  @change="updateDays"
                  class="w-full border rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500"
                  required
              >
                <option value="" disabled>Select</option>
                <option v-for="(month, index) in months" :key="index" :value="index + 1">
                  {{ month }}
                </option>
              </select>
            </div>

            <!-- Day Input -->
            <div class="w-1/3">
              <label for="day" class="block text-gray-700 text-sm font-medium mb-1">Day</label>
              <input
                  id="day"
                  v-model="dobDay"
                  type="number"
                  min="1"
                  :max="daysInMonth"
                  placeholder="dd"
                  class="w-full border rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500"
                  @input="validateDay"
                  required
              />
            </div>

            <!-- Year Input -->
            <div class="w-1/3">
              <label for="year" class="block text-gray-700 text-sm font-medium mb-1">Year</label>
              <input
                  id="year"
                  v-model="dobYear"
                  type="number"
                  :min="currentYear - 100"
                  :max="currentYear"
                  placeholder="yyyy"
                  class="w-full border rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500"
                  @input="validateYear"
                  required
              />
            </div>
          </div>
          <p v-if="dobError" class="text-red-500 text-sm mt-2">{{ dobError }}</p>
        </div>





        <!-- Gender -->
        <div class="mb-4">
          <label class="block text-gray-700 font-medium text-left mb-2">Gender</label>
          <div class="flex items-center">
            <button
                type="button"
                :class="{
                  'custom-blue-bg text-white custom-blue-border': pet.gender === 'Female',
                  'bg-white text-blue-500 custom-blue-border': pet.gender !== 'Female',
                }"
                class="border rounded-l-lg px-6 py-2 w-1/4 focus:outline-none"
                @click="selectGender('Female')"
            >
              Female
            </button>
            <button
                type="button"
                :class="{
                  'custom-blue-bg text-white custom-blue-border': pet.gender === 'Male',
                  'bg-white text-blue-500 custom-blue-border': pet.gender !== 'Male',
                }"
                class="border rounded-r-lg px-6 py-2 w-1/4 focus:outline-none"
                @click="selectGender('Male')"
            >
              Male
            </button>
          </div>
        </div>


        <!-- Submit Button -->
        <div class="flex justify-center">
          <button
              :disabled="!isFormValid"
              :class="isFormValid ? 'bg-blue-500 hover:bg-blue-600' : 'bg-gray-400 cursor-not-allowed'"
              class="text-white px-4 py-2 rounded-lg"
          >
            Save Pet
          </button>
        </div>
      </form>
    </div>
  </div>
</template>

<script>
import { mapState, mapActions, mapGetters } from 'vuex';

export default {
  data() {
    return {
      dobOrAge: 'age',
      cantFindBreedOption: 'I don’t know',
      mixBreedDetails: '',
      dobMonth: '',
      dobDay: '',
      dobYear: '',
      months: [
        'January', 'February', 'March', 'April', 'May', 'June',
        'July', 'August', 'September', 'October', 'November', 'December',
      ],
    };
  },
  computed: {
    ...mapState(['pet', 'petTypes', 'ageOptions']),
    ...mapGetters(['getBreeds']),
    breeds() {
      return this.getBreeds(this.pet.type);
    },
    currentYear() {
      return new Date().getFullYear();
    },
    years() {
      const startYear = this.currentYear;
      const endYear = this.currentYear - 100;
      return Array.from({ length: startYear - endYear + 1 }, (_, i) => startYear - i);
    },
    daysInMonth() {
      if (!this.dobMonth || !this.dobYear) return [];
      const days = new Date(this.dobYear, this.dobMonth, 0).getDate();
      return Array.from({ length: days }, (_, i) => i + 1);
    },
    isFormValid() {
      return (
          this.pet.name &&
          this.pet.type &&
          this.pet.breed &&
          this.dobOrAge &&
          (this.dobOrAge === 'age' ? this.pet.ageOption : this.isValidDob()) &&
          this.pet.gender
      );
    },
  },
  methods: {
    ...mapActions(['updatePetField']),
    updateType() {
      this.updatePetField({ field: 'type', value: this.pet.type });
    },
    handleBreedSelection() {
      if (this.pet.breed !== 'CantFindIt') {
        this.cantFindBreedOption = 'I don’t know';
      }
    },
    selectPetType(type) {
      this.updatePetField({ field: 'type', value: type });
    },
    selectDobOrAge(option) {
      this.dobOrAge = option;
      if (option === 'age') {
        this.clearDob();
      } else {
        this.clearAgeOption();
      }
    },
    selectGender(gender) {
      this.updatePetField({ field: 'gender', value: gender });
    },
    setCantFindBreedOption() {
      this.updatePetField({ field: 'breed', value: 'CantFindIt' });
    },
    clearDob() {
      this.dobMonth = '';
      this.dobDay = '';
      this.dobYear = '';
    },
    clearAgeOption() {
      this.updatePetField({ field: 'ageOption', value: '' });
    },
    updateDays() {
      this.dobDay = ''; // Reset day selection when month changes
    },
    isValidDob() {
      return (
          this.dobMonth &&
          this.dobDay &&
          this.dobYear &&
          this.dobYear >= this.currentYear - 100 &&
          this.dobYear <= this.currentYear
      );
    },
    validateYear() {
      if (this.dobYear < this.currentYear - 100 || this.dobYear > this.currentYear) {
        this.dobError = `Year must be between ${this.currentYear - 100} and ${this.currentYear}.`;
      } else {
        this.dobError = '';
      }
    },
    savePet() {
      if (this.dobOrAge === 'dob' && this.isValidDob()) {
        this.updatePetField({
          field: 'dob',
          value: `${this.dobYear}-${String(this.dobMonth).padStart(2, '0')}-${String(this.dobDay).padStart(2, '0')}`,
        });
      }
      console.log('Saved Pet:', this.pet);
      alert('Pet details saved successfully!');
    },
  },
  mounted() {
    this.updatePetField({ field: 'gender', value: 'Male' });
    this.updatePetField({ field: 'type', value: 'Dog' });
  },
};
</script>

<style scoped>
.custom-blue-bg {
  background-color: #0096e1;
}

.custom-blue-border {
  border-color: #0096e1;
}

.custom-blue-text {
  color: #02386d;
}
</style>