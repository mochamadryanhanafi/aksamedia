<template>
  <div class="min-h-screen bg-gray-50 dark:bg-gray-900">
    <Navbar />

    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 pt-24">
      <!-- Header -->
      <div class="mb-8">
        <h2 class="text-3xl font-bold text-gray-900 dark:text-white tracking-tight">Performance Reports</h2>
        <p class="text-gray-500 dark:text-gray-400 mt-1">View comprehensive analysis of employee test scores.</p>
      </div>

      <!-- Tabs -->
      <div class="flex space-x-1 rounded-xl bg-blue-900/20 p-1 mb-8 w-fit">
        <button
          v-for="tab in tabs"
          :key="tab.id"
          @click="currentTab = tab.id"
          :class="[
            'w-full rounded-lg py-2.5 px-6 text-sm font-medium leading-5',
            'ring-white ring-opacity-60 ring-offset-2 ring-offset-blue-400 focus:outline-none focus:ring-2',
            currentTab === tab.id
              ? 'bg-white dark:bg-gray-800 text-blue-700 dark:text-blue-400 shadow'
              : 'text-blue-100 hover:bg-white/[0.12] hover:text-white'
          ]"
        >
          {{ tab.name }}
        </button>
      </div>

      <!-- Content -->
      <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 overflow-hidden">
        
        <!-- Realizing Potential Table -->
        <div v-if="currentTab === 'rt'" class="overflow-x-auto">
          <table class="min-w-full divide-y divide-gray-100 dark:divide-gray-700">
            <thead class="bg-gray-50/50 dark:bg-gray-700/30">
              <tr>
                <th scope="col" class="px-6 py-4 text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Name</th>
                <th scope="col" class="px-6 py-4 text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">NISN</th>
                <th scope="col" class="px-6 py-4 text-center text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Realistic</th>
                <th scope="col" class="px-6 py-4 text-center text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Investigative</th>
                <th scope="col" class="px-6 py-4 text-center text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Artistic</th>
                <th scope="col" class="px-6 py-4 text-center text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Social</th>
                <th scope="col" class="px-6 py-4 text-center text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Enterprising</th>
                <th scope="col" class="px-6 py-4 text-center text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Conventional</th>
              </tr>
            </thead>
            <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
              <tr v-for="item in rtData" :key="item.nisn" class="hover:bg-gray-50/50 dark:hover:bg-gray-700/20 transition-colors">
                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-white">{{ item.nama }}</td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">{{ item.nisn }}</td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-center text-gray-600 dark:text-gray-300">{{ item.nilaiRt?.realistic || '-' }}</td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-center text-gray-600 dark:text-gray-300">{{ item.nilaiRt?.investigative || '-' }}</td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-center text-gray-600 dark:text-gray-300">{{ item.nilaiRt?.artistic || '-' }}</td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-center text-gray-600 dark:text-gray-300">{{ item.nilaiRt?.social || '-' }}</td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-center text-gray-600 dark:text-gray-300">{{ item.nilaiRt?.enterprising || '-' }}</td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-center text-gray-600 dark:text-gray-300">{{ item.nilaiRt?.conventional || '-' }}</td>
              </tr>
            </tbody>
          </table>
        </div>

        <!-- Smart Test Table -->
        <div v-if="currentTab === 'st'" class="overflow-x-auto">
          <table class="min-w-full divide-y divide-gray-100 dark:divide-gray-700">
            <thead class="bg-gray-50/50 dark:bg-gray-700/30">
              <tr>
                <th scope="col" class="px-6 py-4 text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Name</th>
                <th scope="col" class="px-6 py-4 text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">NISN</th>
                <th scope="col" class="px-6 py-4 text-center text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Verbal</th>
                <th scope="col" class="px-6 py-4 text-center text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Quantitative</th>
                <th scope="col" class="px-6 py-4 text-center text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Reasoning</th>
                <th scope="col" class="px-6 py-4 text-center text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Figural</th>
                <th scope="col" class="px-6 py-4 text-center text-xs font-bold text-blue-600 dark:text-blue-400 uppercase tracking-wider">Total Score</th>
              </tr>
            </thead>
            <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
              <tr v-for="item in stData" :key="item.nisn" class="hover:bg-gray-50/50 dark:hover:bg-gray-700/20 transition-colors">
                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-white">{{ item.nama }}</td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">{{ item.nisn }}</td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-center text-gray-600 dark:text-gray-300">{{ formatNumber(item.listNilai?.verbal) }}</td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-center text-gray-600 dark:text-gray-300">{{ formatNumber(item.listNilai?.kuantitatif) }}</td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-center text-gray-600 dark:text-gray-300">{{ formatNumber(item.listNilai?.penalaran) }}</td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-center text-gray-600 dark:text-gray-300">{{ formatNumber(item.listNilai?.figural) }}</td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-center font-bold text-blue-600 dark:text-blue-400">{{ formatNumber(item.total) }}</td>
              </tr>
            </tbody>
          </table>
        </div>

      </div>
    </main>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import axios from 'axios'
import Navbar from '../components/Navbar.vue'
import { useAuthStore } from '../stores/auth'

const authStore = useAuthStore()

const tabs = [
  { id: 'rt', name: 'Realizing Potential (RT)' },
  { id: 'st', name: 'Smart Test (ST)' },
]

const currentTab = ref('rt')
const rtData = ref([])
const stData = ref([])

const formatNumber = (num) => {
  if (!num) return '-'
  return parseFloat(num).toFixed(2)
}

const fetchData = async () => {
  try {
    const [rtRes, stRes] = await Promise.all([
      axios.get(`${import.meta.env.VITE_API_BASE_URL}/nilaiRT`, {
        headers: { Authorization: `Bearer ${authStore.token}` }
      }),
      axios.get(`${import.meta.env.VITE_API_BASE_URL}/nilaiST`, {
        headers: { Authorization: `Bearer ${authStore.token}` }
      })
    ])

    rtData.value = rtRes.data
    stData.value = stRes.data
  } catch (e) {
    console.error('Failed to fetch report data', e)
  }
}

onMounted(() => {
  fetchData()
})
</script>
