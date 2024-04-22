<template>
  <div class="max-w-full">
    <div class="flex">
    <h2 class="text-3xl w-[50%] font-semibold text-gray-800">Profile</h2>
    <div class="w-[50%]">
    <button v-if="!adding && !editing && viewingId === null" @click="toggleAddProfileForm" class="bg-blue-500 hover:bg-blue-600 text-white font-bold float-right py-2 px-4 rounded mb-2">Add Profile</button></div></div>


    <!-- Modal for deletion confirmation -->
    <div v-if="showDeleteModal" class="fixed z-10 inset-0 overflow-y-auto">
      <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
        <div class="fixed inset-0 transition-opacity" aria-hidden="true">
          <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
        </div>
        <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
        <div class="inline-block align-bottom bg-[rgb(255,255,255)] rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
          <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
            <div class="sm:flex sm:items-start">
              <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-red-100 sm:mx-0 sm:h-10  sm:w-10">
                <!-- Heroicon name: exclamation -->
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-6 w-6 text-red-600">
                  <path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0"/>
                </svg>
              </div>
              <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                <h3 class="text-lg leading-6 font-medium text-gray-900">Delete Profile</h3>
                <div class="mt-2">
                  <p class="text-sm text-gray-500">Are you sure you want to delete {{ deleteProfileData.first_name }} {{ deleteProfileData.last_name }}?</p>
                </div>
              </div>
            </div>
          </div>
          <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
            <button @click="deleteProfile(deleteProfileData)" type="button" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-red-600 text-base font-medium text-white hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 sm:ml-3 sm:w-auto sm:text-sm">
              Delete
            </button>
            <button @click="closeDeleteModal" type="button" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
              Cancel
            </button>
          </div>
        </div>
      </div>
    </div>

    <!-- Container for table and forms -->
    <div class="table-container">
      <!-- Display initial profile fields -->
      <div v-if="!editing && !adding && !viewingId" class="bg-[rgb(255,255,255)] rounded-lg shadow-md overflow-hidden">
        <!-- Existing profiles table -->
        <div class="overflow-x-auto">
          <table class="min-w-full">
            <thead>
              <tr class="bg-gray-200 text-gray-700 uppercase text-xs font-semibold">
                <th class="py-3 px-6 text-left">First Name</th>
                <th class="py-3 px-6 text-left">Last Name</th>
                <th class="py-3 px-6 text-left">Email</th>
                <th class="py-3 px-6 text-left">Phone Number</th>
                <th class="py-3 px-6 text-center">Actions</th>
              </tr>
            </thead>
            <tbody>
              <!-- Rows for each profile -->
              <tr v-for="(profile, index) in profileData" :key="index" class="border-b border-gray-200 hover:bg-gray-100">
                <td class="py-3 px-6 text-left whitespace-nowrap">{{ profile.first_name }}</td>
                <td class="py-3 px-6 text-left whitespace-nowrap">{{ profile.last_name }}</td>
                <td class="py-3 px-6 text-left">{{ profile.email }}</td>
                <td class="py-3 px-6 text-left">{{ profile.phone_number }}</td>
                <td class="py-3 px-6 text-center">
                  <!-- Edit, delete, and view buttons -->
                  <button @click="editProfile(profile)" class="text-white border border-purple-500 rounded-md bg-purple-500 px-2 hover:bg-purple-700">Edit</button>
                  <button @click="openDeleteModal(profile)" class="text-white hover:bg-red-700 mx-1 border border-red-500 rounded-md bg-red-500 px-2">Delete</button>
                  <button @click="viewProfile(profile)" class="text-white hover:bg-green-700 border border-green-500 rounded-md bg-green-500 px-2" >View</button>
                </td>
              </tr>
              <!-- Display message if no profile data available -->
              <tr v-if="profileData.length === 0">
                <td class="py-4 px-6 text-center text-gray-500" colspan="5">No profile data available</td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>

      <!-- Add Profile Form -->
      <form v-if="adding" @submit.prevent="submitAddProfileForm" class="bg-white p-8 rounded-lg shadow-md">
        <div class="mb-4">
          <label for="add-first-name" class="block text-gray-700 font-bold mb-2">First Name:</label>
          <input id="add-first-name" name="first-name" type="text" v-model="addFormData.firstName" placeholder="Enter your first name" class="mb-2 px-4 py-2 rounded-lg border focus:outline-none focus:border-blue-500 w-full">
          <span v-if="!addFormData.firstName && addFormData.firstName !== null" class="text-red-500">First name is required</span>
        </div>
        <div class="mb-4">
          <label for="add-last-name" class="block text-gray-700 font-bold mb-2">Last Name:</label>
          <input id="add-last-name" name="last-name" type="text" v-model="addFormData.lastName" placeholder="Enter your last name" class="mb-2 px-4 py-2 rounded-lg border focus:outline-none focus:border-blue-500 w-full">
          <span v-if="!addFormData.lastName && addFormData.lastName !== null" class="text-red-500">Last name is required</span>
        </div>
        <div class="mb-4">
          <label for="add-phone-number" class="block text-gray-700 font-bold mb-2">Phone Number:</label>
          <input type="text" id="add-phone-number" name="phone-number" v-model="addFormData.phoneNumber" placeholder="Enter your phone number" class="mb-2 px-4 py-2 rounded-lg border focus:outline-none focus:border-blue-500 w-full" pattern="[0-9]{10}" title="Phone number must be 10 digits and contain only numbers">
          <span v-if="!addFormData.phoneNumber && addFormData.phoneNumber !== null" class="text-red-500">Phone number is required</span>
          <span v-else-if="!isValidPhoneNumber(addFormData.phoneNumber) && addFormData.phoneNumber !== null" class="text-red-500">Invalid phone number format</span>
        </div>
        <div class="mb-4">
          <label for="add-email" class="block text-gray-700 font-bold mb-2">Email:</label>
          <input id="add-email" name="email" type="email" v-model="addFormData.email" placeholder="Enter your email address" class="mb-2 px-4 py-2 rounded-lg border focus:outline-none focus:border-blue-500 w-full">
          <span v-if="!addFormData.email && addFormData.email !== null" class="text-red-500">Email is required</span>
          <span v-else-if="!isValidEmail(addFormData.email) && addFormData.email !== null" class="text-red-500">Invalid email address</span>
        </div>
        <div class="flex justify-between">
          <button type="button" @click="cancelAdd" class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded">Cancel</button>
          <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded">Add</button>
        </div>
      </form>

      <!-- Edit Profile Form -->
      <form v-if="editing" @submit.prevent="submitEditProfileForm" class="bg-white p-8 rounded-lg shadow-md">
        <div class="mb-4">
          <label for="edit-first-name" class="block text-gray-700 font-bold mb-2">First Name:</label>
          <input id="edit-first-name" name="edit-first-name" type="text" v-model="editFormData.first_name" placeholder="Enter your first name" class="mb-2 px-4 py-2 rounded-lg border focus:outline-none focus:border-blue-500 w-full">
          <span v-if="!editFormData.first_name && editFormData.first_name !== null" class="text-red-500">First name is required</span>
        </div>
        <div class="mb-4">
          <label for="edit-last-name" class="block text-gray-700 font-bold mb-2">Last Name:</label>
          <input id="edit-last-name" name="edit-last-name" type="text" v-model="editFormData.last_name" placeholder="Enter your last name" class="mb-2 px-4 py-2 rounded-lg border focus:outline-none focus:border-blue-500 w-full">
          <span v-if="!editFormData.last_name && editFormData.last_name !== null" class="text-red-500">Last name is required</span>
        </div>
        <div class="mb-4">
          <label for="edit-phone-number" class="block text-gray-700 font-bold mb-2">Phone Number:</label>
          <input type="text" id="edit-phone-number" name="edit-phone-number" v-model="editFormData.phone_number" placeholder="Enter your phone number" class="mb-2 px-4 py-2 rounded-lg border focus:outline-none focus:border-blue-500 w-full" pattern="[0-9]{10}" title="Phone number must be 10 digits and contain only numbers">
          <span v-if="!editFormData.phone_number && editFormData.phone_number !== null" class="text-red-500">Phone number is required</span>
          <span v-else-if="!isValidPhoneNumber(editFormData.phone_number) && editFormData.phone_number !== null" class="text-red-500">Invalid phone number format</span>
      </div>
        <div class="mb-4">
          <label for="edit-email" class="block text-gray-700 font-bold mb-2">Email:</label>
          <input id="edit-email" name="edit-email" type="email" v-model="editFormData.email" placeholder="Enter your email address" class="mb-2 px-4 py-2 rounded-lg border focus:outline-none focus:border-blue-500 w-full">
          <span v-if="!editFormData.email && editFormData.email !== null" class="text-red-500">Email is required</span>
          <span v-else-if="!isValidEmail(editFormData.email) && editFormData.email !== null" class="text-red-500">Invalid email address</span>
        </div>
        <div class="flex justify-between">
          <button type="button" @click="cancelEdit" class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded">Cancel</button>
          <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded">Update</button>
        </div>
      </form>

      <!-- View Profile Form -->
      <form v-if="viewingId !== null" @submit.prevent="cancelView" class="bg-white p-8 pr-0 rounded-lg shadow-md">
        <div class="mb-4 flex">
        <div class="mb-4 w-[60%]">
        <div class="mb-4">
          <label class="block text-gray-700 font-bold mb-2">First Name:</label>
          <p class="px-4 py-2 rounded-lg border bg-gray-100">{{ viewProfileData.first_name }}</p>
        </div>
        <div class="mb-4">
          <label class="block text-gray-700 font-bold mb-2">Last Name:</label>
          <p class="px-4 py-2 rounded-lg border bg-gray-100">{{ viewProfileData.last_name }}</p>
        </div>
        <div class="mb-4">
          <label class="block text-gray-700 font-bold mb-2">Phone Number:</label>
          <p class="px-4 py-2 rounded-lg border bg-gray-100">{{ viewProfileData.phone_number }}</p>
        </div>
        <div class="mb-4">
          <label class="block text-gray-700 font-bold mb-2">Email:</label>
          <p class="px-4 py-2 rounded-lg border bg-gray-100">{{ viewProfileData.email }}</p>
        </div>
        </div>
        <div class="mb-4 flex flex-col items-center w-[50%]">
          <div class="mb-2 flex justify-center items-center h-[100%]"> <!-- Adjusted height -->
  <img :src="generateQRCode(viewProfileData)" alt="QR Code" class="border-[5px] border-gray-300 bg-white max-w-[80%] rounded-lg p-2 qr-code transition duration-300 ease-in-out transform hover:scale-105"> <!-- Adjusted width -->
