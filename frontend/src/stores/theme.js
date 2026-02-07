import { defineStore } from 'pinia'
import { ref, watch } from 'vue'

export const useThemeStore = defineStore('theme', () => {
    const theme = ref(localStorage.getItem('theme') || 'system')

    const applyTheme = () => {
        const root = document.documentElement
        const isDark = theme.value === 'dark' ||
            (theme.value === 'system' && window.matchMedia('(prefers-color-scheme: dark)').matches)

        if (isDark) {
            root.classList.add('dark')
        } else {
            root.classList.remove('dark')
        }
    }

    const setTheme = (newTheme) => {
        theme.value = newTheme
        localStorage.setItem('theme', newTheme)
        applyTheme()
    }

    // Listen for system changes
    window.matchMedia('(prefers-color-scheme: dark)').addEventListener('change', () => {
        if (theme.value === 'system') {
            applyTheme()
        }
    })

    // Initialize
    applyTheme()

    return {
        theme,
        setTheme
    }
})
