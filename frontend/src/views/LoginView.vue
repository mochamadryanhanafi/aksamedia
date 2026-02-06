<template>
  <div class="min-h-screen flex items-center justify-center bg-gray-100 dark:bg-gray-900">
    <div class="max-w-md w-full bg-white dark:bg-gray-800 rounded-lg shadow-md p-8">
      <h2 class="text-2xl font-bold mb-6 text-center text-gray-800 dark:text-white">Login</h2>
      <form @submit.prevent="handleLogin">
        <div class="mb-4">
          <label class="block text-gray-700 dark:text-gray-300 mb-2" for="username">Username</label>
          <input
            v-model="username"
            type="text"
            id="username"
            class="w-full px-3 py-2 border rounded-lg dark:bg-gray-700 dark:border-gray-600 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-500"
            required
          >
        </div>
        <div class="mb-6">
          <label class="block text-gray-700 dark:text-gray-300 mb-2" for="password">Password</label>
          <input
            v-model="password"
            type="password"
            id="password"
            class="w-full px-3 py-2 border rounded-lg dark:bg-gray-700 dark:border-gray-600 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-500"
            required
          >
        </div>
        <button
          type="submit"
          class="w-full bg-blue-500 text-white py-2 px-4 rounded-lg hover:bg-blue-600 transition duration-200"
        >
          Login
        </button>
      </form>
    </div>
  </div>
</template>

<script setup>
import { ref } from 'vue'
import { useRouter } from 'vue-router'
import { useAuthStore } from '../stores/auth'
import axios from 'axios'

const username = ref('')
const password = ref('')
const router = useRouter()
const authStore = useAuthStore()

const handleLogin = async () => {
  try {
    const response = await axios.post(`${import.meta.env.VITE_API_BASE_URL}/login`, {
      username: username.value,
      password: password.value
    })

    if (response.data.status === 'success') {
      authStore.setAuth(response.data.data.token, response.data.data.admin)
      router.push('/')
    }
  } catch (error) {
    alert(error.response?.data?.message || 'Login Failed')
  }
}
</script>