</div>
          
        </div>
      </div>
        <div class="flex justify-between w-[54.5%]">
          <button type="button" @click="cancelView" class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded">Back</button>
          <button @click="downloadVCard(viewProfileData)" class="bg-green-500 hover:bg-green-600 text-white font-bold py-2 px-4 rounded flex items-center space-x-2">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
  <path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75V16.5M16.5 12 12 16.5m0 0L7.5 12m4.5 4.5V3" />
</svg>

  <span>Save contact</span>
</button>
        </div>
      </form>
    </div>
  </div>
</template>

<script>
  export default {
    data() {
      return {
        adding: false,
        editing: false,
        viewingId: null,
        profileData: [],
        addFormData: {
          firstName: null,
          lastName: null,
          phoneNumber: null,
          email: null,
        },
        editFormData: {
          id: '',
          first_name: '',
          last_name: '',
          phone_number: '',
          email: '',
        },
        viewProfileData: {},
        deleteProfileData: {},
        showDeleteModal: false,
      };
    },
    mounted() {
      this.fetchProfileData();
    },
    methods: {
      // Generate QR code for a profile
      generateQRCode(profile) {
    // Construct vCard data
    const vCardData = `BEGIN:VCARD
VERSION:3.0
N:${profile.last_name};${profile.first_name};;;
FN:${profile.first_name} ${profile.last_name}
TEL;TYPE=MOBILE:${profile.phone_number}
EMAIL:${profile.email}
END:VCARD`;

    // Encode vCard data and generate QR code
    const encodedVCardData = encodeURIComponent(vCardData);
    return `http://api.qrserver.com/v1/create-qr-code/?data=${encodedVCardData}`;
},
      // Fetch profile data from the server
      async fetchProfileData() {
        try {
          const response = await fetch('http://localhost/php-vue/src/php/profile.php');
          const data = await response.json();
          if (data.error) {
            console.error('Error:', data.error);
          } else {
            this.profileData = data;
          }
        } catch (error) {
          console.error('Error:', error);
        }
      },
      // Submit add profile form
      async submitAddProfileForm() {
        try {
          const formData = new FormData();
          formData.append('first_name', this.addFormData.firstName);
          formData.append('last_name', this.addFormData.lastName);
          formData.append('phone_number', this.addFormData.phoneNumber);
          formData.append('email', this.addFormData.email);
          formData.append('action', 'add');

          const response = await fetch('http://localhost/php-vue/src/php/profile.php', {
            method: 'POST',
            body: formData
          });
          if (!this.addFormData.firstName || !this.addFormData.lastName || !this.addFormData.phoneNumber || !this.addFormData.email) {
            this.addFormData.firstName === null ? this.addFormData.firstName = '' : '';
            this.addFormData.lastName === null ? this.addFormData.lastName = '' : '';
            this.addFormData.phoneNumber === null ? this.addFormData.phoneNumber = '' : '';
            this.addFormData.email === null ? this.addFormData.email = '' : '';
            return;
          }
          const data = await response.json();
          console.log(data);
          this.fetchProfileData();
          this.cancelAdd();
        } catch (error) {
          console.error('Error:', error);
        }
      },
      // Submit edit profile form
      async submitEditProfileForm() {
        try {
          const formData = new FormData();
          formData.append('id', this.editFormData.id);
          formData.append('first_name', this.editFormData.first_name);
          formData.append('last_name', this.editFormData.last_name);
          formData.append('phone_number', this.editFormData.phone_number);
          formData.append('email', this.editFormData.email);
          formData.append('action', 'edit');

          const response = await fetch(`http://localhost/php-vue/src/php/profile.php?id=${this.editFormData.id}`, {
            method: 'POST',
            body: formData
          });

          const data = await response.json();
          console.log(data);

          if (!this.editFormData.first_name || !this.editFormData.last_name || !this.editFormData.phone_number || !this.editFormData.email) {
            this.editFormData.first_name === null ? this.editFormData.first_name = '' : '';
            this.editFormData.last_name === null ? this.editFormData.last_name = '' : '';
            this.editFormData.phone_number === null ? this.editFormData.phone_number = '' : '';
            this.editFormData.email === null ? this.editFormData.email = '' : '';
            return;
          }
          if (response.ok) {
            // Update local state with updated profile data
            this.profileData = data;
            this.fetchProfileData();

            // Reset edit form and toggle editing mode off
            this.cancelEdit();
          } else {
            // Handle error response
            console.error('Error:', data.error);
          }
        } catch (error) {
          console.error('Error:', error);
        }
      },
      // Toggle add profile form
      toggleAddProfileForm() {
        this.adding = true;
        this.editing = false;
      },
      // Edit profile
      editProfile(profile) {
        this.editing = true;
        this.adding = false;
        this.editFormData = { ...profile };
      },
      // Cancel add
      cancelAdd() {
        this.addFormData = {
          firstName: null,
          lastName: null,
          phoneNumber: null,
          email: null,
        };
        this.adding = false;
      },
      // Cancel edit
      cancelEdit() {
        this.editFormData = {
          id: null,
          first_name: null,
          last_name: null,
          phone_number: null,
          email: null,
        };
        this.editing = false;
      },
      // View profile
      viewProfile(profile) {
        this.viewingId = profile.id;
        this.viewProfileData = { ...profile };
      },
      // Cancel view
      cancelView() {
        this.viewProfileData = {};
        this.viewingId = null; // Reset viewingId to null when canceling the view
      },
      // Open delete modal
      openDeleteModal(profile) {
        this.showDeleteModal = true;
        this.deleteProfileData = { ...profile };
      },
      // Close delete modal
      closeDeleteModal() {
        this.showDeleteModal = false;
        this.deleteProfileData = {};
      },
      // Delete profile
      async deleteProfile(profile) {
        try {
          const response = await fetch(`http://localhost/php-vue/src/php/profile.php?id=${profile.id}`, {
            method: 'DELETE',
          });
          const data = await response.json();
          console.log(data);
          // Check if the profile was deleted successfully
          if (data.message === "Profile deleted successfully") {
            this.fetchProfileData(); // Refresh profile data
          }
          this.closeDeleteModal();
        } catch (error) {
          console.error('Error:', error);
        }
      },
      // Simple email validation
      isValidEmail(email) {
        const emailRegex = /\S+@\S+\.\S+/;
        return emailRegex.test(email);
      },
      // Validate phone number format
      isValidPhoneNumber(phoneNumber) {
        const phoneRegex = /^[0-9]{10}$/;
        return phoneRegex.test(phoneNumber);
      },
      downloadVCard(profile) {
        // Download vCard with profile data
        const vCardData = `BEGIN:VCARD
VERSION:3.0
N:${profile.first_name} ${profile.last_name};;;
FN:${profile.first_name} ${profile.last_name}
TEL;TYPE=WORK,VOICE:${profile.phone_number}
EMAIL:${profile.email}
END:VCARD`;
        const blob = new Blob([vCardData], { type: 'text/vcard' });
        const link = document.createElement('a');
        link.href = window.URL.createObjectURL(blob);
        link.setAttribute('download', `${profile.first_name}_${profile.last_name}.vcf`);
        document.body.appendChild(link);
        link.click();
        document.body.removeChild(link);
      },
    },
  };
</script>
