<template>
  <div class="min-h-screen flex items-center justify-center bg-gradient-to-br from-black to-blue-700">
    <div class="max-w-md w-full bg-white rounded-lg shadow-md p-8">
      <h2 class="text-center text-3xl font-bold text-gray-800 mb-8">Reset Password</h2>
      <form @submit.prevent="onReset">
        <div class="mb-6">
          <label for="username" class="block text-gray-700 text-sm font-semibold mb-2">Username</label>
          <input type="text" id="username" placeholder="Enter your username" v-model="username" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
        </div>
        <div class="mb-6">
          <label for="password" class="block text-gray-700 text-sm font-semibold mb-2">New Password</label>
          <div class="relative">
            <input v-if="!showPassword" type="password" placeholder="Enter new password" id="password" v-model="password" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
            <input v-else type="text" id="password" placeholder="Enter new password" v-model="password" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
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
          <p v-if="passwordValidationMessage" class="text-red-500 text-xs italic mt-2">{{ passwordValidationMessage }}</p>
        </div>
        <button type="submit" class="bg-blue-500 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline w-full mt-4 transition-transform transform hover:scale-105">Reset Password</button>
        <button type="button" @click="onCancelReset" class="bg-gray-300 text-gray-800 font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline w-full mt-4 transition-transform transform hover:scale-105">Cancel</button>
        <p v-if="showResetMessage" class="text-green-600 text-xs italic mt-2">{{ resetMessage }}</p>
        <p v-if="showErrorMessage" class="text-red-500 text-xs italic mt-2">{{ errorMessage }}</p>
      </form>
    </div>
  </div>
</template>

<script>
import axios from 'axios'

export default {
  data() {
    return {
      username: '',
      password: '',
      showResetMessage: false,
      showErrorMessage: false,
      resetMessage: '',
      errorMessage: '',
      passwordValidationMessage: '', // Added for password validation message
      countdown: 3, // Initial countdown value
      showPassword: false // Added for password visibility
    }
  },
  methods: {
    onReset() {
      if (!this.username || !this.password) {
        this.showErrorMessage = true;
        this.errorMessage = 'Please fill in both username and new password';
        return;
      }

      // Password validation
      const isValidPassword = /^(?=.*[A-Za-z])(?=.*\d)(?=.*[@$!%*#?&])[A-Za-z\d@$!%*#?&]{8,}$/.test(this.password);
      if (!isValidPassword) {
        this.passwordValidationMessage = 'Password must be at least 8 characters long and contain at least one letter, one number, and one special character.';
        return;
      }

      const requestData = {
        username: this.username,
        password: this.password
      };

      axios.post("http://localhost/php-vue/src/php/reset_password.php", requestData)
        .then(response => {
          if (response.data.error) {
            this.showErrorMessage = true;
            this.errorMessage = response.data.message;
          } else {
            this.showResetMessage = true;
            this.resetMessage = 'Password reset successfully, redirecting to login in ' + this.countdown;
            // Start countdown
            this.startCountdown();
          }
        })
        .catch(error => {
          console.error("Error:", error);
        });
    },
    onCancelReset() {
      // Implement cancellation logic here, for example, redirecting to the login page
      this.$router.push('/login');
    },
    startCountdown() {
      const timer = setInterval(() => {
        this.countdown--;
        this.resetMessage = 'Password reset successfully, redirecting to login in ' + this.countdown;

        if (this.countdown === 0) {
          clearInterval(timer);
          this.$router.push('/login'); // Redirect to login
        }
      }, 1000);
    },
    togglePasswordVisibility() {
      this.showPassword = !this.showPassword;
    }
  }
}
</script>
