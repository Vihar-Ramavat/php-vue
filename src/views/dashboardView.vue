<template>
  <div class="flex h-screen bg-gradient-to-br from-black to-blue-700">
    <!-- Sidebar -->
    <aside class="w-64 bg-gradient-to-b from-black to-blue-600 shadow-md flex flex-col transition duration-300 ease-in-out transform hover:translate-x-2 hover:shadow-lg">
      <div class="p-4">
        <h1 class="text-2xl font-bold text-white">Dashboard</h1>
        <button @click="toggleSidebar" class="lg:hidden focus:outline-none mt-2">
          <svg class="w-6 h-6 fill-current text-gray-200" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
            <path d="M0 3h20v2H0V3zm0 6h20v2H0V9zm0 6h20v2H0v-2z"/>
          </svg>
        </button>
      </div>
      <nav class="flex-1 px-4 py-2">
        <router-link to="/dashboard" :class="{ 'bg-blue-900 text-white': isLinkActive('/dashboard') }" class="block py-2 px-4 text-white hover:bg-blue-700 hover:text-white rounded-lg mb-2 transition duration-300 ease-in-out">Dashboard</router-link>
        <router-link to="/dashboard/profile" :class="{ 'bg-blue-900 text-white': isLinkActive('/dashboard/profile') }" class="block py-2 px-4 text-white hover:bg-blue-700 hover:text-white rounded-lg mb-2 transition duration-300 ease-in-out">Profile</router-link>
        <router-link to="/dashboard/change-password" :class="{ 'bg-blue-900 text-white': isLinkActive('/dashboard/change-password') }" class="block py-2 px-4 text-white hover:bg-blue-700 hover:text-white rounded-lg mb-2 transition duration-300 ease-in-out">Change Password</router-link>
      </nav>
      <div class="p-4">
        <button @click="confirmLogout" class="flex border-2 border-red-400 items-center justify-center w-full rounded-md py-2 text-center text-white bg-red-600 hover:bg-red-700 font-semibold transition duration-300 ease-in-out">
          <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 mr-2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0 0 13.5 3h-6a2.25 2.25 0 0 0-2.25 2.25v13.5A2.25 2.25 0 0 0 7.5 21h6a2.25 2.25 0 0 0 2.25-2.25V15M12 9l-3 3m0 0 3 3m-3-3h12.75" />
          </svg>
          <span>Logout</span>
        </button>
      </div>
    </aside>
    
    <!-- Main content area -->
    <main class="flex-1 p-8">
      <div class="max-w-full mx-auto">
        <div class="bg-white rounded-lg shadow-md p-8">
          <!-- Conditional rendering of welcome message -->
          <h2 v-if="showWelcomeMessage" class="text-3xl font-semibold text-gray-800 mb-6">Welcome to Your Dashboard</h2>
          <p v-if="showWelcomeMessage" class="text-gray-700">Welcome, <span class="font-bold">{{ username }}</span>! You are part of our awesome team.</p>
          <!-- Dynamic content based on route -->
          <router-view></router-view>
        </div>
      </div>
    </main>
    
    <!-- Logout confirmation modal -->
    <!-- Logout confirmation modal -->
<div v-if="showLogoutModal" class="fixed z-10 inset-0 overflow-y-auto">
  <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
    <div class="fixed inset-0 transition-opacity" aria-hidden="true">
      <div class="absolute inset-0 bg-black bg-opacity-50"></div>
    </div>
    <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
    <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
      <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
        <div class="sm:flex sm:items-start">
          <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-red-100 sm:mx-0 sm:h-10  sm:w-10">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="red" class="w-6 h-6">
  <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 9V5.25A2.25 2.25 0 0 1 10.5 3h6a2.25 2.25 0 0 1 2.25 2.25v13.5A2.25 2.25 0 0 1 16.5 21h-6a2.25 2.25 0 0 1-2.25-2.25V15m-3 0-3-3m0 0 3-3m-3 3H15" />
</svg>

          </div>
          <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
            <h3 class="text-lg leading-6 font-medium text-gray-900">Logout</h3>
            <div class="mt-2">
              <p class="text-sm text-gray-500">Are you sure you want to log out from the dashboard?</p>
            </div>
          </div>
        </div>
      </div>
      <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
        <button @click="logout" type="button" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-red-600 text-base font-medium text-white hover:bg-red-700 focus:outline-none focus:ring-2  sm:ml-3 sm:w-auto sm:text-sm">
          Logout
        </button>
        <button @click="cancelLogout" type="button" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-100 focus:outline-none focus:ring-offset-2 sm:mt-0 sm:w-auto sm:text-sm">
          Cancel
        </button>
      </div>
    </div>
  </div>
</div>

  </div>
</template>

<script>
export default {
  name: 'DashboardView',
  data() {
    return {
      username: '',
      showWelcomeMessage: true,
      showLogoutModal: false
    };
  },
  created() {
    this.username = localStorage.getItem('username');
    this.user_id=localStorage.getItem('user_id');
    this.updateWelcomeMessage();
  },
  watch: {
    // Watch for route changes and update welcome message
    '$route'() {
      this.updateWelcomeMessage();
    }
  },
  methods: {
    logout() {
      localStorage.removeItem('token');
      localStorage.removeItem('username');
      sessionStorage.removeItem('username');
      this.$router.push('/login');
    },
    updateWelcomeMessage() {
      this.showWelcomeMessage = this.$route.path === '/dashboard';
    },
    isLinkActive(route) {
      return this.$route.path === route;
    },
    confirmLogout() {
      this.showLogoutModal = true;
    },
    cancelLogout() {
      this.showLogoutModal = false;
    }
  }
};
</script>
