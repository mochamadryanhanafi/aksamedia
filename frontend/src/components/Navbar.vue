<template>
  <nav class="bg-white/80 dark:bg-gray-800/90 backdrop-blur-md sticky top-0 z-50 shadow-sm border-b border-gray-100 dark:border-gray-700">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      <div class="flex justify-between h-16 items-center">
        <div class="flex items-center gap-2">
            <div class="w-8 h-8 bg-blue-600 rounded-lg flex items-center justify-center text-white font-bold text-lg shadow-blue-200 shadow-md">
                A
            </div>
            <h1 class="text-xl font-bold bg-gradient-to-r from-gray-800 to-gray-600 dark:from-white dark:to-gray-300 bg-clip-text text-transparent">
                Aksamedia
            </h1>
        </div>
        
        <div class="flex items-center gap-4">
          <div class="flex items-center gap-2 bg-gray-50 dark:bg-gray-700/50 px-3 py-1.5 rounded-full border border-gray-200 dark:border-gray-600">
             <div class="w-6 h-6 rounded-full bg-gradient-to-tr from-blue-500 to-purple-500 flex items-center justify-center text-xs text-white font-bold">
                 {{ user?.name?.charAt(0).toUpperCase() }}
             </div>
             <span class="text-sm font-medium text-gray-700 dark:text-gray-200 hidden sm:block">{{ user?.name }}</span>
          </div>
          
          <button
            @click="logout"
            class="text-gray-500 hover:text-red-500 dark:text-gray-400 dark:hover:text-red-400 p-2 rounded-full hover:bg-red-50 dark:hover:bg-red-900/20 transition-all duration-200"
            title="Logout"
          >
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-log-out"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" x2="9" y1="12" y2="12"/></svg>
          </button>
        </div>
      </div>
    </div>
  </nav>
</template>

<script setup>
import { useAuthStore } from '../stores/auth'
import { useRouter } from 'vue-router'
import { storeToRefs } from 'pinia'
import axios from 'axios'

const authStore = useAuthStore()
const { user } = storeToRefs(authStore)
const router = useRouter()

const logout = async () => {
    try {
        await axios.post('http://localhost:8002/api/logout', {}, {
            headers: { Authorization: `Bearer ${authStore.token}` }
        })
    } catch (e) {
        console.error(e)
    } finally {
        authStore.clearAuth()
        router.push('/login')
    }
}
</script>
