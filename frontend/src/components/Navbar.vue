<template>
  <nav class="fixed w-full top-0 z-50 bg-white/50 dark:bg-gray-900/50 backdrop-blur-xl border-b border-gray-200/50 dark:border-gray-700/50 transition-all duration-300">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      <div class="flex justify-between h-16 items-center">
        <div class="flex items-center gap-8">
            <div class="flex items-center gap-2">
                <div class="w-8 h-8 bg-blue-600 rounded-lg flex items-center justify-center text-white font-bold text-lg shadow-blue-200 shadow-md">
                    A
                </div>
                <h1 class="text-xl font-bold bg-gradient-to-r from-gray-800 to-gray-600 dark:from-white dark:to-gray-300 bg-clip-text text-transparent">
                    Aksamedia
                </h1>
            </div>
            
            <div class="hidden md:flex items-center gap-1">
                <router-link 
                    to="/" 
                    class="px-3 py-2 rounded-lg text-sm font-medium transition-colors"
                    active-class="bg-blue-50 text-blue-600 dark:bg-blue-900/20 dark:text-blue-400"
                    :class="$route.path === '/' ? '' : 'text-gray-600 dark:text-gray-300 hover:text-gray-900 dark:hover:text-white hover:bg-gray-50 dark:hover:bg-gray-700/50'"
                >
                    Dashboard
                </router-link>
                <router-link 
                    to="/reports" 
                    class="px-3 py-2 rounded-lg text-sm font-medium transition-colors"
                    active-class="bg-blue-50 text-blue-600 dark:bg-blue-900/20 dark:text-blue-400"
                    :class="$route.path === '/reports' ? '' : 'text-gray-600 dark:text-gray-300 hover:text-gray-900 dark:hover:text-white hover:bg-gray-50 dark:hover:bg-gray-700/50'"
                >
                    Reports
                </router-link>
            </div>
        </div>
        
        <div class="flex items-center">
          <!-- Theme Toggler -->
          <div class="relative mr-4">
            <button 
                @click="isThemeOpen = !isThemeOpen"
                class="p-2 rounded-full text-gray-500 hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors focus:outline-none focus:ring-2 focus:ring-blue-500/20"
                title="Toggle Theme"
            >
                <!-- Sun (Light) -->
                <svg v-if="theme === 'light'" xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-orange-500"><circle cx="12" cy="12" r="5"/><path d="M12 1v2"/><path d="M12 21v2"/><path d="M4.22 4.22l1.42 1.42"/><path d="M18.36 18.36l1.42 1.42"/><path d="M1 12h2"/><path d="M21 12h2"/><path d="M4.22 19.78l1.42-1.42"/><path d="M18.36 5.64l1.42-1.42"/></svg>
                <!-- Moon (Dark) -->
                <svg v-else-if="theme === 'dark'" xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-blue-500"><path d="M21 12.79A9 9 0 1 1 11.21 3 7 7 0 0 0 21 12.79z"/></svg>
                <!-- Monitor (System) -->
                <svg v-else xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-gray-500 dark:text-gray-400"><rect x="2" y="3" width="20" height="14" rx="2" ry="2"/><line x1="8" y1="21" x2="16" y2="21"/><line x1="12" y1="17" x2="12" y2="21"/></svg>
            </button>

            <Transition
                enter-active-class="transition ease-out duration-100"
                enter-from-class="transform opacity-0 scale-95"
                enter-to-class="transform opacity-100 scale-100"
                leave-active-class="transition ease-in duration-75"
                leave-from-class="transform opacity-100 scale-100"
                leave-to-class="transform opacity-0 scale-95"
            >
                <div v-if="isThemeOpen" class="absolute right-0 mt-2 w-36 bg-white dark:bg-gray-800 rounded-xl shadow-lg border border-gray-100 dark:border-gray-700 py-1 focus:outline-none origin-top-right ring-1 ring-black ring-opacity-5 z-50">
                    <button @click="setTheme('light')" class="w-full text-left px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700 flex items-center gap-2" :class="{ 'text-blue-600 bg-blue-50 dark:bg-blue-900/20': theme === 'light' }">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="5"/><path d="M12 1v2"/><path d="M12 21v2"/><path d="M4.22 4.22l1.42 1.42"/><path d="M18.36 18.36l1.42 1.42"/><path d="M1 12h2"/><path d="M21 12h2"/><path d="M4.22 19.78l1.42-1.42"/><path d="M18.36 5.64l1.42-1.42"/></svg>
                        Light
                    </button>
                    <button @click="setTheme('dark')" class="w-full text-left px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700 flex items-center gap-2" :class="{ 'text-blue-600 bg-blue-50 dark:bg-blue-900/20': theme === 'dark' }">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 12.79A9 9 0 1 1 11.21 3 7 7 0 0 0 21 12.79z"/></svg>
                        Dark
                    </button>
                    <button @click="setTheme('system')" class="w-full text-left px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700 flex items-center gap-2" :class="{ 'text-blue-600 bg-blue-50 dark:bg-blue-900/20': theme === 'system' }">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="3" width="20" height="14" rx="2" ry="2"/><line x1="8" y1="21" x2="16" y2="21"/><line x1="12" y1="17" x2="12" y2="21"/></svg>
                        System
                    </button>
                </div>
            </Transition>
            <div v-if="isThemeOpen" @click="isThemeOpen = false" class="fixed inset-0 z-40 cursor-default"></div>
          </div>

          <!-- User Menu -->
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
                <router-link 
                    to="/profile" 
                    @click="isOpen = false"
                    class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700 flex items-center gap-2 transition-colors"
                >
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                    Profile
                </router-link>
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
    </div>
  </nav>
</template>

<script setup>
import { useAuthStore } from '../stores/auth'
import { useThemeStore } from '../stores/theme'
import { useRouter } from 'vue-router'
import { storeToRefs } from 'pinia'
import axios from 'axios'
import { ref } from 'vue'

const authStore = useAuthStore()
const themeStore = useThemeStore()
const { user } = storeToRefs(authStore)
const { theme } = storeToRefs(themeStore)
const router = useRouter()
const isOpen = ref(false)
const isThemeOpen = ref(false)

const setTheme = (val) => {
    themeStore.setTheme(val)
    isThemeOpen.value = false
}

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
