# Rentigo

A full-stack web application for  car rental, featuring a PHP REST API backend and a Vue 3 frontend, allows users to book a car, manage bookings, and share their experiences through reviews.

## 🏗️ Architecture

This project consists of two main components:

- **Backend**: PHP REST API following MVC architecture patterns
- **Frontend**: Vue 3 application with Vite, Tailwind CSS, and Storybook

## Technical Implementation 

Backend Arcitcture: 
- **RESTful API**: Developed a stateless API that communicates via JSON, allowing the frontend to be entirely decoupled from the backend logic.

- **Database Pagination**: Implemented LIMIT and OFFSET logic directly in the SQL queries to handle large datasets efficiently, ensuring fast response times regardless of fleet size.

Security & Authorization:
- **Stateless Auth**: Implemented JWT (JSON Web Tokens) for user sessions. Upon login, the server issues a signed token which the Vue frontend stores and sends in the Authorization: Bearer header for protected routes.

- **Role-Based Access (RBAC)**: Middleware checks the decrypted token to ensure only users with Admin privileges can access sensitive endpoints like /api/admin/bookings

Frontend Arcitcture:
- **Atomic Design Methodology**: Organized the Vue.js 3 (Composition API) frontend into a hierarchical component library (Atoms, Molecules, Organisms), ensuring high reusability and UI consistency across the application.

Design & UI Consistency:
- **Tailwind CSS**: Utilized a utility-first CSS approach to build a highly custom, responsive UI without writing thousands of lines of bloated CSS files.

- **Storybook**: Integrated Storybook as a "workshop" environment. Each Atomic component is developed and documented in isolation, ensuring UI components are bug-free and visually consistent before they are integrated into the main application.

## AI Assistance
Throughout the development of this project, I utilized AI to accelerate the engineering lifecycle.Specifically, AI helped in drafting complex SQL queries for the repository methods, create the initial structures of Vue components, and refining the responsive Tailwind CSS layouts. AI also assisted with debugging complex state management and refactoring the custom PHP MVC router.

## Login Credentials 

Admin account login credentials:
- email: admin@gmail.com
- password: 123 (the password was assigned before I implemented solid password validation and has never been changed since)


User account login credentials: 
- alina@gmail.com
- password: 12345678

## Future Implementations
Currently, the application uses "prop drilling" to pass booking data through multiple layers of components. Transitioning to Pinia will centralize the application state, allowing components to access data directly from a global store. This will simplify the component architecture and make the codebase significantly more maintainable.


## 📁 Project Structure

```
web_development_2_boilerplate/
├── backend/          # PHP REST API
│   ├── app/          # Application code
│   ├── docker-compose.yml
│   └── README.md     # Backend documentation
└── frontend/         # Vue 3 application
    ├── src/          # Source code
    └── README.md     # Frontend documentation
```

## 🚀 Quick Start

### Prerequisites

- **Docker and Docker Compose** (for backend)
- **Node.js** ^20.19.0 or >=22.12.0 (for frontend)
- **npm** or **yarn**

### Backend Setup

1. Navigate to the backend directory:

```bash
cd backend
```

2. Start Docker containers:

```bash
docker-compose up
```

3. Install PHP dependencies:

```bash
docker-compose exec php composer install
```

### Frontend Setup

1. Navigate to the frontend directory:

```bash
cd frontend
```

2. Install dependencies:

```bash
npm install
```

3. Start the development server:

```bash
npm run dev
```


