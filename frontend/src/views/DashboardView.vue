<template>
  <div class="min-h-screen bg-gray-50 dark:bg-gray-900">
    <Navbar />

    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
      <!-- Header Section -->
      <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-8">
        <div>
            <h2 class="text-3xl font-bold text-gray-900 dark:text-white tracking-tight">Employees</h2>
            <p class="text-gray-500 dark:text-gray-400 mt-1">Manage your team members and their roles.</p>
        </div>
        <button 
            @click="openModal()" 
            class="group inline-flex items-center justify-center gap-2 bg-blue-600 hover:bg-blue-700 text-white px-5 py-2.5 rounded-xl font-medium transition-all duration-200 shadow-lg shadow-blue-600/20 hover:shadow-blue-600/30 active:scale-95"
        >
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14"/><path d="M12 5v14"/></svg>
            Add Employee
        </button>
      </div>

      <!-- Filters -->
      <div class="bg-white dark:bg-gray-800 p-1.5 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 mb-8 flex flex-col sm:flex-row gap-2">
        <div class="relative flex-1">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.3-4.3"/></svg>
            <input 
                v-model="search" 
                @input="debouncedFetch" 
                placeholder="Search employees..." 
                class="w-full pl-10 pr-4 py-2.5 bg-gray-50 dark:bg-gray-900/50 border-none rounded-xl text-gray-900 dark:text-white placeholder-gray-400 focus:ring-2 focus:ring-blue-500/20 focus:bg-white dark:focus:bg-gray-900 transition-all font-medium" 
            />
        </div>
        <div class="relative sm:w-64">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400"><rect width="7" height="7" x="3" y="3" rx="1"/><rect width="7" height="7" x="14" y="3" rx="1"/><rect width="7" height="7" x="14" y="14" rx="1"/><rect width="7" height="7" x="3" y="14" rx="1"/></svg>
            <select 
                v-model="selectedDivision" 
                @change="handleDivisionChange" 
                class="w-full pl-10 pr-8 py-2.5 bg-gray-50 dark:bg-gray-900/50 border-none rounded-xl text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500/20 focus:bg-white dark:focus:bg-gray-900 transition-all font-medium appearance-none cursor-pointer"
            >
                <option value="">All Divisions</option>
                <option v-for="div in divisions" :key="div.id" :value="div.id">{{ div.name }}</option>
            </select>
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 pointer-events-none"><path d="m6 9 6 6 6-6"/></svg>
        </div>
      </div>

      <!-- Desktop Table -->
      <div class="hidden sm:block bg-white dark:bg-gray-800 shadow-xl shadow-gray-200/50 dark:shadow-none rounded-2xl overflow-hidden border border-gray-100 dark:border-gray-700">
        <table class="min-w-full divide-y divide-gray-100 dark:divide-gray-700">
          <thead class="bg-gray-50/50 dark:bg-gray-700/30">
            <tr>
              <th scope="col" class="px-6 py-4 text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Name</th>
              <th scope="col" class="px-6 py-4 text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Contact</th>
              <th scope="col" class="px-6 py-4 text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Role</th>
              <th scope="col" class="px-6 py-4 text-right text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Actions</th>
            </tr>
          </thead>
          <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
            <tr v-for="emp in employees" :key="emp.id" class="group hover:bg-gray-50/50 dark:hover:bg-gray-700/20 transition-colors">
              <td class="px-6 py-4 whitespace-nowrap">
                <div class="flex items-center">
                    <div class="h-10 w-10 flex-shrink-0 bg-gradient-to-br from-blue-100 to-indigo-100 dark:from-blue-900/30 dark:to-indigo-900/30 rounded-full flex items-center justify-center text-blue-600 dark:text-blue-400 font-bold overflow-hidden">
                         <img v-if="emp.image" :src="emp.image" class="w-full h-full object-cover" />
                         <span v-else>{{ emp.name.charAt(0) }}</span>
                    </div>
                    <div class="ml-4">
                        <div class="text-sm font-semibold text-gray-900 dark:text-gray-100 group-hover:text-blue-600 dark:group-hover:text-blue-400 transition-colors">{{ emp.name }}</div>
                        <div class="text-sm text-gray-500 dark:text-gray-400">{{ emp.position }}</div>
                    </div>
                </div>
              </td>
              <td class="px-6 py-4 whitespace-nowrap">
                <div class="text-sm text-gray-600 dark:text-gray-300 flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-gray-400"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"/></svg>
                    {{ emp.phone }}
                </div>
              </td>
              <td class="px-6 py-4 whitespace-nowrap">
                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-50 text-blue-700 dark:bg-blue-900/30 dark:text-blue-300 border border-blue-100 dark:border-blue-800">
                  {{ emp.division?.name }}
                </span>
              </td>
              <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                <div class="flex items-center justify-end gap-3 opacity-0 group-hover:opacity-100 transition-opacity">
                    <button @click="openModal(emp)" class="text-gray-400 hover:text-blue-600 dark:hover:text-blue-400 transition-colors" title="Edit">
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M17 3a2.828 2.828 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5L17 3z"/></svg>
                    </button>
                    <button @click="deleteEmployee(emp.id)" class="text-gray-400 hover:text-red-600 dark:hover:text-red-400 transition-colors" title="Delete">
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 6h18"/><path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6"/><path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2"/></svg>
                    </button>
                </div>
              </td>
            </tr>
          </tbody>
        </table>
      </div>

      <!-- Mobile Cards -->
      <div class="grid grid-cols-1 gap-4 sm:hidden">
        <div v-for="emp in employees" :key="emp.id" class="bg-white dark:bg-gray-800 p-4 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700">
            <div class="flex items-center gap-4 mb-3">
                <div class="h-12 w-12 flex-shrink-0 bg-blue-100 dark:bg-blue-900/30 rounded-full flex items-center justify-center text-blue-600 dark:text-blue-400 font-bold overflow-hidden">
                     <img v-if="emp.image" :src="emp.image" class="w-full h-full object-cover" />
                     <span v-else>{{ emp.name.charAt(0) }}</span>
                </div>
                <div>
                    <h3 class="font-semibold text-gray-900 dark:text-gray-100">{{ emp.name }}</h3>
                    <p class="text-sm text-gray-500 dark:text-gray-400">{{ emp.position }}</p>
                </div>
            </div>
            <div class="space-y-2 text-sm text-gray-600 dark:text-gray-300 mb-4">
                <div class="flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-gray-400"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"/></svg>
                    {{ emp.phone }}
                </div>
                <div class="flex items-center gap-2">
                     <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-gray-400"><rect width="7" height="7" x="3" y="3" rx="1"/><rect width="7" height="7" x="14" y="3" rx="1"/><rect width="7" height="7" x="14" y="14" rx="1"/><rect width="7" height="7" x="3" y="14" rx="1"/></svg>
                    {{ emp.division?.name }}
                </div>
            </div>
            <div class="flex gap-2 border-t border-gray-100 dark:border-gray-700 pt-3">
                <button @click="openModal(emp)" class="flex-1 py-2 text-center text-sm font-medium text-blue-600 bg-blue-50 dark:bg-blue-900/20 dark:text-blue-400 rounded-lg hover:bg-blue-100 transition-colors">Edit</button>
                <button @click="deleteEmployee(emp.id)" class="flex-1 py-2 text-center text-sm font-medium text-red-600 bg-red-50 dark:bg-red-900/20 dark:text-red-400 rounded-lg hover:bg-red-100 transition-colors">Delete</button>
            </div>
        </div>
      </div>

      <!-- Pagination -->
      <div v-if="lastPage > 1" class="mt-8 flex justify-center items-center gap-4">
        <button 
            :disabled="currentPage <= 1" 
            @click="changePage(currentPage - 1)" 
            class="px-4 py-2 border border-gray-200 dark:border-gray-700 rounded-xl text-sm font-medium text-gray-600 dark:text-gray-300 hover:bg-white dark:hover:bg-gray-800 hover:shadow-sm disabled:opacity-50 disabled:hover:shadow-none transition-all"
        >
            Previous
        </button>
        <span class="text-sm font-medium text-gray-500 dark:text-gray-400 bg-white dark:bg-gray-800 px-4 py-2 rounded-xl shadow-sm border border-gray-100 dark:border-gray-700">Page {{ currentPage }} of {{ lastPage }}</span>
        <button 
            :disabled="currentPage >= lastPage" 
            @click="changePage(currentPage + 1)" 
            class="px-4 py-2 border border-gray-200 dark:border-gray-700 rounded-xl text-sm font-medium text-gray-600 dark:text-gray-300 hover:bg-white dark:hover:bg-gray-800 hover:shadow-sm disabled:opacity-50 disabled:hover:shadow-none transition-all"
        >
            Next
        </button>
      </div>
    </main>
    
    <!-- Modal -->
    <Transition
        enter-active-class="transition duration-200 ease-out"
        enter-from-class="transform scale-95 opacity-0"
        enter-to-class="transform scale-100 opacity-100"
        leave-active-class="transition duration-150 ease-in"
        leave-from-class="transform scale-100 opacity-100"
        leave-to-class="transform scale-95 opacity-0"
    >
        <div v-if="showModal" class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
            <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                <div class="fixed inset-0 bg-gray-900/60 backdrop-blur-sm transition-opacity" aria-hidden="true" @click="closeModal"></div>

                <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

                <div class="inline-block align-bottom bg-white dark:bg-gray-800 rounded-2xl text-left overflow-hidden shadow-2xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg w-full">
                    <div class="bg-white dark:bg-gray-800 px-4 pt-5 pb-4 sm:p-6 sm:pb-4 border-b border-gray-100 dark:border-gray-700">
                        <div class="sm:flex sm:items-center">
                            <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-blue-100 dark:bg-blue-900/30 sm:mx-0 sm:h-10 sm:w-10">
                                <svg v-if="!isEditing" xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-blue-600 dark:text-blue-400"><path d="M16 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="8.5" cy="7" r="4"/><line x1="20" x2="20" y1="8" y2="14"/><line x1="23" x2="17" y1="11" y2="11"/></svg>
                                <svg v-else xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-blue-600 dark:text-blue-400"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                            </div>
                            <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                                <h3 class="text-lg leading-6 font-medium text-gray-900 dark:text-white" id="modal-title">
                                    {{ isEditing ? 'Edit Employee' : 'Add New Employee' }}
                                </h3>
                                <div class="mt-2">
                                    <p class="text-sm text-gray-500 dark:text-gray-400">
                                        {{ isEditing ? 'Update the details below to edit the employee.' : 'Fill in the details below to add a new team member.' }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <form @submit.prevent="saveEmployee">
                        <div class="px-6 py-4 space-y-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Full Name</label>
                                <input v-model="form.name" type="text" class="w-full px-4 py-2 border border-gray-200 dark:border-gray-600 rounded-xl dark:bg-gray-700 dark:text-white focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-all outline-none" required placeholder="e.g. John Doe" />
                            </div>
                             <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Phone Number</label>
                                <input v-model="form.phone" type="tel" class="w-full px-4 py-2 border border-gray-200 dark:border-gray-600 rounded-xl dark:bg-gray-700 dark:text-white focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-all outline-none" required placeholder="e.g. 08123..." />
                            </div>
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Division</label>
                                    <select v-model="form.division" class="w-full px-4 py-2 border border-gray-200 dark:border-gray-600 rounded-xl dark:bg-gray-700 dark:text-white focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-all outline-none" required>
                                         <option v-for="div in divisions" :key="div.id" :value="div.id">{{ div.name }}</option>
                                    </select>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Position</label>
                                    <input v-model="form.position" type="text" class="w-full px-4 py-2 border border-gray-200 dark:border-gray-600 rounded-xl dark:bg-gray-700 dark:text-white focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-all outline-none" required placeholder="e.g. Senior Dev" />
                                </div>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Profile Image</label>
                                <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 dark:border-gray-600 border-dashed rounded-xl hover:border-blue-500 transition-colors cursor-pointer relative bg-gray-50 dark:bg-gray-700/50">
                                    <input type="file" @change="handleFileChange" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer" />
                                    <div class="space-y-1 text-center">
                                        <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48" aria-hidden="true">
                                            <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                        </svg>
                                        <div class="flex text-sm text-gray-600 dark:text-gray-400">
                                            <span class="relative cursor-pointer bg-white rounded-md font-medium text-blue-600 hover:text-blue-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-blue-500">
                                                <span>Upload a file</span>
                                            </span>
                                            <p class="pl-1">or drag and drop</p>
                                        </div>
                                        <p class="text-xs text-gray-500">PNG, JPG, GIF up to 2MB</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="bg-gray-50 dark:bg-gray-700/50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse rounded-b-2xl">
                            <button type="submit" class="w-full inline-flex justify-center rounded-xl border border-transparent shadow-sm px-5 py-2.5 bg-blue-600 text-base font-medium text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:ml-3 sm:w-auto sm:text-sm transition-all shadow-blue-600/20 hover:shadow-blue-600/30">
                                {{ isEditing ? 'Save Changes' : 'Create Employee' }}
                            </button>
                            <button type="button" @click="closeModal" class="mt-3 w-full inline-flex justify-center rounded-xl border border-gray-300 dark:border-gray-600 shadow-sm px-5 py-2.5 bg-white dark:bg-gray-800 text-base font-medium text-gray-700 dark:text-gray-200 hover:bg-gray-50 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm transition-all">
                                Cancel
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </Transition>
  </div>
</template>

<script setup>
import { ref, onMounted, reactive, watch } from 'vue'
import axios from 'axios'
import { useAuthStore } from '../stores/auth'
import { useRoute, useRouter } from 'vue-router'
import Navbar from '../components/Navbar.vue'

const authStore = useAuthStore()
const router = useRouter()
const route = useRoute()

const employees = ref([])
const divisions = ref([])
const search = ref('')
const selectedDivision = ref('')
const currentPage = ref(1)
const lastPage = ref(1)

const showModal = ref(false)
const isEditing = ref(false)
const form = reactive({
    id: null,
    name: '',
    phone: '',
    division: '',
    position: '',
    image: null
})

const fetchDivisions = async () => {
    try {
        const res = await axios.get(`${import.meta.env.VITE_API_BASE_URL}/divisions`, {
             headers: { Authorization: `Bearer ${authStore.token}` }
        })
        divisions.value = res.data.data.divisions
    } catch (e) {
        console.error(e)
    }
}

const fetchEmployees = async (page = 1) => {
    try {
        const res = await axios.get(`${import.meta.env.VITE_API_BASE_URL}/employees`, {
            params: {
                page,
                name: search.value,
                division_id: selectedDivision.value
            },
             headers: { Authorization: `Bearer ${authStore.token}` }
        })
        employees.value = res.data.data.employees
        currentPage.value = res.data.pagination.current_page
        lastPage.value = res.data.pagination.last_page
        
        // Update URL
        router.push({
            query: {
                page: currentPage.value,
                ...(search.value && { name: search.value }),
                ...(selectedDivision.value && { division_id: selectedDivision.value })
            }
        })
    } catch (e) {
        console.error(e)
    }
}

let timeout = null
const debouncedFetch = () => {
    clearTimeout(timeout)
    timeout = setTimeout(() => {
        fetchEmployees(1)
    }, 300)
}

const handleDivisionChange = () => {
    fetchEmployees(1)
}

const changePage = (page) => {
    if (page >= 1 && page <= lastPage.value) fetchEmployees(page)
}

const openModal = (emp = null) => {
    isEditing.value = !!emp
    if (emp) {
        form.id = emp.id
        form.name = emp.name
        form.phone = emp.phone
        form.division = emp.division_id || emp.division.id
        form.position = emp.position
        form.image = null 
    } else {
        form.id = null
        form.name = ''
        form.phone = ''
        form.division = ''
        form.position = ''
        form.image = null
    }
    showModal.value = true
}

const closeModal = () => {
    showModal.value = false
}

const handleFileChange = (e) => {
    form.image = e.target.files[0]
}

const saveEmployee = async () => {
    const formData = new FormData()
    formData.append('name', form.name)
    formData.append('phone', form.phone)
    formData.append('division', form.division)
    formData.append('position', form.position)
    if (form.image) {
        formData.append('image', form.image)
    }

    try {
        if (isEditing.value) {
            formData.append('_method', 'PUT')
            await axios.post(`${import.meta.env.VITE_API_BASE_URL}/employees/${form.mainId || form.id}`, formData, {
                 headers: { 
                     Authorization: `Bearer ${authStore.token}`,
                     'Content-Type': 'multipart/form-data'
                 }
            })
        } else {
            await axios.post(`${import.meta.env.VITE_API_BASE_URL}/employees`, formData, {
                 headers: { 
                     Authorization: `Bearer ${authStore.token}`,
                     'Content-Type': 'multipart/form-data'
                 }
            })
        }
        closeModal()
        if (isEditing.value) {
            fetchEmployees(currentPage.value)
        } else {
            fetchEmployees(1)
        }
    } catch (e) {
        alert(e.response?.data?.message || 'Error occurred')
    }
}

const deleteEmployee = async (id) => {
    if (!confirm('Are you sure?')) return
    try {
        await axios.delete(`${import.meta.env.VITE_API_BASE_URL}/employees/${id}`, {
             headers: { Authorization: `Bearer ${authStore.token}` }
        })
        fetchEmployees(currentPage.value)
    } catch (e) {
        alert('Failed to delete')
    }
}

onMounted(() => {
    // Restore state from URL
    if (route.query.name) search.value = route.query.name
    if (route.query.division_id) selectedDivision.value = route.query.division_id
    if (route.query.page) currentPage.value = parseInt(route.query.page)
    
    fetchDivisions()
    fetchEmployees(currentPage.value)
})
</script>
