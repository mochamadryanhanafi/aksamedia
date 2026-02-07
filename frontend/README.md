# Aksamedia Frontend

This directory contains the Vue.js 3 frontend application for . It uses Tailwind CSS for styling and Pinia for state management.

## 🛠️ Tech Stack

-   **Framework**: Vue.js 3 (Composition API)
-   **Build Tool**: Vite
-   **Styling**: Tailwind CSS
-   **State Management**: Pinia
-   **Routing**: Vue Router
-   **HTTP Client**: Axios

## 📂 Directory Structure

```
src/
├── assets/            # Static assets (images, css)
├── components/        # Reusable UI components (Navbar, Modal, etc.)
├── router/            # Route definitions
├── stores/            # Pinia stores (Auth, Theme, Toast)
├── views/             # Page components (Dashboard, Login, Profile)
└── App.vue            # Root component
```

## 🚀 Setup & Installation

### Prerequisites
-   Node.js (v16+)
-   NPM

### Steps

1.  **Install Dependencies**
    ```bash
    npm install
    ```

2.  **Environment Configuration**
    The app uses `import.meta.env.VITE_API_BASE_URL` to connect to the backend.
    Ensure `.env` exists (or usage default):
    ```env
    VITE_API_BASE_URL=http://localhost:8002/api
    ```

3.  **Run Development Server**
    ```bash
    npm run dev
    ```
    The app will basically run at `http://localhost:5173`.

## 📦 Build for Production

To create a production-ready build:

```bash
npm run build
```

The output will be in the `dist/` directory.

## 🎨 Features

-   **Dark Mode**: Respects system preference, toggleable in Navbar.
-   **Glassmorphism Navbar**: Fixed top navbar with backdrop blur.
-   **Responsive Design**: Desktop (Table) and Mobile (Cards) layouts.
-   **Skeleton Loading**: Enhances perceived performance during data fetching.
