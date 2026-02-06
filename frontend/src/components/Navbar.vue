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
        
        <div class="relative">
          <button 
            @click="isOpen = !isOpen"
            class="flex items-center gap-2 bg-gray-50 dark:bg-gray-700/50 px-3 py-1.5 rounded-full border border-gray-200 dark:border-gray-600 hover:bg-gray-100 dark:hover:bg-gray-600 transition-colors focus:outline-none focus:ring-2 focus:ring-blue-500/20"
          >
             <div class="w-6 h-6 rounded-full bg-gradient-to-tr from-blue-500 to-purple-500 flex items-center justify-center text-xs text-white font-bold">
                 {{ user?.name?.charAt(0).toUpperCase() }}
             </div>
             <span class="text-sm font-medium text-gray-700 dark:text-gray-200 hidden sm:block">{{ user?.name }}</span>
             <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-gray-400 dark:text-gray-500 transition-transform duration-200" :class="{ 'rotate-180': isOpen }"><path d="m6 9 6 6 6-6"/></svg>
          </button>

          <!-- Custom Dropdown -->
          <Transition
            enter-active-class="transition ease-out duration-100"
            enter-from-class="transform opacity-0 scale-95"
            enter-to-class="transform opacity-100 scale-100"
            leave-active-class="transition ease-in duration-75"
            leave-from-class="transform opacity-100 scale-100"
            leave-to-class="transform opacity-0 scale-95"
          >
            <div 
                v-if="isOpen" 
                class="absolute right-0 mt-2 w-48 bg-white dark:bg-gray-800 rounded-xl shadow-lg border border-gray-100 dark:border-gray-700 py-1 focus:outline-none origin-top-right ring-1 ring-black ring-opacity-5"
            >
                <div class="px-4 py-2 border-b border-gray-100 dark:border-gray-700 sm:hidden">
                    <p class="text-sm font-medium text-gray-900 dark:text-white truncate">{{ user?.name }}</p>
                </div>
                <button 
                    @click="logout" 
                    class="w-full text-left px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700 hover:text-red-600 dark:hover:text-red-400 flex items-center gap-2 transition-colors"
                >
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" x2="9" y1="12" y2="12"/></svg>
                    Logout
                </button>
            </div>
          </Transition>

          <!-- Click outside overlay -->
          <div v-if="isOpen" @click="isOpen = false" class="fixed inset-0 z-[-1] cursor-default"></div>
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
import { ref } from 'vue'

const authStore = useAuthStore()
const { user } = storeToRefs(authStore)
const router = useRouter()
const isOpen = ref(false)

const logout = async () => {
    try {
        await axios.post(`${import.meta.env.VITE_API_BASE_URL}/logout`, {}, {
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
