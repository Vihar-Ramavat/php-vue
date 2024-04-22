<template>
  <div class="min-h-screen flex items-center justify-center bg-gradient-to-br from-black to-blue-700">
    <div class="max-w-md w-full bg-white rounded-lg shadow-md p-8">
      <h2 class="text-center text-3xl font-bold text-gray-800 mb-8">Registration</h2>
      <form @submit.prevent="onRegister">
        <div class="mb-6">
          <label for="username" class="block text-gray-700 text-sm font-semibold mb-2">Username</label>
          <input type="text" id="username" v-model="Admin.username" @input="checkButtonColor" placeholder="Enter username" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
          <p v-if="showUsernameMessage" class="text-red-500 text-xs italic mt-2">Username should not contain spaces</p>
        </div>
        <div class="mb-6">
          <label for="password" class="block text-gray-700 text-sm font-semibold mb-2">Password</label>
          <div class="relative">
            <input v-if="!showPassword" type="password" id="password" v-model="Admin.password" @input="checkButtonColor" placeholder="Enter password" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
            <input v-else type="text" id="password" v-model="Admin.password" @input="checkButtonColor" placeholder="Enter password" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
            <button type="button" @click="togglePasswordVisibility" class="absolute inset-y-0 right-0 flex items-center px-2 text-gray-700 focus:outline-none">
              <svg v-if="showPassword" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                <path stroke-linecap="round" stroke-linejoin="round" d="M3.98 8.223A10.477 10.477 0 0 0 1.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.451 10.451 0 0 1 12 4.5c4.756 0 8.773 3.162 10.065 7.498a10.522 10.522 0 0 1-4.293 5.774M6.228 6.228 3 3m3.228 3.228 3.65 3.65m7.894 7.894L21 21m-3.228-3.228-3.65-3.65m0 0a3 3 0 1 0-4.243-4.243m4.242 4.242L9.88 9.88" />
              </svg>
              <svg v-else xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z" />
                <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
              </svg>
            </button>
          </div>
          <p v-if="showPasswordMessage" class="text-red-500 text-xs italic mt-2">Password should not contain spaces</p>
          <p v-if="showPasswordLengthMessage" class="text-red-500 text-xs italic mt-2">Password should be at least 8 characters long</p>
          <p v-if="showPasswordRequirementsMessage" class="text-red-500 text-xs italic mt-2">Password must contain at least one number, one alphabet, and one special character</p>
        </div>
        <div class="mb-6">
          <label for="cpassword" class="block text-gray-700 text-sm font-semibold mb-2">Confirm Password</label>
          <div class="relative">
            <input v-if="!showPassword" type="password" id="cpassword" v-model="Admin.cpassword" @input="checkButtonColor" placeholder="Confirm Password" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
            <input v-else type="text" id="cpassword" v-model="Admin.cpassword" @input="checkButtonColor" placeholder="Confirm Password" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
            <button type="button" @click="togglePasswordVisibility" class="absolute inset-y-0 right-0 flex items-center px-2 text-gray-700 focus:outline-none">
              <svg v-if="showPassword" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                <path stroke-linecap="round" stroke-linejoin="round" d="M3.98 8.223A10.477 10.477 0 0 0 1.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.451 10.451 0 0 1 12 4.5c4.756 0 8.773 3.162 10.065 7.498a10.522 10.522 0 0 1-4.293 5.774M6.228 6.228 3 3m3.228 3.228 3.65 3.65m7.894 7.894L21 21m-3.228-3.228-3.65-3.65m0 0a3 3 0 1 0-4.243-4.243m4.242 4.242L9.88 9.88" />
              </svg>
              <svg v-else xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z" />
                <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
              </svg>
            </button>
          </div>
        </div>
        <button type="submit" :class="{ 'bg-blue-700': isButtonDarkBlue, 'bg-blue-500': !isButtonDarkBlue }" class="text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline w-full mt-4 transition-transform transform hover:scale-105">Register</button>
        <p v-if="showSuccessMessage" class="text-green-600 text-xs italic mt-2">{{ registerMessage }}</p>
        <p v-if="showErrorMessage" class="text-red-500 text-xs italic mt-2">{{ registerMessage }}</p>
      </form>
      <p class="text-center text-sm mt-4">Already have an account?<a href="/login" class="text-blue-500 hover:text-blue-700"> Login</a></p>
    </div>
  </div>
</template>

<script>
import axios from 'axios'

export default {
  name: 'RegistrationView',
  data() {
    return {
      Admin: {
        username: null,
        password: null,
        cpassword: null
      },
      isButtonDarkBlue: false,
      showUsernameMessage: false,
      showPasswordMessage: false,
      showPasswordLengthMessage: false,
      showPasswordRequirementsMessage: false,
      showSuccessMessage: false,
      showErrorMessage: false,
      registerMessage: '',
      redirectToLogin: false,
      showPassword: false // Add this line to track password visibility
    }
  },
  methods: {
    onRegister() {
      if (!this.Admin.username || !this.Admin.password || !this.Admin.cpassword) {
        this.showErrorMessage = true;
        this.registerMessage = 'Please fill in all fields';
        return;
      }

      if (this.Admin.username.includes(' ')) {
        this.showUsernameMessage = true;
        return;
      }

      if (this.Admin.password.includes(' ')) {
        this.showPasswordMessage = true;
        return;
      }

      if (this.Admin.password.length < 8) {
        this.showPasswordLengthMessage = true;
        return;
      }

      if (!this.checkPasswordRequirements(this.Admin.password)) {
        this.showPasswordRequirementsMessage = true;
        return;
      }

      if (this.Admin.password !== this.Admin.cpassword) {
        this.showErrorMessage = true;
        this.registerMessage = 'Passwords do not match';
        return;
      }

      const userData = {
        username: this.Admin.username,
        password: this.Admin.password,
        cpassword: this.Admin.cpassword
      };

      axios.post("http://localhost/php-vue/src/php/register.php", userData)
        .then(response => {
          if (response.data.error) {
            this.showErrorMessage = true;
            this.registerMessage = response.data.message;
          } else {
            this.showSuccessMessage = true;
            this.registerMessage = 'Register successfully, redirecting to login in 3';
            this.redirectToLogin = true; // Set flag to trigger redirection
            setTimeout(() => {
              this.$router.push('/login'); // Redirect after 3 seconds
            }, 3000); // Delay for 3 seconds
          }
        })
        .catch(error => {
          console.error("Error:", error);
        });
    },
    checkButtonColor() {
      this.isButtonDarkBlue = this.Admin.username && this.Admin.password && this.Admin.cpassword;
      this.showUsernameMessage = false; // Reset username message on input change
      this.showPasswordMessage = false; // Reset password message on input change
      this.showPasswordLengthMessage = false; // Reset password length message on input change
      this.showPasswordRequirementsMessage = false; // Reset password requirements message on input change
      this.showErrorMessage = false; // Reset error message on input change
      this.showSuccessMessage = false; // Reset success message on input change
    },
    checkPasswordRequirements(password) {
      // Password must contain at least one number, one alphabet, and one special character
      const regex = /^(?=.*\d)(?=.*[a-zA-Z])(?=.*[^a-zA-Z0-9]).{8,}$/;
      return regex.test(password);
    },
    togglePasswordVisibility() {
      this.showPassword = !this.showPassword;
    }
  }
}
</script>