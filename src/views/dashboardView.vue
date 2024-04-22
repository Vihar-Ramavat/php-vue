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
    <div v-if="showLogoutModal" class="fixed inset-0 z-50 flex items-center justify-center overflow-auto bg-black bg-opacity-50">
      <div class="bg-white w-full max-w-md mx-auto rounded-lg shadow-lg">
        <div class="p-8">
          <p class="text-lg text-center mb-8 text-gray-700">Are you sure you want to log out from the dashboard?</p>
          <div class="flex justify-center space-x-4">
            <button @click="cancelLogout" class="px-6 py-3 text-gray-600 bg-gray-200 hover:bg-gray-300 rounded-md focus:outline-none transform transition hover:scale-105">Cancel</button>
            <button @click="logout" class="px-6 py-3 bg-red-600 text-white hover:bg-red-700 rounded-md focus:outline-none transform transition hover:scale-105">Logout</button>
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
