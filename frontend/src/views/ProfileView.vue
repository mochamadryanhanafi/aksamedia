<template>
  <div class="min-h-screen bg-gray-50 dark:bg-gray-900">
    <Navbar />

    <main class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-10 pt-24">
      <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 overflow-hidden">
        <div class="px-6 py-8 border-b border-gray-100 dark:border-gray-700">
            <h2 class="text-2xl font-bold text-gray-900 dark:text-white">Profile Settings</h2>
            <p class="mt-1 text-gray-500 dark:text-gray-400">Manage your account information and preferences.</p>
        </div>

        <form @submit.prevent="saveProfile" class="p-6 space-y-6">
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Display Name</label>
                <div class="relative">
                     <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-gray-400"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                    </div>
                    <input 
                        v-model="form.name" 
                        type="text" 
                        class="pl-10 block w-full rounded-xl border-gray-200 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:ring-blue-500 focus:border-blue-500 transition-colors" 
                        required
                    />
                </div>
                <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">This name will be displayed in the navigation bar.</p>
            </div>

            <div class="pt-4 flex items-center justify-end border-t border-gray-100 dark:border-gray-700">
                 <button 
                    type="submit" 
                    class="inline-flex justify-center py-2.5 px-6 border border-transparent shadow-sm text-sm font-medium rounded-xl text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all shadow-blue-600/20 hover:shadow-blue-600/30 active:scale-95"
                >
                    Save Changes
                </button>
            </div>
        </form>
      </div>
    </main>
  </div>
</template>

<script setup>
import { ref, reactive, onMounted } from 'vue'
import { useAuthStore } from '../stores/auth'
import { useToastStore } from '../stores/toast'
import Navbar from '../components/Navbar.vue'

const authStore = useAuthStore()
const toast = useToastStore()

const form = reactive({
    name: ''
})

onMounted(() => {
    if (authStore.user) {
        form.name = authStore.user.name
    }
})

const saveProfile = () => {
    if (!form.name.trim()) return
    
    authStore.updateUser({ name: form.name })
    toast.success('Profile updated successfully')
}
</script>
