import { createStore } from 'vuex';

export default createStore({
    state: {
        pet: {
            name: '',
            type: '',
            breed: '',
            breedOptions: [],
            ageOption: '',
            dob: null,
            gender: '',
        },
        petTypes: ['Cat', 'Dog'],
        breeds: {
            Cat: [
                'Persian',
                'Siamese',
                'Bengal',
                'Maine Coon',
                'Ragdoll',
                'Abyssinian',
                'Birman',
                'Russian Blue',
                'Scottish Fold',
                'Sphynx',
                'British Shorthair',
                'Oriental Shorthair',
                'Devon Rex',
                'Norwegian Forest Cat',
                'American Shorthair',
                'Egyptian Mau',
                'Savannah Cat',
                'Manx',
                'Himalayan',
                'Tonkinese',
            ],
            Dog: [
                'Pitbull',
                'Mastiff',
                'Golden Retriever',
                'Labrador Retriever',
                'German Shepherd',
                'Beagle',
                'Bulldog',
                'Poodle',
                'Rottweiler',
                'Boxer',
                'Siberian Husky',
                'Dachshund',
                'Great Dane',
                'Doberman Pinscher',
                'Shih Tzu',
                'Corgi',
                'Chihuahua',
                'Border Collie',
                'Australian Shepherd',
                'Akita',
            ],
        },
        dangerousBreeds: ['Pitbull', 'Mastiff', 'Rottweiler', 'Doberman Pinscher', 'Akita'],
        ageOptions: Array.from({ length: 20 }, (_, i) => i + 1),
    },
    getters: {
        getBreeds: (state) => (type) => {
            if (type) {
                return state.breeds[type] || [];
            }
            return [];
        },
    },
    mutations: {
        setPetField(state, { field, value }) {
            state.pet[field] = value;

            if (field === 'type') {
                state.pet.breedOptions = state.breeds[value] || [];
                state.pet.breed = ''; // Reset breed when type changes
            }
        },
    },
    actions: {
        updatePetField({ commit }, payload) {
            commit('setPetField', payload);
        },
    },
});
